<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$this->setFrameMode(true);
if(count($arResult["SECTIONS"]) < 1) return;
$uniquerId = $this->randString(6);
?>
<div id="side-navigation-<?=$uniquerId?>">
        <div class="col_one_third nobottommargin">
            <ul class="sidenav">
<?foreach($arResult["SECTIONS"] as $keySection => $arSection):
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));?>
        <?if ($keySection == 0) : ?>
            <li class="ui-tabs-active" id="<?=$this->GetEditAreaId($arSection['ID']);?>"><a href="#snav-content-<?=$uniquerId?>-<?=$keySection?>"><?=$arSection["NAME"]?><i class="icon-chevron-right"></i></a></li>
        <?else:?>
            <li id="<?=$this->GetEditAreaId($arSection['ID']);?>"><a href="#snav-content-<?=$uniquerId?>-<?=$keySection?>"><?=$arSection["NAME"]?><i class="icon-chevron-right"></i></a></li>
        <?endif;?>
<?endforeach;?>
            </ul>
        </div>
    <div class="col_two_third col_last nobottommargin">
        <?foreach($arResult["SECTIONS"] as $keySection => $arSection):?>
            <div id="snav-content-<?=$uniquerId?>-<?=$keySection?>">
                <div class="fancy-title">
                    <h3><?=$arSection["NAME"]?></h3>
                </div>
                <img src="<?=$arSection["PICTURE"]["SRC"]?>" alt="<?=$arSection["PICTURE"]["ALT"]?>" title="<?=$arSection["PICTURE"]["TITLE"]?>" class="alignleft" style="max-width: 320px;">
                <?=$arSection["DESCRIPTION"]?>
            </div>
        <?endforeach;?>
    </div>
</div>
<script>
  $(function() {
    $( "#side-navigation-<?=$uniquerId?>" ).tabs({ show: { effect: "fade", duration: 400 } });
  });
</script>