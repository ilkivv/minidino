<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$frame = $this->createFrame()->begin("");

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

$injectId = 'bigdata_recommeded_products_'.rand();

?>

	<script type="text/javascript">
		BX.cookie_prefix = '<?=CUtil::JSEscape(COption::GetOptionString("main", "cookie_name", "BITRIX_SM"))?>';
		BX.cookie_domain = '<?=$APPLICATION->GetCookieDomain()?>';
		BX.current_server_time = '<?=time()?>';

		BX.ready(function(){
			bx_rcm_recommendation_event_attaching(BX('<?=$injectId?>_items'));
		});

	</script>

<?

if (isset($arResult['REQUEST_ITEMS']))
{
	CJSCore::Init(array('ajax'));

	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedParameters = $signer->sign(
		base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
		'bx.bd.products.recommendation'
	);
	$signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

	?>

	<span id="<?=$injectId?>" class="bigdata_recommended_products_container"></span>

	<script type="text/javascript">
		BX.ready(function(){
			bx_rcm_get_from_cloud(
				'<?=CUtil::JSEscape($injectId)?>',
				<?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
				{
					'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
					'template': '<?=CUtil::JSEscape($signedTemplate)?>',
					'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
					'rcm': 'yes'
				}
			);
		});
	</script>

	<?
	$frame->end();
	return;
}


