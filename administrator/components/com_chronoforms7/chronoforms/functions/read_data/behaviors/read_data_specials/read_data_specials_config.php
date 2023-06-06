<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$options_settings =  [
		'complex' => json_encode(['hide' => ['.specials_params'], 'show' => ['.specials_p1']]),
		'json_decode' => json_encode(['hide' => ['.specials_params']]),
	];
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['specials'],
		'items' => $unit['models']['data']['specials'] ?? [],
		'btns' => ['specials' => ['main' => ['text' => rl3('Add Special Field')]]],
		'headers' => [
			'specials' => [
				['width' => 'eight wide', 'label' => rl3('Data Path')],
				['width' => 'six wide', 'label' => rl3('Processing Function')],
				['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'specials' => [
				'main' => [
					'r1' => [
						[
							'width' => 'eight wide',
							'params' => [
								'placeholder' => rl3('Table field name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][specials][#specials#][field]']
							],
						],
						[
							'width' => 'six wide', 
							'type' => 'select',
							'options' =>  [
								'json_decode' => rl3('Decode JSON'),
								'complex' => rl3('Complex Field'),
							],
							'options_settings' =>  $options_settings,
							'params' => [
								'data-cfwizardjob' => 'content-switcher',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][specials][#specials#][type]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => [],
								'delete' => [],
								'sort' => [],
							]
						],
					],
					'r2' => [
						[
							'width' => 'fourteen wide specials_params specials_p1',
							'params' => [
								'placeholder' => rl3('New Field value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][specials][#specials#][p1]']
							],
						],
					],
				],
			],
		]
	]);
?>