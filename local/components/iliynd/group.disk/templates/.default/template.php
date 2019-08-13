<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\UI\Extension;
Extension::load('ui.bootstrap4');

$this->addExternalCss("/bitrix/css/main/font-awesome.css");

?>

<? if ($arResult["DIR"]) :?>
	<div class="bd-example" id="group-disk">
		<div class="list-group">
			<? foreach ($arResult["DIR"] as $dir) :?>
				<a href="#" 
				class="list-group-item list-group-item-action" 
				data-folderid="<?=($dir['TYPE'] == 2) ? $dir['ID'] : ''?>" 
				data-storageid="<?=$dir['STORAGE']?>"
				data-canname="<?=str_replace('.', '',$dir['NAME'])?>"  <?=($dir['ATTR']) ? $dir['ATTR'] : ''?>  >
				<?=($dir['TYPE'] == 2) ? '<i class="fa fa-folder mr-2"></i>' : '<i class="fa fa-file mr-2"></i>'?><?=$dir['NAME']?>
				</a>
			<? endforeach; ?>
		</div>
	</div>
<? endif; 




if ($arResult["OPENFILE"]) {
	$i = 0;?>
		<script type="text/javascript">
			BX.ready(function(){	
				<?foreach($arResult["OPENFILE"] as $diropen) { 
					?>
		    		setTimeout(function() { var select = document.querySelector('a[data-canname="<?=$diropen?>"]'); BX.fireEvent(select,'click'); }, <?=$i?>);
				<?
				$i = $i + 300;
				}?>
			});
		</script>
<? 
}



?>

