<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\String\PunycodeHelper;

$params	= $displayData['params'];
$width	= $displayData['width'];
$item	= $displayData['item'];
?>
<dl class="com-gmapfp__address gmapfp-address dl-horizontal col-md-<?php echo $width; ?>" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
	<?php if ($item->adresse || $item->adresse2 || $item->ville  || $item->departement || $item->pays || $item->codepostal) : ?>
		<dt>
			<span class="<?php echo $params->get('marker_class'); ?>">
				<?php echo $params->get('marker_address'); ?>
			</span>
		</dt>

		<?php if (($item->adresse || $item->adresse2) && $params->get('show_street_address',1)) : ?>
			<dd>
				<span class="gmapfp-rue" itemprop="streetAddress">
					<?php if($item->adresse and $item->adresse2) $br = '</br>'; else $br = '';?>
					<?php echo $item->adresse.$br; ?>
					<?php echo $item->adresse2; ?>
					<br>
				</span>
			</dd>
		<?php endif; ?>

		<?php if ($item->codepostal && $params->get('show_postcode',1) && $params->get('postcode_before_city',1)) : ?>
			<dd>
				<span class="gmapfp-codepostal" itemprop="postalCode">
					<?php echo $item->codepostal; ?>
					<br>
				</span>
			</dd>
		<?php endif; ?>

		<?php if ($item->ville && $params->get('show_suburb',1)) : ?>
			<dd>
				<span class="gmapfp-ville" itemprop="addressLocality">
					<?php echo $item->ville; ?>
					<br>
				</span>
			</dd>
		<?php endif; ?>
		<?php if ($item->departement && $params->get('show_state',1)) : ?>
			<dd>
				<span class="gmapfp-departement" itemprop="addressRegion">
					<?php echo $item->departement; ?>
					<br>
				</span>
			</dd>
		<?php endif; ?>
		<?php if ($item->codepostal && $params->get('show_postcode',1) && !$params->get('postcode_before_city',1)) : ?>
			<dd>
				<span class="gmapfp-codepostal" itemprop="postalCode">
					<?php echo $item->codepostal; ?>
					<br>
				</span>
			</dd>
		<?php endif; ?>
		<?php if ($item->pays && $params->get('show_country',1)) : ?>
		<dd>
			<span class="gmapfp-pays" itemprop="addressCountry">
				<?php echo $item->pays; ?>
				<br>
			</span>
		</dd>
		<?php endif; ?>
	<?php endif; ?>

<?php if (!$params->get('show_email_form', 1) && $item->email && $params->get('show_email',1)) : ?>
	<dt>
		<span class="<?php echo $params->get('marker_class'); ?>" itemprop="email">
			<?php echo nl2br($params->get('marker_email')); ?>
		</span>
	</dt>
	<dd>
		<span class="gmapfp-email">
			<?php echo $item->email; ?>
		</span>
	</dd>
<?php endif; ?>

<?php if ($item->tel && $params->get('show_telephone',1)) : ?>
	<dt>
		<span class="<?php echo $params->get('marker_class'); ?>">
			<?php echo $params->get('marker_telephone'); ?>
		</span>
	</dt>
	<dd>
		<span class="gmapfp-tel" itemprop="telephone">
			<?php echo $item->tel; ?>
		</span>
	</dd>
<?php endif; ?>
<?php if ($item->web && $params->get('show_webpage',1)) : ?>
	<dt>
		<span class="<?php echo $params->get('marker_class'); ?>">
		</span>
	</dt>
	<dd>
		<span class="gmapfp-webpage">
			<a href="<?php echo $item->web; ?>" target="_blank" rel="noopener noreferrer" itemprop="url">
			<?php echo PunycodeHelper::urlToUTF8($item->web); ?></a>
		</span>
	</dd>
<?php endif; ?>
</dl>
