<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<button type="button" class="ui button icon labeled <?php echo $color ?? 'orange'; ?> fluid refresh_dragged" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=refresh_element&tvout=view&Connection[id]='.$this->data('Connection.id')); ?>"><i class="faicon sync"></i><?php echo $label ?? rl3('Update Areas'); ?></button>