<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

$arViewStyles = array(
	'TILE' => array(
		'COL_SIZE' => 'col_half',
		'TRUNCATE' => true,
		),
	'LIST' => array(
		'COL_SIZE' => 'col_full',
		'TRUNCATE' => false,
		),
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];
$arCurView["TRUNCATE"] = true;

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>
<?if ($arParams["SL_USE_TITLE"] == "Y") :?>
	<div class="heading-block center">
		<h3><?=$arParams["TITLE_TEXT"]?></h3>
		<span><?=$arParams["UNDER_TITLE_TEXT"]?></span>
	</div>
<?endif;?>

<?if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID'])
{
    $this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
    ?>
    <div class="fancy-title title-border">
        <h2 id="<? echo $this->GetEditAreaId($arResult['SECTION']['ID']); ?>">
            <?
            echo (
            isset($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
                ? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
                : $arResult['SECTION']['NAME']
            );
            ?>
        </h2>
    </div>
<?}?>


<?
if (0 < $arResult["SECTIONS_COUNT"])
{
?><div class="col_full catalog__list bottommargin-sm">

<div class="col_one_fourth catalog__item catalog-item bottommargin-sm " id="bx_novelty">
	<div class="feature-box catalog-item__inner center media-box fbox-bg">
		<div class="fbox-media md-catalog-section catalog-item__link-image-wrapper">
			<a class="catalog-item__link" href="/catalog/novelty/" title="Новинки">
				<img class="catalog-item__image image_fade thumbnail nobottommargin nopadding" src="<?=$arResult['NOVELTY']['PICTURE']['SRC']?>" title="Новинки" alt="novelty" style="opacity: 1;">
			</a>
		</div>
		<div class="fbox-desc catalog-item__description">
			<h3 class="nott"><a href="/catalog/novelty/" title="Новинки">Новинки</a></h3>
								</div>
	</div>
</div>

<?
	$sectionCounter = 1;
	foreach ($arResult['SECTIONS'] as $keySection => &$arSection)
	{
		$sectionCounter++;
		if ($sectionCounter >$arParams['LIMIT'] && $arParams['LIMIT'] >0) break;
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
		if (false === $arSection['PICTURE'])
			$arSection['PICTURE'] = array(
				'ALT' => (
				'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
					? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
					: $arSection["NAME"]
				),
				'TITLE' => (
				'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
					? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
					: $arSection["NAME"]
				)
			);

		$sectionsInLine = 4;
		?>
		<?if ($arParams['VIEW_MODE'] == "BLOCK") :?>
			<div class="col_one_fourth catalog__item catalog-item bottommargin-sm <?=($sectionCounter%$sectionsInLine) ? '':'  col_last' ?>" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
				<div class="feature-box catalog-item__inner center media-box fbox-bg">
					<div class="fbox-media md-catalog-section catalog-item__link-image-wrapper">
						<a class="catalog-item__link" href="<?=$arSection['SECTION_PAGE_URL']; ?>" title="<?=$arSection['PICTURE']['TITLE']; ?>">
							<?if (isset($arSection['PICTURE']["SRC"])):?>
								<img class="catalog-item__image image_fade thumbnail nobottommargin nopadding" src="<?=$arSection['PICTURE']['SRC'];?>"
									 title="<?=$arSection['PICTURE']['TITLE']; ?>" alt="<?=$arSection['PICTURE']['ALT']; ?>">
							<?else:?>
								<img class="catalog-item__image image_fade thumbnail nobottommargin" src="<?=$this->GetFolder(). '/images/nophoto.png';?>"
									 title="<?=$arSection['NAME']; ?>" alt="<?=$arSection['NAME']; ?>">
							<?endif;?>
						</a>
					</div>
					<div class="fbox-desc catalog-item__description">
						<h3 class="nott"><a href="<?=$arSection['SECTION_PAGE_URL']; ?>" title="<?=$arSection['PICTURE']['TITLE']; ?>"><?=$arSection['NAME'];?></a></h3>
						<?
						// hide it temporta
						if (false && isset($arSection["DESCRIPTION"]) && strlen($arSection["DESCRIPTION"]) > 0):?>
							<span class="subtitle">
								<?
								if ($arCurView["TRUNCATE"]) {
									echo TruncateText($arSection["DESCRIPTION"], $arParams["TRUNCATE_DESCRIPTION"]);
								} else {
									echo $arSection["DESCRIPTION"];
								}
								?>
							</span>
						<?endif;?>
					</div>
				</div>
			</div>
			<?=($sectionCounter%$sectionsInLine) ? '':'<div class="clearfix"></div>' ?>
		<?else:?>
			<div class="<?=$arCurView["COL_SIZE"]?><?=($sectionCounter%2) ? '':'  col_last' ?>">
				<div class="feature-box fbox-large fbox-rounded fbox-effect fbox-light" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
					<div class="fbox-icon">
						<a href="<?=$arSection['SECTION_PAGE_URL']; ?>" title="<?=$arSection['PICTURE']['TITLE']; ?>">
							<?if (isset($arSection['PICTURE']["SRC"])):?>
								<img src="<?=$arSection['PICTURE']['SRC'];?>" title="<?=$arSection['PICTURE']['TITLE']; ?>" alt="<?=$arSection['PICTURE']['ALT']; ?>">
							<?else:?>
								<i class="icon-line-image"></i>
							<?endif;?>
						</a>
					</div>
					<h3 class="nott"><a href="<?=$arSection['SECTION_PAGE_URL']; ?>"><?=$arSection['NAME'];?>
							<?if ($arParams["COUNT_ELEMENTS"]) echo '(' . $arSection['ELEMENT_CNT'] . ')' ?></a>
					</h3>
					<?$keySection++;?>
					<?if (isset($arResult['SECTIONS'][$keySection]["RELATIVE_DEPTH_LEVEL"]) && $arResult['SECTIONS'][$keySection]["RELATIVE_DEPTH_LEVEL"] != 1):?>
						<p>
							<?while(isset($arResult['SECTIONS'][$keySection]["RELATIVE_DEPTH_LEVEL"]) && $arResult['SECTIONS'][$keySection]["RELATIVE_DEPTH_LEVEL"] != 1):?>
								<a class="btn btn-default btn-xs" href="<?=$arResult['SECTIONS'][$keySection]["SECTION_PAGE_URL"]?>">
									<?=$arResult['SECTIONS'][$keySection]["NAME"]?></a>
								<?
								unset($arResult['SECTIONS'][$keySection]);
								$keySection++;
								?>
							<?endwhile;?>
						</p>
					<?endif;?>
					<p><?
						if ($arCurView["TRUNCATE"]) {
							echo TruncateText($arSection["DESCRIPTION"], $arParams["TRUNCATE_DESCRIPTION"]);
						} else {
							echo $arSection["DESCRIPTION"];
						}
						?>&nbsp;
					</p>
				</div>
			</div>
		<?endif;?>
		<?//=($sectionCounter%2) ? '':'<div class="divider"><i class="icon-circle"></i></div>' ?>
		<?
	}
	//echo ($sectionCounter%3) ? '':'<div class="divider"><i class="icon-circle"></i></div>';
	?></div><?
}
?>
<div class="clear"></div>