<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application;
global $USER;

if($USER->IsAuthorized()) {
	
	$request = Application::getInstance()->getContext()->getRequest();
	$folderid = $request->getPost("id");
	$storageid = $request->getPost("storage");

	if($id) {

		\Bitrix\Main\Loader::includeModule('disk');

		$storage = \Bitrix\Disk\Driver::getInstance()->getStorageByGroupId($storageid);

		if ($storage) 
		{ 
	
			$folder = \Bitrix\Disk\Folder::loadById($folderid);

		    $securityContext = $storage->getCurrentUserSecurityContext();


		    $urlManager = \Bitrix\Disk\Driver::getInstance()->getUrlManager();
		    foreach ($folder->getChildren($securityContext) as $item) {

		    	$attr = false;
		    	$attrib = false;
		    	if ($item->getType() == 3) {
		    		$attr = \Bitrix\Disk\Ui\Viewer::getAttributesByObject($item);

		    		// Костыль
		    		$exp = explode('" ', $attr);
		    		$at = [];
		    		foreach($exp as $v) {
		    			$ex = explode('="', $v);
		    			$at[$ex[0]] = $ex[1];

		    		}
		    		$attrib['dataviewertype'] = $at['data-bx-viewer'];
		    		$attrib['datasrc'] = $at['data-bx-src'];
				}

		    	$arResult["DIR"][] = [
		    		"ID" => $item->getId(),
		    		"NAME" => $item->getName(),
		    		"TYPE" => $item->getType(),
		    		"STORAGE" => $storageid,
		    		"ATTR" => $attrib,
		    	];
		    }
		} 

	}

}

	
echo json_encode($arResult["DIR"]);




?>