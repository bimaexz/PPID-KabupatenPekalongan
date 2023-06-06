<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait Forms {
	use \G3\L\T\Model;
	
	function edit(){
		$this->theme = 'admin';
		$this->_helpers[] = '\G3\H\Fields';
		$this->models = [
			'Form' => '\G3\A\M\Form',
			'Field' => '\G3\A\M\Field',
			'FormField' => '\G3\A\M\FormField',
		];
		
		$form = $this->Model('Form')->where('id', $this->data('id'))->select('first');
		
		$fields = $this->Model('Field')
		->hasOne($this->Model('FormField'), 'FormField', 'field_id')
		->where('FormField.form_id', $form['Form']['id'])
		->where('FormField.enabled', 1)
		->order(['FormField.ordering' => 'asc'])
		->select('all', ['json' => ['Field.params', 'FormField.params']]);
		
		//p3($fields);
		$this->set('fields', \G3\L\Arr::getVal($fields, ['[n]', 'Field']));
		$this->set('f_fields', $fields);
		$this->view = 'views.admin.forms.edit';
	}
	
}
?>