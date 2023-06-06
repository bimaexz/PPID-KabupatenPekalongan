<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_9F
	* Creation date: Octobre 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\View\Item;

defined('_JEXEC') or die;

use Joomla\CMS\Categories\Categories;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Gmapfp\Site\Helper\AssociationHelper;
use Joomla\Component\Gmapfp\Site\Helper\RouteHelper as GmapfpRoute;
use Joomla\Component\Gmapfp\Site\Helper\GmapfpHelper;
use Joomla\CMS\HTML\HTMLHelper;

class HtmlView extends BaseHtmlView
{
	protected $item;
	protected $params = null;
	protected $print = false;
	protected $state;
	protected $user = null;
	protected $pageclass_sfx = '';
	protected $menuItemMatchArticle = false;

	public function display($tpl = null)
	{
	if ($this->getLayout() == 'pagebreak')
		{
			return parent::display($tpl);
		}

		$app        		= Factory::getApplication();
		$this->user     	= Factory::getUser();
		$this->item  		= $this->get('Item');
		$this->markers 		= GmapfpHelper::getMarkers();
		$this->print 		= $app->input->getBool('print', false);
		$this->state 		= $this->get('State');
		$this->email_form 	= $this->get('EmailForm');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		$wa = $this->document->getWebAssetManager();
		$wa->useScript('jquery')
			->addInlineScript('var rootFull = "'.URI::base().'";')
			->useScript('com_gmapfp.front-map');

		// Create a shortcut for $item.
		$item            = $this->item;
		$item->tagLayout = new FileLayout('joomla.content.tags');

		// Add router helpers.
		$item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;

		// No link for ROOT category
		if ($item->parent_alias === 'root')
		{
			$item->parent_id = null;
		}

		// TODO: Change based on shownoauth
		$item->readmore_link = Route::_(GmapfpRoute::getItemRoute($item->slug, $item->catid, $item->language));
		// Merge article params. If this is single-article view, menu params override article params
		// Otherwise, article params override menu item params
		$this->params = $this->state->get('params');
		$active       = $app->getMenu()->getActive();
		$temp         = clone $this->params;

		// Check to see which parameters should take priority
		if ($active)
		{
			$currentLink = $active->link;

			// If the current view is the active item and an article view for this article, then the menu item params take priority
			if (strpos($currentLink, 'view=item') && strpos($currentLink, '&id=' . (string) $item->id))
			{
				// Load layout from active query (in case it is an alternative menu item)
				if (isset($active->query['layout']))
				{
					$this->setLayout($active->query['layout']);
				}
				// Check for alternative layout of article
				elseif ($layout = $item->params->get('item_layout'))
				{
					$this->setLayout($layout);
				}

				// $item->params are the article params, $temp are the menu item params
				// Merge so that the menu item params take priority
				$item->params->merge($temp);
			}
			else
			{
				// Current view is not a single article, so the article params take priority here
				// Merge the menu item params with the article params so that the article params take priority
				$temp->merge($item->params);
				$item->params = $temp;

				// Check for alternative layouts (since we are not in a single-article menu item)
				// Single-article menu item layout takes priority over alt layout for an article
				if ($layout = $item->params->get('item_layout'))
				{
					$this->setLayout($layout);
				}
			}
		}
		else
		{
			// Merge so that article params take priority
			$temp->merge($item->params);
			$item->params = $temp;

			// Check for alternative layouts (since we are not in a single-article menu item)
			// Single-article menu item layout takes priority over alt layout for an article
			if ($layout = $item->params->get('item_layout'))
			{
				$this->setLayout($layout);
			}
		}

		$offset = $this->state->get('list.offset');

		// Check the view access to the article (the model has already computed the values).
		if ($item->params->get('access-view') == false && ($item->params->get('show_noauth', '0') == '0'))
		{
			$app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'error');
			$app->setHeader('status', 403, true);

			return;
		}

		/**
		 * Check for no 'access-view' and empty fulltext,
		 * - Redirect guest users to login
		 * - Deny access to logged users with 403 code
		 * NOTE: we do not recheck for no access-view + show_noauth disabled ... since it was checked above
		 */
		if ($item->params->get('access-view') == false && !strlen($item->fulltext))
		{
			if ($this->user->get('guest'))
			{
				$return = base64_encode(Uri::getInstance());
				$login_url_with_return = Route::_('index.php?option=com_users&view=login&return=' . $return);
				$app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'notice');
				$app->redirect($login_url_with_return, 403);
			}
			else
			{
				$app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'error');
				$app->setHeader('status', 403, true);

