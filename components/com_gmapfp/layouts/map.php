<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_9F
	* Creation date: Octobre 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\Uri\Uri;

$link = '';
$source = '';
$zoom = '';
$item = '';
$num = rand(1000, 9999);

$params = $displayData['params'];
$category_params = (array_key_exists('category_params', $displayData)) ? new Registry($displayData['category_params']) : new Registry('');
//récupère les paramètres 
if (array_key_exists('category_id', $displayData) and !empty($displayData['category_id'])){
	$link .= 'category&catid='.json_encode($displayData['category_id']);
}
if (array_key_exists('id', $displayData) and !empty($displayData['id'])){
	if (is_array($displayData['id']))
		$link .= 'category&id='.json_encode($displayData['id']);
	else
		$link .= 'item&id='.json_encode($displayData['id']);
}
$source = $params->get('source');
if (array_key_exists('item', $displayData)) $item = $displayData['item'];

$document = Factory::getApplication()->getDocument();
$document->addScript('index.php?option=com_gmapfp&view='.$link.'&format=raw&map=1&num='.$num);

$document->addScript('media/com_gmapfp/js/front-map.js');

$wa = $document->getWebAssetManager();
$wa->useScript('jquery')
	->addInlineScript('var rootFull = "'.URI::base().'";');
	// ->useScript('com_gmapfp.front-map');

$largeur = $params->get('gmapfp_width', '100%');
if (substr($largeur,-1,1)!='%' and substr($largeur,-2,2)!='px')
	$largeur = (int)$largeur.'px';
$hauteur = $params->get('gmapfp_height', '500');
if (substr($hauteur,-1,1)!='%' and substr($hauteur,-2,2)!='px')
	$hauteur = (int)$hauteur.'px';

/*********************************************
* traitement des données de zoom et centrage *
*********************************************/

switch ($source) {
	case 'item':
		switch ($params->get('gmapfp_zoom_lightbox_carte', 100)) {
			case 0:
				$zoom = $params->get('gmapfp_zoom', 0);
				break;
			case 100:
				$zoom = $item->gzoom;
				break;
			default :
				$zoom = $params->get('gmapfp_zoom_lightbox_carte');
		}
		break;
	default :
		$zoom = $params->get('gmapfp_zoom', 0);
}

if($params->get('target') == 0)
	echo HTMLHelper::_(
		'bootstrap.renderModal',
		'GmapfpMapLinkModal',
		array(
			'url'        => 'index.php?option=com_gmapfp&view=item&tmpl=component&id=',
			'height'     => $params->get('gmapfp_hauteur_lightbox', 400),
			'width'      => $params->get('gmapfp_largeur_lightbox', 700),
			'footer'     => '<a href="//gmapfp.org" target="_blank" >GMapFP</a>'
		)
	);

?>
<div class="com-gmapfp-carte item-page">
	<div id="gmapfp_map<?php echo $num;?>" style="width: <?php echo $largeur;?>; height: <?php echo $hauteur;?>; overflow:hidden;"></div>

	<?php
		$plugin_name = $params->get('plugin_map_name', 'google');
		echo LayoutHelper::render($plugin_name.'_front', array('num' => $num, 'params' => $params, 'kml_cat' => $category_params->get('kml_categories')), JPATH_ROOT . '/plugins/gmapfp-map/'.$plugin_name.'/tmpl');
		// include PluginHelper::getLayoutPath('gmapfp-map', $plugin_name, $plugin_name.'_front');
	?>

</div>
