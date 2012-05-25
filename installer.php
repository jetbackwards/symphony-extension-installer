<?php

require_once(EXTENSIONS . '/extension_installer/lib/extension-data.class.php');	

$extensionArr = ExtensionData::retrieve();
foreach($extensionArr as $e) {
	if($e['id'] == $_GET['id']) {

	// download the file to $root/manifest/tmp
	$fileContents = file_get_contents($e['url']);
	file_put_contents(MANIFEST . '/tmp/' . $e['id'] . '.zip', $fileContents);
	
	// extract the ZIP to the folder



	// rename the folder to the proper name




	// copy the renamed folder to the extensions directory




	// tidy up (delete the stuff we put in $root/manifest/tmp)











	
	}
}




?>