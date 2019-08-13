<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

\Bitrix\Main\Loader::includeModule('disk');
use Bitrix\Disk\Ui\FileAttributes;
use Bitrix\Main\Web\Uri;

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
    	];
    }





    $page = $APPLICATION->GetCurPage(true);
    $urls = explode('/', $page);
    $urls = array_reverse($urls);

    $structure = [];
    $openfile = false;
    foreach ($urls as $url) {
        if ($url == 'show'){
            $openfile = true;
            break;
        }

        $structure[] = $url;
    }

    if ($structure && $openfile)
        $arResult["OPENFILE"] = array_reverse($structure);

} 








$this->IncludeComponentTemplate();
?>