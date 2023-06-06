<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$extdb = [];
	if(!empty($this->data('Connection.'.$utype.'.'.$n.'.dbconn'))){
		$db_conns = $this->controller->get_connection_data('Connection.settings.form.external_dbs');
		foreach(($db_conns ?? []) as $db_conn){
			if($db_conn['alias'] == $this->data('Connection.'.$utype.'.'.$n.'.dbconn')){
				$extdb = $db_conn;
			}
		}
	}
?>
<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][models][<?php echo $name ?? 'data'; ?>][name]" class="ui fluid search selection dropdown" data-clearable="1" data-keepnonexistent="1" data-rich="1" data-fulltextsearch="1">
	<option value=""></option>
	<?php /*foreach($this->controller->Models->list() as $model): ?>
		<option value="<?php echo $model['Model']['name']; ?>"><?php echo $model['Model']['name']; ?></option>
	<?php endforeach;*/ ?>
	<!-- <option data-type="header" value="-">=== <?php el3('Database Tables'); ?> ===</option> -->
	<?php foreach($this->controller->Models->tables($extdb) as $ntable => $table): ?>
		<option value="<?php echo $ntable; ?>"><?php echo $table; ?></option>
	<?php endforeach; ?>
</select>