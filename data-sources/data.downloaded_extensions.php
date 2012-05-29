<?php

	require_once(TOOLKIT . '/class.datasource.php');

	Class datasourcedownloaded_extensions extends Datasource{

		public $dsParamROOTELEMENT = 'downloaded-extensions';

		public function __construct(&$parent, $env=NULL, $process_params=true){
			parent::__construct($parent, $env, $process_params);
			$this->_dependencies = array();
		}

		public function about(){
			return array(
				'name' => 'Downloaded Extensions',
				'author' => array(
					'name' => 'Thomas Johnson',
					'website' => 'http://127.0.0.1/devjet2',
					'email' => 'jetbackwards@gmail.com'),
				'version' => 'Symphony 2.2.5',
				'release-date' => '2012-05-29T09:35:05+00:00'
			);
		}

		public function getSource(){
			return 'static_xml';
		}

		public function allowEditorToParse(){
			return false;
		}

		public function grab(&$param_pool=NULL){
			$result = new XMLElement($this->dsParamROOTELEMENT);

			try{
				
				if ($handle = opendir(EXTENSIONS)) {
					while (false !== ($entry = readdir($handle))) {
						if ($entry != "." && $entry != "..") {
							
							$this->dsSTATIC .= "<extension-item id='{$entry}'/>";
							
						}
					}
					closedir($handle);
				}
				
				
				include(TOOLKIT . '/data-sources/datasource.static.php');
			}
			catch(FrontendPageNotFoundException $e){
				// Work around. This ensures the 404 page is displayed and
				// is not picked up by the default catch() statement below
				FrontendPageNotFoundExceptionHandler::render($e);
			}
			catch(Exception $e){
				$result->appendChild(new XMLElement('error', $e->getMessage()));
				return $result;
			}

			if($this->_force_empty_result) $result = $this->emptyXMLSet();

			

			return $result;
		}

	}
