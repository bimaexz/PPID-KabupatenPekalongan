<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$btn_defaults = [
		'add' => ['icon' => 'copy', 'color' => 'blue', 'hint' => rl3('Copy')],
		'delete' => ['icon' => 'trash', 'color' => 'red', 'hint' => rl3('Delete')],
		'sort' => ['icon' => 'sort', 'color' => 'yellow', 'hint' => rl3('Sort')],
	];
?>
<?php foreach($inputs[$group][$grouptype] as $rowk => $row_inputs): ?>
<div class="<?php echo $rowk; ?> <?php if(count($row_inputs) > 1): ?>fields<?php else: ?>ui container fluid<?php endif; ?>">
	<?php foreach($row_inputs as $input): ?>
		<?php
			if(!empty($input['ignore'])){
				continue;
			}
			$attrs = '';
			if(!empty($input['params'])){
				foreach($input['params'] as $pname => $pvalue){
					if($pname == 'origin'){
						foreach($pvalue as $attr_name => $attr_value){
							$attrs .= ' '.$attr_name.'="'.str_replace(array_keys($keys), array_values($keys), $attr_value).'"';
						}
					}else{
						if(strpos($pvalue, '"') === false){
							$attrs .= ' '.$pname.'="'.$pvalue.'"';
						}else{
							$attrs .= ' '.$pname.'=\''.$pvalue.'\'';
						}
					}
				}
				if(!empty($input['params']['origin'])){
					$attrs .= " data-origin='".json_encode($input['params']['origin'])."'";
				}
			}
		?>
		<div class="<?php echo !empty($input['width']) ? $input['width'] : ''; ?> field">
			<?php if(!empty($input['label'])): ?><label><?php echo $input['label']; ?></label><?php endif; ?>
			<?php if(empty($input['type']) OR $input['type'] == 'text'): ?>
				<input type="text" <?php echo $attrs; ?>>
			<?php elseif($input['type'] == 'input'): ?>
				<div class="ui icon input">
					<input type="text" <?php echo $attrs; ?>>
					<i class=" icon"></i>
				</div>
			<?php elseif($input['type'] == 'checkbox' OR $input['type'] == 'radio'): ?>
				<div class="ui checkbox toggle" style="margin-top:0;">
					<input type="<?php echo $input['type']; ?>" class="hidden" <?php echo $attrs; ?>>
					<label><?php echo $input['label'] ?? ''; ?></label>
				</div>
			<?php elseif($input['type'] == 'select'): ?>
				<select <?php echo $attrs; ?> class="ui fluid dropdown search">
					<?php if(!empty($input['options'])): ?>
						<?php foreach($input['options'] as $value => $text): ?>
							<?php
								$option_settings = '';
								if(!empty($input['options_settings'][$value])){
									$option_settings = "data-settings='".$input['options_settings'][$value]."'";
								}

								$option_attrs = '';
								if(!empty($input['options_attrs'][$value])){
									foreach($input['options_attrs'][$value] as $opattrname => $opattrval){
										$option_attrs .= " ".$opattrname."='".$opattrval."'";
									}
								}
							?>
							<option <?php echo $option_settings; ?> <?php echo $option_attrs; ?> value="<?php echo $value; ?>"><?php echo $text; ?></option>
						<?php endforeach; ?>
					<?php else: ?>
						
					<?php endif; ?>
				</select>
			<?php elseif($input['type'] == 'add_clone'): ?>
				<button type="button" data-group="<?php echo $group; ?>" data-subgroup="<?php echo $input['subgroup']; ?>" data-cloning="source" <?php echo $attrs; ?> class="ui button icon compact fluid <?php if(!empty($input['text'])): ?>labeled<?php endif; ?> <?php echo !empty($input['color']) ? $input['color'] : 'black'; ?> tiny add_clone"><i class="faicon <?php echo $input['icon']; ?>"></i><?php echo $input['text']; ?></button>
			<?php elseif($input['type'] == 'textarea'): ?>
				<textarea <?php echo $attrs; ?>></textarea>
			<?php elseif($input['type'] == 'empty'): ?>
				<div <?php echo $attrs; ?>></div>
			<?php elseif($input['type'] == 'button'): ?>
				<button <?php echo $attrs; ?>><?php echo $input['text']; ?></button>
			<?php elseif($input['type'] == 'string'): ?>
				<div <?php echo $attrs; ?>><?php echo $input['string']; ?></div>
			<?php elseif($input['type'] == 'require'): ?>
				<?php $this->view($input['file'], array_merge(['item' => $item, 'parents' => $keys], $input['vars'])); ?>
			<?php elseif($input['type'] == 'btns'): ?>
				<?php foreach($input['btns'] as $t => $btn): ?>
					<?php
						$btn = array_merge($btn_defaults[$t] ?? [], $btn);
						$hidden = '';
						if(isset($btn['hidden']) AND $key <= $btn['hidden']){
							$hidden = 'hidden';
						}
					?>
					<?php if(empty($btn['text'])): ?>
						<a data-group="<?php echo $group; ?>" data-cloning="copy" class="ui button icon compact circular <?php echo $btn['color']; ?> mini <?php echo $t; ?>_clone <?php echo $btn['class'] ?? ''; ?> <?php echo $hidden; ?>" data-hint="<?php echo $btn['hint']; ?>"><i class="faicon <?php echo $btn['icon']; ?>"></i></a>
					<?php else: ?>
						<button type="button" data-group="<?php echo $group; ?>" data-cloning="copy" class="ui button icon compact labeled <?php echo $btn['color']; ?> mini <?php echo $t; ?>_clone <?php echo $btn['class'] ?? ''; ?> <?php echo $hidden; ?>" data-hint="<?php echo $btn['hint']; ?>"><i class="faicon <?php echo $btn['icon']; ?>"></i><?php echo $btn['text']; ?></button>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if(!empty($input['desc'])): ?>
				<small><?php echo $input['desc']; ?></small>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
	</div>
<?php endforeach; ?>