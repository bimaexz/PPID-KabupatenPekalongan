<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$Group = new \G3\A\M\Group();
	$_groups = $Group->select('flat');
	$_groups = array_merge([['Group' => ['id' => 'owner', 'title' => rl3('Owner'), '_parents' => []]]], $_groups);
	$groups = [];
	foreach($_groups as $g){
		$groups[$g['Group']['id']] = str_repeat('- ', count($g['Group']['_parents'])).$g['Group']['title'];
	}
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['acl_profiles'],
		'items' => $this->data('Connection.'.$utype.'.'.$n.'.acl_profiles', []) ?? [],
		'btns' => ['acl_profiles' => ['main' => ['text' => rl3('Add ACL Profile')]]],
		'inputs' => [
			'acl_profiles' => [
				'main' => [
					'r1' => [
						[
							'width' => 'eight wide', 
							'desc' => rl3('ACL Profile title'), 
							'params' => [
								'placeholder' => rl3('ACL Profile title'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][acl_profiles][#acl_profiles#][title]', 'value' => 'Custom ACL Profile #acl_profiles#']
							],
						],
						[
							'width' => 'six wide', 
							'desc' => rl3('ACL Profile id, used to reference this profile in ACL behaviors, do NOT change this after using the profile'), 
							'params' => [
								'placeholder' => rl3('ACL Profile id'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][acl_profiles][#acl_profiles#][alias]', 'value' => 'acl_profile_#acl_profiles#']
							],
						],
						// [
						// 	'width' => 'six wide', 
						// 	'type' => 'select',
						// 	'options' => [
						// 		'' => rl3('No'),
						// 		'1' => rl3('Yes'),
						// 	],
						// 	'params' => [
						// 		'placeholder' => rl3('Enabled'), 
						// 		'origin' => ['name' => 'Extension[settings][acl_profiles][#acl_profiles#][enabled]']
						// 	],
						// ],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => [],
								'delete' => [],
							]
						],
					],
					'r2' => [
						[
							'width' => 'eight wide', 
							'type' => 'select',
							'options' => ['owner' => rl3('Owner')] + $groups,
							'desc' => rl3('The users of these groups and their children groups will be allowed'), 
							'params' => [
								'placeholder' => rl3('Allowed Groups'), 
								'multiple' => 'multiple',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][acl_profiles][#acl_profiles#][allowed_groups][]']
							],
						],
						[
							'width' => 'eight wide', 
							'type' => 'select',
							'options' => ['owner' => rl3('Owner')] + $groups,
							'desc' => rl3('The users of these groups and their children groups will be denied'), 
							'params' => [
								'placeholder' => rl3('Denied Groups'), 
								'multiple' => 'multiple',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][acl_profiles][#acl_profiles#][denied_groups][]']
							],
						],
					],
				],
			],
		]
	]);
?>