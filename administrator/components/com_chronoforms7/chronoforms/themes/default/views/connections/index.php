<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$legacy_options = [];
	$dbo = \G3\L\Database::getInstance();
	$db_tables = $dbo->getTablesList();

	if($dbo->tableExists('#__chronoengine_chronoforms')){
		$legacy_options[] = [
			'title' => rl3('ChronoForms 5'),
			'url' => r3('index.php?ext=chronoforms&cont=connections&pversion=cf5&startat=0'),
		];
	}

	$this->view('views.admin.page_menu', [
			'title' => rl3('Forms Manager'),
			'class' => 'quti bg-cfpcolor',
			'search' => ['text' => rl3('Search Forms')],
			'paginator' => 'Connection',
			'items' => [
				'legacy' => [
					'color' => 'white',
					'icon' => 'recycle large',
					'title' => rl3('Import'),
					'options' => $legacy_options
				],
			],
			'btns' => [
				[
					'color' => 'green',
					'href' => r3('index.php?ext=chronoforms&cont=connections&act=wizard'),
					'hint' => rl3('Create a New Form'),
					'icon' => 'magic',
					'title' => rl3('New'),
				],
				// [
				// 	'color' => 'inverted active',
				// 	'href' => r3('index.php?ext=chronoforms&cont=connections&act=demoslist'),
				// 	'hint' => rl3('Use a demo form'),
				// 	'icon' => 'boxes',
				// 	'title' => rl3('Demos'),
				// ],
				[
					'color' => 'inverted active',
					'url' => r3('index.php?ext=chronoforms&cont=connections&act=copy'),
					'hint' => rl3('Copy Selected Forms'),
					'icon' => 'copy',
					'title' => rl3('Copy'),
					'selections' => '1',
					'message' => rl3('Please make a selection'),
				],
				[
					'color' => 'inverted active',
					'url' => r3('index.php?ext=chronoforms&cont=connections&act=delete'),
					'hint' => rl3('Delete Selected Forms'),
					'icon' => 'trash',
					'title' => rl3('Delete'),
					'selections' => '1',
					'message' => rl3('Please make a selection'),
				],
				[
					'color' => 'inverted active',
					'url' => r3('index.php?ext=chronoforms&cont=connections&act=backup'),
					'hint' => rl3('Backup Selected Forms'),
					'icon' => 'download',
					'title' => rl3('Backup'),
					'selections' => '1',
					'message' => rl3('Please make a selection'),
				],
				[
					'color' => 'active inverted',
					'href' => r3('index.php?ext=chronoforms&cont=connections&act=restore'),
					'hint' => rl3('Restore Forms'),
					'icon' => 'upload',
					'title' => rl3('Restore'),
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
				if(!empty($row['Connection']['settings']['form']['tags'])){
					foreach($row['Connection']['settings']['form']['tags'] as $tag){
						$tags .= '<a class="ui label quti bg-grey800 text-white" href="'.r3('index.php?ext=chronoforms&cont=connections&tagged='.$tag).'">'.$tag.'</a>';
					}
				}
				return $this->Html->a($row['Connection']['title'], r3('index.php?ext=chronoforms&cont=connections&act=edit'.rp3('id', $row['Connection'])))
				.'<br>'.'<small>'.$row['Connection']['alias'].'</small>'
				.((\G3\Globals::get('app') == 'wordpress') ? 
				'<br>'.'<small class="quti text-indigo">[Chronoforms chronoform='.$row['Connection']['alias'].']</small><button type="button" data-hint="'.rl3('Copy Shortcode to Clipboard').'" class="ui button icon quti p-1 ml-2" onclick="jQuery.G3.copyToClipboard(\'[Chronoforms chronoform='.$row['Connection']['alias'].']\');"><i class="faicon copy"></i></button>' 
				: 
				'<br>'.'<small class="quti text-indigo">{chronoforms7}'.$row['Connection']['alias'].'{/chronoforms7}</small><button type="button" data-hint="'.rl3('Copy Shortcode to Clipboard').'" class="ui button icon quti p-1 ml-2" onclick="jQuery.G3.copyToClipboard(\'{chronoforms7}'.$row['Connection']['alias'].'{/chronoforms7}\');"><i class="faicon copy"></i></button>')
				.(!empty($row['Connection']['description']) ? '<br><span class="quti text-sm text-grey700">'.nl2br($row['Connection']['description']).'</span>' : '').(!empty($tags) ? '<br>'.$tags : '');
			}
		],
		[
			'name' => 'Connection.apptype', 
			'title' => rl3('Type'),
			'content' => function($row){
				$colors = [
					'contact' => 'bg-blue500 text-white',
					'form' => 'bg-teal500 text-white',
					'connectivity' => 'bg-orange500 text-white',
				];
				return '<label class="ui label quti '.($colors[$row['Connection']['apptype']] ?? '').'">'.\G3\L\Str::camilize($row['Connection']['apptype']).'</label>';
			}
		],
		[
			'name' => 'Connection.published', 
			'title' => rl3('Enabled'),
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
		// [
		// 	'name' => 'Log', 
		// 	'title' => rl3('DB Log'),
		// 	'content' => function($row){
		// 		return $this->Html->a('<i class="icon database"></i>'.rl3('View Log'), r3('index.php?ext=chronoforms&cont=logs&form_id='.$row['Connection']['id']), []);
		// 	}
		// ],
		[
			'name' => 'Actions', 
			'title' => rl3('Actions'),
			'content' => function($row){
				$return = '
				<div class="ui floating labeled icon dropdown">
				<i class="faicon ellipsis-h large"></i>
				<div class="menu">
					<div class="item">
						'.$this->Html->a('<i class="faicon database quti mr-2"></i>'.rl3('View Log'), r3('index.php?ext=chronoforms&cont=logs&form_id='.$row['Connection']['id']), []).'
					</div>';

					if(!empty($row['Connection']['settings']['form']['connected_tables'])){
						$return .= '
						<div class="divider"></div>
						<div class="header">
							<i class="faicon table"></i>
							'.rl3('Connected Tables').'
						</div>';

						foreach($row['Connection']['settings']['form']['connected_tables']['db_tables'] as $db_table){
							$return .= '
							<div class="item">
								'.$this->Html->a('<i class="faicon search"></i>'.$db_table['name'], r3('index.php?ext=chronoforms&cont=logs&act=tableindex&tablename='.str_replace('#__', \G3\L\Config::get('db.prefix'), $db_table['name']).'&form_id='.$row['Connection']['id']), []).'
							</div>';
						}
					}

				$return .= '
				</div>
			  </div>
			  ';
			  return $return;
			}
		],
	],
	'rows' => $connections,
]); ?>