<?php
	/*
	* GMapFP Plugin Google Map for Joomla! 3.x
	* Version J4_2F
	* Creation date: Octobre 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/
	
defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\Component\Gmapfp\Site\Helper\GmapfpHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Layout\LayoutHelper;

class PlgContentGmapfp_map extends CMSPlugin
{
	protected $app;
	protected static $modules = array();
	protected static $mods = array();

	function __construct(&$subject)
	{
		parent::__construct($subject);
		$this->variables = array();
	}
	
	public function onContentPrepare($context, &$row, &$params, $page = 0)
	{
		$canProceed = $context === 'com_content.article';
		$canProceed = 1;
		$options	= array();
		$GMapFP_params = clone ComponentHelper::getParams('com_gmapfp');

		if (!$canProceed or !$this->app->isClient('site'))
		{
			return;
		}

		if (preg_match_all('/{gmapfp (.*?)}/', $row->text, $matches)) {
			if (!property_exists($row, 'id')) $row->id = rand();
			if (!property_exists($row, 'introtext')) $row->introtext = '';
			
			$cnt = 1;
			
			foreach($matches[0] as $matche) {
			
				if ((preg_match_all('/\bid\b="[0-9,]*"/', $matche, $ids))or(preg_match_all('/catid="[0-9,]*"/', $matche, $catids))or(preg_match('/where="(.*?)"/', $matche, $where))) 
				{
					preg_match('/hmap="[0-9]*"/', $matche, $Hmap);
					preg_match('/lmap="[0-9.px%]*"/', $matche, $Lmap);
					preg_match('/zmap="[0-9]*"/', $matche, $Zmap);
					preg_match('/map_centre_lat="[0-9.-]*"/', $matche, $map_centre_lat);
					preg_match('/map_centre_lng="[0-9.-]*"/', $matche, $map_centre_lng);
					preg_match('/kml_file="(.*?)"/', $matche, $kml_file);
					preg_match('/map_centre_id="[0-9.]*"/', $matche, $map_centre_id);

					$plug_params['gmapfp_height'] = str_replace('hmap=','',$Hmap);
					$plug_params['gmapfp_width'] = str_replace('lmap=','',$Lmap);
					$plug_params['gmapfp_zoom'] = str_replace('zmap=','',$Zmap);
					$kml_file = str_replace('kml_file=','',$kml_file);
					$plug_params['map_centre_lat'] = str_replace('map_centre_lat=','',$map_centre_lat);
					$plug_params['map_centre_lng'] = str_replace('map_centre_lng=','',$map_centre_lng);
					$map_centre_id = str_replace('map_centre_id=','',$map_centre_id);
					
					if (!empty($map_centre_id)) {
						$LatLng = GmapfpHelper::getLatLng(str_replace('"','',$map_centre_id)[0]);
						$plug_params['plug_map_centre_lat'] = $LatLng['glat'];
						$plug_params['plug_map_centre_lng'] = $LatLng['glng'];
					}
					
					foreach ($plug_params as $key => $plug_param){
						$plug_param = str_replace('"','',$plug_param);
						if (is_array($plug_param) and !empty($plug_param)) $plug_param = $plug_param[0];
						if ($plug_param) $GMapFP_params->set($key, $plug_param);
					}
					if (!empty($kml_file)) {
						$kml_file = str_replace('"','',$kml_file);
						if ($GMapFP_params->get('gmapfp_geoXML')) {
							$GMapFP_params->set('gmapfp_geoXML', $GMapFP_params->get('gmapfp_geoXML'.';'.$kml_file[0]));
						} else {
							$GMapFP_params->set('gmapfp_geoXML', $kml_file[0]);
						}
					}

					if (preg_match_all('/\bid\b="[0-9,]*"/', $matche, $ids)) {
						foreach($ids as $id)
						{
							$id = str_replace('id=','',$id);
							$id = str_replace('"','',$id);
						};
					}else{
						$id = 0;
					};
					$map_ids = array();
					if (!empty($id)) foreach ($id as $tmp)
					{
						if (strpos($tmp, ',') > 0) {
							$map_ids = array_unique(array_merge($map_ids, explode(',', $tmp)));
						} else {
							$map_ids[] = $tmp;
						}
					}

					if (preg_match_all('/catid="[0-9,]*"/', $matche, $catids)) {
						foreach($catids as $catid)
						{
						$catid = str_replace('catid=','',$catid);
						$catid = str_replace('"','',$catid);
						};
					}else{
						$catid = 0;
					};
					$map_catids = array();
					if (!empty($catid)) foreach ($catid as $tmp)
					{
						if (strpos($tmp, ',') > 0) {
							$map_catids = array_unique(array_merge($map_catids, explode(',', $tmp)));
						} else {
							$map_catids[] = $tmp;
						}
					}
				
					if (preg_match_all('/where="(.*?)"/', $matche, $where)) {
						$where = str_replace('where=','',$where[0]);
						$where = str_replace('"','',$where[0]);
					}else{
						$where = '';
					};
				
					$language 	= $this->app->getLanguage();
					$language->load('com_gmapfp');
					
					$random = rand(1, 999);
					$map='';
					
					$GMapFP_params->set('source', 'map');
					$datas = array();
					$datas['category_id'] = $map_catids;
					$datas['id'] = $map_ids;
					$datas['options'] = $options;
					$datas['params'] = $GMapFP_params;

					ob_start();
						echo LayoutHelper::render('map', $datas, '', array('component' => 'com_gmapfp'));
					$map = ob_get_clean();

					$row->introtext=str_replace($matche, $map, $row->introtext);
					if (property_exists($row, 'fulltext'))
					$row->fulltext=str_replace($matche, $map, $row->fulltext);
					if (property_exists($row, 'text'))
					$row->text=str_replace($matche, $map, $row->text);

					$cnt++;
				};
			}
		}		
		return true;	
	}
}
?>