<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== TRUE) die(); ?>
<? $this->setFrameMode(TRUE);
if (count($arResult["ITEMS"]) < 1) return;
$uniqId = $this->randString(6);
?>
<!-- Related Portfolio Items
============================================= -->
<h4><?= GetMessage('NL_MD_RELATED') . ' ' . $arResult["NAME"] ?>:</h4>

<div class="related-posts clearfix">
	<? foreach ($arResult["ITEMS"] as $keyItem => $arItem): ?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="col_half <?= (($keyItem + 1) % 2 == 0) ? ' col_last' : '' ?>">
			<div class="mpost clearfix" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
				<div class="entry-image">
					<a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
						<img src="<?= $arItem["PREVIEW_PICTURE_RESIZED"]["SRC"] ?>" alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"></a>
				</div>
				<div class="entry-c">
					<div class="entry-title">
						<h4><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?= $arItem["NAME"] ?></a></h4>
					</div>
					<?if($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"] && strlen($arItem["DISPLAY_ACTIVE_FROM"]) > 0):?>
						<ul class="entry-meta clearfix">
							<li><i class="icon-calendar3"></i> <?= $arItem["DISPLAY_ACTIVE_FROM"] ?></li>
						</ul>
					<?endif;?>
				</div>
			</div>
		</div>
	<? endforeach; ?>
</div>