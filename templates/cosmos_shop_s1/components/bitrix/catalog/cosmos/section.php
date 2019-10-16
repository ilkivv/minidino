<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);


$this->setFrameMode(true);

$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
$arParams["SECTION_DEFAULT_VIEW"] = (isset($arParams["SECTION_DEFAULT_VIEW"]) ? $arParams["SECTION_DEFAULT_VIEW"] : "list");

$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');


if (IsModuleInstalled("sale") && IsModuleInstalled("boxsol.cosmofashion")) {
	$arComponentTemplates = array(
		"catalog.section" => "cosmos_sku",
		);
} else {
	$arComponentTemplates = array(
		"catalog.section" => "cosmos",
		);
}
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"cosmos_square",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
	),
	$component,
	array("HIDE_ICONS" => "Y")
);


if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
}
else
{
	$basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
}
$intSectionID = 0;

?><?
if($arParams["USE_COMPARE"]=="Y" && IsModuleInstalled("sale") && IsModuleInstalled("boxsol.cosmofashion"))
{
	?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.list",
	"cosmos",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"NAME" => $arParams["COMPARE_NAME"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		'POSITION_FIXED' => isset($arParams['COMPARE_POSITION_FIXED']) ? $arParams['COMPARE_POSITION_FIXED'] : '',
		'POSITION' => isset($arParams['COMPARE_POSITION']) ? $arParams['COMPARE_POSITION'] : ''
	),
	$component,
	array("HIDE_ICONS" => "Y")
);?>
<?}?>

<?
$arFilterSecCount = Array(
         "ACTIVE" => "Y",
         "IBLOCK_ID"=> $arParams["IBLOCK_ID"],
         "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"], 
      );

$subSecCount = CIBlockSection::GetCount($arFilterSecCount);
if ($subSecCount > 0 && $arParams["HIDE_IF_SUBSECTIONS_EXISTS"] == "Y") {
	return ;
}
?>



<?if (IsModuleInstalled("sale") || ($isFilter && ($APPLICATION->GetDirProperty("left_sidebar") != 'Y' && $APPLICATION->GetDirProperty("right_sidebar") != 'Y'))) : ?>
<div class="sidebar">
<?endif;?>
<?
if ($isFilter)
{
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);
	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
	{
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	}
	elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
	{
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
	}

	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
	{
		$arCurSection = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		$arCurSection = array();
		if (Loader::includeModule("iblock"))
		{
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurSection = $dbRes->Fetch())
				{
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
				}
				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurSection = $dbRes->Fetch())
					$arCurSection = array();
			}
		}
		$obCache->EndDataCache($arCurSection);
	}
	if (!isset($arCurSection))
	{
		$arCurSection = array();
	}


	if ($APPLICATION->GetDirProperty("left_sidebar") == 'Y' || $APPLICATION->GetDirProperty("right_sidebar") == 'Y')  {
		// show smart filter in header or footer sidebar
		$this->SetViewTarget('catalog_smart_filter_left');
	}
	?>
	<div class="widget clearfix">
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.smart.filter",
			"cosmos",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => $arCurSection['ID'],
				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"SAVE_IN_SESSION" => "N",
				"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
				"XML_EXPORT" => "Y",
			    "DISPLAY_ELEMENT_COUNT"=>"N",
				"SECTION_TITLE" => "NAME",
				"SECTION_DESCRIPTION" => "DESCRIPTION",
				'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
				"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				"SEF_MODE" => $arParams["SEF_MODE"],
				"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
				"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
				"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
			),
			$component,
			array('HIDE_ICONS' => 'Y')
		);?>
	</div>
	<?
	if ($APPLICATION->GetDirProperty("left_sidebar") == 'Y' || $APPLICATION->GetDirProperty("right_sidebar") == 'Y')  {
		$this->EndViewTarget();
	}
}
?>
    <?if (IsModuleInstalled("sale")):?>
	<div class="widget clearfix hidden-sm hidden-xs">
		<?$APPLICATION->IncludeComponent(
				"bitrix:sale.viewed.product",
				"cosmos_sidebar",
				Array(
					"ACTION_VARIABLE" => "viewed_action",
					"BASKET_URL" => $arParams["BASKET_URL"],
					"PRODUCT_ID_VARIABLE" => "id_viewed",
					"SET_TITLE" => "N",
					"VIEWED_CANBASKET" => "N",
					"VIEWED_CANBUY" => "N",
					"VIEWED_COUNT" => "5",
					"VIEWED_IMAGE" => "Y",
					"VIEWED_IMG_HEIGHT" => "300",
					"VIEWED_IMG_WIDTH" => "300",
					"VIEWED_NAME" => "Y",
					"VIEWED_PRICE" => "Y"
				)
			);?>
	</div>
	<?endif;?>
