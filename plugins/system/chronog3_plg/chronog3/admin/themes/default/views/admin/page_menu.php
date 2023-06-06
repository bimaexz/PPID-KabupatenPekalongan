<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui menu inverted small top attached G3-tabs <?php echo $class ?? ''; ?>">
	<?php if(!empty($title)): ?>
	<h3 class="item notab quti text-md m-0">
		<?php echo $title; ?>
	</h3>
	<?php endif; ?>

	<?php if(!empty($search)): ?>
	<div class="item notab">
		<div class="ui input icon">
			<input class="prompt" name="_search" type="text" placeholder="<?php echo $search['text'] ?? ''; ?>">
			<i class="faicon search link"></i>
		</div>
		<!-- <div class="results"></div> -->
	</div>
	<?php endif; ?>

	<?php if(!empty($items)): ?>
		<?php foreach($items as $it => $item): ?>
			<?php if(!empty($item['options'])): ?>
				<div class="ui dropdown icon item <?php echo $item['color'] ?? ''; ?> <?php echo $item['active'] ?? ''; ?>">
					<i class="faicon <?php echo $item['icon']; ?>"></i>&nbsp;
					<?php echo $item['title']; ?>
					<div class="menu">
						<?php foreach($item['options'] as $k => $option): ?>
							<a class="item blue" href="<?php echo $option['url']; ?>">
								<?php echo $option['title']; ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php else: ?>
				<?php if(!empty($item['url'])): ?>
					<a class="item <?php echo $item['color'] ?? ''; ?> <?php echo $item['active'] ?? ''; ?>" href="<?php echo $item['url']; ?>">
						<i class="faicon <?php echo $item['icon']; ?>"></i>&nbsp;
						<?php echo $item['title']; ?>
					</a>
				<?php else: ?>
					<a class="item <?php echo $item['color'] ?? ''; ?> <?php echo $item['active'] ?? ''; ?>" data-tab="<?php echo $it; ?>">
						<i class="faicon <?php echo $item['icon']; ?>"></i>&nbsp;
						<?php echo $item['title']; ?>
					</a>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if(!empty($btns)): ?>
	<div class="item notab right">
		<?php foreach($btns as $bt => $btn): ?>
			<?php
				$attrs = '';
				if(!empty($btn['attrs'])){
					foreach($btn['attrs'] as $k => $v){
						$attrs .= ' '.$k.'="'.$v.'"';
					}
				}

				$labeled = 'labeled';
				if(empty($btn['title'])){
					$labeled = '';
				}

				$title = !empty($btn['title']) ? '&nbsp;'.$btn['title'] : '';
			?>
			<?php if(!empty($btn['href'])): ?>
				<a class="ui button tiny icon <?php echo $labeled; ?> quti bg-white text-grey800 <?php echo $btn['color'] ?? ''; ?>" href="<?php echo $btn['href'] ?? ''; ?>" data-hint="<?php echo $btn['hint'] ?? ''; ?>" <?php echo $attrs; ?>>
					<i class="faicon <?php echo $btn['icon']; ?>"></i><?php echo $title; ?>
				</a>
			<?php else: ?>
				<button type="button" name="<?php echo $btn['name'] ?? ''; ?>" class="ui button tiny icon <?php echo $labeled; ?> toolbar-button quti bg-white text-grey800 <?php echo $btn['color'] ?? ''; ?>" data-url="<?php echo $btn['url'] ?? ''; ?>" data-hint="<?php echo $btn['hint'] ?? ''; ?>" data-selections="<?php echo $btn['selections'] ?? '0'; ?>" data-message="<?php echo $btn['message'] ?? ''; ?>" <?php echo $attrs; ?>>
					<i class="faicon <?php echo $btn['icon']; ?>"></i><?php echo $title; ?>
				</button>
			<?php endif; ?>
			&nbsp;
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	
</div>