<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => rl3('Locales Manager'),
		'class' => 'quti bg-cfpcolor',
		'search' => ['text' => rl3('Search Locales')],
		'paginator' => 'Locale',
		'btns' => [
			[
				'color' => 'inverted active',
				'href' => r3('index.php?ext=chronoforms&cont=locales&act=edit'),
				'hint' => rl3('Create a New Locale'),
				'icon' => 'language',
				'title' => rl3('New'),
			],
			[
				'color' => 'inverted active',
				'url' => r3('index.php?ext=chronoforms&cont=locales&act=copy'),
				'hint' => rl3('Copy Selected Locales'),
				'icon' => 'copy',
				'title' => rl3('Copy'),
				'selections' => '1',
				'message' => rl3('Please make a selection'),
			],
			[
				'color' => 'inverted active',
				'url' => r3('index.php?ext=chronoforms&cont=locales&act=delete'),
				'hint' => rl3('Delete Selected Locales'),
				'icon' => 'trash',
				'title' => rl3('Delete'),
				'selections' => '1',
				'message' => rl3('Please make a selection'),
			],
		]
	]);
?>

<?php $this->view('views.admin.listing', [
	'id' => 'Locale.id',
	'paginator' => 'Locale',
	'fields' => [
		[
			'name' => 'Locale.id', 
			'title' => rl3('ID'),
			'content' => function($row){
				return $row['Locale']['id'];
			}
		],
		[
			'name' => 'Locale.title', 
			'title' => rl3('Title'),
			'content' => function($row){
				return $this->Html->a($row['Locale']['title'], r3('index.php?ext=chronoforms&cont=locales&act=edit'.rp3('id', $row['Locale'])))
				.'<br>'.'<small>'.$row['Locale']['alias'].'</small>'
				.(!empty($row['Locale']['description']) ? '<br><small class="ui text grey">'.nl2br($row['Locale']['description']).'</small>' : '');
			}
		],
		[
			'name' => 'Locale.enabled', 
			'title' => rl3('Enable'),
			'content' => function($row){
				return $this->Html->toggler($row['Locale']['enabled'], r3('index.php?ext=chronoforms&cont=locales&act=toggle'.rp3('gcb', $row['Locale']['id']).rp3('fld', 'enabled').rp3('val', (int)!(bool)$row['Locale']['enabled'])));
			}
		],
	],
	'rows' => $locales,
]); ?>