				return;
			}
		}

		if ($item->email && $item->params->get('show_email',1))
		{
			$item->email = HTMLHelper::_('email.cloak', $item->email, (bool) $item->params->get('add_mailto_link', 1));
		}

		// Gère l'affichage des icons ou légendes
		$item->params = GmapfpHelper::getIconsAddress($item->params);

		/**
		 * NOTE: The following code (usually) sets the text to contain the fulltext, but it is the
		 * responsibility of the layout to check 'access-view' and only use "introtext" for guests
		 */
		if ($item->params->get('show_intro', '1') == '1')
		{
			$item->text = $item->introtext . ' ' . $item->fulltext;
		}
		elseif ($item->fulltext)
		{
			$item->text = $item->fulltext;
		}
		else
		{
			$item->text = $item->introtext;
		}

		$item->tags = new TagsHelper;
		$item->tags->getItemTags('com_gmapfp.item', $this->item->id);

		if (Associations::isEnabled() && $item->params->get('show_associations'))
		{
			$item->associations = AssociationHelper::displayAssociations($item->id);
		}

		// Process the content plugins.
		PluginHelper::importPlugin('content');
		Factory::getApplication()->triggerEvent('onContentPrepare', array('com_gmapfp.item', &$item, &$item->params, $offset));
		Factory::getApplication()->triggerEvent('onContentPrepare', array('com_content.article', &$item, &$item->params, $offset));

		$item->event = new \stdClass;
		$results = Factory::getApplication()->triggerEvent('onContentAfterTitle', array('com_gmapfp.item', &$item, &$item->params, $offset));
		// $results = Factory::getApplication()->triggerEvent('onContentAfterTitle', array('com_content.article', &$item, &$item->params, $offset));
		$item->event->afterDisplayTitle = trim(implode("\n", $results));

		$results = Factory::getApplication()->triggerEvent('onContentBeforeDisplay', array('com_gmapfp.item', &$item, &$item->params, $offset));
		// $results = Factory::getApplication()->triggerEvent('onContentBeforeDisplay', array('com_content.article', &$item, &$item->params, $offset));
		$item->event->beforeDisplayContent = trim(implode("\n", $results));

		$results = Factory::getApplication()->triggerEvent('onContentAfterDisplay', array('com_gmapfp.item', &$item, &$item->params, $offset));
		// $results = Factory::getApplication()->triggerEvent('onContentAfterDisplay', array('com_content.article', &$item, &$item->params, $offset));
		$item->event->afterDisplayContent = trim(implode("\n", $results));

		// Escape strings for HTML output
		$this->pageclass_sfx = @htmlspecialchars($this->item->params->get('pageclass_sfx'));

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document.
	 *
	 * @return  void
	 */
	protected function _prepareDocument()
	{
		$app     = Factory::getApplication();
		$pathway = $app->getPathway();
		$menu = $app->getMenu()->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', Text::_('JGLOBAL_ARTICLES'));
		}

		$title = $this->params->get('page_title', '');

		// If the menu item is not linked to this article
		if (!$this->menuItemMatchArticle)
		{
			// If a browser page title is defined, use that, then fall back to the article title if set, then fall back to the page_title option
			$title = $this->item->params->get('item_page_title', $this->item->title ?: $title);

			// Get ID of the category from active menu item
			if ($menu && $menu->component == 'com_gmapfp' && isset($menu->query['view'])
				&& in_array($menu->query['view'], ['categories', 'category']))
			{
				$id = $menu->query['id'];
			}
			else
			{
				$id = 0;
			}

			$path     = array(array('title' => $this->item->title, 'link' => ''));
			$category = Categories::getInstance('Gmapfp')->get($this->item->catid);

			while ($category !== null && $category->id != $id && $category->id !== 'root')
			{
				$path[]   = array('title' => $category->title, 'link' => GmapfpRoute::getCategoryRoute($category->id, $category->language));
				$category = $category->getParent();
			}

			$path = array_reverse($path);

			foreach ($path as $item)
			{
				$pathway->addItem($item['title'], $item['link']);
			}
		}

		if (empty($title))
		{
			$title = $this->item->title;
		}

		$this->setDocumentTitle($title);

		if ($this->item->metadesc)
		{
			$this->document->setDescription($this->item->metadesc);
		}
		elseif ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetaData('robots', $this->params->get('robots'));
		}

		if ($app->get('MetaAuthor') == '1')
		{
			$author = $this->item->created_by_alias ?: $this->item->author;
			$this->document->setMetaData('author', $author);
		}

		$mdata = $this->item->metadata->toArray();

		foreach ($mdata as $k => $v)
		{
			if ($v)
			{
				$this->document->setMetaData($k, $v);
			}
		}

		// If there is a pagebreak heading or title, add it to the page title
		if (!empty($this->item->page_title))
		{
			$this->item->title = $this->item->title . ' - ' . $this->item->page_title;
			$this->setDocumentTitle(
				$this->item->page_title . ' - ' . Text::sprintf('PLG_CONTENT_PAGEBREAK_PAGE_NUM', $this->state->get('list.offset') + 1)
			);
		}

		if ($this->print)
		{
			$this->document->setMetaData('robots', 'noindex, nofollow');
		}
	}
}
