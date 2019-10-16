<?
define("NO_KEEP_STATISTIC", true);
define('NO_AGENT_CHECK', true);
define("NO_AGENT_STATISTIC", true);

if (!isset($_POST['siteId']) || !is_string($_POST['siteId']))
    die();

if ($_SERVER['REQUEST_METHOD'] != 'POST' ||
    preg_match('/^[A-Za-z0-9_]{2}$/', $_POST['siteId']) !== 1)
    die;

define('SITE_ID', $_POST['siteId']);

global $APPLICATION;

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Application;
$request = Application::getInstance()->getContext()->getRequest();  

if ($_SERVER["REQUEST_METHOD"] == "POST" && check_bitrix_sessid())
{
    $arPostParams = $request->getPost("arParams");

    $APPLICATION->IncludeComponent(
        "bitrix:sale.basket.basket.small",
        "cosmos",
        array(
            "PATH_TO_BASKET" => htmlspecialchars($arPostParams["PATH_TO_BASKET"]),
            "PATH_TO_ORDER" => htmlspecialchars($arPostParams["PATH_TO_ORDER"]),
            "SHOW_DELAY" => htmlspecialchars($arPostParams["SHOW_DELAY"]),
            "SHOW_NOTAVAIL" => htmlspecialchars($arPostParams["SHOW_NOTAVAIL"]),
            "SHOW_SUBSCRIBE" => htmlspecialchars($arPostParams["SHOW_SUBSCRIBE"]),
        ),
        false
    );
    die();
}