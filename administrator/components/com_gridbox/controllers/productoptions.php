<?php
/**
* @package   Gridbox
* @author    Balbooa http://www.balbooa.com/
* @copyright Copyright @ Balbooa
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class gridboxControllerProductoptions extends JControllerAdmin
{
    public function getModel($name = 'productoptions', $prefix = 'gridboxModel', $config = [])
    {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

    public function updateProductoptions()
    {
        gridboxHelper::checkUserEditLevel();
        $post = $this->input->post->getArray([]);
        $data = (object)$post;
        $keys = ['id', 'title', 'field_type', 'required', 'file_options', 'options'];
        foreach ($data as $key => $value) {
            if (!in_array($key, $keys)) {
                unset($data->{$key});
            }
        }
        $model = $this->getModel();
        $model->updateProductoptions($data);
        $obj = new stdClass();
        $obj->message = JText::_('JLIB_APPLICATION_SAVE_SUCCESS');
        $str = json_encode($obj);
        echo $str;
        exit;
    }

    public function getOptions()
    {
        $id = $this->input->get('id', 0, 'int');
        $model = $this->getModel();
        $obj = $model->getOptions($id);
        $str = json_encode($obj);
        echo $str;
        exit;
    }

    public function addProductOptions()
    {
        gridboxHelper::checkUserEditLevel();
        $model = $this->getModel();
        $model->addProductOptions();
        echo '{}';
        exit;
    }

    public function delete()
    {
        gridboxHelper::checkUserEditLevel();
        $pks = $this->input->getVar('cid', [], 'post', 'array');
        $model = $this->getModel();
        $model->delete($pks);
        gridboxHelper::ajaxReload('COM_GRIDBOX_N_ITEMS_DELETED');
    }

    public function contextDelete()
    {
        gridboxHelper::checkUserEditLevel();
        $id = $this->input->get('context-item', 0, 'int');
        $array = [];
        $array[] = $id;
        $model = $this->getModel();
        $model->delete($array);
        gridboxHelper::ajaxReload('COM_GRIDBOX_N_ITEMS_DELETED');
    }
}