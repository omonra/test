<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>

<?if($arParams["~CURRENT_SERVICE"] <> ''):?>
<script type="text/javascript">
    BX.ready(function(){BxShowAuthService('<?=CUtil::JSEscape($arParams["~CURRENT_SERVICE"])?>', '<?=$arParams["~SUFFIX"]?>')});
</script>
<?endif?>
<div class="soc_auth">
    <p>или авторизируйтесь с помощью предлагаемых сервисов</p>

    <form method="post" name="bx_auth_services<?=$arParams["SUFFIX"]?>" target="_top" action="<?=$arParams["AUTH_URL"]?>">
        <ul>
            <?foreach($arParams["~AUTH_SERVICES"] as $service):?>
            <? $a=strpos($service["FORM_HTML"],'</a>');?>
            <li><?=substr($service["FORM_HTML"],0,$a+4);?></li>
            <?endforeach?>
        </ul>
        <?foreach($arParams["~POST"] as $key => $value):?>
        <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
        <?endforeach?>
        <input type="hidden" name="auth_service_id" value="" />
    </form>
</div>
