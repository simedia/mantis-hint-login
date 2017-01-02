<?php
/**
	add a custom hint to the login page (below submit button)
*/

class HintLoginPlugin extends MantisPlugin {
	/**
	 * populates the plugin information and minimum requirements.
	 */
	public function register() {
		
		$this->name        = 'Hint login';
		$this->description = 'Add some text to the login page';
		$this->version     = '1.0';
		$this->requires    = array(
			'MantisCore' => '1.3.0',
		);
		$this->author  = 'Simédia';
		$this->contact = 'simedia2@online.fr';
		$this->url     = 'track.qap10.com';
	}


	function init() {
	}	

	
	function hooks() {
		/*
			Mantis EVENT_LAYOUT_CONTENT_END does not seem to be fired in login_page.
			Have to use more complex trick using the jquery lib already present in Mantis 1.3
		*/
		return array(
				'EVENT_LAYOUT_RESOURCES' => 'my_resources',
				'EVENT_LAYOUT_PAGE_HEADER' => 'my_login',
			);
	}


	function my_resources( $p_event ) {
		
		$markup = '';
		$plugin_path = config_get_global( 'path' ) . 'plugins/' . plugin_get_current();

		// Because of 'Content Security Policy' message on my Firefox/firebug cannot set style directly inside a tag. 
		// I need to use small css file
		$style = $plugin_path . '/inc/plugin.css';
		$markup .= '<link rel="stylesheet" type="text/css" href="' . $style . '" />';
		
		// cf comment above about 'Content Security Policy'
		$script = $plugin_path . '/inc/plugin.js';	
		$markup .= '<script type="text/javascript" src="' . $script . '"></script>';

		return $markup;
	}


	function my_login($p_event) {
		// only login
		if ( !is_page_name( 'login_page' ) )
			return '';

		return '<h1 class="hintLogin">You can login as guest/guest</h1>';
	}
}
