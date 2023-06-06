<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
			'title' => rl3('Acls Manager'),
			'class' => 'quti bg-cfpcolor',
			'search' => ['text' => rl3('Search Acls')],
			'paginator' => 'AclProfile',
			'btns' => [
				[
					'color' => 'inverted active',
					'href' => r3('index.php?ext=chronoforms&cont=acls&act=edit'),
					'hint' => rl3('Create a New Acl Profile'),
					'icon' => 'user-shield',
					'title' => rl3('New'),
				],
				[
					'color' => 'inverted active',
					'url' => r3('index.php?ext=chronoforms&cont=acls&act=copy'),
					'hint' => rl3('Copy Selected Acls'),
					'icon' => 'copy',
					'title' => rl3('Copy'),
					'selections' => '1',
					'message' => rl3('Please make a selection'),
				],
				[
					'color' => 'inverted active',
					'url' => r3('index.php?ext=chronoforms&cont=acls&act=delete'),
					'hint' => rl3('Delete Selected Acls'),
					'icon' => 'trash',
					'title' => rl3('Delete'),
					'selections' => '1',
					'message' => rl3('Please make a selection'),
				],
			]
	]);
?>

<?php $this->view('views.admin.listing', [
	'id' => 'AclProfile.id',
	'paginator' => 'AclProfile',
	'fields' => [
		[
			'name' => 'AclProfile.id', 
			'title' => rl3('ID'),
			'content' => function($row){
				return $row['AclProfile']['id'];
			}
		],
		[
			'name' => 'AclProfile.title', 
			'title' => rl3('Title'),
			'content' => function($row){
				return $this->Html->a($row['AclProfile']['title'], r3('index.php?ext=chronoforms&cont=acls&act=edit'.rp3('id', $row['AclProfile'])))
				.'<br>'.'<small>'.$row['AclProfile']['alias'].'</small>'
				.(!empty($row['AclProfile']['description']) ? '<br><small class="ui text grey">'.nl2br($row['AclProfile']['description']).'</small>' : '');
			}
		],
		[
			'name' => 'AclProfile.enabled', 
			'title' => rl3('Enable'),
			'content' => function($row){
				return $this->Html->toggler($row['AclProfile']['enabled'], r3('index.php?ext=chronoforms&cont=acls&act=toggle'.rp3('gcb', $row['AclProfile']['id']).rp3('fld', 'enabled').rp3('val', (int)!(bool)$row['AclProfile']['enabled'])));
			}
		],
	],
	'rows' => $acls,
]); ?>
