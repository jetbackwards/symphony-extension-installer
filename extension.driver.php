<?php

Class extension_extension_installer extends Extension{
	
	public function about() {
		return array('name' => 'Extension Installer',
					 'version' => '0.1',
					 'release-date' => '2012-05-25',
					 'author' => array('name' => 'Tom Johnson',
									   'website' => 'http://www.devjet.co.uk',
									   'email' => 'jetbackwards@gmail.com'),
						'description'   => 'Allow inline installation of Symphony Extensions'
			 		);
	}

	public function install() {	
	}

	public function uninstall() {
	}

	
	public function getSubscribedDelegates() {
		return array(
			array(
				'page'		=> '/backend/',
				'delegate'	=> 'ExtensionsAddToNavigation',
				'callback'	=> 'add_navigation'
			)
		);
	}
	
	
	public function add_navigation($context) {
		$context['navigation'][200]['children'][] = array(
			'link'		=> '/extension/extension_installer/',
			'name'		=> __('Extension Installer'),
			'visible'	=> 'yes'
		);
	}
	
		
}