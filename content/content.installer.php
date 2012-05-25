<?php

require_once(TOOLKIT . '/class.xsltpage.php');
require_once(TOOLKIT . '/class.administrationpage.php');

require_once(TOOLKIT . '/class.sectionmanager.php');
require_once(TOOLKIT . '/class.fieldmanager.php');
require_once(TOOLKIT . '/class.entrymanager.php');
require_once(TOOLKIT . '/class.entry.php');
require_once(EXTENSIONS . '/importcsv/lib/parsecsv-0.3.2/parsecsv.lib.php');
require_once(EXTENSIONS . '/extension_installer/lib/extension-data.class.php');

require_once(CORE . '/class.cacheable.php');

class contentExtensionExtension_installerInstaller extends AdministrationPage
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
	
		$resultSuccess = 1;
		$resultMessage = "";
	/*
		$extensionArr = ExtensionData::retrieve();
		
		$theExt = null;
		
		foreach($extensionArr as $e) {
			if($e['id'] == $_GET['id']) {
				$theExt = $e;		
			}
		}
		
		if(!$theExt) {
			$resultSuccess = 0;
			$resultMessage = "Extension was not found.";
		}
		else {		
		*/
		
		$theExt = array("id" => $_GET['id'], "title" => $_GET['title'], "dev" => $_GET['dev']);
		
		$resultMessage = $theExt['title'] . " was installed successfully!";
		
		// download the file to $root/manifest/tmp
		$fileContents = file_get_contents("https://github.com/{$theExt['dev']}/{$theExt['id']}/zipball/master");
		if(!$fileContents) {
			$resultSuccess = 0;
			$resultMessage = $theExt['title'] . " could not be downloaded.";
		}
		$zipFilePath = MANIFEST . '/tmp/' . $theExt['id'] . '.zip';
		
		file_put_contents($zipFilePath, $fileContents);
		chmod($zipFilePath, 0777);
		
		// extract the ZIP file

		$zipExtractPath = "";
		
		$zip = new ZipArchive;
		$res = $zip->open($zipFilePath);
		if ($res === TRUE) {
			$zip->extractTo(MANIFEST . '/tmp/');
			$zipExtractPath = MANIFEST . '/tmp/' . $zip->getNameIndex(0);
			$zip->close();					
		} else {
			$resultSuccess = 0;
			$resultMessage = $theExt['title'] . " could not be extracted.";
		}
		
		// rename the ZIP file to the correct name
		$finishedZipExtractPath = MANIFEST . '/tmp/' . $theExt['id'];
		rename($zipExtractPath, $finishedZipExtractPath);
		chmod($finishedZipExtractPath, 0777);

		// copy the renamed folder to the extensions directory
		self::recursiveCopy($finishedZipExtractPath, EXTENSIONS . '/' . $theExt['id']);



		// tidy up (delete the stuff we put in $root/manifest/tmp)
		self::recursiveDelete($finishedZipExtractPath);
		self::recursiveDelete($zipFilePath);
	/*
		}
	*/	
		$responseXml = new XMLElement('response');
		
		$responseXml->appendChild(new XMLElement("success", $resultSuccess));
		$responseXml->appendChild(new XMLElement("message", $resultMessage));
		
        $xslt = new XSLTPage();
        $xslt->setXML($responseXml->generate());
        $xslt->setXSL(EXTENSIONS . '/extension_installer/content/installer.xsl', true);
        $this->Form->setValue($xslt->generate());
        $this->Form->setAttribute('enctype', 'multipart/form-data');		
		
	}
	
	static function recursiveDelete($dir) {
		if (is_dir($dir)) {
			$files = scandir($dir);
			foreach ($files as $file)
			if ($file != "." && $file != "..") self::recursiveDelete("$dir/$file");
				rmdir($dir);
		}
		else if (file_exists($dir)) unlink($dir);	
	}
	
	static function recursiveCopy($src, $dst) {
		if (file_exists($dst)) self::recursiveDelete($dst);
			if (is_dir($src)) {
			mkdir($dst);
			$files = scandir($src);
			foreach ($files as $file)
			if ($file != "." && $file != "..") self::recursiveCopy("$src/$file", "$dst/$file");
		}
		else if (file_exists($src)) copy($src, $dst);
	}
	
}
