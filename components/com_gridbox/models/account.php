<?php
/**
* @package   Gridbox
* @author    Balbooa http://www.balbooa.com/
* @copyright Copyright @ Balbooa
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

defined('_JEXEC') or die;

class gridboxModelAccount extends JModelItem
{
    public function getTable($type = 'pages', $prefix = 'gridboxTable', $config = array()) 
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getUserByEmail($email)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__users')
            ->where('email = '.$db->quote($email));
        $db->setQuery($query);
        $user = $db->loadObject();

        return $user;
    }

    public function remindUsername($email)
    {
        $user = $this->getUserByEmail($email);
        $response = new stdClass();
        $response->status = true;
        if ($user) {
            $config = JFactory::getConfig();
            $sitename = $config->get('sitename');
            $sender = [$config->get('mailfrom'), $config->get('fromname')];
            $subject = JText::_('USERNAME_RECOVERY_ON').' '.$sitename;
            $recipients = [$email];
            $text = str_replace('{SITENAME}', $sitename, JText::_('A_USERNAME_REMINDER_REQUESTED_FOR_YOUR_ACCOUNT'));
            $btn = str_replace('{SITENAME}', $sitename, JText::_('VISIT_SITENAME'));
            include(JPATH_ROOT.'/components/com_gridbox/views/layout/patterns/login/forgot-username-email-pattern.php');
            $mailer = JFactory::getMailer();
            $mailer->sendMail($sender[0], $sender[1], $recipients, $subject, $body, true);
        } else {
            $response->status = false;
            $response->message = JText::_('NO_ACOOUNTS_WITH_ENTERED_EMAIL');
        }
        $str = json_encode($response);
        echo $str;
    }

    public function remindPassword($email)
    {
        $user = $this->getUserByEmail($email);
        $response = new stdClass();
        $response->status = true;
        if ($user) {
            $token = JApplicationHelper::getHash(JUserHelper::genRandomPassword());
            $response->message = $token;
            $hash = JUserHelper::hashPassword($token);
            $user->activation = $hash;
            $db = JFactory::getDbo();
            $db->updateObject('#__users', $user, 'id');
            $config = JFactory::getConfig();
            $sitename = $config->get('sitename');
            $sender = [$config->get('mailfrom'), $config->get('fromname')];
            $subject = JText::_('PASSWORD_RESET_ON').' '.$sitename;
            $recipients = [$email];
            $text = str_replace('{SITENAME}', $sitename, JText::_('REQUEST_MADE_TO_RESET'));
            include(JPATH_ROOT.'/components/com_gridbox/views/layout/patterns/login/forgot-password-email-pattern.php');
            $mailer = JFactory::getMailer();
            $mailer->sendMail($sender[0], $sender[1], $recipients, $subject, $body, true);
        } else {
            $response->status = false;
            $response->message = JText::_('NO_ACOOUNTS_WITH_ENTERED_EMAIL');
        }
        $str = json_encode($response);
        echo $str;
    }

    public function requestPassword($data)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__users')
            ->where('username = '.$db->quote($data['username']));
        $db->setQuery($query);
        $user = $db->loadObject();
        $response = new stdClass();
        $response->status = true;
        if ($user && !empty($user->activation) && JUserHelper::verifyPassword($data['code'], $user->activation)) {
            $response->id = $user->id;
        } else {
            $response->status = false;
            $response->message = JText::_('USERNAME_VERIFICATION_CODE_NOT_VALID');
        }
        $str = json_encode($response);
        echo $str;
    }

    public function resetPassword($data)
    {
        $db = JFactory::getDbo();
        $user = JUser::getInstance($data['id'] * 1);
        $response = new stdClass();
        $response->status = true;
        if ($user) {
            $array = [];
            $array['password'] = $array['password1'] = $array['password2'] = $data['password1'];
            $array['activation'] = '';
            $user->bind($array);
            $user->save(true);
        } else {
            $response->status = false;
            $response->message = '';
        }
        $str = json_encode($response);
        echo $str;
    }

    public function socialLogin($data)
    {
        $db = JFactory::getDbo();
        $user = $this->getUserByEmail($data['email']);
        if (!$user) {
            $username = preg_replace('/\s+/i', '-', strtolower($data['name']));
            $username = preg_replace('/[^A-z0-9_\-]/i', '', $username);
            if (strlen($username) < 2 && !empty($username)) {
                $username = 'user-'.$username;
            } else if (strlen($username) < 2) {
                $username = 'user';
            }
            $n = 2;
            $tmpname = $username;
            while ($this->getByUsername($tmpname, $db)) {
                $tmpname = $username.'-'.$n++;
            }
            $username = $tmpname;
            $params = JComponentHelper::getParams('com_users');
            $array = [];
            $array['name'] = $data['name'];
            $array['username'] = $username;
            $array['groups'] = [];
            $array['groups'][] = $params->get('new_usertype', $params->get('guest_usergroup', 1));
            $array['email'] = JStringPunycode::emailToPunycode($data['email']);
            $array['password'] = $array['password1'] = $array['password2'] = JUserHelper::genRandomPassword();
            $user = new JUser;
            $user->bind($array);
            $user->save();
        }
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__gridbox_user_avatars')
            ->where('user_id = '.$user->id);
        $db->setQuery($query);
        $obj = $db->loadObject();
        if (!$obj) {
            $obj = new stdClass();
            $obj->user_id = $user->id;
            $obj->avatar = $data['avatar'];
            $db->insertObject('#__gridbox_user_avatars', $obj);
        } else {
            $obj->avatar = (empty($obj->avatar) || gridboxHelper::isExternal($obj->avatar)) ? $data['avatar'] : $obj->avatar;
            $db->updateObject('#__gridbox_user_avatars', $obj, 'id');
        }
        gridboxHelper::userLogin($user->username);
        $response = new stdClass();
        $response->status = true;
        $str = json_encode($response);
        echo $str;
    }

    protected function getByUsername($username, $db)
    {
        $query = $this->_db->getQuery(true);
        $query->select('id')
              ->from('#__users')
              ->where('username = '.$db->quote($username));
        $db->setQuery($query);
        $user = $db->loadObject();
        
        return $user;
    }

    public function getItem($pk = null)
    {
        $input = JFactory::getApplication()->input;
        $id = $input->get('id', 0, 'string');
        $order = $this->getOrder($id);

        return $order;
    }

    public function getTime()
    {
        $item = gridboxHelper::getSystemParamsByType('checkout');
        $time = $item ? $item->saved_time : '';

        return $time;
    }

    public function saveCustomerInfo($data)
    {
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        foreach ($data as $customer_id => $value) {
            $query = $db->getQuery(true)
                ->select('*')
                ->from('#__gridbox_store_user_info')
                ->where('customer_id = '.$customer_id)
                ->where('user_id = '.$user_id);
            $db->setQuery($query);
            $customer = $db->loadObject();
            if (!$customer) {
                $customer = new stdClass();
                $customer->user_id = $user_id;
                $customer->customer_id = $customer_id;
                $customer->value = $value;
                $db->insertObject('#__gridbox_store_user_info', $customer);
            } else {
                $customer->value = $value;
                $db->updateObject('#__gridbox_store_user_info', $customer, 'id');
            }
        }
    }

    public function calculatePlanUpgrade($id, $subscription)
    {
        $db = JFactory::getDbo();
        $total = gridboxHelper::$storeHelper->calculateSubscriptionTotal($id);
        $query = $db->getQuery(true)
            ->select('p.id, p.title, d.subscription, d.price, d.sale_price')
            ->from('#__gridbox_pages AS p')
            ->leftJoin('#__gridbox_store_product_data AS d ON d.product_id = p.id')
            ->where('p.id IN ('.implode(', ', $subscription->upgrade).')');
        $db->setQuery($query);
        $plans = $db->loadObjectList();
        $array = array();
        foreach ($plans as $plan) {
            $object = gridboxHelper::$storeHelper->getUpgradeObject($plan, $total);
            $array[] = $object;
        }

        return $array;
    }

    public function getSubscriptions()
    {
        $id = JFactory::getUser()->id;
        $db = JFactory::getDbo();
        $date = $db->quote(date("Y-m-d H:i:s"));
        $nullDate = $db->quote($db->getNullDate());
        $query = gridboxHelper::$storeHelper->getSubscriprionsQuery($id);
        $db->setQuery($query);
        $items = $db->loadObjectList();
        $obj = new stdClass();
        $obj->expires = false;
        $obj->renew = false;
        $obj->upgrade = false;
        $obj->digital = array();
        $link = JUri::root().'index.php?option=com_gridbox&task=store.downloadSubscriptionFile&file=';
        $now = date('Y-m-d H:i:s');
        foreach ($items as $item) {
            if (!$obj->expires && !empty($item->expires)) {
                $obj->expires = true;
            }
            $subscription = json_decode($item->subscription);
            $item->params = $subscription;
            $item->refunded = false;
            $item->plans = array();
            $item->upgrade_plans = array();
            foreach ($subscription->renew->plans as $key => $plan) {
                if (empty($item->expires) || $plan->price == '') {
                    continue;
                }
                $plan->key = $key;
                $plan->prices = gridboxHelper::prepareProductPrices($item->product_id, $plan->price, '');
                $item->plans[] = $plan;
                if (!$obj->renew) {
                    $obj->renew = true;
                }
            }
            if (!empty($subscription->upgrade)) {
                $item->upgrade_plans = $this->calculatePlanUpgrade($item->id, $subscription);
                $obj->upgrade = true;
            }
            if (($subscription->action == 'products' || $subscription->action == 'full')
                && !empty($subscription->products) && (empty($item->expires) || $now < $item->expires)) {
                $query = $db->getQuery(true)
                    ->select('p.id, p.title, p.intro_image AS image')
                    ->from('#__gridbox_pages AS p')
                    ->where('p.id IN ('.implode(', ', $subscription->products).')')
                    ->where('p.page_category <> '.$db->quote('trashed'))
                    ->where('p.published = 1')
                    ->where('p.created <= '.$date)
                    ->where('(p.end_publishing = '.$nullDate.' OR p.end_publishing >= '.$date.')');
                $db->setQuery($query);
                $digital = $db->loadObjectList();
                foreach ($digital as $product) {
                    $file = base64_encode($item->id.'+'.$product->id);
                    $product->link = $link.$file;
                    $product->license = new stdClass();
                    $product->license->expires = $item->expires;
                    $obj->digital[] = $product;
                }
            } else if (!empty($item->expires) && $now > $item->expires) {
                $query = $db->getQuery(true)
                    ->select('last_status')
                    ->from('#__gridbox_store_subscriptions_map')
                    ->where('subscription_id = '.$item->id);
                $db->setQuery($query);
                $maps = $db->loadObjectList();
                $item->refunded = array_reduce($maps, function($carry, $map){
                    return (is_null($carry) || $carry) && $map->last_status == 'refunded';
                });
            }
        }
        $obj->items = $items;

        return $obj;
    }

    public function getData()
    {
        $data = new stdClass();
        $data->orders = $this->getOrders();
        $data->digital = new stdClass();
        $data->digital->products = [];
        $data->digital->limit = 0;
        $data->digital->expires = 0;
        $db = JFactory::getDbo();
        $date = $db->quote(date("Y-m-d H:i:s"));
        $nullDate = $db->quote($db->getNullDate());
        $link = JUri::root().'index.php?option=com_gridbox&task=store.downloadDigitalFile&file=';
        foreach ($data->orders as $order) {
            if ($order->status != 'completed') {
                continue;
            }
            foreach ($order->products as $product) {
                if ($product->product_type != 'digital') {
                    continue;
                }
                $query = $db->getQuery(true)
                    ->select('l.*')
                    ->from('#__gridbox_store_order_license AS l')
                    ->where('l.product_id = '.$product->id)
                    ->where('p.page_category <> '.$db->quote('trashed'))
                    ->where('p.published = 1')
                    ->where('p.created <= '.$date)
                    ->where('(p.end_publishing = '.$nullDate.' OR p.end_publishing >= '.$date.')')
                    ->leftJoin('#__gridbox_store_order_products AS op ON op.id = l.product_id')
                    ->leftJoin("#__gridbox_pages AS p ON op.product_id = p.id");
                $db->setQuery($query);
                $license = $db->loadObject();
                if ($license->expires == 'new') {
                    $query = $db->getQuery(true)
                        ->select('d.digital_file')
                        ->from('#__gridbox_store_order_products AS op')
                        ->where('op.id = '.$product->id)
                        ->leftJoin('#__gridbox_store_product_data AS d ON d.product_id = op.product_id');
                    $db->setQuery($query);
                    $digital_file = $db->loadResult();
                    $digital = !empty($digital_file) ? json_decode($digital_file) : new stdClass();
                    if (empty($digital->expires->value)) {
                        $license->expires = '';
                    } else {
                        $expires = array('h' => 'hour', 'd' => 'day', 'm' => 'month', 'y' => 'year');
                        $time = strtotime('+'.$digital->expires->value.' '.$expires[$digital->expires->format]);
                        $license->expires = date("Y-m-d H:i:s", $time);
                    }
                    $db->updateObject('#__gridbox_store_order_license', $license, 'id');
                }
                $expired = false;
                $limit = $license && ($license->limit == '' || $license->downloads < $license->limit);
                if (!empty($license->expires)) {
                    $expired = $date > $license->expires;
                }
                if (!$expired && $limit) {
                    $product->link = $link.$product->product_token;
                    $product->license = $license;
                    $data->digital->products[] = $product;
                    $data->digital->limit += !empty($license->limit) ? 1 : 0;
                    $data->digital->expires += !empty($license->expires) ? 1 : 0;
                }
            }
        }

        return $data;
    }

    public function getOrders()
    {
        $id = JFactory::getUser()->id;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__gridbox_store_orders')
            ->where('published = 1')
            ->where('user_id = '.$id)
            ->order('date desc');
        $db->setQuery($query);
        $orders = $db->loadObjectList();
        foreach ($orders as $order) {
            $query = $db->getQuery(true)
                ->select('*')
                ->from('#__gridbox_store_order_products')
                ->where('order_id = '.$order->id);
            $db->setQuery($query);
            $order->products = $db->loadObjectList();
        }

        return $orders;
    }

    public function getOrder($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__gridbox_store_orders')
            ->where('id = '.$id);
        $db->setQuery($query);
        $order = $db->loadObject();
        $order->tracking = gridboxHelper::$storeHelper->getTracking($id);
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__gridbox_store_orders_discount')
            ->where('order_id = '.$id);
        $db->setQuery($query);
        $order->promo = $db->loadObject();
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__gridbox_store_orders_shipping')
            ->where('order_id = '.$id);
        $db->setQuery($query);
        $order->shipping = $db->loadObject();
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__gridbox_store_orders_payment')
            ->where('order_id = '.$id);
        $db->setQuery($query);
        $order->payment = $db->loadObject();
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__gridbox_store_order_products')
            ->where('order_id = '.$id);
        $db->setQuery($query);
        $order->products = $db->loadObjectList();
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__gridbox_store_products_fields');
        $db->setQuery($query);
        $fields = $db->loadObjectList();
        $fieldsData = array();
        foreach ($fields as $field) {
            $options = json_decode($field->options);
            foreach ($options as $option) {
                $option->value = $option->title;
                $option->title = $field->title;
                $option->type = $field->field_type;
                $fieldsData[$option->key] = $option;
            }
        }
        foreach ($order->products as $product) {
            $query = $db->getQuery(true)
                ->select('*')
                ->from('#__gridbox_store_order_product_variations')
                ->where('product_id = '.$product->id);
            $db->setQuery($query);
            $product->variations = $db->loadObjectList();
            $info = array();
            foreach ($product->variations as $variation) {
                $info[] = '<span>'.$variation->title.' '.$variation->value.'</span>';
            }
            $product->info = implode('/', $info);
            $query = $db->getQuery(true)
                ->select('p.title, p.intro_image AS image, d.*')
                ->from('#__gridbox_pages AS p')
                ->where('d.product_id = '.$product->product_id)
                ->where('p.page_category <> '.$db->quote('trashed'))
                ->leftJoin('#__gridbox_store_product_data AS d ON d.product_id = p.id');
            $db->setQuery($query);
            $obj = $db->loadObject();
            if (!$obj) {
                continue;
            }
            $variations = json_decode($obj->variations);
            if (!empty($product->variation) && !isset($variations->{$product->variation})) {
                continue;
            }
            $product->extra_options = !empty($product->extra_options) ? json_decode($product->extra_options) : new stdClass();
        }
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__gridbox_store_order_customer_info')
            ->where('order_id = '.$id)
            ->order('order_list ASC, id ASC');
        $db->setQuery($query);
        $order->info = $db->loadObjectList();
        
        return $order;
    }

    public function getCustomerInfoGroup($title)
    {
        $group = new stdClass();
        $group->title = $title;
        $group->items = array();

        return $group;
    }

    public function getCustomerInfo()
    {
        $info = gridboxHelper::getCustomerInfo();
        $groups = array();
        $group = null;
        foreach ($info as $key => $obj) {
            if ($obj->type == 'headline') {
                $groups[] = $group = $this->getCustomerInfoGroup($obj->title);
            } else if (!$group) {
                $groups[] = $group = $this->getCustomerInfoGroup('');
            }
            if ($obj->type != 'headline' && $obj->type != 'acceptance') {
                $group->items[] = $obj->id;
            }
        }

        return $groups;
    }

    public function getStatuses()
    {
        $data = new stdClass();
        $data->undefined = new stdClass();
        $data->undefined->title = 'Undefined';
        $data->undefined->color = '#f10000';
        foreach (gridboxHelper::$store->statuses as $status) {
            $data->{$status->key} = $status;
        }

        return $data;
    }
}