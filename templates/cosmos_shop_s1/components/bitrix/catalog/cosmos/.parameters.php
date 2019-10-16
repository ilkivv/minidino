<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if (!Loader::includeModule('iblock'))
	return;
$boolCatalog = Loader::includeModule('catalog');

$arSKU = false;
$boolSKU = false;
if ($boolCatalog && (isset($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID']) > 0)
{
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	$boolSKU = !empty($arSKU) && is_array($arSKU);
}

$arThemes = array();
if (ModuleManager::isModuleInstalled('bitrix.eshop'))
{
	$arThemes['site'] = Loc::getMessage('CPT_BC_TPL_THEME_SITE');
}

$arThemes['blue'] = Loc::getMessage('CPT_BC_TPL_THEME_BLUE');
$arThemes['green'] = Loc::getMessage('CPT_BC_TPL_THEME_GREEN');
$arThemes['red'] = Loc::getMessage('CPT_BC_TPL_THEME_RED');
$arThemes['wood'] = Loc::getMessage('CPT_BC_TPL_THEME_WOOD');
$arThemes['yellow'] = Loc::getMessage('CPT_BC_TPL_THEME_YELLOW');
$arThemes['black'] = Loc::getMessage('CP_BC_TPL_THEME_BLACK');

$arViewModeList = array(
	'LIST' => Loc::getMessage('CPT_BC_SECTIONS_VIEW_MODE_LIST'),
	//'TEXT' => Loc::getMessage('CPT_BC_SECTIONS_VIEW_MODE_TEXT'),
	'TILE' => Loc::getMessage('CPT_BC_SECTIONS_VIEW_MODE_TILE'),
	'BLOCK' => GetMessage('CPT_BC_SECTIONS_VIEW_MODE_BLOCK'),
);

$arFilterViewModeList = array(
	"VERTICAL" => Loc::getMessage("CPT_BC_FILTER_VIEW_MODE_VERTICAL"),
	"HORIZONTAL" => Loc::getMessage("CPT_BC_FILTER_VIEW_MODE_HORIZONTAL")
);

$arTemplateParameters = array(
	"SECTIONS_VIEW_MODE" => array(
		"PARENT" => "SECTIONS_SETTINGS",
		"NAME" => Loc::getMessage('CPT_BC_SECTIONS_VIEW_MODE'),
		"TYPE" => "LIST",
		"VALUES" => $arViewModeList,
		"MULTIPLE" => "N",
		"DEFAULT" => "LIST",
		"REFRESH" => "Y"
	),
	"SECTIONS_SHOW_PARENT_NAME" => array(
		"PARENT" => "SECTIONS_SETTINGS",
		"NAME" => Loc::getMessage('CPT_BC_SECTIONS_SHOW_PARENT_NAME'),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y"
	)
);

if (isset($arCurrentValues['SECTIONS_VIEW_MODE']) && 'TILE' == $arCurrentValues['SECTIONS_VIEW_MODE'])
{
	$arTemplateParameters['SECTIONS_HIDE_SECTION_NAME'] = array(
		'PARENT' => 'SECTIONS_SETTINGS',
		'NAME' => Loc::getMessage('CPT_BC_SECTIONS_HIDE_SECTION_NAME'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N'
	);
}

$arTemplateParameters["FILTER_VIEW_MODE"] = array(
	"PARENT" => "FILTER_SETTINGS",
	"NAME" => Loc::getMessage('CPT_BC_FILTER_VIEW_MODE'),
	"TYPE" => "LIST",
	"VALUES" => $arFilterViewModeList,
	"DEFAULT" => "VERTICAL",
	"HIDDEN" => (!isset($arCurrentValues['USE_FILTER']) || 'N' == $arCurrentValues['USE_FILTER'])
);

$arTemplateParameters['TEMPLATE_THEME'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage("CP_BC_TPL_TEMPLATE_THEME"),
	'TYPE' => 'LIST',
	'VALUES' => $arThemes,
	'DEFAULT' => 'blue',
	'ADDITIONAL_VALUES' => 'Y'
);

if (isset($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0)
{
	$arAllPropList = array();
	$arFilePropList = array(
		'-' => Loc::getMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$arListPropList = array(
		'-' => Loc::getMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$arHighloadPropList = array(
		'-' => Loc::getMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$rsProps = CIBlockProperty::GetList(
		array('SORT' => 'ASC', 'ID' => 'ASC'),
		array('IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], 'ACTIVE' => 'Y')
	);
	while ($arProp = $rsProps->Fetch())
	{
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
		if ('' == $arProp['CODE'])
			$arProp['CODE'] = $arProp['ID'];
		$arAllPropList[$arProp['CODE']] = $strPropName;
		if ('F' == $arProp['PROPERTY_TYPE'])
			$arFilePropList[$arProp['CODE']] = $strPropName;
		if ('L' == $arProp['PROPERTY_TYPE'])
			$arListPropList[$arProp['CODE']] = $strPropName;
		if ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
			$arHighloadPropList[$arProp['CODE']] = $strPropName;
	}

	$arTemplateParameters['ADD_PICT_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('CP_BC_TPL_ADD_PICT_PROP'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'ADDITIONAL_VALUES' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => '-',
		'VALUES' => $arFilePropList
	);
	$arTemplateParameters['LABEL_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('CP_BC_TPL_LABEL_PROP'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'ADDITIONAL_VALUES' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => '-',
		'VALUES' => $arListPropList
	);

	if ($boolSKU)
	{
		$arDisplayModeList = array(
			'N' => Loc::getMessage('CP_BC_TPL_DML_SIMPLE'),
			'Y' => Loc::getMessage('CP_BC_TPL_DML_EXT')
		);
		$arTemplateParameters['PRODUCT_DISPLAY_MODE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => Loc::getMessage('CP_BC_TPL_PRODUCT_DISPLAY_MODE'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'Y',
			'DEFAULT' => 'N',
			'VALUES' => $arDisplayModeList
		);
		$arAllOfferPropList = array();
		$arFileOfferPropList = array(
			'-' => Loc::getMessage('CP_BC_TPL_PROP_EMPTY')
		);
		$arTreeOfferPropList = array(
			'-' => Loc::getMessage('CP_BC_TPL_PROP_EMPTY')
		);
		$rsProps = CIBlockProperty::GetList(
			array('SORT' => 'ASC', 'ID' => 'ASC'),
			array('IBLOCK_ID' => $arSKU['IBLOCK_ID'], 'ACTIVE' => 'Y')
		);
		while ($arProp = $rsProps->Fetch())
		{
			if ($arProp['ID'] == $arSKU['SKU_PROPERTY_ID'])
				continue;
			$arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];
			$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
			if ('' == $arProp['CODE'])
				$arProp['CODE'] = $arProp['ID'];
			$arAllOfferPropList[$arProp['CODE']] = $strPropName;
			if ('F' == $arProp['PROPERTY_TYPE'])
				$arFileOfferPropList[$arProp['CODE']] = $strPropName;
			if ('N' != $arProp['MULTIPLE'])
				continue;
			if (
				'L' == $arProp['PROPERTY_TYPE']
				|| 'E' == $arProp['PROPERTY_TYPE']
				|| ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
			)
				$arTreeOfferPropList[$arProp['CODE']] = $strPropName;
		}
		$arTemplateParameters['OFFER_ADD_PICT_PROP'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => Loc::getMessage('CP_BC_TPL_OFFER_ADD_PICT_PROP'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arFileOfferPropList
		);
		$arTemplateParameters['OFFER_TREE_PROPS'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => Loc::getMessage('CP_BC_TPL_OFFER_TREE_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arTreeOfferPropList
		);
	}
}

$arTemplateParameters['DETAIL_DISPLAY_NAME'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_DISPLAY_NAME'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y'
);

$detailPictMode = array(
	'IMG' => Loc::getMessage('DETAIL_DETAIL_PICTURE_MODE_IMG'),
	'POPUP' => Loc::getMessage('DETAIL_DETAIL_PICTURE_MODE_POPUP'),
	'MAGNIFIER' => Loc::getMessage('DETAIL_DETAIL_PICTURE_MODE_MAGNIFIER'),
/*	'GALLERY' => Loc::getMessage('DETAIL_DETAIL_PICTURE_MODE_GALLERY') */
);

$arTemplateParameters['DETAIL_DETAIL_PICTURE_MODE'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_DETAIL_PICTURE_MODE'),
	'TYPE' => 'LIST',
	'DEFAULT' => 'IMG',
	'VALUES' => $detailPictMode
);

$arTemplateParameters['DETAIL_ADD_DETAIL_TO_SLIDER'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_ADD_DETAIL_TO_SLIDER'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N'
);

$displayPreviewTextMode = array(
	'H' => Loc::getMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE_HIDE'),
	'E' => Loc::getMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE_EMPTY_DETAIL'),
	'S' => Loc::getMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE_SHOW')
);

$arTemplateParameters['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE'),
	'TYPE' => 'LIST',
	'VALUES' => $displayPreviewTextMode,
	'DEFAULT' => 'E'
);

if ($boolCatalog)
{
	$arTemplateParameters['USE_COMMON_SETTINGS_BASKET_POPUP'] = array(
		'PARENT' => 'BASKET',
		'NAME' => Loc::getMessage('CP_BC_TPL_USE_COMMON_SETTINGS_BASKET_POPUP'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);
	$useCommonSettingsBasketPopup = (
		isset($arCurrentValues['USE_COMMON_SETTINGS_BASKET_POPUP'])
		&& $arCurrentValues['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y'
	);
	$addToBasketActions = array(
		'BUY' => Loc::getMessage('ADD_TO_BASKET_ACTION_BUY'),
		'ADD' => Loc::getMessage('ADD_TO_BASKET_ACTION_ADD')
	);
	$arTemplateParameters['COMMON_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => Loc::getMessage('CP_BC_TPL_COMMON_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N',
		'HIDDEN' => ($useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	$arTemplateParameters['COMMON_SHOW_CLOSE_POPUP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('CP_BC_TPL_COMMON_SHOW_CLOSE_POPUP'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
	$arTemplateParameters['TOP_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => Loc::getMessage('CP_BC_TPL_TOP_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N',
		'HIDDEN' => (!$useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	$arTemplateParameters['SECTION_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => Loc::getMessage('CP_BC_TPL_SECTION_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N',
		'HIDDEN' => (!$useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	$arTemplateParameters['DETAIL_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'BUY',
		'REFRESH' => 'N',
		'MULTIPLE' => 'Y',
		'HIDDEN' => (!$useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	/*	$arTemplateParameters['PRODUCT_SUBSCRIPTION'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => Loc::getMessage('CP_BC_TPL_PRODUCT_SUBSCRIPTION'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		); */
	$arTemplateParameters['SHOW_DISCOUNT_PERCENT'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('CP_BC_TPL_SHOW_DISCOUNT_PERCENT'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y',
	);
	$arTemplateParameters['SHOW_OLD_PRICE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('CP_BC_TPL_SHOW_OLD_PRICE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
	$arTemplateParameters['DETAIL_SHOW_MAX_QUANTITY'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_SHOW_MAX_QUANTITY'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
	if (isset($arCurrentValues['USE_PRODUCT_QUANTITY']) && $arCurrentValues['USE_PRODUCT_QUANTITY'] === 'Y')
	{
		$arTemplateParameters['DETAIL_SHOW_BASIS_PRICE'] = array(
			"PARENT" => "BASKET",
			"NAME" => Loc::getMessage("CP_BC_TPL_DETAIL_SHOW_BASIS_PRICE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"REFRESH" => "N",
		);
	}
}

$arTemplateParameters['MESS_BTN_BUY'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('CP_BC_TPL_MESS_BTN_BUY'),
	'TYPE' => 'STRING',
	'DEFAULT' => Loc::getMessage('CP_BC_TPL_MESS_BTN_BUY_DEFAULT')
);
$arTemplateParameters['MESS_BTN_ADD_TO_BASKET'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('CP_BC_TPL_MESS_BTN_ADD_TO_BASKET'),
	'TYPE' => 'STRING',
	'DEFAULT' => Loc::getMessage('CP_BC_TPL_MESS_BTN_ADD_TO_BASKET_DEFAULT')
);
$arTemplateParameters['MESS_BTN_COMPARE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('CP_BC_TPL_MESS_BTN_COMPARE'),
	'TYPE' => 'STRING',
	'DEFAULT' => Loc::getMessage('CP_BC_TPL_MESS_BTN_COMPARE_DEFAULT')
);
$arTemplateParameters['MESS_BTN_DETAIL'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('CP_BC_TPL_MESS_BTN_DETAIL'),
	'TYPE' => 'STRING',
	'DEFAULT' => Loc::getMessage('CP_BC_TPL_MESS_BTN_DETAIL_DEFAULT')
);
$arTemplateParameters['MESS_NOT_AVAILABLE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('CP_BC_TPL_MESS_NOT_AVAILABLE'),
	'TYPE' => 'STRING',
	'DEFAULT' => Loc::getMessage('CP_BC_TPL_MESS_NOT_AVAILABLE_DEFAULT')
);
$arTemplateParameters['DETAIL_USE_VOTE_RATING'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_USE_VOTE_RATING'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y'
);
if (isset($arCurrentValues['DETAIL_USE_VOTE_RATING']) && 'Y' == $arCurrentValues['DETAIL_USE_VOTE_RATING'])
{
	$arTemplateParameters['DETAIL_VOTE_DISPLAY_AS_RATING'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_VOTE_DISPLAY_AS_RATING'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'rating' => Loc::getMessage('CP_BC_TPL_DVDAR_RATING'),
			'vote_avg' => Loc::getMessage('CP_BC_TPL_DVDAR_AVERAGE'),
		),
		'DEFAULT' => 'rating'
	);
}

$arTemplateParameters['DETAIL_USE_COMMENTS'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_USE_COMMENTS'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y'
);
if (isset($arCurrentValues['DETAIL_USE_COMMENTS']) && 'Y' == $arCurrentValues['DETAIL_USE_COMMENTS'])
{
	if (ModuleManager::isModuleInstalled("blog"))
	{
		$arTemplateParameters['DETAIL_BLOG_USE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_BLOG_USE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
			'REFRESH' => 'Y'
		);
		if (isset($arCurrentValues['DETAIL_BLOG_USE']) && $arCurrentValues['DETAIL_BLOG_USE'] == 'Y')
		{
			$arTemplateParameters['DETAIL_BLOG_URL'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => Loc::getMessage('CP_BCE_DETAIL_TPL_BLOG_URL'),
				'TYPE' => 'STRING',
				'DEFAULT' => 'catalog_comments'
			);
			$arTemplateParameters['DETAIL_BLOG_EMAIL_NOTIFY'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => Loc::getMessage('CP_BCE_TPL_DETAIL_BLOG_EMAIL_NOTIFY'),
				'TYPE' => 'CHECKBOX',
				'DEFAULT' => 'N'
			);
		}
	}

	$boolRus = false;
	$langBy = "id";
	$langOrder = "asc";
	$rsLangs = CLanguage::GetList($langBy, $langOrder, array('ID' => 'ru',"ACTIVE" => "Y"));
	if ($arLang = $rsLangs->Fetch())
	{
		$boolRus = true;
	}

	if ($boolRus)
	{
		$arTemplateParameters['DETAIL_VK_USE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_VK_USE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
			'REFRESH' => 'Y'
		);

		if (isset($arCurrentValues['DETAIL_VK_USE']) && 'Y' == $arCurrentValues['DETAIL_VK_USE'])
		{
			$arTemplateParameters['DETAIL_VK_API_ID'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_VK_API_ID'),
				'TYPE' => 'STRING',
				'DEFAULT' => 'API_ID'
			);
		}
	}

	$arTemplateParameters['DETAIL_FB_USE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_FB_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);

	if (isset($arCurrentValues['DETAIL_FB_USE']) && 'Y' == $arCurrentValues['DETAIL_FB_USE'])
	{
		$arTemplateParameters['DETAIL_FB_APP_ID'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_FB_APP_ID'),
			'TYPE' => 'STRING',
			'DEFAULT' => ''
		);
	}
}

if (ModuleManager::isModuleInstalled("highloadblock"))
{
	$arTemplateParameters['DETAIL_BRAND_USE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('CP_BC_TPL_DETAIL_BRAND_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);

	if (isset($arCurrentValues['DETAIL_BRAND_USE']) && 'Y' == $arCurrentValues['DETAIL_BRAND_USE'])
	{
		$arTemplateParameters['DETAIL_BRAND_PROP_CODE'] = array(
			'PARENT' => 'VISUAL',
			"NAME" => Loc::getMessage("CP_BC_TPL_DETAIL_PROP_CODE"),
			"TYPE" => "LIST",
			"VALUES" => $arHighloadPropList,
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y"
		);
	}
}

if (ModuleManager::isModuleInstalled("sale"))
{
	$arTemplateParameters['USE_SALE_BESTSELLERS'] = array(
		'NAME' => Loc::getMessage('CP_BC_TPL_USE_SALE_BESTSELLERS'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y'
	);

	$arTemplateParameters['USE_BIG_DATA'] = array(
		'PARENT' => 'BIG_DATA_SETTINGS',
		'NAME' => Loc::getMessage('CP_BC_TPL_USE_BIG_DATA'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);
	if (!isset($arCurrentValues['USE_BIG_DATA']) || $arCurrentValues['USE_BIG_DATA'] == 'Y')
	{
		$rcmTypeList = array(
			'bestsell' => Loc::getMessage('CP_BC_TPL_RCM_BESTSELLERS'),
			'personal' => Loc::getMessage('CP_BC_TPL_RCM_PERSONAL'),
			'similar_sell' => Loc::getMessage('CP_BC_TPL_RCM_SOLD_WITH'),
			'similar_view' => Loc::getMessage('CP_BC_TPL_RCM_VIEWED_WITH'),
			'similar' => Loc::getMessage('CP_BC_TPL_RCM_SIMILAR'),
			'any_similar' => Loc::getMessage('CP_BC_TPL_RCM_SIMILAR_ANY'),
			'any_personal' => Loc::getMessage('CP_BC_TPL_RCM_PERSONAL_WBEST'),
			'any' => Loc::getMessage('CP_BC_TPL_RCM_RAND')
		);
		$arTemplateParameters['BIG_DATA_RCM_TYPE'] = array(
			'PARENT' => 'BIG_DATA_SETTINGS',
			'NAME' => Loc::getMessage('CP_BC_TPL_BIG_DATA_RCM_TYPE'),
			'TYPE' => 'LIST',
			'VALUES' => $rcmTypeList
		);
		unset($rcmTypeList);
	}
}

if (isset($arCurrentValues['SHOW_TOP_ELEMENTS']) && 'Y' == $arCurrentValues['SHOW_TOP_ELEMENTS'])
{
	$arTopViewModeList = array(
		'BANNER' => Loc::getMessage('CPT_BC_TPL_VIEW_MODE_BANNER'),
		'SLIDER' => Loc::getMessage('CPT_BC_TPL_VIEW_MODE_SLIDER'),
		'SECTION' => Loc::getMessage('CPT_BC_TPL_VIEW_MODE_SECTION')
	);
	$arTemplateParameters['TOP_VIEW_MODE'] = array(
		'PARENT' => 'TOP_SETTINGS',
		'NAME' => Loc::getMessage('CPT_BC_TPL_TOP_VIEW_MODE'),
		'TYPE' => 'LIST',
		'VALUES' => $arTopViewModeList,
		'MULTIPLE' => 'N',
		'DEFAULT' => 'SECTION',
		'REFRESH' => 'Y'
	);
	if (isset($arCurrentValues['TOP_VIEW_MODE']) && ('SLIDER' == $arCurrentValues['TOP_VIEW_MODE'] || 'BANNER' == $arCurrentValues['TOP_VIEW_MODE']))
	{
		$arTemplateParameters['TOP_ROTATE_TIMER'] = array(
			'PARENT' => 'TOP_SETTINGS',
			'NAME' => Loc::getMessage('CPT_BC_TPL_TOP_ROTATE_TIMER'),
			'TYPE' => 'STRING',
			'DEFAULT' => '30'
		);
	}
}

if (isset($arCurrentValues['USE_COMPARE']) && $arCurrentValues['USE_COMPARE'] == 'Y')
{
	$arTemplateParameters['COMPARE_POSITION_FIXED'] = array(
		'PARENT' => 'COMPARE_SETTINGS',
		'NAME' => Loc::getMessage('CPT_BC_TPL_COMPARE_POSITION_FIXED'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);
	if (!isset($arCurrentValues['COMPARE_POSITION_FIXED']) || $arCurrentValues['COMPARE_POSITION_FIXED'] == 'Y')
	{
		$positionList = array(
			'top left' => Loc::getMessage('CPT_BC_TPL_PARAM_COMPARE_POSITION_TOP_LEFT'),
			'top right' => Loc::getMessage('CPT_BC_TPL_PARAM_COMPARE_POSITION_TOP_RIGHT'),
			'bottom left' => Loc::getMessage('CPT_BC_TPL_PARAM_COMPARE_POSITION_BOTTOM_LEFT'),
			'bottom right' => Loc::getMessage('CPT_BC_TPL_PARAM_COMPARE_POSITION_BOTTOM_RIGHT')
		);
		$arTemplateParameters['COMPARE_POSITION'] = array(
			'PARENT' => 'COMPARE_SETTINGS',
			'NAME' => Loc::getMessage('CPT_BC_TPL_COMPARE_POSITION'),
			'TYPE' => 'LIST',
			'VALUES' => $positionList,
			'DEFAULT' => 'top left'
		);
		unset($positionList);
	}
}

$arTemplateParameters['SIDEBAR_SECTION_SHOW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('CPT_SIDEBAR_SECTION_SHOW'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'SORT' => 800
);
$arTemplateParameters['SIDEBAR_DETAIL_SHOW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('CPT_SIDEBAR_DETAIL_SHOW'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'SORT' => 800
);
$arTemplateParameters['SIDEBAR_PATH'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('CPT_SIDEBAR_PATH'),
	'TYPE' => 'STRING',
	'SORT' => 800
);

$arTemplateParameters['LINK_TO_AJAX'] = array(
	'NAME' => Loc::getMessage('CP_BCS_TPL_LINK_TO_AJAX'),
	'TYPE' => 'STRING',
	'DEFAULT' => SITE_DIR . "ajax/catalog.php",
);
$arAJAXType = array(
	'ZAKAZ' => Loc::getMessage('CP_BCE_TPL_AJAX_TYPE_ZAKAZ'),
	'ZABRON' => Loc::getMessage('CP_BCE_TPL_AJAX_TYPE_ZABRON'),
);
$arTemplateParameters['AJAX_TYPE'] = array(
	'NAME' => Loc::getMessage('CP_BCS_TPL_AJAX_TYPE'),
	'TYPE' => 'LIST',
	"VALUES" => $arAJAXType,
	'DEFAULT' => "ZAKAZ",
);


$arTemplateParameters["SECTION_USE_IMAGE_RESIZE"] = array(
		"NAME" => Loc::getMessage("MD_CAT_SEC_USE_IMAGE_RESIZE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
		"PARENT" => "LIST_SETTINGS",
);

if (isset($arCurrentValues['SECTION_USE_IMAGE_RESIZE']) && $arCurrentValues['SECTION_USE_IMAGE_RESIZE'] == 'Y')
{
	$arTemplateParameters["SECTION_IMAGE_RESIZE_WIDTH"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => Loc::getMessage("MD_CAT_SEC_IMAGE_RESIZE_WIDTH"),
		"TYPE" => "STRING",
		"DEFAULT" => "360",
	);
	$arTemplateParameters["SECTION_IMAGE_RESIZE_HEIGHT"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => Loc::getMessage("MD_CAT_SEC_IMAGE_RESIZE_HEIGHT"),
		"TYPE" => "STRING",
		"DEFAULT" => "360",
	);
	$arItemSizes = array(
		BX_RESIZE_IMAGE_PROPORTIONAL => Loc::getMessage("MD_CAT_SEC_IMAGE_RESIZE_TYPE_PROPORTIONAL"),
		BX_RESIZE_IMAGE_EXACT => Loc::getMessage("MD_CAT_SEC_IMAGE_RESIZE_TYPE_EXACT"),
	);
	$arTemplateParameters["SECTION_IMAGE_RESIZE_TYPE"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => Loc::getMessage("MD_CAT_SEC_IMAGE_RESIZE_TYPE"),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"ADDITIONAL_VALUES" => "N",
		"REFRESH" => "N",
		"DEFAULT" => BX_RESIZE_IMAGE_PROPORTIONAL,
		"VALUES" => $arItemSizes
	);
}

$arTemplateParameters['SHOW_ADDITIONAL_PANEL'] = array(
	'NAME' => Loc::getMessage('CP_BCS_TPL_SHOW_ADDITIONAL_PANEL'),
	'TYPE' => 'CHECKBOX',
	'PARENT' => "LIST_SETTINGS",
	"REFRESH" => "Y",
	'DEFAULT' => 'N'
);

if (isset($arCurrentValues['SHOW_ADDITIONAL_PANEL']) && $arCurrentValues['SHOW_ADDITIONAL_PANEL'] == 'Y')
{
	$arItemSizes = array(
		'table' => Loc::getMessage("MD_CAT_SEC_ADDITIONAL_PANEL_TABLE"),
		'list' => Loc::getMessage("MD_CAT_SEC_ADDITIONAL_PANEL_LIST"),
		'grid' => Loc::getMessage("MD_CAT_SEC_ADDITIONAL_PANEL_GRID"),
	);
	$arTemplateParameters["SECTION_DEFAULT_VIEW"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => Loc::getMessage("MD_CAT_SEC_ADDITIONAL_PANEL_VIEW"),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"ADDITIONAL_VALUES" => "N",
		"REFRESH" => "N",
		"DEFAULT" => BX_RESIZE_IMAGE_PROPORTIONAL,
		"VALUES" => $arItemSizes
	);
}

$arTemplateParameters["SECTION_HIDE_ICONLIST"] = array(
		"NAME" => GetMessage("CP_BCS_TPL_SECTION_HIDE_ICONLIST"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"Y",
		"PARENT" => "LIST_SETTINGS",
);
$arTemplateParameters["SECTION_HIDE_PREVIEW_TEXT"] = array(
		"NAME" => GetMessage("CP_BCS_TPL_SECTION_HIDE_PREVIEW_TEXT"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"Y",
		"PARENT" => "LIST_SETTINGS",
);

?>