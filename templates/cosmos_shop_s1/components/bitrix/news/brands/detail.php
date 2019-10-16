<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== TRUE) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(TRUE);
?>
<!-- Post Content
============================================= -->
<div class="nobottommargin clearfix">
	<div class="single-post nobottommargin">
		<? $ElementID = $APPLICATION->IncludeComponent(
				"bitrix:news.detail",
				"single",
				Array(
						"DISPLAY_DATE"              => $arParams["DISPLAY_DATE"],
						"DISPLAY_NAME"              => $arParams["DISPLAY_NAME"],
						"DISPLAY_PICTURE"           => $arParams["DISPLAY_PICTURE"],
						"DISPLAY_PREVIEW_TEXT"      => $arParams["DISPLAY_PREVIEW_TEXT"],
						"IBLOCK_TYPE"               => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID"                 => $arParams["IBLOCK_ID"],
						"FIELD_CODE"                => $arParams["DETAIL_FIELD_CODE"],
						"PROPERTY_CODE"             => $arParams["DETAIL_PROPERTY_CODE"],
						"DETAIL_URL"                => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
						"SECTION_URL"               => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
						"META_KEYWORDS"             => $arParams["META_KEYWORDS"],
						"META_DESCRIPTION"          => $arParams["META_DESCRIPTION"],
						"BROWSER_TITLE"             => $arParams["BROWSER_TITLE"],
						"DISPLAY_PANEL"             => $arParams["DISPLAY_PANEL"],
						"SET_TITLE"                 => $arParams["SET_TITLE"],
						"SET_STATUS_404"            => $arParams["SET_STATUS_404"],
						"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
						"ADD_SECTIONS_CHAIN"        => $arParams["ADD_SECTIONS_CHAIN"],
						"ACTIVE_DATE_FORMAT"        => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
						"CACHE_TYPE"                => $arParams["CACHE_TYPE"],
						"CACHE_TIME"                => $arParams["CACHE_TIME"],
						"CACHE_GROUPS"              => $arParams["CACHE_GROUPS"],
						"USE_PERMISSIONS"           => $arParams["USE_PERMISSIONS"],
						"GROUP_PERMISSIONS"         => $arParams["GROUP_PERMISSIONS"],
						"DISPLAY_TOP_PAGER"         => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
						"DISPLAY_BOTTOM_PAGER"      => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
						"PAGER_TITLE"               => $arParams["DETAIL_PAGER_TITLE"],
						"PAGER_SHOW_ALWAYS"         => "N",
						"PAGER_TEMPLATE"            => $arParams["DETAIL_PAGER_TEMPLATE"],
						"PAGER_SHOW_ALL"            => $arParams["DETAIL_PAGER_SHOW_ALL"],
						"CHECK_DATES"               => $arParams["CHECK_DATES"],
						"ELEMENT_ID"                => $arResult["VARIABLES"]["ELEMENT_ID"],
						"ELEMENT_CODE"              => $arResult["VARIABLES"]["ELEMENT_CODE"],
						"IBLOCK_URL"                => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
						"USE_SHARE"                 => $arParams["USE_SHARE"],
						"SHARE_HIDE"                => $arParams["SHARE_HIDE"],
						"SHARE_TEMPLATE"            => $arParams["SHARE_TEMPLATE"],
						"SHARE_HANDLERS"            => $arParams["SHARE_HANDLERS"],
						"SHARE_SHORTEN_URL_LOGIN"   => $arParams["SHARE_SHORTEN_URL_LOGIN"],
						"SHARE_SHORTEN_URL_KEY"     => $arParams["SHARE_SHORTEN_URL_KEY"],
						"ADD_ELEMENT_CHAIN"         => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
						"DETAIL_PICTURE_RIGHT"		=> "Y",
				),
				$component
		); ?>

<?

