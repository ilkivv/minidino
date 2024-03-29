<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use Bitrix\Main\Localization\Loc;
$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
?>
<div id="basket_items_delayed" class="table-responsive bottommargin">
	<table id="delayed_items" class="table cart">
		<thead>
			<tr>
				<?
				foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
						
					if ($arHeader["id"] == "DISCOUNT") {
						unset($arResult["GRID"]["HEADERS"][$id]);
						continue;
					}
					$arHeader["name"] = (isset($arHeader["name"]) ? (string)$arHeader["name"] : '');
					if ($arHeader["name"] == '')
						$arHeader["name"] = Loc::getMessage("SALE_".$arHeader["id"]);
					if (in_array($arHeader["id"], array("TYPE"))) // some header columns are shown differently
					{
						continue;
					}
					elseif ($arHeader["id"] == "PROPS")
					{
						$bPropsColumn = true;
						continue;
					}
					elseif ($arHeader["id"] == "DELAY")
					{
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
						<th class="cart-product-name" colspan="2">
					<?
					elseif ($arHeader["id"] == "PRICE"):
					?>
						<th class="cart-product-price">
					<?
					elseif ($arHeader["id"] == "QUANTITY"):
					?>
						<th class="cart-product-quantity">
					<?
					elseif ($arHeader["id"] == "SUM"):
					?>
						<th class="cart-product-subtotal">
					<?
					else:
					?>
						<th class="custom">
					<?
					endif;
					?>
						<?=$arHeader["name"]; ?>
						</th>
				<?
				endforeach;

				if ($bDeleteColumn || $bDelayColumn):
				?>
					<th class="custom"></th>
				<?
				endif;
				?>
				<th class="custom"></th>
			</tr>
		</thead>

		<tbody>
			<?
			foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

				if ($arItem["DELAY"] == "Y" && $arItem["CAN_BUY"] == "Y"):
			?>
				<tr id="<?=$arItem["ID"]?>" class="cart_item">
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

						if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in columns in this template
							continue;

						if ($arHeader["id"] == "NAME"):
						?>
							<td class="cart-product-thumbnail">
								<?
								if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
									$url = $arItem["PREVIEW_PICTURE_SRC"];
								elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
									$url = $arItem["DETAIL_PICTURE_SRC"];
								else:
									$url = $templateFolder."/images/no_photo.png";
								endif;
								?>
								<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
									<img src="<?=$url?>">
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
								if (is_array($arItem["SKU_DATA"])):
										foreach ($arItem["SKU_DATA"] as $propId => $arProp):

											// is image property
											$isImgProperty = false;
											foreach ($arProp["VALUES"] as $id => $arVal)
											{
												if (isset($arVal["PICT"]) && !empty($arVal["PICT"]))
												{
													$isImgProperty = true;
													break;
												}
											}
											$countValues = count($arProp["VALUES"]);
											$full = ($countValues > 5) ? "full" : "";

											if ($isImgProperty):
											?>
												<div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_scu_scroller_container">

														<div class="bx_scu">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%;margin-left:0%;">
															<?
															foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																$selected = "";
																foreach ($arItem["PROPS"] as $arItemProp):
																	if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																	{
																		if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
																			$selected = "class=\"bx_active\"";
																	}
																endforeach;
															?>
																<li style="width:10%;" <?=$selected?>>
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
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%; margin-left:0%;">
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
																				$selected = "class=\"bx_active\"";
																		}
																	endforeach;
																?>
																	<li style="width:10%;" <?=$selected?>>
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
								<input type="hidden" name="DELAY_<?=$arItem["ID"]?>" value="Y"/>
							</td>
						<?
						elseif ($arHeader["id"] == "QUANTITY"):
						?>
							<td class="custom">
								<div style="text-align: center;">
									<?echo $arItem["QUANTITY"];
										if (isset($arItem["MEASURE_TEXT"]))
											echo "&nbsp;".$arItem["MEASURE_TEXT"];
									?>
								</div>
							</td>
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<td class="cart-product-price">
								<?if (strlen($arItem["NOTES"]) > 0):?>
									<div class="type_price_value"><?=$arItem["NOTES"]?></div>
								<?endif;?>
								<?if (doubleval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
									<ins><?=$arItem["PRICE_FORMATED"]?></ins> 
									<del><?=$arItem["FULL_PRICE_FORMATED"]?></del>
								<?else:?>
									<ins><?=$arItem["PRICE_FORMATED"];?></ins>
								<?endif?>
								<?
								$divDiscountStyle = '';
								if ($arItem["DISCOUNT_PRICE_PERCENT_FORMATED"] == "") {
									$divDiscountStyle = ' style="display:none"';
								}
								?>
								<div id="discount_info_<?=$arItem["ID"]?>"<?=$divDiscountStyle?>>
									<span class="label label-success" id="discount_value_<?=$arItem["ID"]?>">-<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></span>
									<span class="label label-success"><?=Loc::getMessage("SALE_BASKET_YOU_CAN_SAVE")?>  <span id="discount_value_num_<?=$arItem["ID"]?>"><?=CCurrencyLang::CurrencyFormat($arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"], true);?></span></span>
								</div>

							</td>
						<?
						elseif ($arHeader["id"] == "DISCOUNT"):
						?>
							<td class="custom">
								<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
							</td>
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
							<td class="custom">
								<span><?=$arHeader["name"]; ?></span>
								<? if ($arHeader["id"] == "SUM") : ?>
									<?=CCurrencyLang::CurrencyFormat($arItem["PRICE"] * $arItem["QUANTITY"], $arItem["CURRENCY"], true);?>
								<? else: ?>
									<?=$arItem[$arHeader["id"]]?>
								<? endif; ?>
							</td>
						<?
						endif;
					endforeach;

					if ($bDelayColumn || $bDeleteColumn):
					?>
						<td class="cart-product-add">
							<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["add"])?>" title="<?=Loc::getMessage("SALE_ADD_TO_BASKET")?>" class="fly-cart-btn">
                                <i class="icon-cart"></i>
                            </a>
						</td>
							<?
							if ($bDeleteColumn):
							?>
						<td class="cart-product-remove">
								<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>" title="<?=Loc::getMessage("SALE_DELETE")?>" class="fly-cart-btn">
                                    <i class="icon-trash2"></i>
                                </a>
							<?
							endif;
							?>
						</td>
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
</div>
<?