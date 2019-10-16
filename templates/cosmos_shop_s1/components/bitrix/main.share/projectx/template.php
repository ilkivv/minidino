<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$this->setFrameMode(true);
if (strlen($arResult["PAGE_URL"]) > 0)
{
	?>

<div class="noborder tright clearfix">
    <span class="rightmargin-sm"><?=GetMessage('MS_MD_SHARE')?></span>
    <div class="fright">
        <noindex>
            <script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
            <script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
            <div class="ya-share2" data-services="vkontakte,facebook,twitter,viber,whatsapp,odnoklassniki,moimir"></div>           
        </noindex>
    </div>
</div>
    <?
}
else
{
	?><?=GetMessage("SHARE_ERROR_EMPTY_SERVER")?><?
}
?>