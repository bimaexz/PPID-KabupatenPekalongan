<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['locales'])){
		$Locale = new \G3\A\E\Chronoforms\M\Locale();
		$locales = $Locale
		->where('alias', $unit['locales'], 'in')
		->where('enabled', 1)
		->select('all', ['json' => ['locales']]);
		
		$langs = [];

		foreach($locales as $locale){
			if(!empty($locale['Locale']['locales'])){
				foreach($locale['Locale']['locales'] as $ldata){
					$ltag = $ldata['name'];
					$ltag = strtoupper(str_replace('-', '_', $ltag));

					if(!empty($ldata['content']) AND (strtoupper(\G3\L\Config::get('site.language')) == $ltag)){
						$list = \G3\L\Str::parse($ldata['content'], 'ini');
						
						if(!isset($langs[$ltag])){
							$langs[$ltag] = [];
						}
						
						$langs[$ltag] = array_merge($langs[$ltag], $list);
					}
				}
			}
		}

		$this->controller->FData->cdata('locales', $langs, true);
	}

	if(!empty($unit['plocales'])){
		$langs = $this->controller->FData->cdata('locales', []);

		foreach($unit['plocales'] as $ldata){
			$ltag = $ldata['name'];
			$ltag = strtoupper(str_replace('-', '_', $ltag));

			if(!empty($ldata['content']) AND (strtoupper(\G3\L\Config::get('site.language')) == $ltag)){
				$list = \G3\L\Str::parse($ldata['content'], 'ini');
				
				if(!isset($langs[$ltag])){
					$langs[$ltag] = [];
				}
				
				$langs[$ltag] = array_merge($langs[$ltag], $list);
			}
		}

		$this->controller->FData->cdata('locales', $langs, true);
	}