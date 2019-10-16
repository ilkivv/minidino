<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
$arParams['USE_PRODUCT_QUANTITY'] = "N";

if (!empty($arResult['ITEMS']))
{
	$arSkuTemplate = array();
	if (!empty($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as &$arProp)
		{
			$templateRow = '';
			if ('TEXT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_size full';
					$strWidth = ($arProp['VALUES_COUNT']*20).'%';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_size';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				$templateRow .= '<div class="'.$strClass.'" id="#ITEM#_prop_'.$arProp['ID'].'_cont">
<span class="bx_item_section_name_gray">'.htmlspecialcharsex($arProp['NAME']).'</span>
<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list" style="width: '.$strWidth.';">';
				foreach ($arProp['VALUES'] as $arOneValue)
				{
					$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
					$templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-onevalue="'.$arOneValue['ID'].'" style="width: '.$strOneWidth.';" title="'.$arOneValue['NAME'].'"><i></i><span class="cnt">'.$arOneValue['NAME'].'</span></li>';
				}
				$templateRow .= '</ul></div>
<div class="bx_slide_left" id="#ITEM#_prop_'.$arProp['ID'].'_left" data-treevalue="'.$arProp['ID'].'" style="'.$strSlideStyle.'"></div>
<div class="bx_slide_right" id="#ITEM#_prop_'.$arProp['ID'].'_right" data-treevalue="'.$arProp['ID'].'" style="'.$strSlideStyle.'"></div>
	</div>
</div>';
			}
			elseif ('PICT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_scu full';
					$strWidth = ($arProp['VALUES_COUNT']*20).'%';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_scu';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				
				$templateRow .= '<div class="'.$strClass.'" id="#ITEM#_prop_'.$arProp['ID'].'_cont">
<span class="bx_item_section_name_gray">'.htmlspecialcharsex($arProp['NAME']).'</span>
<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list" style="width: '.$strWidth.';">';
				foreach ($arProp['VALUES'] as $arOneValue)
				{
					$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
					$templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-onevalue="'.$arOneValue['ID'].'" style="width: '.$strOneWidth.'; padding-top: '.$strOneWidth.';"><i title="'.$arOneValue['NAME'].'"></i>
<span class="cnt"><span class="cnt_item" style="background-image:url(\''.$arOneValue['PICT']['SRC'].'\');" title="'.$arOneValue['NAME'].'"></span></span></li>';
				}
				$templateRow .= '</ul></div>
<div class="bx_slide_left" id="#ITEM#_prop_'.$arProp['ID'].'_left" data-treevalue="'.$arProp['ID'].'" style="'.$strSlideStyle.'"></div>
<div class="bx_slide_right" id="#ITEM#_prop_'.$arProp['ID'].'_right" data-treevalue="'.$arProp['ID'].'" style="'.$strSlideStyle.'"></div>
	</div>
</div>';
			}
			$arSkuTemplate[$arProp['CODE']] = $templateRow;
		}
		unset($templateRow, $arProp);
	}

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM'));

	$strFullPath = $_SERVER['DOCUMENT_ROOT'].$this->GetFolder();
	$templateLibrary = array('popup');
	$currencyList = '';
	if (!empty($arResult['CURRENCIES']))
	{
		$templateLibrary[] = 'currency';
		$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
	}
	$templateData = array(
		'TEMPLATE_LIBRARY' => $templateLibrary,
		'CURRENCIES' => $currencyList
	);
	unset($currencyList, $templateLibrary);

	$uniqId = "shop-" . $this->randString();
	
?>
	<h2 class="title--main"><?=$arResult['ITEMS'][0]['PROPERTIES']['LABEL_ITEM']['VALUE'][0]?></h2>
					
	<div class="clearfix"></div>
	<div id="<?=$uniqId?>" class=" grid-container shop clearfix bx_catalog_top_home product-<?=$arParams["LINE_ELEMENT_COUNT"]?>" data-layout="fitRows">
	
<?
$prevValueXmlId = false;
foreach ($arResult['ITEMS'] as $key => $arItem)
{
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
	$strMainID = $this->GetEditAreaId($arItem['ID']);

	$arItemIDs = array(
		'ID' => $strMainID,
		'PICT' => $strMainID.'_pict',
		'SECOND_PICT' => $strMainID.'_secondpict',
		'MAIN_PROPS' => $strMainID.'_main_props',

		'QUANTITY' => $strMainID.'_quantity',
		'QUANTITY_DOWN' => $strMainID.'_quant_down',
		'QUANTITY_UP' => $strMainID.'_quant_up',
		'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
		'BUY_LINK' => $strMainID.'_buy_link',
		'BASKET_ACTIONS' => $strMainID.'_basket_actions',
		'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
		'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
		'COMPARE_LINK' => $strMainID.'_compare_link',

		'PRICE' => $strMainID.'_price',
		'DSC_PERC' => $strMainID.'_dsc_perc',
		'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',

		'PROP_DIV' => $strMainID.'_sku_tree',
		'PROP' => $strMainID.'_prop_',
		'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
		'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
		'STICKER_ID' => $strMainID.'_stiker_label',
	);

	$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
	$productTitle = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
		: $arItem['NAME']
	);
	$imgTitle = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
		: $arItem['NAME']
	);

	$imgAlt = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']
		: $arItem['NAME']
	);

	$minPrice = false;
	if (isset($arItem['MIN_PRICE']) || isset($arItem['RATIO_PRICE']))
		$minPrice = (isset($arItem['RATIO_PRICE']) ? $arItem['RATIO_PRICE'] : $arItem['MIN_PRICE']);


	$curValueXmlId = $arItem["PROPERTIES"]["LABEL_ITEM"]["VALUE_XML_ID"];
	if (isset($arResult["UL_TABS"][0]["XML_ID"])) {
		if (!is_array($curValueXmlId) || count($curValueXmlId) < 1) {
			continue;
		}
	}
	$curItemClass = implode(' product-item-', $curValueXmlId);
