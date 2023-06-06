<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui menu inverted small quti bg-grey800">
	<a class="item icon blue <?php if($this->action == 'index' AND $this->controller == ''): ?>active<?php endif; ?>" href="<?php echo r3('index.php?ext='.$this->extension); ?>">
		<div class="quti text-md m-0 text-blue500 font-bold"><?php echo $title; ?></div>
	</a>
	<?php
		$items = array_merge($items, [
			['cont' => 'tasks', 'act' => 'clear_cache', 'title' => rl3('Clear cache'), 'hidden' => true],
			['cont' => 'languages', 'title' => rl3('Translations'), 'hidden' => true],
			//['act' => 'validateinstall', 'title' => rl3('Validate')],
		]);
	?>
	<?php foreach($items as $k => $amdata): ?>
		<?php
			$items[$k]['active'] = '';
			$icon = '';
			
			if(!empty($amdata['cont'])){
				if(strtolower(\GApp3::instance()->controller) == $amdata['cont']){
					if(empty($amdata['act'])){
						$items[$k]['active'] = 'active';
					}else{
						if(strtolower(\GApp3::instance()->action) == $amdata['act']){
							$items[$k]['active'] = 'active';
						}
					}
				}
				
				if($amdata['cont'] == 'languages'){
					$items[$k]['icon'] = 'language';
				}
				
				if($amdata['cont'] == 'tags'){
					$items[$k]['icon'] = 'tag';
				}
			}
			if(!empty($amdata['act'])){
				if($this->action == $amdata['act']){
					$items[$k]['active'] = 'active';
				}
				
				if($amdata['act'] == 'install_feature'){
					$items[$k]['icon'] = 'magic';
				}
				
				if($amdata['act'] == 'clear_cache'){
					$items[$k]['icon'] = 'recycle';
				}
				
				if($amdata['act'] == 'validateinstall'){
					$items[$k]['icon'] = 'checkmark';
				}
				
				if($amdata['act'] == 'info'){
					$items[$k]['icon'] = 'question';
				}
				
				if($amdata['act'] == 'settings'){
					$items[$k]['icon'] = 'settings';
				}
				
				if($amdata['act'] == 'permissions'){
					$items[$k]['icon'] = 'key';
				}
			}
			
			if(!empty($amdata['icon'])){
				$items[$k]['icon'] = $amdata['icon'];
			}
			
			$items[$k]['url'] = 'index.php?ext='.$this->extension.(!empty($amdata['cont']) ? '&cont='.$amdata['cont'] : '').(!empty($amdata['act']) ? '&act='.$amdata['act'] : '');
			
			if(!empty($amdata['hidden'])){
				continue;
			}
		?>
		<a class="item blue <?php echo $items[$k]['active']; ?>" href="<?php echo r3($items[$k]['url']); ?>">
			<?php if(!empty($items[$k]['icon'])): ?>
				<i class="faicon <?php echo $items[$k]['icon']; ?> quti mr-2"></i>
			<?php endif; ?>
			<?php echo $amdata['title']; ?>
			<?php
				// if(!empty($amdata['act']) AND $amdata['act'] == 'validateinstall'){
				// 	$valid = \GApp3::extension($this->get('ext'))->valid();
				// 	if($valid === false){
				// 		echo '&nbsp;<i class="icon exclamation red circular inverted small"></i>';
				// 	}else if($valid === true){
				// 		echo '&nbsp;<i class="icon checkmark green circular inverted small"></i>';
				// 	}else if(is_numeric($valid)){
				// 		echo '<span class="ui label green"><i class="icon checkmark"></i>'.rl3('%s days left', [$valid]).'</span>';
				// 	}
				// }
			?>
		</a>
	<?php endforeach; ?>
	<div class="ui dropdown icon item">
		<i class="faicon ellipsis-h"></i>
		<div class="menu">
			<?php foreach($items as $k => $amdata): ?>
				<?php
					if(empty($amdata['hidden'])){
						continue;
					}
				?>
				<a class="item blue <?php echo $items[$k]['active']; ?>" href="<?php echo r3($items[$k]['url']); ?>">
					<?php if(!empty($items[$k]['icon'])): ?>
						<i class="faicon <?php echo $items[$k]['icon']; ?> quti mr-1"></i>
					<?php endif; ?>
					<?php echo $amdata['title']; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<a class="item right" href="<?php echo r3('index.php?ext='.$this->extension.'&cont=tasks&act=validate'); ?>">
		<?php
			$valid = \GApp3::extension($this->get('ext'))->valid();
			if($valid === false){
				echo '<div class="quti bg-red700 p-1 rounded px-2 font-bold text-sm"><i class="faicon cancel quti mr-1"></i>'.$title.' is NOT Validated</div>';
			}else if($valid === true){
				echo '<div class="quti bg-green700 p-1 rounded px-2 font-bold text-sm"><i class="faicon check quti mr-1"></i>'.$title.' is Validated</div>';
			}else if(is_numeric($valid)){
				echo '<div class="quti bg-green700 p-1 rounded px-2 font-bold text-sm"><i class="faicon clock quti mr-1"></i>'.$title.' is Validated, '.rl3('%s days left', [$valid]).'</div>';
			}
		?>
	</a>
</div>