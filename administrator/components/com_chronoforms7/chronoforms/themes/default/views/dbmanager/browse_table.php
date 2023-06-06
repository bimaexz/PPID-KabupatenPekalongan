<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.dbmanager.table_menu');
?>
<div class="ui segment attached">
	<span class="ui text green"><?php echo implode("\n", $sql); ?></span>
</div>
<?php
	$listing_fields = [
		
	];
	
	if(!empty($uid)){
		$listing_fields[] = [
			'name' => 'Actions', 
			'title' => rl3('Actions'),
			'class' => 'single line',
			'content' => function($row)use($table, $uid, $db){
				$return = '
				<div class="ui floating labeled icon dropdown">
				<i class="faicon ellipsis-h large"></i>
				<div class="menu">
					<div class="item">
						'.$this->Html->a('<i class="faicon edit quti mr-2"></i>'.rl3('Edit'), r3('index.php?ext=chronoforms&cont=dbmanager&act=edit_row&db='.$db.'&table='.$table.'&rid='.$row['Record'][$uid]), []).'
					</div>
					<div class="item">
						'.$this->Html->a('<i class="faicon copy quti mr-2"></i>'.rl3('Copy'), r3('index.php?ext=chronoforms&cont=dbmanager&act=copy_row&db='.$db.'&table='.$table.'&rid='.$row['Record'][$uid]), []).'
					</div>
					<div class="item">
						'.$this->Html->a('<i class="faicon trash quti mr-2"></i>'.rl3('Delete'), r3('index.php?ext=chronoforms&cont=dbmanager&act=delete_row&db='.$db.'&table='.$table.'&rid='.$row['Record'][$uid]), []).'
					</div>
					';

				$return .= '
				</div>
			  </div>
			  ';
			  return $return;
			}
		];
	}

	foreach($columns as $column){
		$listing_fields[] = [
			'name' => $column['name'], 
			'title' => $column['name'],
			'content' => function($row)use($column, $table){
				return $row['Record'][$column['name']] ?? '<i>NULL</i>';
			}
		];
	}
	
	$this->view('views.admin.listing', [
		'id' => 'aid',
		'paginator' => 'Record',
		'fields' => $listing_fields,
		'rows' => $rows,
	]);
?>

<input type="hidden" name="form_id" />