if ($current != implode('',$curValueXmlId)) {
	?>
		</div>

		<?foreach ($arResult["UL_TABS"] as $arKeyTab => $arUlTab) :?>
		<?if ($arUlTab['XML_ID'] == $current){?>
					<h2 class="title--main"><?=$arUlTab["VALUE"]?></h2>
					<?}?>
				<?endforeach;?>
			<div class="clearfix"></div>
			<div id="<?=$uniqId?>" class=" grid-container shop clearfix bx_catalog_top_home product-<?=$arParams["LINE_ELEMENT_COUNT"]?>" data-layout="fitRows">
	<?
}
	$current = implode('',$curValueXmlId);

?>

	<div class="product clearfix product-item-<?=$curItemClass?>" id="<? echo $strMainID; ?>">

		<div class="product-image">
			<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $imgTitle; ?>">
				<img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<? echo $imgAlt; ?>">
			</a>

	<?
		if ($arItem['SECOND_PICT'])
		{
	?>
			<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $imgTitle; ?>">
				<img id="<? echo $arItemIDs['SECOND_PICT']; ?>" src="<? echo (
					!empty($arItem['PREVIEW_PICTURE_SECOND'])
					? $arItem['PREVIEW_PICTURE_SECOND']['SRC']
					: $arItem['PREVIEW_PICTURE']['SRC']
				); ?>" alt="<? echo $imgAlt; ?>">
			</a>
	<?
		}
	?>
			<?
			if ($arItem['LABEL'])
			{
				$styleTopForDiscount = 'top:45px; ';
				?>
				<div id="<? echo $arItemIDs['STICKER_ID']; ?>" class="sale-flash" title="<? echo $arItem['LABEL_VALUE']; ?>"><? echo $arItem['LABEL_VALUE']; ?></div>
				<?
			}
			if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
			{
				?>
				<div id="<? echo $arItemIDs['DSC_PERC']; ?>" class="sale-flash" style="<?=$styleTopForDiscount?>display:<? echo (0 < $minPrice['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">-<? echo $minPrice['DISCOUNT_DIFF_PERCENT']; ?>%</div>
				<?
			}
			unset($styleTopForDiscount);
			?>

			<div class="product-overlay">





<?
	$showSubscribeBtn = false;
	$compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCT_TPL_MESS_BTN_COMPARE'));
	if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
	{
		if ($arItem['CAN_BUY'])
		{
			if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
			{
			?>
			<div class="bx_catalog_item_controls_blockone"><div style="display: inline-block;position: relative;">
				<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
					<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
				<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
				<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
			</div></div>
<?
			}
?>

			<div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="bx_catalog_item_controls_blocktwo">
				<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="add-to-cart" href="javascript:void(0)" rel="nofollow">
				<i class="icon-shopping-cart"></i>
<?
			if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY')
			{
				echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCT_TPL_MESS_BTN_BUY'));
			}
			else
			{
				echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCT_TPL_MESS_BTN_ADD_TO_BASKET'));
			}
?>
				</a>
			</div>
<?
			if ($arParams['DISPLAY_COMPARE'])
			{
?>
				<div class="bx_catalog_item_controls_blocktwo">
					<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="item-quick-view" href="javascript:void(0)"><i class="icon-line-bar-graph-2"></i> <? echo $compareBtnMessage; ?></a>
				</div>
<?
			}
		}
		else
		{
?>
			<div id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone"><span class="bx_notavailable">
<?
			echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCT_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
?>
			</span></div>
<?
			if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn)
			{
				?>
				<div class="bx_catalog_item_controls_blocktwo"><?
				if ($arParams['DISPLAY_COMPARE'])
				{
					?><a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><? echo $compareBtnMessage; ?></a><?
				}
				if ($showSubscribeBtn)
				{
					?>
					<a id="<? echo $arItemIDs['SUBSCRIBE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><?
					echo ('' != $arParams['MESS_BTN_SUBSCRIBE'] ? $arParams['MESS_BTN_SUBSCRIBE'] : GetMessage('CT_BCT_TPL_MESS_BTN_SUBSCRIBE'));
					?></a><?
				}
				?>
				</div><?
			}
		}
