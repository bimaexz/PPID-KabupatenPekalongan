<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	ob_start();
?>
<script>
	jQuery(document).ready(function($) {
		function updatePermissions(dropdown, value){
			if(value == ''){
				//not set
				dropdown.removeClass('grey red green').addClass('');
			}else if(value == 0){
				//inherited
				dropdown.removeClass('grey red green').addClass('');
				dropdown.find('i').removeClass('ban check question').addClass('question');
				//find parent
				var current_depth = dropdown.closest('.field').find('i.depth').length;
				$.each(dropdown.closest('.field').prevAll('.field'), function(i, obj){
					var field_depth = $(obj).closest('.field').find('i.depth').length;
					var existing_value = $(obj).find('input').first().val();
					
					if(field_depth == current_depth - 1){
						$(obj).find('.ui.dropdown.permission').trigger('change');
					}
				});
			}else if(value == -1 || value == -2){
				//denied
				dropdown.removeClass('grey red green').addClass('red');
				dropdown.find('i').removeClass('ban check question').addClass('ban');
				updateChildren(dropdown, value, [0, -1], true);
			}else if(value == 1){
				//allowed
				dropdown.removeClass('grey red green').addClass('green');
				dropdown.find('i').removeClass('ban check question').addClass('check');
				updateChildren(dropdown, value, [0, 1, -1], false);
			}
		}
		
		function updateChildren(dropdown, value, update, disable){
			var current_depth = dropdown.closest('.field').find('i.depth').length;
			$.each(dropdown.closest('.field').nextAll('.field'), function(i, obj){
				var field_depth = $(obj).closest('.field').find('i.depth').length;
				var existing_value = $(obj).find('input').first().val();
				
				if(field_depth == current_depth + 1 && ($.inArray(parseInt(existing_value), update) > -1 || existing_value == '')){
					$(obj).find('input').first().val(value);
					$(obj).find('.ui.dropdown.permission').dropdown('set selected', value);
					$(obj).find('.ui.dropdown.permission').trigger('change');
					/*
					if(disable){
						$(obj).find('.ui.dropdown.permission').addClass('disabled');
					}else{
						$(obj).find('.ui.dropdown.permission').removeClass('disabled');
					}
					*/
					//$(obj).find('.ui.dropdown.permission').dropdown('refresh');
				}else{
					//return false;
					if(field_depth == current_depth){
						return false;
					}
				}
			});
		}
		$('.ui.dropdown.permission').on('change', function(){
			var value = $(this).find('input').first().val();
			updatePermissions($(this), value);
			
		});
		$('.ui.dropdown.permission').trigger('change');
	});
</script>
<?php
	$jscode = ob_get_clean();
	\GApp3::document()->addHeaderTag($jscode);
?>
<?php $perm_selections = array(0 => rl3('Inherited'), /*'' => rl3('Not set'),*/ 1 => rl3('Allowed'), -1 => rl3('Denied'), -2 => rl3('Banned')); ?>
<?php
	if(\G3\Globals::get('app') == 'wordpress'){
		$groups = array_merge($groups, \GApp3::get_gcore_wp_usergroups());
	}
?>
<div class="ui grid fluid equal width segment basic">
<div class="four wide column <?php if(!empty($hidden_labels)): ?>hidden<?php endif; ?>">
		<div class="ui vertical pointing menu fluid G3-tabs">
			<?php $counter = 0; ?>
			<?php foreach($perms as $action => $label): ?>
				<?php if(strpos($action, '_') !== 0): ?>
					<a class="red item<?php echo ($counter == 0) ? ' active':''; ?>" data-tab="perm-<?php echo $action; ?>"><?php echo $label; ?></a>
					<?php $counter++; ?>
				<?php else: ?>
					<div class="header item"><?php echo $label; ?></div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="stretched column">
		<?php $counter = 0; ?>
		<?php foreach($perms as $action => $label): ?>
			<?php if(empty($action))continue; ?>
			<div class="ui segment tab<?php echo ($counter == 0) ? ' active':''; ?>" data-tab="perm-<?php echo $action; ?>">
				<?php foreach($groups as $k => $group): ?>
					<?php //echo $this->Html->formLine('Category[rules]['.$action.']['.$g_id.']', array('type' => 'dropdown', 'label' => $g_name, 'class' => 'A', 'options' => array(0 => rl3('INHERITED'), '' => rl3('NOT_SET'), 1 => rl3('ALLOWED'), -1 => rl3('DENIED')))); ?>
					<div class="field">
						<label><?php echo $group['Group']['title']; ?></label>
						<?php echo str_repeat('<i class="faicon angle-right depth"></i>', count($group['Group']['_parents'])); ?>
						<div class="ui dropdown labeled icon buttond label permission">
							<i class="faicon question"></i>
							<input type="hidden" name="<?php echo $model; ?>[rules][<?php echo $action; ?>][<?php echo $group['Group']['id']; ?>]" value="" />
							<div class="default text">------</div>
							<div class="menu">
								<?php foreach($perm_selections as $id => $title): ?>
								<div class="item" data-value="<?php echo $id; ?>"><?php echo $title; ?></div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php $counter++; ?>
		<?php endforeach; ?>
	</div>
</div>