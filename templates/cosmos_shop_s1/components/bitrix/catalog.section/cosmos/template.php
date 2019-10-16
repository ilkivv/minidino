<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

$hiddenIconList = "hideparam-grid";
$hiddenPreviewText = "hideparam-grid";
if ($arParams["SECTION_HIDE_ICONLIST"] == "N") {
	$hiddenIconList = "";
}
if ($arParams["SECTION_HIDE_PREVIEW_TEXT"] == "N") {
	$hiddenPreviewText = "";
}


if (!empty($arResult['ITEMS'])):?>
	<!-- Shop
	============================================= -->
	<div class="shop grid-container product-<?=$arParams['LINE_ELEMENT_COUNT']; ?><?=($arParams["TABLE_VIEW"] == "Y")? " products-table" : "" ?> clearfix" data-layout="fitRows">
		<?$elementCounter = 0;?>
		<?foreach ($arResult['ITEMS'] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$elId = $this->GetEditAreaId($arItem['ID']);

			$elCurrency = $arItem["DISPLAY_PROPERTIES"]["PRICECURRENCY"]["VALUE_ENUM"];
			$arPropHide = array("PRICE", "NEW_PRICE", "PRICECURRENCY", "PRODUCT_STATUS");
			if ($elementCounter % $arParams["LINE_ELEMENT_COUNT"] == 0 && $arParams["LINE_ELEMENT_COUNT"] > 0 && $elementCounter > 0) {
				//echo '<div class="clearfix"></div>';
			}
			$elementCounter++;
			?>
			<div id="<?=$elId?>" class="product clearfix">
				<div class="product-image">
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"></a>
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE_SECOND"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"></a>
					<div class="product-overlay">


                        <?if ($arItem["PRICES"]["PRICE"]["VALUE"] <= 0):?>
                            <a href="<?=$arParams["LINK_TO_AJAX"]?>?TYPE=ASK_PRICE&ELEMENT_CODE=<?=$arItem["CODE"]?>" rel="nofollow" data-lightbox="ajax" class="add-zapros">
                                <span><i class="icon-question"></i> <?=GetMessage("CATALOG_ASK_FOR_PRICE")?></span>
                            </a>
                        <?else:?>
                            <?if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY'):?>
                                <a href="<?=$arItem["BUY_URL"]?>" class="add-to-cart" rel="nofollow">
                                    <span>
                                        <?=('' != $arParams['MESS_BTN_BUY'] ? htmlspecialchars_decode(htmlspecialchars_decode($arParams['MESS_BTN_BUY'])) : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));?>
                                    </span>
                                </a>
                            <?else:?>
                                <?
                                $btnClass = '';
                                if ($arParams["AJAX_TYPE"] == "ZAKAZ") {
                                    $btnClass = "add-to-cart";
                                }
                                ?>
                                <a href="<?=$arParams["LINK_TO_AJAX"]?>?TYPE=<?=$arParams["AJAX_TYPE"]?>&ELEMENT_CODE=<?=$arItem["CODE"]?>" data-lightbox="ajax" class="<?=$btnClass?>" rel="nofollow">
                                    <span>
                                        <?=('' != $arParams['MESS_BTN_BUY'] ? htmlspecialchars_decode(htmlspecialchars_decode($arParams['MESS_BTN_BUY'])) : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));?>
                                    </span>
                                </a>
                            <?endif;?>
                        <?endif;?>

                        <?
						$ajaxUrl = $arItem["DETAIL_PAGE_URL"] . (parse_url($arItem["DETAIL_PAGE_URL"], PHP_URL_QUERY) ? '&' : '?') . 'cosmos_ajax=Y';
						?>
						<a href="<?=$ajaxUrl?>" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i>
							<span> <?=GetMessage("CATALOG_BUTTON_QUICK_VIEW")?></span>
						</a>
					</div>
				</div>
				<div class="product-desc">
					<div class="product-title">
						<h3><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h3>
					</div>
					<div class="product-price">

						<?if ($arItem["PRICES"]["PRICE"]["VALUE"] <= 0):?>
							<a href="<?=$arParams["LINK_TO_AJAX"]?>?TYPE=ASK_PRICE&ELEMENT_CODE=<?=$arItem["CODE"]?>" data-lightbox="ajax" class="button button-mini button-border tright notopmargin nobottommargin noleftmargin">
								<span><?=GetMessage("CATALOG_ASK_FOR_PRICE")?></span>
							</a>
						<?endif;?>
						<?if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY'):?>
							<a href="<?=$arItem["BUY_URL"]?>" class="button button-mini notopmargin nobottommargin hidden add-to-cart" rel="nofollow">
								<span>
									<?=('' != $arParams['MESS_BTN_BUY'] ? htmlspecialchars_decode(htmlspecialchars_decode($arParams['MESS_BTN_BUY'])) : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));?>
								</span>
							</a>
						<?else:?>
							<a href="<?=$arParams["LINK_TO_AJAX"]?>?TYPE=<?=$arParams["AJAX_TYPE"]?>&ELEMENT_CODE=<?=$arItem["CODE"]?>" data-lightbox="ajax" class="button button-mini notopmargin nobottommargin hidden add-to-cart" rel="nofollow">
								<span>
									<?=('' != $arParams['MESS_BTN_BUY'] ? htmlspecialchars_decode(htmlspecialchars_decode($arParams['MESS_BTN_BUY'])) : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));?>
								</span>
							</a>
						<?endif;?>

						<?if ($arItem["PRICES"]["PRICE"]["VALUE"] > 0):?>
							<?if(isset($arItem["PRICES"]["NEW_PRICE"]["VALUE"]) && $arItem["PRICES"]["NEW_PRICE"]["VALUE"] > 0):?>
									<del><?=$arItem["PRICES"]["PRICE"]["VALUE"]?> <?=$elCurrency?></del>
									<ins><?=$arItem["PRICES"]["NEW_PRICE"]["VALUE"]?> <?=$elCurrency?></ins>
							<?else:?>
								<ins><?=$arItem["PRICES"]["PRICE"]["VALUE"]?> <?=$elCurrency?></ins>
							<?endif;?>
						<?endif;?>

						<?if(
							isset($arItem["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE"])
							&& strlen($arItem["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE"]) > 0
							&& isset($arItem["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"])
							):?>
							<?
							$labelClass='';
							if ($arItem["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"] == "EXPECTED") {
								$labelClass = "warning";
							} elseif ($arItem["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"] == "IN_STOCK") {
								$labelClass = "success";
							} elseif ($arItem["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"] == "UNDER_THE_ORDER") {
								$labelClass = "info";
							}
							?>
							<span class="label label-<?=$labelClass?>"><?=$arItem["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE"]?></span>
						<?endif;?>
					</div>
					<p class="<?=$hiddenPreviewText?>"><?=$arItem["PREVIEW_TEXT"]?></p>
					<?if (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES'])):?>
						<ul class="iconlist <?=$hiddenIconList?>">
							<?foreach ($arItem['DISPLAY_PROPERTIES'] as $keyProp => $arOneProp) :?>
								<? if (in_array($keyProp, $arPropHide)) continue; ?>
								<li><i class="icon-caret-right"></i> <strong><? echo $arOneProp['NAME']; ?>:</strong>
									<?=(is_array($arOneProp['DISPLAY_VALUE'])
										? implode('<br>', $arOneProp['DISPLAY_VALUE'])
										: $arOneProp['DISPLAY_VALUE']
										);?>
								</li>
							<?endforeach;?>
						</ul>
					<?endif;?>
				</div>
			</div>
		<?endforeach;?>
		<?
			if ($arParams["DISPLAY_BOTTOM_PAGER"])
			{
				?><? echo $arResult["NAV_STRING"]; ?><?
			}
		if ($arResult["NAV_RESULT"]->NavPageNomer == 1) :
		?>
			<div class="divider divider-short divider-center"><i class="icon-crop"></i></div>
			<div class="col_full">
				<?=$arResult["DESCRIPTION"]?>
			</div>
		<?endif;?>
	</div>
<?endif;?>