<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_7F
	* Creation date: Mai 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\View\Category;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\CategoryView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;
use Joomla\Component\Gmapfp\Site\Helper\GmapfpHelper;
use Joomla\CMS\Uri\Uri;

class HtmlView extends CategoryView
{
	protected $lead_items = array();
	protected $intro_items = array();
	protected $link_items = array();
	protected $extension = 'com_gmapfp';
	protected $defaultPageTitle = 'COM_GMAPFP_ITEMS';
	protected $viewName = 'item';
	protected $perso = array();

	public function display($tpl = null)
	{
		parent::commonCategoryDisplay();

		$wa = $this->document->getWebAssetManager();
		$wa->useScript('jquery')
			->addInlineScript('var rootFull = "'.URI::base().'";')
			->useScript('com_gmapfp.front-map');

		// Flag indicates to not add limitstart=0 to URL
		$this->pagination->hideEmptyLimitstart = true;
		
		// Prepare the data
		// Get the metrics for the structural page layout.
		$numLeading = $this->params->def('num_leading_articles', 1);
		$numIntro   = $this->params->def('num_intro_articles', 1);
		$numLinks   = $this->params->def('num_links', 4);

		PluginHelper::importPlugin('content');

		$app     = Factory::getApplication();

		//récupère la personnalisation
		if($app->input->get('perso_id')){
			$this->perso = GmapfpHelper::getPerso($app->input->get('perso_id'));
		}
		
		if($app->input->get('layout')){
			$this->setLayout($app->input->get('layout'));
		}

		// Compute the article slugs and prepare introtext (runs content plugins).
		foreach ($this->items as $item)
		{
			$item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;

			// Gère l'affichage des icons ou légendes
			$item->params = GmapfpHelper::getIconsAddress($item->params);

			// No link for ROOT category
			if ($item->parent_alias === 'root')
			{
				$item->parent_id = null;
			}

			$item->event   = new \stdClass;

			// Old plugins: Ensure that text property is available
			if (!isset($item->text))
			{
				$item->text = $item->introtext;
			}

			$app->triggerEvent('onContentPrepare', array('com_gmapfp.category', &$item, &$item->params, 0));

			// Old plugins: Use processed text as introtext
			$item->introtext = $item->text;

			$results = $app->triggerEvent('onContentAfterTitle', array('com_gmapfp.category', &$item, &$item->params, 0));
			$item->event->afterDisplayTitle = trim(implode("\n", $results));

			$results = $app->triggerEvent('onContentBeforeDisplay', array('com_gmapfp.category', &$item, &$item->params, 0));
			$item->event->beforeDisplayContent = trim(implode("\n", $results));

			$results = $app->triggerEvent('onContentAfterDisplay', array('com_gmapfp.category', &$item, &$item->params, 0));
			$item->event->afterDisplayContent = trim(implode("\n", $results));
		}

		// For blog layouts, preprocess the breakdown of leading, intro and linked articles.
		// This makes it much easier for the designer to just interrogate the arrays.
		if ($this->params->get('category_layout') === 'blog' || $this->getLayout() === 'blog')
		{
			foreach ($this->items as $i => $item)
			{
				if ($i < $numLeading)
				{
					$this->lead_items[] = $item;
				}

				elseif ($i >= $numLeading && $i < $numLeading + $numIntro)
				{
					$item->adresse = '';
					$item->adresse2 = '';
					$item->ville = '';
					$item->departement = '';
					$item->codepostal = '';
					$item->pays = '';
					$item->tel = '';
					$item->img = '';
					
					$this->intro_items[] = $item;
				}

				elseif ($i < $numLeading + $numIntro + $numLinks)
				{
					$this->link_items[] = $item;
				}
				else
				{
					continue;
				}
			}
		}

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$app    = Factory::getApplication();
		$active = $app->getMenu()->getActive();
	
		if ($active
			&& $active->component == 'com_gmapfp'
			&& isset($active->query['view'], $active->query['id'])
			&& $active->query['view'] == 'category'
			&& $active->query['id'] == $this->category->id)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $active->title));
			$title = $this->params->get('page_title', $active->title);
		}
		else
		{
			$this->params->def('page_heading', $this->category->title);
			$title = $this->category->title;
			$this->params->set('page_title', $title);
		}

		// Check for empty title and add site name if param is set
		if (empty($title))
		{
			$title = $app->get('sitename');
		}
		elseif ($app->get('sitename_pagetitles', 0) == 1)
		{
			$title = Text::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		}
		elseif ($app->get('sitename_pagetitles', 0) == 2)
		{
			$title = Text::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		if (empty($title))
		{
			$title = $this->category->title;
		}

		$this->document->setTitle($title);

		if ($this->category->metadesc)
		{
			$this->document->setDescription($this->category->metadesc);
		}
		elseif ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->category->metakey)
		{
			$this->document->setMetaData('keywords', $this->category->metakey);
		}
		elseif ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetaData('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetaData('robots', $this->params->get('robots'));
		}

		if (!is_object($this->category->metadata))
		{
			$this->category->metadata = new Registry($this->category->metadata);
		}

		if (($app->get('MetaAuthor') == '1') && $this->category->get('author', ''))
		{
			$this->document->setMetaData('author', $this->category->get('author', ''));
		}

		$mdata = $this->category->metadata->toArray();

		foreach ($mdata as $k => $v)
		{
			if ($v)
			{
				$this->document->setMetaData($k, $v);
			}
		}
		
		return parent::display($tpl);
	}

	/**
	 * Prepares the document
	 *
	 * @return  void
	 */
	protected function prepareDocument()
	{
		parent::prepareDocument();
		$menu = $this->menu;
		$id = (int) @$menu->query['id'];

		if ($menu && ($menu->query['option'] !== 'com_gmapfp' || $menu->query['view'] === 'item' || $id != $this->category->id))
		{
			$path = array(array('title' => $this->category->title, 'link' => ''));
			$category = $this->category->getParent();

			while (($menu->query['option'] !== 'com_gmapfp' || $menu->query['view'] === 'item' || $id != $category->id) && $category->id > 1)
			{
				$path[] = array('title' => $category->title, 'link' => \ContentHelperRoute::getCategoryRoute($category->id, $category->language));
				$category = $category->getParent();
			}

			$path = array_reverse($path);

			foreach ($path as $item)
			{
				$this->pathway->addItem($item['title'], $item['link']);
			}
		}

		parent::addFeed();
	}
}
