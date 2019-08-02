<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

\Bitrix\Main\Loader::includeModule('disk');

$storageid = $arParams['GROUP_ID'];


$storage = \Bitrix\Disk\Driver::getInstance()->getStorageByGroupId($storageid);
if ($storage) 
{ 
    $folder = $storage->getRootObject(); 
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
    		$attrib['data-viewer-type'] = $at['data-bx-viewer'];
    		$attrib['data-src'] = $at['data-bx-src'];
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







$this->IncludeComponentTemplate();
?>