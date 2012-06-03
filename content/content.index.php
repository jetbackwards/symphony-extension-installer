<?php

require_once(TOOLKIT . '/class.xsltpage.php');
require_once(TOOLKIT . '/class.administrationpage.php');

require_once(TOOLKIT . '/class.sectionmanager.php');
require_once(TOOLKIT . '/class.fieldmanager.php');
require_once(TOOLKIT . '/class.entrymanager.php');
require_once(TOOLKIT . '/class.entry.php');
require_once(EXTENSIONS . '/extension_installer/lib/extension-data.class.php');

require_once(TOOLKIT . '/class.datasource.php');
require_once(TOOLKIT . '/class.datasourcemanager.php');

require_once(CORE . '/class.cacheable.php');
require_once(CORE . '/class.administration.php');

require_once(EXTENSIONS . '/extension_installer/data-sources/data.extension_list.php');
require_once(EXTENSIONS . '/extension_installer/data-sources/data.downloaded_extensions.php');


class contentExtensionExtension_installerIndex extends AdministrationPage
{	

/*    public function __construct(&$parent)
    {
        parent::__construct($parent);

    }
*/


    public function build()
    {
        parent::build();
		$this->setPageType('form');
        $this->setTitle('Symphony - Install Extensions');
		
    }

	public function about() {
	
	}

    public function view()
    {
		//print_r($_REQUEST);
		$this->__indexPage();
    }
	
	private function __indexPage() {
		
		if(isset($_GET['id'])) {
			if(isset($_GET['err'])) {
				$this->pageAlert("Install of " . urldecode($_GET['name']) . " failed.", Alert::ERROR);
			}
			else {
				$this->pageAlert(urldecode($_GET['name']) . " was successfully installed!", Alert::SUCCESS);
			}
		}
		
		//$extList = new datasourceextension_list(Administration::instance(), array());
		$extList = new datasourceextension_list(array());
		$extListXml = $extList->grab();
		
		//$downList = new datasourcedownloaded_extensions(Administration::instance(), array());
		$downList = new datasourcedownloaded_extensions(array());
		$downListXml = $downList->grab();

		$xmlRoot = new XMLElement('root');
		$xmlRoot->appendChild($extListXml);
		$xmlRoot->appendChild($downListXml);
		
		if(isset($_GET['debug'])) {
			//echo($xmlRoot->generate());
		}
		
		$xslt = new XSLTPage();
        $xslt->setXML($xmlRoot->generate());
		//echo($xmlRoot->generate());
		$xslt->setXSL(EXTENSIONS . '/extension_installer/content/index.xsl', true);
        $this->Form->setValue($xslt->generate());
		//print_r($xslt->getError());
		
	}
	
	private function getExtensionUrls() {
		return ExtensionData::retrieve();	
	}

}

