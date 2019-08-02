<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\UI\Extension;
Extension::load('ui.bootstrap4');

$this->addExternalCss("/bitrix/css/main/font-awesome.css");



//href="<?=($dir['TYPE'] == 3) ? '/disk-group/show/'.$dir["ID"] : '#'

?>

<? if ($arResult["DIR"]) :?>
	<div class="bd-example" id="group-disk">
		<div class="list-group">
			<? foreach ($arResult["DIR"] as $dir) :?>
				<a href="#" 
				class="list-group-item list-group-item-action" 
				data-folderid="<?=($dir['TYPE'] == 2) ? $dir['ID'] : ''?>" 
				data-storageid="<?=$dir['STORAGE']?>" <?=($dir['ATTR']) ? 'data-viewer-type="'.$dir['ATTR']['data-viewer-type'].'" data-src="'.$dir['ATTR']['data-src'].'" data-viewer=""' : ''?>>
				<?=($dir['TYPE'] == 2) ? '<i class="fa fa-folder mr-2"></i>' : '<i class="fa fa-file mr-2"></i>'?><?=$dir['NAME']?>
				</a>
			<? endforeach; ?>
		</div>
	</div>
<? endif; ?>



