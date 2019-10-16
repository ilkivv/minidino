<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use \Bitrix\Main\Localization\Loc;
?>

		<?
			$frame = $this->createFrame("login-line", false)->begin();
			if ($arResult["FORM_TYPE"] == "login")
			{
		?>
		
		<li class="user-menu__login">
			<a title="Войти" href="<?=$arParams["REGISTER_URL"]?>"><?=GetMessage("AUTH_LOGIN_BUTTON")?></a>
		    <div class="top-link-section">
				<form id="top-login" role="form" name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
					<?if($arResult["BACKURL"] <> ''):?>
						<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
					<?endif?>
					
					<?foreach ($arResult["POST"] as $key => $value):?>
						<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
					<?endforeach?>
					
					<input type="hidden" name="AUTH_FORM" value="Y" />
					<input type="hidden" name="TYPE" value="AUTH" />

		            <div class="input-group" id="top-login-username">
		                <span class="input-group-addon"><i class="icon-user"></i></span>
						<input type="text" name="USER_LOGIN" value="<?=$arResult["USER_LOGIN"]?>" class="form-control" placeholder="<?=Loc::getMessage("AUTH_LOGIN");?>"/></td>
		            </div>
		            
		            <div class="input-group" id="top-login-password">
		                <span class="input-group-addon"><i class="icon-key"></i></span>
						<input type="password" name="USER_PASSWORD" class="form-control" placeholder="<?=Loc::getMessage("AUTH_PASSWORD");?>" />
		            </div>
					
					<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
			            <label class="checkbox">
			              	<input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y"> <?=GetMessage("AUTH_REMEMBER_ME")?>
			            </label>
					<?endif?>
		            
		            <button class="btn btn-danger btn-block btn-login" type="submit"><?=GetMessage("AUTH_LOGIN_BUTTON")?></button>
		            <a class="btn btn-danger btn-block btn-registration" href="/auth/?register=yes&backurl=%2F>" title="Зарегистрироваться">Регистрация</a>
		        </form>
		    </div>
		</li>

		
	<?
	}
	else
	{
		$name = trim($USER->GetFullName());
		if (strlen($name) <= 0)
			$name = $USER->GetLogin();
	?>
		<li class="user-menu__profile">
			<a href="<?=$arResult['PROFILE_URL']?>" title="Профиль"><?=GetMessage("AUTH_PROFILE")?></a>
		</li>

		
		<li class="user-menu__logout">
			<a href="<?=$APPLICATION->GetCurPageParam("logout=yes", Array("logout"))?>" title="Выйти"><?=GetMessage("AUTH_LOGOUT")?></a>
		</li>
	<?
	}
$frame->beginStub();

$frame->end();
?>
