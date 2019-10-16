<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();



$arResult['STORE'] = intval($arParams['STORE']);
$arSelect = array(
	"EMAIL"
);
$dbProps = CCatalogStore::GetList(array('ID' => 'ASC'),array('ID' => $arResult['STORE'], 'ACTIVE' => 'Y'),false,false,$arSelect);
$arResult += $dbProps->GetNext();