$iblockCode = "catalogshop_" . SITE_ID;
$res = CIBlock::GetList(
	Array(),
	Array(
		"CODE" => $iblockCode
		),
	true
);
while($ar_res = $res->Fetch() ) {
	$catalogIblockId = $ar_res['ID'];
}
if ($catalogIblockId > 0) {

	global $arFilterPropBrand;
	$arFilterPropBrand = array(
	    "PROPERTY_BRAND" => $ElementID
	    );
	?>
	<?$APPLICATION->IncludeComponent(
	    "bitrix:catalog.top", 
	    "cosmos", 
	    array(
	        "COMPONENT_TEMPLATE" => "cosmos",
	        "IBLOCK_TYPE" => "md_catalog_" . SITE_ID,
	        "IBLOCK_ID" => $catalogIblockId,
	        "ELEMENT_SORT_FIELD" => "",
	        "ELEMENT_SORT_ORDER" => "asc",
	        "ELEMENT_SORT_FIELD2" => "id",
	        "ELEMENT_SORT_ORDER2" => "desc",
	        "FILTER_NAME" => "arFilterPropBrand",
	        "HIDE_NOT_AVAILABLE" => "N",
	        "ELEMENT_COUNT" => "30",
	        "LINE_ELEMENT_COUNT" => "3",
	        "PROPERTY_CODE" => array(
	        ),
	        "OFFERS_FIELD_CODE" => array(
	            0 => "PREVIEW_PICTURE",
	            1 => "DETAIL_PICTURE",
	            2 => "",
	        ),
	        "OFFERS_PROPERTY_CODE" => array(
	            0 => "COLOR_REF",
	            1 => "SIZES_SHOES",
	            2 => "SIZES_CLOTHES",
	            3 => "MEMORY_SIZE",
	            4 => "",
	        ),
	        "OFFERS_SORT_FIELD" => "sort",
	        "OFFERS_SORT_ORDER" => "asc",
	        "OFFERS_SORT_FIELD2" => "id",
	        "OFFERS_SORT_ORDER2" => "desc",
	        "OFFERS_LIMIT" => "7",
	        "VIEW_MODE" => "SECTION",
	        "TEMPLATE_THEME" => "blue",
	        "PRODUCT_DISPLAY_MODE" => "Y",
	        "ADD_PICT_PROP" => "MORE_PHOTO",
	        "LABEL_PROP" => "",
	        "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
	        "OFFER_TREE_PROPS" => array(
	            0 => "COLOR_REF",
	            1 => "SIZES_SHOES",
	            2 => "SIZES_CLOTHES",
	            3 => "MEMORY_SIZE",
	        ),
	        "SHOW_DISCOUNT_PERCENT" => "Y",
	        "SHOW_OLD_PRICE" => "Y",
	        "SHOW_CLOSE_POPUP" => "Y",
	        "SECTION_URL" => SITE_DIR . "catalog/#SECTION_CODE#/",
	        "DETAIL_URL" => SITE_DIR . "catalog/#SECTION_CODE#/#ELEMENT_CODE#/",
	        "SECTION_ID_VARIABLE" => "SECTION_ID",
	        "PRODUCT_QUANTITY_VARIABLE" => "",
	        "SEF_MODE" => "N",
	        "CACHE_TYPE" => "A",
	        "CACHE_TIME" => "36000000",
	        "CACHE_GROUPS" => "Y",
	        "CACHE_FILTER" => "N",
	        "ACTION_VARIABLE" => "action",
	        "PRODUCT_ID_VARIABLE" => "id",
	        "PRICE_CODE" => array(
	            0 => "BASE",
	        ),
	        "USE_PRICE_COUNT" => "N",
	        "SHOW_PRICE_COUNT" => "1",
	        "PRICE_VAT_INCLUDE" => "Y",
	        "CONVERT_CURRENCY" => "N",
	        "BASKET_URL" => SITE_DIR . "personal/cart/",
	        "USE_PRODUCT_QUANTITY" => "N",
	        "ADD_PROPERTIES_TO_BASKET" => "Y",
	        "PRODUCT_PROPS_VARIABLE" => "prop",
	        "PARTIAL_PRODUCT_PROPERTIES" => "N",
	        "PRODUCT_PROPERTIES" => array(
	        ),
	        "OFFERS_CART_PROPERTIES" => array(
	            0 => "COLOR_REF",
	            1 => "SIZES_SHOES",
	            2 => "SIZES_CLOTHES",
	        ),
	        "ADD_TO_BASKET_ACTION" => "ADD",
	        "DISPLAY_COMPARE" => "Y",
	        "COMPARE_PATH" => SITE_DIR . "catalog/compare/",
	        "ROTATE_TIMER" => "30",
	        "SHOW_PAGINATION" => "Y",
	        "SECTION_USE_IMAGE_RESIZE" => "Y",
	        "SECTION_IMAGE_RESIZE_WIDTH" => "360",
	        "SECTION_IMAGE_RESIZE_HEIGHT" => "360",
	        "SECTION_IMAGE_RESIZE_TYPE" => "1"
	    ),
	    false
	);?>
<?
}
?>
	</div>
</div><!-- .postcontent end -->