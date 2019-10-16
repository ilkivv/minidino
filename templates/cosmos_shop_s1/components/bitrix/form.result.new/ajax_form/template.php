<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="single-product shop-quick-view-ajax clearfix">
<?if ($arResult["isFormNote"] == "Y"): ?>
    <div class="product modal-padding clearfix">
        <i class="icon-ok-sign"></i> <?=$arResult["FORM_NOTE"]?>
    </div>
<?endif;?>
<?if ($arResult["isFormNote"] != "Y")
{
?>
    <?if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y"):?>
        <div class="ajax-modal-title">
        <?
        /***********************************************************************************
                            form header
        ***********************************************************************************/
            if ($arResult["isFormTitle"])
            {
            ?>
                <h2><?=$arResult["FORM_TITLE"]?></h2>
            <?
            } //endif ;

            if ($arResult["isFormImage"] == "Y")
            {
            ?>
                <a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
            <?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
            <?
            } //endif
            ?>

            <span><?=$arResult["FORM_DESCRIPTION"]?></span>
        </div>
    <?endif;?>
    <div class="product modal-padding clearfix">
        <?if ($arResult["isFormErrors"] == "Y"):?>
            <div class="style-msg2 errormsg">
                <div class="sb-msg">
                <?=$arResult["FORM_ERRORS_TEXT"];?>
                </div>
            </div>
        <?endif;?>
        <?=$arResult["FORM_HEADER"]?>
    <?
    /***********************************************************************************
                            form questions
    ***********************************************************************************/
        foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) :
            if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
            {
                echo $arQuestion["HTML_CODE"];
            }
            else
            {
        ?>
            <div class="col_full input-required">
                <?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
                <span class="error-fld" title="<?=$arResult["FORM_ERRORS"][$FIELD_SID]?>"></span>
                <?endif;?>
                <label><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?> <small><?=$arResult["REQUIRED_SIGN"];?></small><?endif;?></label>
                <?=$arQuestion["HTML_CODE"]?>
                <?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>
            </div>
        <?
            }
        endforeach;
        ?>


        <?
        if($arResult["isUseCaptcha"] == "Y")
        {
        ?>
            <label><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b> <?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></label>
            <div class="col_half input-required">
                <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
            </div>
            <div class="col_half col_last input-required">
                <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
            </div>
        <?
        } // isUseCaptcha
        ?>
        <div class="col_full">
            <button <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?>  class="button button-3d button-large btn-block nomargin" type="submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>"><?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?></button>
            <input type="hidden" name="web_form_apply" value="Y" />
        </div>
        <p>
        <?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
        </p>
        <?=$arResult["FORM_FOOTER"]?>
    </div>
    <script type="text/javascript">
        $('[name="<?=$arResult["WEB_FORM_NAME"]?>"] input, [name="<?=$arResult["WEB_FORM_NAME"]?>"] select, [name="<?=$arResult["WEB_FORM_NAME"]?>"] textarea').addClass('sm-form-control');
        $('[name="<?=$arResult["WEB_FORM_NAME"]?>"] .input-required input').addClass('required');
        $('[name="<?=$arResult["WEB_FORM_NAME"]?>"]').submit(function() {
            $(this).closest('.mfp-container.mfp-ajax-holder').removeClass('mfp-s-ready').addClass('mfp-s-loading');
            $(this).closest('.single-product.shop-quick-view-ajax').remove();
            var url = "<?=$APPLICATION->GetCurPage();?>"; // the script where you handle the form input.
            $.ajax({
                    type: "POST",
                    url: url,
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    //data: $('[name="<?=$arResult["WEB_FORM_NAME"]?>"]').serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                         $.magnificPopup.open({
                           items: {
                             src: data, // can be a HTML string, jQuery object, or CSS selector
                             type: 'inline'
                           }
                         });
                         $('font.errortext').removeClass('errortext');
                    }
                });
            return false; // avoid to execute the actual submit of the form.
        });
    </script>
<?
} //endif (isFormNote)
?>
</div>