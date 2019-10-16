<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;


$arProperty_LNSF = array(
	"IBLOCK_SECTION" => GetMessage("IBLOCK_ADD_IBLOCK_SECTION"),
	"NAME" => GetMessage("IBLOCK_ADD_NAME"),
	/*"TAGS" => GetMessage("IBLOCK_ADD_TAGS"),
	"DATE_ACTIVE_FROM" => GetMessage("IBLOCK_ADD_ACTIVE_FROM"),
	"DATE_ACTIVE_TO" => GetMessage("IBLOCK_ADD_ACTIVE_TO"),
	"PREVIEW_TEXT" => GetMessage("IBLOCK_ADD_PREVIEW_TEXT"),
	"PREVIEW_PICTURE" => GetMessage("IBLOCK_ADD_PREVIEW_PICTURE"),
	"DETAIL_TEXT" => GetMessage("IBLOCK_ADD_DETAIL_TEXT"),
	"DETAIL_PICTURE" => GetMessage("IBLOCK_ADD_DETAIL_PICTURE"),*/
);
$arVirtualProperties = $arProperty_LNSF;

$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "F", "E")))
	{
		$arProperty_LNSF[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arTemplateParameters = array(

		"EMAIL_TO" => array(
			"PARENT" => "PARAMS",
			"NAME" => GetMessage("ADD_ELEMENT_FORM_EMAIL_TO"),
			"TYPE" => "TEXT",
			"DEFAULT" => "",
		),

		"FORM_TITLE" => array(
			"PARENT" => "PARAMS",
			"NAME" => GetMessage("ADD_ELEMENT_FORM_TITLE"),
			"TYPE" => "TEXT",
			"DEFAULT" => GetMessage("ADD_ELEMENT_FORM_TITLE_DEFAULT"),
		),

		"PROPERTY_CODES" => array(
			"PARENT" => "FIELDS",
			"NAME" => GetMessage("IBLOCK_PROPERTY"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty_LNSF,
		),

		"PROPERTY_CODES_REQUIRED" => array(
			"PARENT" => "FIELDS",
			"NAME" => GetMessage("IBLOCK_PROPERTY_REQUIRED"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "N",
			"VALUES" => $arProperty_LNSF,
		),

);



if (strlen($arCurrentValues["IBLOCK_ID"]) > 0 )
{

	$arFilter = array('IBLOCK_ID' => $arCurrentValues["IBLOCK_ID"]);
	$rsSections = CIBlockSection::GetList(array(), $arFilter);
	while ($arSection = $rsSections->Fetch()) {
		$arSections[$arSection["ID"]] = "[".$arSection["ID"]."] ".$arSection["NAME"];
	}

	$arTemplateParameters["SECTION_ID"] = array(
		"NAME" => GetMessage("ADD_ELEMENT_CHOOSE_SECTION"),
		"TYPE" => "LIST",
		"VALUE" => "Y",
		"DEFAULT" => "N",
		"VALUES" => $arSections,
		"PARENT" => "DATA_SOURCE",
	);
}

?>