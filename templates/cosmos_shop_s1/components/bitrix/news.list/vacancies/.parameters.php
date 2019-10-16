<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (CModule::IncludeModule("form")){
    $arTemplateParameters = array(
        "SHOW_FORM" => array(
            "NAME" => GetMessage("FRN_SHOW_FROM"),
            "PARENT" => "BASE",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",   
            "REFRESH"=> "Y",
        ),
    );

    if ($arCurrentValues["SHOW_FORM"] == "Y") {
        $arTemplateParameters["FORM_URL"] = array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("FRN_FORM_URL"),
            "TYPE" => "STRING",
            "DEFAULT" => SITE_DIR . "/ajax/vacancy.php",
        );
    }

} else {
    return;
}

?>