<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
$elCurrency = $arResult["DISPLAY_PROPERTIES"]["PRICECURRENCY"]["VALUE_ENUM"];
$arPropHide = array("PRICE", "NEW_PRICE", "PRICECURRENCY", "PRODUCT_STATUS", "MORE_PHOTO");
$isAjaxMode = ($arParams["AJAX_COSMOS_MODE"] == "Y") ? true : false;
?>
	<?
	$withImage = (isset($arResult["DETAIL_PICTURE"]["SRC"]) && strlen($arResult["DETAIL_PICTURE"]["SRC"]) > 0 || count($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"]) > 0) ? true : false;
	if ($withImage) : 
	?>
	<div class="col_half">
		<!-- Product Single - Gallery
		============================================= -->
		<div class="product-image">
			<?if ($isAjaxMode):?>
				<div class="fslider" data-pagi="false">
					<div class="flexslider">
						<div class="slider-wrap">
							<div class="slide">
								<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>">
							</div>
							<?foreach ($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"] as $photoKey => $arPhoto) :?>
								<div class="slide">
									<img src="<?=$arPhoto["SRC"]?>" alt="<?=$arPhoto["DESCRIPTION"]?>">
								</div>
							<?endforeach;?>
						</div>
					</div>
				</div>
			<?else:?>
				<div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
					<div class="flexslider product-image__slider">
						<div class="slider-wrap" data-lightbox="gallery">
							<div class="slide" data-thumb="<?=$arResult["DETAIL_PICTURE"]["THUMB"]["SRC"]?>">
								<a href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>" data-lightbox="gallery-item">
									<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>">
								</a>
							</div>
							<?foreach ($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"] as $photoKey => $arPhoto) :?>
								<div class="slide" data-thumb="<?=$arPhoto["THUMB"]["SRC"]?>">
									<a href="<?=$arPhoto["SRC"]?>" title="<?=$arPhoto["DESCRIPTION"]?>" data-lightbox="gallery-item">
										<img src="<?=$arPhoto["SRC"]?>" alt="<?=$arPhoto["DESCRIPTION"]?>">
									</a>
								</div>
							<?endforeach;?>
						</div>
					</div>
				</div>
			<?endif;?>
		</div><!-- Product Single - Gallery End -->
	</div>

	<div class="col_half col_last product-desc">
	<?else:?>
	<div class="col_full product-desc">
	<?endif;?>

		<?if (!$isAjaxMode && $arParams["DISPLAY_NAME"] == "Y"):?>
			<h2><?=$arResult["NAME"]?></h2>
		<?endif;?>

		<!-- Product Single - Short Description
		============================================= -->
		<?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?>
			<p><?=$arResult["PREVIEW_TEXT"]?></p>
		<?else:?>
			<?=$arResult["PREVIEW_TEXT"]?>
		<?endif;?>

	<!-- Product Single - Price
    ============================================= -->
		<div class="product-price">
			<?if ($arResult["PRICES"]["PRICE"]["VALUE"] <= 0):?>
				<span><?=Loc::getMessage("CATALOG_ASK_FOR_PRICE")?></span>
			<?else:?>
				<?if(isset($arResult["PRICES"]["NEW_PRICE"]["VALUE"]) && $arResult["PRICES"]["NEW_PRICE"]["VALUE"] > 0):?>
					<del><?=$arResult["PRICES"]["PRICE"]["VALUE"]?> <?=$elCurrency?></del>
					<ins><?=$arResult["PRICES"]["NEW_PRICE"]["VALUE"]?> <?=$elCurrency?></ins>
				<?else:?>
					<ins><?=$arResult["PRICES"]["PRICE"]["VALUE"]?> <?=$elCurrency?></ins>
				<?endif;?>
			<?endif;?>

			<?if(
				isset($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE"])
				&& strlen($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE"]) > 0
				&& isset($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"])
			):?>
				<?
				$labelClass='';
				if ($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"] == "EXPECTED") {
					$labelClass = "warning";
				} elseif ($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"] == "IN_STOCK") {
					$labelClass = "success";
				} elseif ($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"] == "UNDER_THE_ORDER") {
					$labelClass = "info";
				}
				?>
				<span class="label label-<?=$labelClass?>"><?=$arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE"]?></span>
			<?endif;?>
		</div>

		<div class="clear"></div>
		<div class="line"></div>

		<!-- Product Single - Quantity & Cart Button
		============================================= -->
		<div class="cart nobottommargin clearfix">
            <?if ($arItem["PRICES"]["PRICE"]["VALUE"] > 0):?>
                <?
                $btnClass = '';
                if ($arParams["AJAX_TYPE"] == "ZAKAZ") {
                    $btnClass = "add-to-cart";
                }
                ?>
                <a href="<?=$arParams["LINK_TO_AJAX"]?>?TYPE=<?=$arParams["AJAX_TYPE"]?>&ELEMENT_CODE=<?=$arResult["CODE"]?>" data-lightbox="ajax" class="<?=$btnClass?> button nomargin">
                    <?=('' != $arParams['MESS_BTN_BUY'] ? htmlspecialchars_decode(htmlspecialchars_decode($arParams['MESS_BTN_BUY'])) : Loc::getMessage('CT_BCE_CATALOG_ZAKAZ'));?>
                </a>
            <? endif; ?>
			<a href="<?=$arParams["LINK_TO_AJAX"]?>?TYPE=ASK_QUESTION&ELEMENT_CODE=<?=$arResult["CODE"]?>" data-lightbox="ajax" class="button button-border">
				<?=Loc::getMessage("CT_BCE_CATALOG_ASK")?>
			</a>
		</div><!-- Product Single - Quantity & Cart Button End -->

		<div class="clear"></div>
		<div class="line"></div>

		<?if (isset($arResult['DISPLAY_PROPERTIES']) && !empty($arResult['DISPLAY_PROPERTIES'])):?>
			<ul class="iconlist">
				<?/*
				//Add chance to show it
				<?$breakCounter = 0;?>
				<?foreach ($arResult['DISPLAY_PROPERTIES'] as $keyProp => $arOneProp) :?>
					<? if (in_array($keyProp, $arPropHide)) continue; ?>
					<?$breakCounter++; if ($breakCounter > 3) break;?>
					<li><i class="icon-caret-right"></i> <strong><? echo $arOneProp['NAME']; ?></strong>
						<?=(is_array($arOneProp['DISPLAY_VALUE'])
							? implode('<br>', $arOneProp['DISPLAY_VALUE'])
							: $arOneProp['DISPLAY_VALUE']
						);?>
					</li>
				<?endforeach;?>
				<?if (!$isAjaxMode):?>
					<li><a href="#" onclick="$('#tab-1').tabs({active: 1});" data-scrollto="#tab-1"><i class="icon-caret-down"></i> <?=Loc::getMessage("CAT_WATCH_ALL_SPEC")?></a></li>
				<?endif;?>
				*/?>
			</ul>
			<?if ($isAjaxMode):?>
				<div class="toggle toggle-border toggle-product-modal">
					<div class="togglet"><i class="toggle-closed icon-ok-circle"></i><i class="toggle-open icon-remove-circle"></i><?=Loc::getMessage("CAT_WATCH_ALL_SPEC")?></div>
					<div class="togglec">
						<ul class="iconlist">
							<?foreach ($arResult['DISPLAY_PROPERTIES'] as $keyProp => $arOneProp) :?>
								<? if (in_array($keyProp, $arPropHide)) continue; ?>
								<li><i class="icon-caret-right"></i> <strong><? echo $arOneProp['NAME']; ?></strong>
									<?=(is_array($arOneProp['DISPLAY_VALUE'])
										? implode('<br>', $arOneProp['DISPLAY_VALUE'])
										: $arOneProp['DISPLAY_VALUE']
									);?>
								</li>
							<?endforeach;?>
						</ul>
					</div>
				</div>
				<script type="text/javascript">
					var $toggle = $('.toggle-product-modal');
					if( $toggle.length > 0 ) {
						$toggle.each( function(){
							var element = $(this),
								elementState = element.attr('data-state');

							if( elementState != 'open' ){
								element.find('.togglec').hide();
							} else {
								element.find('.togglet').addClass("toggleta");
							}

							element.find('.togglet').click(function(){
								$(this).toggleClass('toggleta').next('.togglec').slideToggle(300);
								return true;
							});
						});
					}
				</script>
			<?endif;?>
		<?endif;?><!-- Product Single - Short Description End -->

		<!-- Product Single - Share
		============================================= -->

		<div class="noborder clearfix">
			<?
				$APPLICATION->IncludeComponent("bitrix:main.share", "projectx", array(
					"HANDLERS"          => $arParams["SHARE_HANDLERS"],
					"PAGE_URL"          => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE"        => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY"   => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE"              => $arParams["SHARE_HIDE"],
				),
					$component,
					array("HIDE_ICONS" => "Y")
				);
			?>
		</div><!-- Product Single - Share End -->

	</div>

<?if (!$isAjaxMode):?>
	<div class="col_full nobottommargin">
		<?
			foreach ($arResult['DISPLAY_PROPERTIES'] as $keyProp => $arOneProp) {
				if (in_array($keyProp, $arPropHide)) {
					unset($arResult['DISPLAY_PROPERTIES'][$keyProp]);
				}
			}
			if (count($arResult['DISPLAY_PROPERTIES']) < 1) {
				$arResult["AR_TABS"]["INFO"]["HIDE"] = "Y";
			}
		?>
		<?
			if ($arParams["DETAIL_USE_TABS"] == "Y") :
		?>
		<div class="tabs clearfix nobottommargin" id="tab-1">

			<ul class="tab-nav clearfix">
				<?foreach ($arResult["AR_TABS"] as $tabKey => $tabValue) : ?>
					<?if ($tabValue["HIDE"] == "Y") continue;?>
					<li><a href="<?=$tabValue["HREF"]?>"><i class="<?=$tabValue["ICON"]?>"></i><span class="hidden-xs"> <?=$tabValue["NAME"]?></span></a></li>
				<?endforeach;?>
			</ul>

			<div class="tab-container">

				<div class="tab-content clearfix" id="tabs-1">
					<?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?>
						<p><?=$arResult["DETAIL_TEXT"]?></p>
					<?else:?>
						<?=$arResult["DETAIL_TEXT"]?>
					<?endif;?>
				</div>
				<? if ($arResult["AR_TABS"]["INFO"]["HIDE"] != "Y"): ?>
					<div class="tab-content clearfix" id="tabs-2">

						<table class="table table-striped table-bordered">
							<tbody>
								<?foreach ($arResult['DISPLAY_PROPERTIES'] as $keyProp => $arOneProp) :?>
									<? if (in_array($keyProp, $arPropHide)) continue; ?>
									<tr>
										<td><? echo $arOneProp['NAME']; ?></td>
										<td><?=(is_array($arOneProp['DISPLAY_VALUE'])
												? implode(', ', $arOneProp['DISPLAY_VALUE'])
												: $arOneProp['DISPLAY_VALUE']
											);?></td>
									</tr>
								<?endforeach;?>
							</tbody>
						</table>

					</div>
				<?endif;?>

			</div>

		</div>
		<?else :?>
			<?if (strlen($arResult["DETAIL_TEXT"]) > 0) :?>
				<div class="fancy-title title-bottom-border">
					<h3>
						<?=Loc::getMessage("FULL_DESCRIPTION");?>
					</h3>
				</div>

				<?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?>
					<p><?=$arResult["DETAIL_TEXT"]?></p>
				<?else:?>
					<?=$arResult["DETAIL_TEXT"]?>
				<?endif;?>
			<?endif;?>

			<? if ($arResult["AR_TABS"]["INFO"]["HIDE"] != "Y"): ?>
				<div class="fancy-title title-bottom-border">
					<h3>
						<?=Loc::getMessage("FULL_PROPERTIES");?>
					</h3>
				</div>

				<table class="table table-striped table-bordered">
					<tbody>
						<?foreach ($arResult['DISPLAY_PROPERTIES'] as $keyProp => $arOneProp) :?>
							<? if (in_array($keyProp, $arPropHide)) continue; ?>
							<tr>
								<td><? echo $arOneProp['NAME']; ?></td>
								<td><?=(is_array($arOneProp['DISPLAY_VALUE'])
										? implode(', ', $arOneProp['DISPLAY_VALUE'])
										: $arOneProp['DISPLAY_VALUE']
									);?></td>
							</tr>
						<?endforeach;?>
					</tbody>
				</table>
			<?endif;?>

		<?endif;?>

		<?if (count($arResult["ADDITIONAL_FILES"]) > 0) :?>
			<div class="fancy-title title-bottom-border">
				<h3><?=$arResult["ADDITIONAL_FILES_TITLE"]?></h3>
			</div>
			<?foreach($arResult["ADDITIONAL_FILES"] as $keyPhoto => $arFile):?>
				<div class="col_half col_last">
					<div class="feature-box fbox-plain">
						<div class="fbox-icon bounceIn animated" data-animate="bounceIn">
							<a href="<?=$arFile["SRC"]?>" title="<?=$arFile["ORIGINAL_NAME"]?>" target="_blank">
								<img src="<?=$arFile["FILE_EXTENSION_SRC"]?>" alt="<?=$arFile["ORIGINAL_NAME"]?>">
							</a>
						</div>
						<a href="<?=$arFile["SRC"]?>" target="_blank" title="<?=$arFile["ORIGINAL_NAME"]?>"><h5 class="nobottommargin"><?=$arFile["ORIGINAL_NAME"]?></h5></a>
						<p><?=Loc::getMessage("MD_ND_FILE_SIZE")?> <?=$arFile["FILE_SIZE_FORMATED"]?></p>
					</div>
				</div>
			<?endforeach;?>

		<?endif;?>

		<div class="line"></div>
	</div>
<?else:?>
<?endif;?>
<?if($isAjaxMode):?>
	<script type="text/javascript">
		$lightboxAjaxElItem = $('.product.modal-padding [data-lightbox="ajax"]');
		if( $lightboxAjaxElItem.length > 0 ) {
			$lightboxAjaxElItem.magnificPopup({
				type: 'ajax',
				closeBtnInside: false,
				callbacks: {
					ajaxContentAdded: function(mfpResponse) {
						SEMICOLON.widget.loadFlexSlider();
						SEMICOLON.initialize.resizeVideos();
						SEMICOLON.widget.masonryThumbs();
					},
					open: function() {
						$body.addClass('ohidden');
					},
					close: function() {
						$body.removeClass('ohidden');
					}
				}
			});
		}
	</script>
<?endif;?>
<?/*if (CModule::IsInstalled("sale")) : //add SKU SUPPORT?>
	<script type="text/javascript">
		$.ajax({
			type: "POST",
			url: "/bitrix/components/bitrix/catalog.element/ajax.php",
			data: { PRODUCT_ID: <?=$arResult["ID"]?>, SITE_ID: "<?=SITE_ID?>", AJAX: "Y" },
		});
	</script>
<?endif;*/?>