?>

<?
		$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
		if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
		{
?>
		<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
			<?
			if (!empty($arItem['PRODUCT_PROPERTIES_FILL']))
			{
				foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
				{
					?>
					<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>"><?
					if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
						unset($arItem['PRODUCT_PROPERTIES'][$propID]);
				}
			}
			$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties)
			{
				?>
				<table>
					<?
					foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo)
					{
						?>
						<tr><td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
							<td>
								<?
								if(
									'L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']
									&& 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']
								)
								{
									foreach($propInfo['VALUES'] as $valueID => $value)
									{
										?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
									}
								}
								else
								{
									?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
									foreach($propInfo['VALUES'] as $valueID => $value)
									{
										?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
									}
									?></select><?
								}
								?>
							</td></tr>
					<?
					}
					?>
				</table>
			<?
			}
			?>
		</div>
	<?
	}
		$arJSParams = array(
			'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
			'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
			'SHOW_ADD_BASKET_BTN' => false,
			'SHOW_BUY_BTN' => true,
			'SHOW_ABSENT' => true,
			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'PRODUCT' => array(
				'ID' => $arItem['ID'],
				'NAME' => $productTitle,
				'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
				'CAN_BUY' => $arItem["CAN_BUY"],
				'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
				'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
				'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
				'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
				'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
				'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL'],
				'BASIS_PRICE' => $arItem['MIN_BASIS_PRICE']
			),
			'VISUAL' => array(
				'ID' => $arItemIDs['ID'],
				'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
				'QUANTITY_ID' => $arItemIDs['QUANTITY'],
				'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
				'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
				'PRICE_ID' => $arItemIDs['PRICE'],
				'BUY_ID' => $arItemIDs['BUY_LINK'],
				'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV'],
				'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
				'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
				'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
			),
			'BASKET' => array(
				'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
				'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
				'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
				'EMPTY_PROPS' => $emptyProductProperties,
				'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
				'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
			),
			'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
		);
		if ($arParams['DISPLAY_COMPARE'])
		{
			$arJSParams['COMPARE'] = array(
				'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
				'COMPARE_PATH' => $arParams['COMPARE_PATH']
			);
		}
		?><script type="text/javascript">
		var <? echo $strObName; ?> = new JCCatalogTopSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
		</script><?
	}
	else
	{

		if ('Y' == $arParams['PRODUCT_DISPLAY_MODE'])
		{
			if (!empty($arItem['OFFERS_PROP']))
			{
				$arSkuProps = array();
				?><div class="bx_catalog_item_scu" id="<? echo $arItemIDs['PROP_DIV']; ?>"><?
				foreach ($arSkuTemplate as $code => $strTemplate)
				{
					if (!isset($arItem['OFFERS_PROP'][$code]))
						continue;
					echo '<div>', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
				}
				foreach ($arResult['SKU_PROPS'] as $arOneProp)
				{
					if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
						continue;
					$arSkuProps[] = array(
						'ID' => $arOneProp['ID'],
						'SHOW_MODE' => $arOneProp['SHOW_MODE'],
						'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
					);
				}
				foreach ($arItem['JS_OFFERS'] as &$arOneJs)
				{
					if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
					{
						$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
						$arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
					}
				}
				unset($arOneJs);
				?></div><?
				if ($arItem['OFFERS_PROPS_DISPLAY'])
				{
					foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer)
					{
						$strProps = '';
						if (!empty($arJSOffer['DISPLAY_PROPERTIES']))
						{
							foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp)
							{
								$strProps .= '<br>'.$arOneProp['NAME'].' <strong>'.(
									is_array($arOneProp['VALUE'])
									? implode(' / ', $arOneProp['VALUE'])
									: $arOneProp['VALUE']
								).'</strong>';
							}
						}
						$arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
					}
				}
				$arJSParams = array(
					'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
					'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
					'SHOW_ADD_BASKET_BTN' => false,
					'SHOW_BUY_BTN' => true,
					'SHOW_ABSENT' => true,
					'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
					'SECOND_PICT' => $arItem['SECOND_PICT'],
					'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
					'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
					'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
					'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
					'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
					'DEFAULT_PICTURE' => array(
						'PICTURE' => $arItem['PRODUCT_PREVIEW'],
						'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
					),
					'VISUAL' => array(
						'ID' => $arItemIDs['ID'],
						'PICT_ID' => $arItemIDs['PICT'],
						'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
						'QUANTITY_ID' => $arItemIDs['QUANTITY'],
						'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
						'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
						'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
						'PRICE_ID' => $arItemIDs['PRICE'],
						'TREE_ID' => $arItemIDs['PROP_DIV'],
						'TREE_ITEM_ID' => $arItemIDs['PROP'],
						'BUY_ID' => $arItemIDs['BUY_LINK'],
						'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
						'DSC_PERC' => $arItemIDs['DSC_PERC'],
						'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
						'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
						'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
						'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
						'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
					),
					'BASKET' => array(
						'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
						'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
						'SKU_PROPS' => $arItem['OFFERS_PROP_CODES'],
						'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
						'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
					),
					'PRODUCT' => array(
						'ID' => $arItem['ID'],
						'NAME' => $productTitle
					),
					'OFFERS' => $arItem['JS_OFFERS'],
					'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
					'TREE_PROPS' => $arSkuProps,
					'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
				);
			if ($arParams['DISPLAY_COMPARE'])
			{
				$arJSParams['COMPARE'] = array(
					'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
					'COMPARE_PATH' => $arParams['COMPARE_PATH']
				);
			}
				?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogTopSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>
				<?
			}
		}
		else
		{
			$arJSParams = array(
				'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
				'SHOW_QUANTITY' => false,
				'SHOW_ADD_BASKET_BTN' => false,
				'SHOW_BUY_BTN' => false,
				'SHOW_ABSENT' => false,
				'SHOW_SKU_PROPS' => false,
				'SECOND_PICT' => $arItem['SECOND_PICT'],
				'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
				'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
				'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
				'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
				'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
				'DEFAULT_PICTURE' => array(
					'PICTURE' => $arItem['PRODUCT_PREVIEW'],
					'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
				),
				'VISUAL' => array(
					'ID' => $arItemIDs['ID'],
					'PICT_ID' => $arItemIDs['PICT'],
					'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
					'QUANTITY_ID' => $arItemIDs['QUANTITY'],
					'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
					'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
					'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
					'PRICE_ID' => $arItemIDs['PRICE'],
					'TREE_ID' => $arItemIDs['PROP_DIV'],
					'TREE_ITEM_ID' => $arItemIDs['PROP'],
					'BUY_ID' => $arItemIDs['BUY_LINK'],
					'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
					'DSC_PERC' => $arItemIDs['DSC_PERC'],
					'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
					'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
					'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
					'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
					'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
				),
				'BASKET' => array(
					'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
					'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
					'SKU_PROPS' => $arItem['OFFERS_PROP_CODES'],
					'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
					'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
				),
				'PRODUCT' => array(
					'ID' => $arItem['ID'],
					'NAME' => $productTitle
				),
				'OFFERS' => array(),
				'OFFER_SELECTED' => 0,
				'TREE_PROPS' => array(),
				'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
			);
			if ($arParams['DISPLAY_COMPARE'])
			{
				$arJSParams['COMPARE'] = array(
					'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
					'COMPARE_PATH' => $arParams['COMPARE_PATH']
				);
			}
?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogTopSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>
<?
		}

		if ('Y' == $arParams['PRODUCT_DISPLAY_MODE'])
		{
			$canBuy = $arItem['JS_OFFERS'][$arItem['OFFERS_SELECTED']]['CAN_BUY'];
			
			if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
			{
			?>
				<div class="bx_catalog_item_controls_blockone">
					<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
					<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
					<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
					<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"></span>
				</div>
			<?
			}
			?>
		<div id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone" style="display: <? echo ($canBuy ? 'none' : ''); ?>;"><span class="bx_notavailable">
<?
			echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCT_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
?>
		</span></div>
		<div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="bx_catalog_item_controls_blocktwo" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
			<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="add-to-cart" href="javascript:void(0)" rel="nofollow"><i class="icon-shopping-cart"></i> <?
			if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY')
			{
				echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCT_TPL_MESS_BTN_BUY'));
			}
			else
			{
				echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCT_TPL_MESS_BTN_ADD_TO_BASKET'));
			}
			?></a>
		</div>
			<?
			if ($arParams['DISPLAY_COMPARE'])
			{
				?>
				<div class="bx_catalog_item_controls_blocktwo">
				<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="item-quick-view" href="javascript:void(0)"><i class="icon-line-bar-graph-2"></i> <? echo $compareBtnMessage; ?></a>
				</div><?
			}
			?>
			<?
			unset($canBuy);
		}
		else
		{
			?>
		<div class="bx_catalog_item_controls no_touch">
			<a class="bx_bt_button_type_2 bx_medium" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?
			echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CT_BCT_TPL_MESS_BTN_DETAIL'));
			?></a>
		</div>
			<?
		}
		?>
			<?
			if (!$arParams['DISPLAY_COMPARE'])
			{?>
					<a class="item-quick-view" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><i class="icon-zoom2"></i> <?
					echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CT_BCT_TPL_MESS_BTN_DETAIL'));
					?></a>
			<?
			}
			?>
		<?
	}
