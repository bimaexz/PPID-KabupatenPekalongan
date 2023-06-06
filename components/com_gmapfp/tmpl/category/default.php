<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_5_0F
	* Creation date: Novembre 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

$this->params->set('source', 'category');
?>
<div class="com-gmapfp-category category-list">

	<?php
		if($this->params->get('map_position',1) == 1){
			if(isset($this->perso->intro_carte))
				echo '<div class="com_gmapfp_perso_avant_carte">'.$this->perso->intro_carte.'</div>';
			$catid = $this->get('category'); 
			echo LayoutHelper::render('map', array('category_id'=>$catid->id, 'params'=>$this->params));
			if(isset($this->perso->conclusion_carte))
				echo '<div class="com_gmapfp_perso_apres_carte">'.$this->perso->conclusion_carte.'</div>';
		}

		$this->subtemplatename = 'items';
		echo LayoutHelper::render('joomla.content.category_default', $this);

		if($this->params->get('map_position',1) == 2){
			if(isset($this->perso->intro_carte))
				echo '<div class="com_gmapfp_perso_avant_carte">'.$this->perso->intro_carte.'</div>';
			$catid = $this->get('category'); 
			echo LayoutHelper::render('map', array('category_id'=>$catid->id, 'params'=>$this->params));
			if(isset($this->perso->conclusion_carte))
				echo '<div class="com_gmapfp_perso_apres_carte">'.$this->perso->conclusion_carte.'</div>';
		}
	?>

</div>
