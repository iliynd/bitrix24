<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application;
use Bitrix\Disk\Ui\FileAttributes;
use Bitrix\Main\Web\Uri;
global $USER;

if($USER->IsAuthorized()) {
	
	$request = Application::getInstance()->getContext()->getRequest();
	$folderid = $request->getPost("id");
	$storageid = $request->getPost("storage");

	if($storageid) {

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

					$attr = FileAttributes::buildByFileId($item->getFileId(), new Uri($urlManager->getUrlForDownloadFile($item)))
					->setObjectId($item->getId())
					->setTitle($item->getName())
					->addAction([
					'type' => 'download',
					]);

					$attrib .= ' data-viewer="'.$attr->getAttribute('data-viewer').'"';
					$attrib .= ' data-viewer-type="'.$attr->getAttribute('data-viewer-type').'"';
					$attrib .= ' data-src="'.$attr->getAttribute('data-src').'"';
					$attrib .= ' data-object-id="'.$attr->getAttribute('data-object-id').'"';
					$attrib .= ' data-title="'.$attr->getAttribute('data-title').'"';
					$attrib .= ' data-actions="[{&quot;type&quot;:&quot;download&quot;}]"';

				}

		    	$arResult["DIR"][] = [
		    		"ID" => $item->getId(),
		    		"NAME" => $item->getName(),
		    		"TYPE" => $item->getType(),
		    		"STORAGE" => $storageid,
		    		"ATTR" => $attrib,
		    		"PARENT" => $folderid,
		    		"CANNAME" => str_replace(".", "", $item->getName()),
		    	];


		    }
		} 

	}

}

	
echo json_encode($arResult["DIR"]);




?>