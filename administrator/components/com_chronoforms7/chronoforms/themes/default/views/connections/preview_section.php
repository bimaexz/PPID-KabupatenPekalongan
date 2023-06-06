<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
// $result = '';
// foreach($this->data('Connection.views') as $view){
//     $result .= $this->Parser->view($view);
// }
$result = $this->Parser->section($section);

echo $result;