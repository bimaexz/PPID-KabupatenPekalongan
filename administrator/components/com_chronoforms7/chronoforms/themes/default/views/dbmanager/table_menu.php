<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		// 'title' => $title,
		'class' => 'quti bg-cfpcolor',
		// 'search' => ['text' => rl3('Search table records')],
		'paginator' => 'Record',
		'items' => [
			'browse' => [
				'color' => 'white notab',
				'active' => ($this->data('act') == 'browse_table' ? 'active' : ''),
				'icon' => 'list-ol',
				'title' => rl3('Browse'),
				'url' => r3('index.php?ext=chronoforms&cont=dbmanager&act=browse_table&db='.$db.'&table='.$table),
			],
			'structure_table' => [
				'color' => 'white notab',
				'active' => ($this->data('act') == 'structure_table' ? 'active' : ''),
				'icon' => 'columns',
				'title' => rl3('Structure'),
				'url' => r3('index.php?ext=chronoforms&cont=dbmanager&act=structure_table&db='.$db.'&table='.$table),
			],
			'search' => [
				'color' => 'white notab',
				'active' => ($this->data('act') == 'search_table' ? 'active' : ''),
				'icon' => 'search',
				'title' => rl3('Search'),
				'url' => r3('index.php?ext=chronoforms&cont=dbmanager&act=search_table&db='.$db.'&table='.$table),
			],
			'insert' => [
				'color' => 'white notab',
				'active' => (in_array($this->data('act'), ['insert_row', 'edit_row', 'copy_row']) ? 'active' : ''),
				'icon' => 'edit',
				'title' => rl3('Insert'),
				'url' => r3('index.php?ext=chronoforms&cont=dbmanager&act=insert_row&db='.$db.'&table='.$table),
			],
		],
		'btns' => [
			[
				'color' => 'inverted active '.(!in_array($this->data('act'), ['insert_row', 'edit_row', 'copy_row', 'delete_row']) ? 'hidden' : ''),
				'name' => 'confirm',
				'url' => r3('index.php?ext=chronoforms&cont=dbmanager&act='.$this->data('act').'&db='.$db.'&table='.$table.'&rid='.$this->data('rid')),
				'hint' => rl3('Apply changes'),
				'icon' => 'check',
				'title' => rl3('Confirm'),
				// 'attrs' => ['data-fn' => 'saveform']
			],
		]
	]);
?>