if (!empty($arResult['ITEMS']))
{
	?><script type="text/javascript">
	BX.message({
		CBD_MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CVP_TPL_MESS_BTN_BUY')); ?>',
		CBD_MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CVP_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',

		CBD_MESS_BTN_DETAIL: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',

		CBD_MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
		CBD_BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
		BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
		CBD_ADD_TO_BASKET_OK: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_TITLE_ERROR: '<? echo GetMessageJS('CVP_CATALOG_TITLE_ERROR') ?>',
		CBD_TITLE_BASKET_PROPS: '<? echo GetMessageJS('CVP_CATALOG_TITLE_BASKET_PROPS') ?>',
		CBD_TITLE_SUCCESSFUL: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CVP_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		CBD_BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
		CBD_BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_CLOSE') ?>'
	});
</script>

	<?php /*?><h3><? echo GetMessage('CVP_TPL_MESS_RCM') ?></h3>*/?>


	<span id="<?=$injectId?>_items" class="bigdata_recommended_products_items">
	<input type="hidden" name="bigdata_recommendation_id" value="<?=htmlspecialcharsbx($arResult['RID'])?>">
		<?

		$arSkuTemplate = array();
		if(is_array($arResult['SKU_PROPS']))
		{
			foreach ($arResult['SKU_PROPS'] as $iblockId => $skuProps)
			{
				$arSkuTemplate[$iblockId] = array();
				foreach ($skuProps as &$arProp)
				{
					ob_start();
					if ('TEXT' == $arProp['SHOW_MODE'])
					{
						if (5 < $arProp['VALUES_COUNT'])
						{
							$strClass = 'bx_item_detail_size full';
							$strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
							$strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
							$strSlideStyle = '';
						}
						else
						{
							$strClass = 'bx_item_detail_size';
							$strWidth = '100%';
							$strOneWidth = '20%';
							$strSlideStyle = 'display: none;';
						}
						?>
					<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
						<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

					<div class="bx_size_scroller_container">
						<div class="bx_size">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
								foreach ($arProp['VALUES'] as $arOneValue)
								{
									?>
								<li
									data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID']; ?>"
									data-onevalue="<? echo $arOneValue['ID']; ?>"
									style="width: <? echo $strOneWidth; ?>;"
								><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span>
									</li><?
								}
								?></ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
						</div><?
					}
					elseif ('PICT' == $arProp['SHOW_MODE'])
					{
						if (5 < $arProp['VALUES_COUNT'])
						{
							$strClass = 'bx_item_detail_scu full';
							$strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
							$strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
							$strSlideStyle = '';
						}
						else
						{
							$strClass = 'bx_item_detail_scu';
							$strWidth = '100%';
							$strOneWidth = '20%';
							$strSlideStyle = 'display: none;';
						}
						?>
					<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
						<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

					<div class="bx_scu_scroller_container">
						<div class="bx_scu">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
								foreach ($arProp['VALUES'] as $arOneValue)
								{
									?>
								<li
									data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID'] ?>"
									data-onevalue="<? echo $arOneValue['ID']; ?>"
									style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
								><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
							<span class="cnt"><span class="cnt_item"
													style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
													title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
								></span></span></li><?
								}
								?></ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
						</div><?
					}
					$arSkuTemplate[$iblockId][$arProp['CODE']] = ob_get_contents();
					ob_end_clean();
					unset($arProp);
				}
			}
		}

		?>
		<div class="bx_item_list_you_looked_horizontal shop col<? echo $arParams['LINE_ELEMENT_COUNT']; ?> <? echo $templateData['TEMPLATE_CLASS']; ?>">

			<div id="<?=$injectId?>-oc-product" class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xxs="1" data-items-sm="2" data-items-lg="4">

	<?

	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		$strMainID = $this->GetEditAreaId($arItem['ID'] . $key);

		$arItemIDs = array(
			'ID' => $strMainID,
			'PICT' => $strMainID . '_pict',
			'SECOND_PICT' => $strMainID . '_secondpict',
			'MAIN_PROPS' => $strMainID . '_main_props',

			'QUANTITY' => $strMainID . '_quantity',
			'QUANTITY_DOWN' => $strMainID . '_quant_down',
			'QUANTITY_UP' => $strMainID . '_quant_up',
			'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
			'BUY_LINK' => $strMainID . '_buy_link',
			'BASKET_ACTIONS' => $strMainID.'_basket_actions',
			'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
			'SUBSCRIBE_LINK' => $strMainID . '_subscribe',

			'PRICE' => $strMainID . '_price',
			'DSC_PERC' => $strMainID . '_dsc_perc',
			'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',

			'PROP_DIV' => $strMainID . '_sku_tree',
			'PROP' => $strMainID . '_prop_',
			'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
			'BASKET_PROP_DIV' => $strMainID . '_basket_prop'
		);

		$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

		$strTitle = (
		isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
			? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
			: $arItem['NAME']
		);
		$showImgClass = $arParams['SHOW_IMAGE'] != "Y" ? "no-imgs" : "";

		?>
		<div class="oc-item">
			<div class="product iproduct clearfix norightpadding" id="<? echo $strMainID; ?>">
				<div class="product-image">

					<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" data-product-id="<?=$arItem['ID']?>">
						<img id="<? echo $arItemIDs['PICT']; ?>" src="<?=$arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?=$strAlt?>">
					</a>

					<?
					if ($arItem['SECOND_PICT'])
					{
						?><a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
						<img id="<? echo $arItemIDs['SECOND_PICT']; ?>" src="<? echo(
						!empty($arItem['PREVIEW_PICTURE_SECOND'])
							? $arItem['PREVIEW_PICTURE_SECOND']['SRC']
							: $arItem['PREVIEW_PICTURE']['SRC']
						); ?>" alt="<?=$strAlt?>">
						</a><?
					}
					?>
					<?
					if ($arItem['LABEL'])
					{
						$styleTopForDiscount = 'top:45px; ';
						?>
						<div class="sale-flash"
							 title="<? echo $arItem['LABEL_VALUE']; ?>"><? echo $arItem['LABEL_VALUE']; ?></div>
						<?
					}
					if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
					{
						?>
						<div
							id="<? echo $arItemIDs['DSC_PERC']; ?>"
							class="sale-flash"
							style="<?=$styleTopForDiscount?>display:<? echo(0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">
					-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%
				</div>
						<?
					}
					unset($styleTopForDiscount);
					?>

					<div class="product-overlay">

		<?
			if (!empty($arItem['OFFERS']) && isset($arSkuTemplate[$arItem['IBLOCK_ID']]))
			{
			$arSkuProps = array();
			?>
		<div class="bx_catalog_item_scu" id="<? echo $arItemIDs['PROP_DIV']; ?>"><?
			foreach ($arSkuTemplate[$arItem['IBLOCK_ID']] as $code => $strTemplate)
			{
				if (!isset($arItem['OFFERS_PROP'][$code]))
					continue;
				echo '<div>', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
			}

			if (isset($arResult['SKU_PROPS'][$arItem['IBLOCK_ID']]))
			{
				foreach ($arResult['SKU_PROPS'][$arItem['IBLOCK_ID']] as $arOneProp)
				{
					if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
						continue;
					$arSkuProps[] = array(
						'ID' => $arOneProp['ID'],
						'SHOW_MODE' => $arOneProp['SHOW_MODE'],
						'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
					);
				}
			}
			foreach ($arItem['JS_OFFERS'] as &$arOneJs)
			{
				if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
					$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-' . $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] . '%';
			}

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
										$strProps .= '<br>' . $arOneProp['NAME'] . ' <strong>' . (
											is_array($arOneProp['VALUE'])
												? implode(' / ', $arOneProp['VALUE'])
												: $arOneProp['VALUE']
											) . '</strong>';
									}
								}
								$arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
							}
						}
						$arJSParams = array(
							'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
							'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
							'SHOW_ADD_BASKET_BTN' => false,
							'SHOW_BUY_BTN' => true,
							'SHOW_ABSENT' => true,
							'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
							'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
							'SECOND_PICT' => ($arParams['SHOW_IMAGE'] == "Y" ? $arItem['SECOND_PICT'] : false),
							'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
							'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
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
							),
							'BASKET' => array(
								'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
								'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE']
							),
							'PRODUCT' => array(
								'ID' => $arItem['ID'],
								'NAME' => $arItem['~NAME']
							),
							'OFFERS' => $arItem['JS_OFFERS'],
							'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
							'TREE_PROPS' => $arSkuProps,
							'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
						);
						?>
						<script type="text/javascript">
			var <? echo $strObName; ?> = new JCCatalogBigdataProducts(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
		</script>
						<?
						}?>



						<?
						if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) // Simple Product
						{
								if ($arItem['CAN_BUY'])
								{
									?>

									<a id="<? echo $arItemIDs['BUY_LINK']; ?>" href="javascript:void(0)" rel="nofollow" class="add-to-cart">
										<i class="icon-shopping-cart"></i><span> <?
											echo('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
											?></span>
									</a>
									<?
								}
								?>
									<a class="item-quick-view" data-product-id="<?=$arItem['ID']?>" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" rel="nofollow"><i class="icon-line-arrow-right"></i><span><?
									echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CVP_TPL_MESS_BTN_DETAIL'));
									?></span></a>
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
					<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
					<?
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
						<tr>
							<td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
							<td>
								<?
								if (
									'L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']
									&& 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']
								)
								{
									foreach ($propInfo['VALUES'] as $valueID => $value)
									{
										?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
									}
								}
								else
								{
									?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
									foreach ($propInfo['VALUES'] as $valueID => $value)
									{
										?>
										<option value="<? echo $valueID; ?>" <? echo($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
									}
									?></select><?
								}
								?>
							</td>
						</tr>
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
							'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
							'SHOW_ADD_BASKET_BTN' => false,
							'SHOW_BUY_BTN' => true,
							'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
							'SHOW_ABSENT' => true,
							'PRODUCT' => array(
								'ID' => $arItem['ID'],
								'NAME' => $arItem['~NAME'],
								'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
								'CAN_BUY' => $arItem["CAN_BUY"],
								'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
								'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
								'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
								'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
								'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
								'ADD_URL' => $arItem['~ADD_URL'],
								'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL']
							),
							'BASKET' => array(
								'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
								'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
								'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
								'EMPTY_PROPS' => $emptyProductProperties
							),
							'VISUAL' => array(
								'ID' => $arItemIDs['ID'],
								'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
								'QUANTITY_ID' => $arItemIDs['QUANTITY'],
								'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
								'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
								'PRICE_ID' => $arItemIDs['PRICE'],
								'BUY_ID' => $arItemIDs['BUY_LINK'],
								'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
							),
							'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
						);
						?>
		<script type="text/javascript">
			var <? echo $strObName; ?> = new JCCatalogBigdataProducts(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
		</script><?
						}
						else // Wth Sku
						{
						?>

							<a id="<? echo $arItemIDs['BUY_LINK']; ?>" href="javascript:void(0)" rel="nofollow" class="add-to-cart">
								<i class="icon-shopping-cart"></i><span> <?
								echo('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
								?></span>
							</a>

							<a class="item-quick-view" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" data-product-id="<?=$arItem['ID']?>"><i class="icon-line-arrow-right"></i><span><?
									echo('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CVP_TPL_MESS_BTN_DETAIL'));
									?></span></a>

							<?
							$boolShowOfferProps =  !!$arItem['OFFERS_PROPS_DISPLAY'];
							$boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));

						}
						?>
					</div>
				</div>


				<div class="product-desc">
					<? if ($arParams['SHOW_NAME'] == "Y")
					{
						?>
						<div class="product-title">
							<h3>
								<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" data-product-id="<?=$arItem['ID']?>" title="<? echo $arItem['NAME']; ?>">
									<? echo $arItem['NAME']; ?>
								</a>
							</h3>
						</div>
						<?
					}?>
					<div class="product-price" id="<? echo $arItemIDs['PRICE']; ?>">
						<?
						if (!empty($arItem['MIN_PRICE']))
						{
							if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
							{
								?> <del><? echo $arItem['MIN_PRICE']['PRINT_VALUE']; ?></del><?
							}
							echo "<ins>";
							if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
							{
								echo GetMessage(
									'CVP_TPL_MESS_PRICE_SIMPLE_MODE',
									array(
										'#PRICE#' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
										'#MEASURE#' => GetMessage(
											'CVP_TPL_MESS_MEASURE_SIMPLE_MODE',
											array(
												'#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
												'#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
											)
										)
									)
								);
							}
							else
							{
								echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
							}
							echo "</ins>";
						}
						?>
					</div>
				</div>
			</div></div><?
	}
	?>


	</div>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var ocProduct = $("#<?=$injectId?>-oc-product");
				ocProduct.owlCarousel({
					margin: 30,
					nav: <?=(count($arResult['ITEMS']) > 4) ? "true" : "false"?>,
					navText : ['<i class="icon-angle-left"></i>','<i class="icon-angle-right"></i>'],
					autoplayHoverPause: true,
					dots: false,
					responsive:{
						0:{ items:1 },
						600:{ items:2 },
						1000:{ items:4 }
					},
					onInitialized: setTimeout(function(){
						var $body = $('body');
						if( ocProduct.length > 0) {
							if( $body.hasClass('device-sm') || $body.hasClass('device-md') || $body.hasClass('device-lg') ) {
								var maxHeight = 0;
								ocProduct.each( function(){
									$(this).find(".product > .product-image").each(function(){
										if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
									});
									$(this).find(".product > .product-image").height(maxHeight);
									maxHeight = 0;
								});
							} else {
								ocProduct.find(".product > .product-image").css({ 'height': 'auto' });
							}
						}
					}, 800)
				});

			});
		</script>
	</span>

	<?
}

$frame->end();
?>


