<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("catalog");
$itemsSum = 0;
foreach($arResult["ITEMS"] as $key => $arItem) {
    $itemsSum += $arItem["PRICE"] * $arItem["QUANTITY"];
    $idsArray[] = IntVal($arItem["PRODUCT_ID"]);
}

$arResult["BASKET_SUM"] = $itemsSum;
if(count($arResult["ITEMS"]) > 0 && CModule::IncludeModule('iblock')) {
    $res = CIBlockElement::GetList(
        array(),
        array("ACTIVE" => "Y", "ID" => $idsArray),
        false,
        false,
        array("PREVIEW_PICTURE", "DETAIL_PICTURE", "ID", "DETAIL_PAGE_URL")
    );

    while($ar_fields = $res->GetNext()) {

        if (!isset($ar_fields["PREVIEW_PICTURE"]) && !isset($ar_fields["DETAIL_PICTURE"])){
            $ar_field_parent_sku = CCatalogSku::GetProductInfo($ar_fields["ID"], $ar_fields["IBLOCK_ID"]);
            if ($ar_field_parent_sku["ID"] > 0) {
                $ar_parent_sku_res = CIBlockElement::GetList(
                    array(),
                    array("ACTIVE" => "Y", "ID" => $ar_field_parent_sku["ID"]),
                    false,
                    false,
                    array("PREVIEW_PICTURE", "DETAIL_PICTURE", "ID", "DETAIL_PAGE_URL")
                );
                if ($ar_parent_sku_fields = $ar_parent_sku_res->GetNext()) {
                    $ar_fields["PREVIEW_PICTURE"] = $ar_parent_sku_fields["PREVIEW_PICTURE"];
                    $ar_fields["DETAIL_PICTURE"] = $ar_parent_sku_fields["DETAIL_PICTURE"];
                }
            }
        }

        if (isset($ar_fields["PREVIEW_PICTURE"])) {
            $arFileTmp = CFile::ResizeImageGet(
                $ar_fields["PREVIEW_PICTURE"],
                array("width" => 120, "height" => 120),
                BX_RESIZE_IMAGE_EXACT,
                true
            );
        } elseif ($ar_fields["DETAIL_PICTURE"]) {
            $arFileTmp = CFile::ResizeImageGet(
                $ar_fields["DETAIL_PICTURE"],
                array("width" => 120, "height" => 120),
                BX_RESIZE_IMAGE_EXACT,
                true
            );
        } else {
            $arFileTmp["src"] = $this->GetFolder() . "/images/no_photo.png";
        }

        // strange bug
        $arResult["DETAIL_PAGE_URLS"][$ar_fields["ID"]] = $ar_fields["DETAIL_PAGE_URL"];
        // end

        $arResult['PICTURES'][$ar_fields["ID"]] = array(
            'SRC' => $arFileTmp["src"],
            'WIDTH' => $arFileTmp["width"],
            'HEIGHT' => $arFileTmp["height"],
        );
        unset($ar_parent_sku_fields);
        unset($ar_field_parent_sku);
        unset($arFileTmp);
        unset($ar_fields);
    }
}

?>