?>


			</div>
		</div>

		<div class="product-desc">
			<div class="product-title">
				<h3><a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $productTitle; ?>"><? echo $productTitle; ?></a></h3>
			</div>
			<div id="<? echo $arItemIDs['PRICE']; ?>" class="product-price">
<?
	if (!empty($minPrice))
	{
		echo "<ins>";
		if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
		{
			echo GetMessage(
				'CT_BCT_TPL_MESS_PRICE_SIMPLE_MODE',
				array(
					'#PRICE#' => $minPrice['PRINT_DISCOUNT_VALUE'],
					'#MEASURE#' => GetMessage(
						'CT_BCT_TPL_MESS_MEASURE_SIMPLE_MODE',
						array(
							'#VALUE#' => $minPrice['CATALOG_MEASURE_RATIO'],
							'#UNIT#' => $minPrice['CATALOG_MEASURE_NAME']
						)
					)
				)
			);
		}
		else
		{
			echo $minPrice['PRINT_DISCOUNT_VALUE'];
		}
		echo "</ins>";
		if ('Y' == $arParams['SHOW_OLD_PRICE'] && $minPrice['DISCOUNT_VALUE'] < $minPrice['VALUE'])
		{
			?> <del><? echo $minPrice['PRINT_VALUE']; ?></del><?
		}
	}
	unset($minPrice);
