<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("Socialnetwork");

$dbIBlockType = \Bitrix\Socialnetwork\WorkgroupTable::GetList(
   array('filter' => array("ACTIVE" => "Y"))
);
while ($arIBlockType = $dbIBlockType->Fetch())
{
      $arIblockType[$arIBlockType["ID"]] = "[".$arIBlockType["ID"]."] ".$arIBlockType["NAME"];
}

$arComponentParameters = array(
   "GROUPS" => array(
      "SETTINGS" => array(
         "NAME" => GetMessage("SETTINGS_PHR")
      ),
      "PARAMS" => array(
         "NAME" => GetMessage("PARAMS_PHR")
      ),
   ),
   "PARAMETERS" => array(
      "GROUP_ID" => array(
         "PARENT" => "SETTINGS",
         "NAME" => "Группа",
         "TYPE" => "LIST",
         "ADDITIONAL_VALUES" => "Y",
         "VALUES" => $arIblockType,
         "REFRESH" => "Y"
      ),

      "SEF_MODE" => array(
         "list" => array(
            "NAME" => GetMessage("CATALOG_LIST_PATH_TEMPLATE_PHR"),
            "DEFAULT" => "index.php",
            "VARIABLES" => array()
         ),
         "section1" => array(
            "NAME" => GetMessage("SECTION_LIST_PATH_TEMPLATE_PHR"),
            "DEFAULT" => "#IBLOCK_ID#",
            "VARIABLES" => array("IBLOCK_ID")
         ),
         "section2" => array(
            "NAME" => GetMessage("SUB_SECTION_LIST_PATH_TEMPLATE_PHR"),
            "DEFAULT" => "#IBLOCK_ID#/#SECTION_ID#",
            "VARIABLES" => array("IBLOCK_ID", "SECTION_ID")
         ),
      ),
   )
);
?>