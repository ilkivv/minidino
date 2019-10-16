<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (count($arResult["ITEMS"]) < 1) return;
?>

<div class="heading-block center">
    <h2><?=GetMessage("CT_EL_LI_TITLE")?></h2>
</div>
<div id="events_list" class="events small-thumbs">
    <div class="col_half nobottommargin">

<? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

	$elCurrency = $arItem["DISPLAY_PROPERTIES"]["PRICECURRENCY"]["VALUE_ENUM"];
	$arPropHide = array("PRICE", "NEW_PRICE", "PRICECURRENCY", "PRODUCT_STATUS");
    ?>
        <div class="entry clearfix" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <div class="entry-image hidden-sm">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                    <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>">
                </a>
            </div>
            <div class="entry-c">
                <div class="entry-title">
                    <h4 class="nobottommargin"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?= $arItem["NAME"] ?></a></h4>
                </div>
                <ul class="entry-meta clearfix">
                    <?if (isset($arItem["DISPLAY_ACTIVE_FROM"]) && strlen($arItem["DISPLAY_ACTIVE_FROM"]) > 0) :?>
                        <li><i class="icon-time"></i> <?=$arItem["DISPLAY_ACTIVE_FROM"]?></li>
                    <?endif;?>

					<?if (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES'])):?>
						<ul class="iconlist">
							<?foreach ($arItem['DISPLAY_PROPERTIES'] as $keyProp => $arOneProp) :?>
								<? if (in_array($keyProp, $arPropHide)) continue; ?>
								<li><i class="icon-caret-right"></i> <strong><? echo $arOneProp['NAME']; ?>: </strong>
									<?=(is_array($arOneProp['DISPLAY_VALUE'])
										? implode('<br>', $arOneProp['DISPLAY_VALUE'])
										: $arOneProp['DISPLAY_VALUE']
										);?>
								</li>
							<?endforeach;?>
						</ul>
					<?endif;?>
                </ul>

				<div class="product-price">
					<?if ($arItem["PRICES"]["PRICE"]["VALUE"] == 0 && isset($arItem["PRICES"]["PRICE"]["ID"])):?>
						<ins><?=GetMessage("CT_EL_FREE");?></ins>
		                <div class="entry-content">
		                    <a href="<?=$arParams["LINK_TO_AJAX"]?>?TYPE=ASK_PRICE&ELEMENT_CODE=<?=$arItem["CODE"]?>" data-lightbox="ajax"
		                    	class="button button-rounded button-mini noleftmargin">
		                    	<?=GetMessage("CT_EL_LI_ZABRON");?>
		                    </a>
		                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="button button-rounded button-border button-mini"><?=GetMessage("CT_EL_LI_READ_MORE");?></a>
		                </div>
					<? elseif($arItem["PRICES"]["PRICE"]["VALUE"] < 1):?>
		                <div class="entry-content">
							<a href="<?=SITE_DIR?>ajax/study.php?ELEMENT_CODE=<?=$arItem["CODE"]?>&TYPE=ASK_PRICE" data-lightbox="ajax"
								class="button button-rounded button-mini button-border noleftmargin tright">
								<span><?=GetMessage("CATALOG_ASK_FOR_PRICE")?></span>
							</a>
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="button button-rounded button-border button-mini"><?=GetMessage("CT_EL_LI_READ_MORE");?></a>
		                </div>
					<?else:?>
						<?if(isset($arItem["PRICES"]["NEW_PRICE"]["VALUE"]) && $arItem["PRICES"]["NEW_PRICE"]["VALUE"] > 0) : ?>
							<del><?=$arItem["PRICES"]["PRICE"]["VALUE"]?> <?=$elCurrency?></del>
							<ins><?=$arItem["PRICES"]["NEW_PRICE"]["VALUE"]?> <?=$elCurrency?></ins>
						<?else : ?>
							<ins><?=$arItem["PRICES"]["PRICE"]["VALUE"]?> <?=$elCurrency?></ins>
						<?endif;?>
		                <div class="entry-content">
		                    <a href="<?=SITE_DIR?>ajax/study.php?ELEMENT_CODE=<?=$arItem["CODE"]?>&TYPE=ZABRON" data-lightbox="ajax"
		                    	class="button button-rounded button-mini noleftmargin">
		                    	<?=GetMessage("CT_EL_LI_ZABRON");?>
		                    </a>
		                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="button button-rounded button-border button-mini"><?=GetMessage("CT_EL_LI_READ_MORE");?></a>
		                </div>
					<?endif;?>
				</div>

            </div>
        </div>
    <?$tmpRowsInCol = ceil(count($arResult["ITEMS"]) / 2) ?>
    <?= (($key + 1) % $tmpRowsInCol == 0 && ($key + 1) !== count($arResult["ITEMS"])) ? '</div><div class="col_half col_last nobottommargin">' : '' ?>
<? endforeach; ?>

    </div>
</div>

<div class="clear"></div>