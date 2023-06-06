<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$Group = new \G3\A\M\Group();
	$_groups = $Group->select('flat');
	$_groups = array_merge([['Group' => ['id' => 'owner', 'title' => rl3('Owner'), '_parents' => []]]], $_groups);
	$groups = [];
	foreach($_groups as $g){
		$groups[$g['Group']['id']] = str_repeat('- ', count($g['Group']['_parents'])).$g['Group']['title'];
	}
?>

<?php $this->view('views.permissions_manager', ['model' => 'Connection['.$utype.']['.$n.']', 'perms' => ['access' => rl3('Access')], 'groups' => $_groups, 'hidden_labels' => true]); ?>