<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment teal draggable-receiver grey tertiary" data-receive="views" style="min-height:150px; margin:0; padding-top:5px;"  data-area="<?php echo $pcount; ?>">
	<label class="ui label teal ribbon quti bg-teal text-white" style="z-index:1005;"><?php el3('Views'); ?></label>
	<?php if(!empty($views)): ?>
		<?php foreach($views as $view_n => $view): ?>
			<?php if(($view['_area'] == $pcount)): ?>
				<?php $this->view('views.connections.units_config', ['utype' => 'views', 'type' => $view['type'], 'count' => $view_n, 'unit' => $view, 'units' => $views, 'starting_unit' => true]); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php else: ?>
		<div class="ui icon message center aligned empty_form_message">
			<i class="faicon question"></i>
			<div class="content">
				<div class="header">
					<?php el3('This page has no views, you may drag one from the %s menu above', ['<div class="ui label quti bg-teal text-white">Views</div>']); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="ui dimmer">
		<div class="content">
			<h3 class="ui inverted header"><?php el3('Views are the rendered HTML blocks, e.g.: form inputs, tables, charts'); ?></h3>
			<div class="ui teal button icon labeled"><i class="faicon toggle-on"></i><?php el3('Switch to Views Editor'); ?></div>
		</div>
	</div>
</div>
<div class="ui segment blue draggable-receiver  grey tertiary drop_disabled contact-hidden" data-receive="functions" style="min-height:90px; padding-top:5px;"  data-area="<?php echo $pcount; ?>">
	<label class="ui label ribbon quti bg-purple text-white" style="z-index:1005;"><?php el3('Actions'); ?></label>
	<?php if(!empty($functions)): ?>
		<?php foreach($functions as $function_n => $function): ?>
			<?php if(($function['_area'] == $pcount)): ?>
				<?php $this->view('views.connections.units_config', ['utype' => 'functions', 'type' => $function['type'], 'count' => $function_n, 'unit' => $function, 'units' => $functions, 'starting_unit' => true]); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php else: ?>
		
	<?php endif; ?>
	<div class="ui dimmer active">
		<div class="content">
			<h3 class="ui inverted header"><?php el3('Actions are server side functions, e.g.: Emails, Database read/write'); ?></h3>
			<div class="ui purple button icon labeled"><i class="faicon toggle-on"></i><?php el3('Switch to Actions Editor'); ?></div>
		</div>
	</div>
</div>