<?if (IsModuleInstalled("sale") || ($isFilter && ($APPLICATION->GetDirProperty("left_sidebar") != 'Y' && $APPLICATION->GetDirProperty("right_sidebar") != 'Y'))) : ?>
</div>
<?endif;?>
<div class="postcontent col_last">
<?if ($arParams["SHOW_ADDITIONAL_PANEL"] == "Y") :?>
	<div class="panel panel-default panel-sorting bottommargin panel-sorting__wrapper">
		<div class="panel-body nopadding panel-sorting__inner">
			<p class="panel-sorting__text">Сортировать:</p>
			<?
			$arSortTypes = array(
				"DEFAULT" => array(
					"SORT" => "default",
					"SORT_CODE" => $arParams["ELEMENT_SORT_FIELD"],
					"ACTIVE" => "N",
					"TEXT" => Loc::getMessage("CAT_SORT_BY_DEFAULT"),
					"SORT_PARAM" => $arParams,
				),
				"NAME" => array(
					"SORT" => "name",
					"SORT_CODE" => "NAME",
					"ACTIVE" => "N",
					"TEXT" => Loc::getMessage("CAT_SORT_BY_NAME"),
					"SORT_PARAM" => "NAME",
				),
				"PRICE" => array(
					"SORT" => "price",
					"SORT_CODE" => "PROPERTY_PRICE",
					"ACTIVE" => "N",
					"TEXT" => Loc::getMessage("CAT_SORT_BY_PRICE"),
					"SORT_PARAM" => $arParams,
				),
			);

			if (IsModuleInstalled("sale") && IsModuleInstalled("boxsol.cosmofashion")) {
				$arSortTypes["PRICE"]["SORT_CODE"] = "catalog_PRICE_1";
			}

			// set catalog order
			$cookieOrderName = Option::get("main", "cookie_name", "BITRIX_SM") . "_CATALOG_ORDER";
			$catalogOrder = $_COOKIE[$cookieOrderName];
			if (!isset($_GET["order"])) {
				if ($catalogOrder && strlen($catalogOrder) > 0) {
					$_GET["order"] = $catalogSort;
				} else {
					$_GET["order"] = "default";
				}
			} else {
				setcookie($cookieOrderName, htmlspecialcharsbx(strtolower($_GET["order"])), time()+60*60*24*30, SITE_DIR);
			}

			// set catalog sort
			$cookieSortName = Option::get("main", "cookie_name", "BITRIX_SM") . "_CATALOG_SORT";
			$catalogSort = $_COOKIE[$cookieSortName];

			if (!isset($_GET["sort"])) {
				if ($catalogSort && strlen($catalogSort) > 0) {
					$_GET["sort"] = $catalogSort;
				} else {
					$_GET["sort"] = "default";
				}
			} else {
				setcookie($cookieSortName, htmlspecialcharsbx(strtolower($_GET["sort"])), time()+60*60*24*30, SITE_DIR);
			}

			// set catalog view
			$cookieViewName = Option::get("main", "cookie_name", "BITRIX_SM") . "_CATALOG_VIEW";
			$catalogView = $_COOKIE[$cookieViewName];

			if (!isset($_GET["view"])) {
				if ($catalogView && strlen($catalogView) > 0) {
					$_GET["view"] = $catalogView;
				} else {
					$_GET["view"] = $arParams["SECTION_DEFAULT_VIEW"];
				}
			} else {
				setcookie($cookieViewName, htmlspecialcharsbx(strtolower($_GET["view"])), time()+60*60*24*30, SITE_DIR);
			}

			foreach ($arSortTypes as $keySort => $arSortType) :
				$sortParams = "sort=" . $arSortType["SORT"];
				if ($_GET["order"] == "desc" && $_GET["sort"] == $arSortType["SORT"]) {
					$sortParams .= "&order=asc";
					$sortArrow = '<i class="icon-line-arrow-up"></i>';
					($_GET["sort"] == $arSortType["SORT"]) ? $arParams["ELEMENT_SORT_ORDER"] = "DESC" : "";
				} else {
					$sortParams .= "&order=desc";
					$sortArrow = '<i class="icon-line-arrow-down"></i>';
					($_GET["sort"] == $arSortType["SORT"]) ? $arParams["ELEMENT_SORT_ORDER"] = "ASC" : "";
				}
				?>
				<a href="<?=$APPLICATION->GetCurPageParam($sortParams, array("sort", "order"));?>" class="panel-sorting__link <?
				echo ($_GET["sort"] == $arSortType["SORT"]) ? 'button button-mini tright panel-sorting__link--selected' : ""?>">
					<?
					echo $arSortType["TEXT"];
					echo ($_GET["sort"] == $arSortType["SORT"]) ? $sortArrow : "";
					($_GET["sort"] == $arSortType["SORT"]) ? $arParams["ELEMENT_SORT_FIELD"] = $arSortType["SORT_CODE"] : "";
					?></a>
			<?endforeach;?>
			<?
			if ($_GET["view"] == "list") {
				$arParams["LINE_ELEMENT_COUNT"] = 1;
				$arParams["TABLE_VIEW"] = "N";
			} elseif ($_GET["view"] == "table") {
				$arParams["LINE_ELEMENT_COUNT"] = 1;
				$arParams["TABLE_VIEW"] = "Y";
			} else {
				$arParams["LINE_ELEMENT_COUNT"] = $arParams["LINE_ELEMENT_COUNT"];
				$arParams["TABLE_VIEW"] = "N";
			}
			?>
		</div>
	</div>
