<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => rl3('View records of %s', [$this->data('tablename')]),
		'class' => 'quti bg-cfpcolor',
		'search' => ['text' => rl3('Search records')],
		'paginator' => 'Table',
		'btns' => [
			[
				'color' => 'inverted active',
				'href' => r3('index.php?ext=chronoforms&cont=connections'),
				'hint' => rl3('Back to Forms Manager'),
				'icon' => 'arrow-left',
				'title' => rl3('Forms Manager'),
			],
			// [
			// 	'color' => 'inverted active',
			// 	'href' => r3('index.php?ext=chronoforms&cont=logs&act=csv&form_id='.$connection['Connection']['id']),
			// 	'hint' => rl3('If no records are selected then all will be exported'),
			// 	'icon' => 'blue download',
			// 	'title' => rl3('CSV Export'),
			// ],
			[
				'color' => 'inverted active',
				'url' => r3('index.php?ext=chronoforms&cont=logs&act=tabledelete&tablename='.$this->data('tablename')),
				'hint' => rl3('Delete Selected Records'),
				'icon' => 'times',
				'title' => rl3('Delete'),
				'selections' => '1',
				'message' => rl3('Please make a selection'),
			],
		]
	]);
?>
<div class="ui container fluid">
<?php
	$listing_fields = [
		// [
		// 	'name' => 'Table.view', 
		// 	'title' => rl3('View'),
		// 	'class' => 'collapsing',
		// 	'content' => function($row) use ($Table) {
		// 		return $this->Html->a(rl3('View'), r3('index.php?ext=chronoforms&cont=logs&act=view&aid='.$row['Table'][$Table->pkey]));
		// 	}
		// ],
		
		[
			'name' => 'Table.data', 
			'title' => rl3('Data'),
			'class' => 'fifteen wide',
			'content' => function($row) use($connection, $Table){
				$output = '<table class="ui table very compact very basic fixed">';
				foreach($Table->tablefields as $field){
					$output .= '<tr>';
					$output .= '<td class="three wide warning"><strong>'.$field.'</strong></td>';
					
					$output .= '<td class="thirteen wide green">'.$row['Table'][$field].'</td>';
					$output .= '</tr>';
				}
				$output .= '</table>';

				return $output;
			}
		],
	];
	
	$this->view('views.admin.listing', [
		'id' => 'Table.'.$Table->pkey,
		'paginator' => 'Table',
		'fields' => $listing_fields,
		'rows' => $records,
	]);
?>
</div>