<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => rl3('Create New Form'),
		'class' => 'quti bg-cfpcolor',
		'btns' => [
			[
				'color' => 'active inverted',
				'href' => r3('index.php?ext=chronoforms&cont=connections'),
				'hint' => rl3('Close'),
				'icon' => 'times',
				'title' => rl3('Close'),
			],
		]
	]);
?>
<div class="quti segment my-0 bottom attached">
	<div class="ui container grid two columns center aligned">
		<div class="row">
			<div class="column">
				<div class="ui segment raised">
					<h2 class="ui header"><?php el3('Contact Form'); ?></h2>
					<p><?php el3('Simplified interface with quick Admin and User Emails behaviors, Confirmation Message and Data Logging'); ?></p>
					<a class="ui button compact fluid circular blue" href="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=edit&apptype=contact'); ?>">
						<?php el3('Create a new Contact Form'); ?>
					</a>
				</div>
			</div>
			<div class="column">
				<div class="ui segment raised">
					<h2 class="ui header"><?php el3('Advanced Form'); ?></h2>
					<p><?php el3('Experience all the ChronoForms v7 features, add actions to your form and control Page Groups and More'); ?></p>
					<a class="ui button compact fluid circular teal" href="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=edit&apptype=form'); ?>">
						<?php el3('Create a new Advanced Form'); ?>
					</a>
				</div>
				<div class="ui segment raised">
					<h2 class="ui header"><?php el3('Connectivity App'); ?></h2>
					<p><?php el3('Build a custom app using global units and page code (the ChronoConnectivity way)'); ?></p>
					<a class="ui button compact fluid circular orange" href="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=edit&apptype=connectivity'); ?>">
						<?php el3('Create a new Connectivity App'); ?>
					</a>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="column">
				<h1 class="ui header dividing">
					<?php el3('Demo Forms'); ?>
				</h1>
			</div>
		</div>

		<div class="row">
			<?php
				$demos = [];
				
				$path = \G3\L\Extension::getInstance('chronoforms')->path();
				$path = $path.'demos'.DS;
				$d = dir($path);
				while(false !== ($entry = $d->read())){
					
					$filepath = $path.$entry;
					if(is_file($filepath)){
						$data = file_get_contents($filepath);
						$form = json_decode($data, true);
						//pr($form);
						$name = explode('.', basename($filepath))[0];
						$demos[$name] = [
							'name' => $form[0]['Connection']['title'],
							'description' => $form[0]['Connection']['description'],
						];
					}
				}
				
			?>
			<table class="ui table celled padded inverted quti text-center">
				<thead>
					<tr>
						<th class="single line five wide"><?php el3('Title'); ?></th>
						<th><?php el3('Description'); ?></th>
						<th><?php el3('Edit'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($demos as $name => $data): ?>
					<tr>
						<td><h4 class="ui center aligned header inverted blue"><?php echo $data['name']; ?></h4></td>
						<td class="left aligned"><?php echo nl2br($data['description']); ?></td>
						<td><a class="ui button compact fluid circular blue" href="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=demos&name='.$name); ?>">
								<?php el3('Edit'); ?>
						</a></td>
					</tr>
					<!-- <div class="column" style="margin:5px;">
						<div class="ui segment raised">
							<h2 class="ui header"><?php echo $data['name']; ?></h2>
							<p><?php echo nl2br($data['description']); ?></p>
							<a class="ui button compact fluid circular blue" href="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=demos&name='.$name); ?>">
								<?php el3('Edit %s', [$data['name']]); ?>
							</a>
						</div>
					</div> -->
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>

	</div>
</div>