?>
			</div>
			<?

				if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
				{
			
						if (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']))
						{
				?>
							<ul class="iconlist">
				<?
							foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp)
							{
								?><li><i class="icon-caret-right"></i><strong><? echo $arOneProp['NAME']; ?>:</strong> <?
									echo (
										is_array($arOneProp['DISPLAY_VALUE'])
										? implode(', ', $arOneProp['DISPLAY_VALUE'])
										: $arOneProp['DISPLAY_VALUE']
									);
									echo "</li>";
							}
				?>
							</ul>
				<?
						}
			
				} else {

					$boolShowOfferProps = ('Y' == $arParams['PRODUCT_DISPLAY_MODE'] && $arItem['OFFERS_PROPS_DISPLAY']);
					$boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));
					if ($boolShowProductProps || $boolShowOfferProps)
					{
			?>
						<ul class="iconlist">
			<?
						if ($boolShowProductProps)
						{
							foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp)
							{
							?><li><i class="icon-caret-right"></i><strong><? echo $arOneProp['NAME']; ?>:</strong> <?
								echo (
									is_array($arOneProp['DISPLAY_VALUE'])
									? implode(' / ', $arOneProp['DISPLAY_VALUE'])
									: $arOneProp['DISPLAY_VALUE']
								);
								echo "</li>";
							}
						}
						if ($boolShowOfferProps)
						{
			?>
							<span id="<? echo $arItemIDs['DISPLAY_PROP_DIV']; ?>" style="display: none;"></span>
			<?
						}
			?>
						</ul>
			<?
					}
			?>
			<?
				}
			?>

		</div>

</div>
<?
}
?>




</div>


<script type="text/javascript">
BX.message({
	MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCT_TPL_MESS_BTN_BUY')); ?>',
	MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCT_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
	MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCT_TPL_MESS_PRODUCT_NOT_AVAILABLE')); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCT_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
	BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
	ADD_TO_BASKET_OK: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCT_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCT_CATALOG_TITLE_BASKET_PROPS') ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCT_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CT_BCT_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCT_CATALOG_BTN_MESSAGE_CLOSE') ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCT_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCT_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCT_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCT_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCT_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>
<?
}
?>