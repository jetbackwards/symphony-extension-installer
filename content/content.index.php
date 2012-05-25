<?php

require_once(TOOLKIT . '/class.xsltpage.php');
require_once(TOOLKIT . '/class.administrationpage.php');

require_once(TOOLKIT . '/class.sectionmanager.php');
require_once(TOOLKIT . '/class.fieldmanager.php');
require_once(TOOLKIT . '/class.entrymanager.php');
require_once(TOOLKIT . '/class.entry.php');
require_once(EXTENSIONS . '/importcsv/lib/parsecsv-0.3.2/parsecsv.lib.php');
require_once(EXTENSIONS . '/extension_installer/lib/extension-data.class.php');

require_once(TOOLKIT . '/class.datasource.php');
require_once(TOOLKIT . '/class.datasourcemanager.php');

require_once(CORE . '/class.cacheable.php');
require_once(CORE . '/class.administration.php');

require_once(EXTENSIONS . '/extension_installer/data-sources/data.extension_list.php');



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
		$this->__indexPage();
    }
	
	private function __indexPage() {
		
		$extList = new datasourceextension_list(Administration::instance(), array());

		$xml = $extList->grab();
		
		if(isset($_GET['debug'])) {
		echo($xml->generate());
		}
		$xslt = new XSLTPage();
        $xslt->setXML($xml->generate());
		$xslt->setXSL(EXTENSIONS . '/extension_installer/content/index.xsl', true);
        $this->Form->setValue($xslt->generate());
		print_r($xslt->getError());
	}
	
	private function getExtensionUrls() {
		return ExtensionData::retrieve();	
	}

}

