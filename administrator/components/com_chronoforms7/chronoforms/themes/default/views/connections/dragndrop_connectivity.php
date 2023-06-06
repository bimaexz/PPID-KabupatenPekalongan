<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui container fluid">
	
	<div class="column">
		<div class="ui fluid container unitsContainer" id="unitsContainer" style="z-index:1010;">
			<?php $this->view(dirname(__FILE__).DS.'draggables2.php'); ?>
		</div>
		<div class="connectivity_pgroups" style="margin-top:5px;">
			<?php
				$pgcount = '-connectivity-repo-pgroup-';
				$pgroup = $this->data('Connection.pgroups.-connectivity-repo-pgroup-', []);

				$pcount = '-connectivity-repo-page-';
				$page = $this->data('Connection.pages.-connectivity-repo-page-', []);
			?>
			<div class="ui segment pages-tab main-event main-area area pagesList" data-count="<?php echo $pcount; ?>" data-name="<?php echo $page['name']; ?>" data-title="Repo.source" style="margin:0 0 0.5em 0;">
				<input type="hidden" value="<?php echo $pgroup['name']; ?>" name="Connection[pgroups][<?php echo $pgcount; ?>][name]" />
				<input type="hidden" value="<?php echo $pgcount; ?>" name="Connection[pages][<?php echo $pcount; ?>][pgroup]" class="page_pgroup">
				<input type="hidden" value="<?php echo $page['name']; ?>" name="Connection[pages][<?php echo $pcount; ?>][name]" class="pagename" />
				<input type="hidden" value="<?php echo $page['description'] ?? ''; ?>" name="Connection[pages][<?php echo $pcount; ?>][desc]" />
				<?php
					$this->view('views.connections.views_actions_editor', [
						'functions' => $this->data('Connection.functions', []), 
						'views' => $this->data('Connection.views', []),
						'pcount' => $pcount,
					]);
				?>
			</div>
		</div>
	</div>
</div>