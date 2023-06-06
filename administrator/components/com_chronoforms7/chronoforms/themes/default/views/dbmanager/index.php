<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		// 'title' => rl3('Tables list @ %s', [$d]),
		'class' => 'quti bg-cfpcolor',
		'search' => ['text' => rl3('Search tables')],
		// 'paginator' => 'Table',
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
			// 	'icon' => 'download',
			// 	'title' => rl3('CSV Export'),
			// ],
			// [
			// 	'color' => 'inverted active',
			// 	'url' => r3('index.php?ext=chronoforms&cont=logs&act=delete&form_id='.$connection['Connection']['id']),
			// 	'hint' => rl3('Delete Selected Records'),
			// 	'icon' => 'trash',
			// 	'title' => rl3('Delete'),
			// 	'selections' => '1',
			// 	'message' => rl3('Please make a selection'),
			// ],
		]
	]);
?>
<div class="ui container fluid">
<?php
	$listing_fields = [
		[
			'name' => 'name', 
			'title' => rl3('Table'),
			'content' => function($row)use($db){
				return $this->Html->a($row['name'], r3('index.php?ext=chronoforms&cont=dbmanager&act=browse_table&db='.$db.'&table='.$row['name']));
			}
		],

		[
			'name' => 'Actions', 
			'title' => rl3('Actions'),
			'content' => function($row)use($db){
				$return = '
				<div class="ui floating labeled icon dropdown">
				<i class="faicon ellipsis-h large"></i>
				<div class="menu">
					<div class="item '.(empty($row['rows']) ? 'disabled' : '').'">
						'.$this->Html->a('<i class="faicon database quti mr-2"></i>'.rl3('Browse'), r3('index.php?ext=chronoforms&cont=dbmanager&act=browse_table&db='.$db.'&table='.$row['name']), []).'
					</div>
					<div class="item">
						'.$this->Html->a('<i class="faicon database quti mr-2"></i>'.rl3('Structure'), r3('index.php?ext=chronoforms&cont=dbmanager&act=structure&db='.$db.'&table='.$row['name']), []).'
					</div>
					<div class="item '.(empty($row['rows']) ? 'disabled' : '').'">
						'.$this->Html->a('<i class="faicon database quti mr-2"></i>'.rl3('Search'), r3('index.php?ext=chronoforms&cont=dbmanager&act=search&db='.$db.'&table='.$row['name']), []).'
					</div>
					<div class="item">
						'.$this->Html->a('<i class="faicon database quti mr-2"></i>'.rl3('Insert'), r3('index.php?ext=chronoforms&cont=dbmanager&act=insert&db='.$db.'&table='.$row['name']), []).'
					</div>
					<div class="item '.(empty($row['rows']) ? 'disabled' : '').'">
						'.$this->Html->a('<i class="faicon database quti mr-2"></i>'.rl3('Truncate'), r3('index.php?ext=chronoforms&cont=dbmanager&act=empty&db='.$db.'&table='.$row['name']), []).'
					</div>
					<div class="item">
						'.$this->Html->a('<i class="faicon database quti mr-2"></i>'.rl3('Drop'), r3('index.php?ext=chronoforms&cont=dbmanager&act=drop&db='.$db.'&table='.$row['name']), []).'
					</div>
					';

				$return .= '
				</div>
			  </div>
			  ';
			  return $return;
			}
		],

		[
			'name' => 'rows', 
			'title' => rl3('Rows'),
			'content' => function($row){
				return $row['rows'];
			}
		],
		[
			'name' => 'engine', 
			'title' => rl3('Engine'),
			'content' => function($row){
				return $row['engine'];
			}
		],
		[
			'name' => 'collation', 
			'title' => rl3('Collation'),
			'content' => function($row){
				return $row['collation'];
			}
		],
		[
			'name' => 'size', 
			'title' => rl3('Size'),
			'content' => function($row){
				return $row['size'];
			}
		],

	];
	
	$this->view('views.admin.listing', [
		'id' => 'aid',
		// 'paginator' => 'Table',
		'fields' => $listing_fields,
		'rows' => $tables,
	]);
?>
</div>
<input type="hidden" name="form_id" />