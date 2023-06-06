<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$title = '';
	if($this->data('pversion') == 'cf5'){
		$title = rl3('ChronoForms 5 Manager');
	}
	$this->view('views.admin.page_menu', [
			'title' => $title,
			'class' => 'quti bg-cfpcolor',
			// 'search' => ['text' => rl3('Search Forms')],
			'paginator' => 'Connection',
			'btns' => [
				[
					'color' => 'active inverted',
					'href' => r3('index.php?ext=chronoforms&cont=connections'),
					'hint' => rl3('Back to v7 Forms Manager'),
					'icon' => 'arrow-left',
					'title' => rl3('ChronoForms 7 Manager'),
				],
			]
	]);
?>

<?php $this->view('views.admin.listing', [
	'id' => 'Connection.id',
	'paginator' => 'Connection',
	'fields' => [
		[
			'name' => 'Connection.id', 
			'title' => rl3('ID'),
			'content' => function($row){
				return $row['Connection']['id'];
			}
		],
		[
			'name' => 'Connection.title', 
			'title' => rl3('Title'),
			'content' => function($row){
				$tags = '';
				return $this->Html->a($row['Connection']['title'], r3('index.php?ext=chronoforms&cont=connections&act=edit_legacy&pversion='.$this->data('pversion').'&pid='.$row['Connection']['id']))
				.'<br>'.'<small>'.$row['Connection']['alias'].'</small>'
				.(!empty($row['Connection']['description']) ? '<br><span class="ui text grey">'.nl2br($row['Connection']['description']).'</span>' : '').(!empty($tags) ? '<br>'.$tags : '');
			}
		],
		// [
		// 	'name' => 'Connection.apptype', 
		// 	'title' => rl3('Type'),
		// 	'content' => function($row){
		// 		$colors = [
		// 			'contact' => 'blue',
		// 			'form' => 'teal',
		// 		];
		// 		return '<label class="ui label '.($colors[$row['Connection']['apptype']] ?? '').'">'.\G3\L\Str::camilize($row['Connection']['apptype']).'</label>';
		// 	}
		// ],
		[
			'name' => 'Connection.published', 
			'title' => rl3('Enable'),
			'content' => function($row){
				return $this->Html->toggler($row['Connection']['published'], r3('index.php?ext=chronoforms&cont=connections&act=toggle'.rp3('gcb', $row['Connection']['id']).rp3('fld', 'published').rp3('val', (int)!(bool)$row['Connection']['published'])));
			}
		],
		[
			'name' => 'View', 
			'title' => rl3('Preview'),
			'content' => function($row){
				return $this->Html->a('<i class="faicon external-link-alt"></i>'.rl3('Admin'), r3('index.php?ext=chronoforms&cont=manager'.rp3('chronoform', $row['Connection']['alias'])), ['target' => '_blank']).
				'&nbsp;|&nbsp;'.
				$this->Html->a('<i class="faicon external-link-alt"></i>'.rl3('Front'), r3(\G3\Globals::get('ROOT_URL').'index.php?ext=chronoforms'.rp3('chronoform', $row['Connection']['alias'])), ['target' => '_blank']);
			}
		],
	],
	'rows' => $connections,
]); ?>