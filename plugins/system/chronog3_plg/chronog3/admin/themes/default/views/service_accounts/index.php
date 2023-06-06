<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => rl3('Acls Manager'),
		'class' => 'quti bg-cfpcolor',
		'search' => ['text' => rl3('Search Acls')],
		'paginator' => 'UserServiceAccount',
		'btns' => [
			[
				'color' => 'inverted active',
				'href' => r3('index.php?ext=chronoforms&cont=service_accounts&act=edit'),
				'hint' => rl3('Create a New Acl Profile'),
				'icon' => 'user-shield',
				'title' => rl3('New'),
			],
			[
				'color' => 'inverted active',
				'url' => r3('index.php?ext=chronoforms&cont=service_accounts&act=copy'),
				'hint' => rl3('Copy Selected Acls'),
				'icon' => 'copy',
				'title' => rl3('Copy'),
				'selections' => '1',
				'message' => rl3('Please make a selection'),
			],
			[
				'color' => 'inverted active',
				'url' => r3('index.php?ext=chronoforms&cont=service_accounts&act=delete'),
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
	'id' => 'UserServiceAccount.id',
	'paginator' => 'UserServiceAccount',
	'fields' => [
		[
			'name' => 'UserServiceAccount.id', 
			'title' => rl3('ID'),
			'content' => function($row){
				return $row['UserServiceAccount']['id'];
			}
		],
		[
			'name' => 'UserServiceAccount.account_id', 
			'title' => rl3('Account ID'),
			'content' => function($row){
				return $this->Html->a($row['UserServiceAccount']['account_id'], r3('index.php?ext=chronoforms&cont=service_accounts&act=edit'.rp3('id', $row['UserServiceAccount'])))
				.'<br>'.'<small>'.$row['UserServiceAccount']['service'];
			}
		],
		[
			'name' => 'UserServiceAccount.user_id', 
			'title' => rl3('User ID'),
			'content' => function($row){
				return $row['UserServiceAccount']['user_id'];
			}
		],
	],
	'rows' => $accounts,
]); ?>
