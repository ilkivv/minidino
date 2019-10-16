<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Main\Localization\Loc;

if (!empty($arResult["ERROR_MESSAGE"]))
	ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

if ($normalCount > 0):
?>
<div id="basket_items_list" class="table-responsive">
		<table id="basket_items" class="table cart">
			<thead>
				<tr class="cart_item">
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

						if ($arHeader["id"] == "DISCOUNT" || $arHeader["id"] == "TYPE") {
							unset($arResult["GRID"]["HEADERS"][$id]);
							continue;
						}

						$arHeader["name"] = (isset($arHeader["name"]) ? (string)$arHeader["name"] : '');
						if ($arHeader["name"] == '')
							$arHeader["name"] = Loc::getMessage("SALE_".$arHeader["id"]);
						$arHeaders[] = $arHeader["id"];

						// remember which values should be shown not in the separate columns, but inside other columns
						if (in_array($arHeader["id"], array("TYPE")))
						{
							$bPriceType = true;
							continue;
						}
						elseif ($arHeader["id"] == "PROPS")
						{
							$bPropsColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELAY")
						{
							$bDelayColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELETE")
						{
							$bDeleteColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "WEIGHT")
						{
							$bWeightColumn = true;
						}

						if ($arHeader["id"] == "NAME"):
						?>
							<th class="cart-product-name" colspan="2" id="col_<?=$arHeader["id"];?>">
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<th class="cart-product-price" id="col_<?=$arHeader["id"];?>">
						<?
						elseif ($arHeader["id"] == "QUANTITY"):
						?>
							<th class="cart-product-quantity" id="col_<?=$arHeader["id"];?>">
						<?
						elseif ($arHeader["id"] == "SUM"):
						?>
							<th class="cart-product-subtotal" id="col_<?=$arHeader["id"];?>">
						<?
						else:
						?>
							<?if ($arHeader["id"] != "DISCOUNT"):?>
								<th class="custom" id="col_<?=$arHeader["id"];?>">
							<?endif;?>
						<?
						endif;
						?>
							<?=$arHeader["name"]; ?>
							</th>
					<?
					endforeach;

					if ($bDelayColumn):
					?>
						<th class="custom"></th>
					<?
					endif;
					if ($bDeleteColumn):
					?>
						<th class="custom"></th>
					<?
					endif;
					?>
				</tr>
			</thead>

			<tbody>
				<?
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
				?>
					<tr id="<?=$arItem["ID"]?>">
						<?
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

							if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in the columns in this template
								continue;

							if ($arHeader["id"] == "NAME"):
							?>

								<?
								if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
									$url = $arItem["PREVIEW_PICTURE_SRC"];
								elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
									$url = $arItem["DETAIL_PICTURE_SRC"];
								else:
									$url = $templateFolder."/images/no_photo.png";
								endif;
								?>
								<td class="cart-product-thumbnail">
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
										<img src="<?=$url?>" alt="<?=$arItem["NAME"]?>">
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									<?
									if (!empty($arItem["BRAND"])):
									?>
									<div class="bx_ordercart_brand">
										<img alt="" src="<?=$arItem["BRAND"]?>" />
									</div>
									<?
									endif;
									?>
								</td>
								<td class="cart-product-name">
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
										<?=$arItem["NAME"]?>
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									<div class="bx_ordercart_itemart">
										<?
										if ($bPropsColumn):
											foreach ($arItem["PROPS"] as $val):

												if (is_array($arItem["SKU_DATA"]))
												{
													$bSkip = false;
													foreach ($arItem["SKU_DATA"] as $propId => $arProp)
													{
														if ($arProp["CODE"] == $val["CODE"])
														{
															$bSkip = true;
															break;
														}
													}
													if ($bSkip)
														continue;
												}

												echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
											endforeach;
										endif;
										?>
									</div>
									<?
									if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
										foreach ($arItem["SKU_DATA"] as $propId => $arProp):

											// if property contains images or values
											$isImgProperty = false;
											if (!empty($arProp["VALUES"]) && is_array($arProp["VALUES"]))
											{
												foreach ($arProp["VALUES"] as $id => $arVal)
												{
													if (!empty($arVal["PICT"]) && is_array($arVal["PICT"])
														&& !empty($arVal["PICT"]['SRC']))
													{
														$isImgProperty = true;
														break;
													}
												}
											}
											$countValues = count($arProp["VALUES"]);
											$full = ($countValues > 5) ? "full" : "";

											if ($isImgProperty): // iblock element relation property
											?>
												<div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_scu_scroller_container">

														<div class="bx_scu">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left:0%;"
																class="sku_prop_list"
																>
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
																				$selected = "bx_active";
																		}
																	endforeach;
																?>
																	<li style="width:10%;"
																		class="sku_prop <?=$selected?>"
																		data-value-id="<?=$arSkuValue["XML_ID"]?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																		>
																		<a href="javascript:void(0);">
																			<span style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"></span>
																		</a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>

														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
													</div>

												</div>
											<?
											else:
											?>
												<div class="bx_item_detail_size_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_size_scroller_container">
														<div class="bx_size">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left:0%;"
																class="sku_prop_list"
																>
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
																				$selected = "bx_active";
																		}
																	endforeach;
																?>
																	<li style="width:10%;"
																		class="sku_prop <?=$selected?>"
																		data-value-id="<?=($arProp['TYPE'] == 'S' && $arProp['USER_TYPE'] == 'directory' ? $arSkuValue['XML_ID'] : $arSkuValue['NAME']); ?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																		>
																		<a href="javascript:void(0);"><?=$arSkuValue["NAME"]?></a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>
														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
													</div>

												</div>
											<?
											endif;
										endforeach;
									endif;
									?>
								</td>
							<?
							elseif ($arHeader["id"] == "QUANTITY"):
							?>
								<td class="cart-product-quantity">
									<div class="quantity<?=(isset($arItem["MEASURE_RATIO"]))? " quantity-with-measure": "";?> clearfix">
										<?
										$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
										$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
										$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
										$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
										?>
										<?
										if (!isset($arItem["MEASURE_RATIO"]))
										{
											$arItem["MEASURE_RATIO"] = 1;
										}

										if (
											floatval($arItem["MEASURE_RATIO"]) != 0
										):
										?><input type="button" value="-" class="minus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"><?
										endif;?>
										<input
											type="text"
											size="3"
											id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
											name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
											size="2"
											maxlength="18"
											min="0"
											<?=$max?>
											step="<?=$ratio?>"
											style="max-width: 50px"
											value="<?=$arItem["QUANTITY"]?>"
											class="qty"
											onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)"
										><?
										if (isset($arItem["MEASURE_TEXT"]))
										{
											?>
												<input class="measure" value="<?=$arItem["MEASURE_TEXT"]?>" disabled>
											<?
										}
										if (
											floatval($arItem["MEASURE_RATIO"]) != 0
										):
										?>
										<input type="button" value="+" class="plus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);"><?
										endif;
										?>
									</div>
									<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
								</td>
							<?
							elseif ($arHeader["id"] == "PRICE"):
							?>
								<td class="cart-product-price">
									<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
										<div class="type_price_value"><?=$arItem["NOTES"]?></div>
									<?endif;?>
										<ins id="current_price_<?=$arItem["ID"]?>">
											<?=$arItem["PRICE_FORMATED"]?>
										</ins>
										<del id="old_price_<?=$arItem["ID"]?>">
											<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
												<?=$arItem["FULL_PRICE_FORMATED"]?>
											<?endif;?>
										</del>
										<?
										$divDiscountStyle = '';
										if ($arItem["DISCOUNT_PRICE_PERCENT_FORMATED"] == "0%") {
											$divDiscountStyle = ' style="display:none"';
										}
										?>
										<div id="discount_info_<?=$arItem["ID"]?>"<?=$divDiscountStyle?>>
											<span class="label label-success" id="discount_value_<?=$arItem["ID"]?>">-<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></span>
											<span class="label label-success"><?=Loc::getMessage("SALE_BASKET_YOU_CAN_SAVE")?> <span id="discount_value_num_<?=$arItem["ID"]?>"><?=CCurrencyLang::CurrencyFormat($arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"], true);?></span></span>
										</div>

								</td>
							<?
							elseif ($arHeader["id"] == "DISCOUNT"):
							?>
							<?
							elseif ($arHeader["id"] == "WEIGHT"):
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<?=$arItem["WEIGHT_FORMATED"]?>
								</td>
							<?
							else:
							?>
								<td class="cart-product-subtotal">
									<?
									if ($arHeader["id"] == "SUM"):
									?>
										<div id="sum_<?=$arItem["ID"]?>">
									<?
									endif;

									echo $arItem[$arHeader["id"]];

									if ($arHeader["id"] == "SUM"):
									?>
										</div>
									<?
									endif;
									?>
								</td>
							<?
							endif;
						endforeach;

						if ($bDelayColumn || $bDeleteColumn):
						?><?
							if ($bDelayColumn):
							?>
							<td class="cart-product-delay">
									<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>" class="remove fly-cart-btn" title="<?=Loc::getMessage("SALE_DELAY")?>"><i class="icon-line-heart medium-icon"></i></a>
							</td>
							<?
							endif;
							if ($bDeleteColumn):
							?>
							<td class="cart-product-remove">
								<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>" class="fly-cart-btn" title="<?=Loc::getMessage("SALE_DELETE")?>"><i class="icon-trash2 medium-icon"></i></a>
							</td>
							<?
							endif;
							?>
						<?
						endif;
						?>
					</tr>
					<?
					endif;
				endforeach;
				?>
			</tbody>
		</table>
	<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
	<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
	<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
	<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
	<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />

	<div class="col_full nobottommargin">

		<div class="col_one_third" id="coupons_block">
			<?if ($arParams["HIDE_COUPON"] == "N") :?>
				<div class="bx_ordercart_coupon">
					<input type="text" id="coupon" name="COUPON" value="" onchange="enterCoupon();" class="sm-form-control" placeholder="<?=Loc::getMessage("STB_COUPON_PROMT")?>">
				</div><?
					if (!empty($arResult['COUPON_LIST']))
					{
						foreach ($arResult['COUPON_LIST'] as $oneCoupon)
						{
							$couponClass = 'disabled';
							switch ($oneCoupon['STATUS'])
							{
								case DiscountCouponsManager::STATUS_NOT_FOUND:
								case DiscountCouponsManager::STATUS_FREEZE:
									$couponClass = 'bad';
									break;
								case DiscountCouponsManager::STATUS_APPLYED:
									$couponClass = 'good';
									break;
							}
							?><div class="bx_ordercart_coupon"><input disabled readonly type="text" name="OLD_COUPON[]" value="<?=htmlspecialcharsbx($oneCoupon['COUPON']);?>" class="<? echo $couponClass; ?>"><span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span><div class="bx_ordercart_coupon_notes"><?
							if (isset($oneCoupon['CHECK_CODE_TEXT']))
							{
								echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
							}
							?></div></div><?
						}
						unset($couponClass, $oneCoupon);
					}
				?>
			<?endif;?>
		</div>
		<div class="col_one_third">
		</div>
		<div class="col_one_third col_last nobottommargin">
			<div class="table-responsive">
				<table class="table cart nobottommargin">
				<?if ($bWeightColumn && floatval($arResult['allWeight']) > 0):?>
					<tr class="cart_item">
						<td class="cart-product-name"><?=Loc::getMessage("SALE_TOTAL_WEIGHT")?></td>
						<td class="cart-product-name" id="allWeight_FORMATED"><?=$arResult["allWeight_FORMATED"]?>
						</td>
					</tr>
				<?endif;?>
				<?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
					<tr class="cart_item">
						<td class="cart-product-name"><?echo Loc::getMessage('SALE_VAT_EXCLUDED')?></td>
						<td class="cart-product-name"><span id="allSum_wVAT_FORMATED"><?=$arResult["allSum_wVAT_FORMATED"]?></span>
							<?if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
									<br><del id="PRICE_WITHOUT_DISCOUNT">
										<?=$arResult["PRICE_WITHOUT_DISCOUNT"]?>
									</del>
								</tr>
							<?endif;?>
						</td>
					</tr>
					<?
					if (floatval($arResult['allVATSum']) > 0):
						?>
						<tr class="cart_item">
							<td class="cart-product-name"><?echo Loc::getMessage('SALE_VAT')?></td>
							<td id="allVATSum_FORMATED" class="cart-product-name"><?=$arResult["allVATSum_FORMATED"]?></td>
						</tr>
						<?
					endif;
					?>
				<?endif;?>
					<tr class="cart_item">
						<td class="cart-product-name">
                            <?=Loc::getMessage("SALE_TOTAL")?>
                        </td>
						<td class="cart-product-name">
                            <span class="amount color lead">
                                <strong id="allSum_FORMATED">
                                    <?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?>
                                </strong>
                            </span>
							<?if ($arParams["PRICE_VAT_SHOW_VALUE"] !== "Y"):?>
								<?if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
									<br><del id="PRICE_WITHOUT_DISCOUNT"><?=$arResult["PRICE_WITHOUT_DISCOUNT"]?></del>
								<?endif;?>
							<?endif;?>
						</td>
					</tr>

				</table>

			</div>
		</div>
		<div class="col_full clearfix nobottommargin">
			<div class="col_one_third nopadding">
			</div>
			<div class="col_two_third nopadding col_last nobottommargin">
				<?if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
					<?=$arResult["PREPAY_BUTTON"]?>
					<span><?=Loc::getMessage("SALE_OR")?></span>
				<?endif;?>

				<a href="javascript:void(0)" onclick="checkOut();" class="button button-3d nomargin fright"><?=Loc::getMessage("SALE_ORDER")?></a>
			</div>
		</div>
	</div>
</div>
<?
else:
?>
<div id="basket_items_list">
	<table>
		<tbody>
			<tr>
				<td colspan="<?=$numCells?>" style="text-align:center">
					<div class=""><?=Loc::getMessage("SALE_NO_ITEMS");?></div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?
endif;
?>