<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui modal fullscreen long shortcodes" style="position:fixed; z-index:9999;">
	<span class="close"><i class="faicon times"></i></span>
	<div class="header">
		<?php el3('Shortcodes Cheatsheet'); ?>
	</div>
	<div class="scrolling content">
	<table class="ui definition table">
		<thead>
			<tr>
			<th><?php el3('ShortCode'); ?></th>
				<th><?php el3('Description'); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{data:field_name}</td>
				<td><?php el3('Return the value of a specific field or request parameter with the name "field_name"'); ?></td>
			</tr>
			<tr>
				<td>{var:action_name}</td>
				<td><?php el3('Return the result value of an action with the name "action_name"'); ?></td>
			</tr>
			<tr>
				<td>{session:var_name}</td>
				<td><?php el3('Return the value of a variable stored in the session with the name "var_name"'); ?></td>
			</tr>
			<tr>
				<td>{global:global_var_name}</td>
				<td><?php el3('Return the value of a global variable desfined under the global Chronoforms settings'); ?></td>
			</tr>
			<tr>
				<td>{user:variable}</td>
				<td><?php el3('Return the value of the logged in user\'s variable named "variable", like id, username, email...etc'); ?></td>
			</tr>
			<tr>
				<td>{date:format}</td>
				<td><?php el3('Return the current date with the format string passed as "format", if format is empty then use mysql date format Y-m-d H:i:s'); ?></td>
			</tr>
			<tr>
				<td>{locale:language_string} or {l:string}</td>
				<td><?php el3('Return the translation of a defined locale string under the current active language'); ?></td>
			</tr>
			<tr>
				<td>{app:title}</td>
				<td><?php el3('Return the form title, you may also get id or alias'); ?></td>
			</tr>
			<tr>
				<td>{document:var}</td>
				<td><?php el3('if var is "title" then return the current page title, else if var is "url" then return the current page url'); ?></td>
			</tr>
			<tr>
				<td>{site:title}</td>
				<td><?php el3('Return the site\'s title'); ?></td>
			</tr>
			<tr>
				<td>{str:uuid}</td>
				<td><?php el3('Return a unique id string'); ?></td>
			</tr>
			<tr>
				<td>{str:rand}</td>
				<td><?php el3('Return a random number'); ?></td>
			</tr>
			<tr>
				<td>{str:ip}</td>
				<td><?php el3('Return the client IP address'); ?></td>
			</tr>
		</tbody>
	</table>
	<br />
	</div>
</div>