<?endif;?>
<?$intSectionID = $APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		$arComponentTemplates["catalog.section"],
		array(
			"LINK_TO_AJAX" => $arParams["LINK_TO_AJAX"],
			"AJAX_TYPE" => $arParams["AJAX_TYPE"],
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
			"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
			"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
			"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
			"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
			"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_FILTER" => $arParams["CACHE_FILTER"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"MESSAGE_404" => $arParams["MESSAGE_404"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"SHOW_404" => $arParams["SHOW_404"],
			"FILE_404" => $arParams["FILE_404"],
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
			"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
			"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
			"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
			"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
			"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

			'LABEL_PROP' => $arParams['LABEL_PROP'],
			'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
			'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

			'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
			'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
			'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
			'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
			'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
			'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
			'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
			'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
			'BACKGROUND_IMAGE' => $arParams["SECTION_BACKGROUND_IMAGE"],

			"SECTION_USE_IMAGE_RESIZE" => $arParams['SECTION_USE_IMAGE_RESIZE'],
			"SECTION_IMAGE_RESIZE_WIDTH" => $arParams['SECTION_IMAGE_RESIZE_WIDTH'],
			"SECTION_IMAGE_RESIZE_HEIGHT" => $arParams['SECTION_IMAGE_RESIZE_HEIGHT'],
			"SECTION_IMAGE_RESIZE_TYPE" => $arParams['SECTION_IMAGE_RESIZE_TYPE'],
			"TABLE_VIEW" => $arParams['TABLE_VIEW'],
			"SECTION_HIDE_ICONLIST" => $arParams['SECTION_HIDE_ICONLIST'],
			"SECTION_HIDE_PREVIEW_TEXT" => $arParams['SECTION_HIDE_PREVIEW_TEXT'],

			'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			"ADD_SECTIONS_CHAIN" => "N",
			'ADD_TO_BASKET_ACTION' => $basketAction,
			'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
			'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
		),
		$component
);?><?
$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
unset($basketAction);
?></div>