<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
if (count($arResult["ITEMS"]) < 1) return;
?>
</div>
<div class="parallax bottommargin-lg light" style="padding: 60px 0; background-image: url('<?=$arParams["CALENDAR_PATH_TO_BACKGROUND"]?>'); background-repeat: repeat-y; height: auto;" data-stellar-background-ratio="0.3">

    <div class="container clearfix">

        <div class="events-calendar">
            <div class="events-calendar-header clearfix">
                <h2>Календарь мероприятий</h2>
                <h3 class="calendar-month-year">
                    <span id="calendar-month" class="calendar-month"></span>
                    <span id="calendar-year" class="calendar-year"></span>
                    <nav>
                        <span id="calendar-prev" class="calendar-prev"><i class="icon-chevron-left"></i></span>
                        <span id="calendar-next" class="calendar-next"><i class="icon-chevron-right"></i></span>
                        <span id="calendar-current" class="calendar-current" title="Got to current date"><i class="icon-reload"></i></span>
                    </nav>
                </h3>
            </div>
            <div id="calendar" class="fc-calendar-container"></div>
        </div>

        <script type="text/javascript">
            var canvasEvents = {
                <?
                $keysToPass = array();
                foreach ($arResult["ITEMS"] as $key => $arItem) :
                    if (in_array($key, $keysToPass)) continue;
                    $tmpKey = $key + 1;
                ?>
                    '<?=ConvertDateTime($arItem["DISPLAY_PROPERTIES"]["DATE_START"]["VALUE"], "MM-DD-YYYY")?>' :
                    '<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" alt="<?=$arItem["NAME"]?>"><?=$arItem["NAME"]?></a><?
                    while(
                        isset($arResult["ITEMS"][$tmpKey]) &&
                        ConvertDateTime($arResult["ITEMS"][$tmpKey]["DISPLAY_PROPERTIES"]["DATE_START"]["VALUE"], "MM-DD-YYYY") == ConvertDateTime($arItem["DISPLAY_PROPERTIES"]["DATE_START"]["VALUE"], "MM-DD-YYYY")
                        )
                    {
                        echo '<a href="' . $arResult["ITEMS"][$tmpKey]["DETAIL_PAGE_URL"] . '" alt="' . $arResult["ITEMS"][$tmpKey]["NAME"] . '">' . $arResult["ITEMS"][$tmpKey]["NAME"] . '</a>';
                        $arResult["ITEMS"][$tmpKey] = NULL;
                        $keysToPass[] = $tmpKey;
                        $tmpKey++;
                    }
                    ?>',
                <?endforeach;?>
            }

            var cal = $( '#calendar' ).calendario( {
                    onDayClick : function( $el, $contentEl, dateProperties ) {

                        for( var key in dateProperties ) {
                            console.log( key + ' = ' + dateProperties[ key ] );
                        }

                    },

                    weeks : [ <?=GetMessage('NL_CAL_WEEKS')?>],
                    months : [ <?=GetMessage('NL_CAL_MONTHS')?> ],
                    caldata : canvasEvents
                } ),
                $month = $( '#calendar-month' ).html( cal.getMonthName() ),
                $year = $( '#calendar-year' ).html( cal.getYear() );

            $( '#calendar-next' ).on( 'click', function() {
                cal.gotoNextMonth( updateMonthYear );
            } );
            $( '#calendar-prev' ).on( 'click', function() {
                cal.gotoPreviousMonth( updateMonthYear );
            } );
            $( '#calendar-current' ).on( 'click', function() {
                cal.gotoNow( updateMonthYear );
            } );

            function updateMonthYear() {
                $month.html( cal.getMonthName() );
                $year.html( cal.getYear() );
            }

        </script>

    </div>

</div>
<div class="container clearfix">

<?
return;
?>

<?if ($arParams["FEATURE_BOX_ICONS"] == "Y") {
    $elementClass = $arParams["FEATURE_BOX_CLASS"] . ' ' . $arParams["FEATURE_BOX_COLOR"] . ' ' . $arParams["FEATURE_BOX_BORDER"];
    if ($arParams["FEATURE_BOX_EFFECT"] == "Y" && !stripos($elementClass, "fbox-plain") > 0) {
        $elementClass .= " " . "fbox-effect";
    }
} else {
    $elementClass = 'fbox-plain' . ' ' . $arParams["FEATURE_BOX_CLASS"];
}
?>
<? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

    ?>
    <div class="col_one_third <?= (($key + 1) % 3 == 0) ? 'col_last' : '' ?>">
        <div class="feature-box <?=$elementClass?>" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <? if ($arParams["FEATURE_BOX_ICONS"] == "Y" &&
                isset($arItem["DISPLAY_PROPERTIES"]["ICON"]["DISPLAY_VALUE"])
                && strlen($arItem["DISPLAY_PROPERTIES"]["ICON"]["DISPLAY_VALUE"]) > 0
            ):
                ?>
                <div class="fbox-icon bounceIn animated" data-animate="bounceIn" data-delay="800">
                    <a href="<?= $arItem["DISPLAY_PROPERTIES"]["LINK"]["DISPLAY_VALUE"] ?>">
                        <i class="<?= $arItem["DISPLAY_PROPERTIES"]["ICON"]["DISPLAY_VALUE"] ?> i-alt"></i>
                    </a>
                </div>
            <? else: ?>
                <div class="fbox-icon bounceIn animated">
                    <a href="<?= $arItem["DISPLAY_PROPERTIES"]["LINK"]["DISPLAY_VALUE"] ?>">
                        <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>">
                    </a>
                </div>
            <? endif; ?>
            <h3>
                <a href="<?= $arItem["DISPLAY_PROPERTIES"]["LINK"]["DISPLAY_VALUE"] ?>">
                    <?= $arItem["NAME"] ?>
                </a>
            </h3>

            <p><?= $arItem["PREVIEW_TEXT"] ?></p>
        </div>
    </div>
    <?= (($key + 1) % 3 == 0) ? '<div class="clear"></div>' : '' ?>
<? endforeach; ?>
