<?php
defined('_JEXEC') or die;

class JFormFieldEDS_Description extends JFormField
{
	public $type = 'Description';
	private $params = null;
	
	protected function getLabel(){
		return '';		
	}
	
	protected function getInput(){		
		return '<div>
			<p><strong>Animate It! </strong> is a Plugin used to add cool CSS3 animations on your content.</p>		
			<h4><a id="features"></a>Features</h4>
			<ul>
				<li>Allowing user to apply CSS3 animations on articles and modules.</li>
				<li>50+ Entry, Exit and Attention Seeker Animations</li>
				<li>Capability to apply animation on Scroll.</li>
				<li>Capability to add different scroll offset on individual animation blocks.</li>
				<li>Capability to apply animation on Click.</li>
				<li>Capability to apply animation on Hover.</li>
				<li>Capability to apply different timing functions.</li>
				<li>Providing delay feature in animation to create a nice animation sequence.</li>
				<li>Providing feature to control the duration for a more precise animation.</li>
				<li>Providing a button in the editor to easily add an animation block in the article.</li>
				<li>Select the article content then click on the Animate It!. After selecting the animation, click on Insert, It will replace the dummy content with the selected content.</li>
				<li>Allow user to add animation on Modules
				<li>Allow user to apply animation infinitely or any fixed number of times.</li>
				<li>Option to add custom CSS classes to individual animation blocks.</li>
				<li>Options to enable or disable animations on Smartphones and Tablets.</li>				
			</ul>	
			<p>If you like our plugin <a href="http://extensions.joomla.org/extensions/extension/style-a-design/design/animate-it" target="_blank">please provide a review</a>
		</div>';
	}
	
	private function get($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
	
	
}
