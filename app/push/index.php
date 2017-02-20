<?php

define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (!$USER->IsAdmin())
    die('');

if (!CModule::IncludeModule("pull"))
    die('Не установлен модуль pull');

    echo "<pre>";
    //print_r($_POST);
    
if ($_POST['agree'] == 'y' && !empty($_POST['to']))
{
    $arFilter = Array (
        'APP_ID' => BX_APP_NAME
    );
    
    
    
    if ($_POST['to'] == 'auth')
    {
        $arFilter['!USER_ID'] = BX_ANONYMOUS_USER_ID;
    }
    elseif ($_POST['to'] == 'anonymous')
    {
        $arFilter['USER_ID'] = BX_ANONYMOUS_USER_ID;
    }
    $arMessages = Array ();
    $arParams = Array ();
    
    if (!empty($_POST['open_page']))
        $arParams['open_page'] = $_POST['open_page'];
    
    $rsPull = CPullPush::GetList(Array(), $arFilter);
    while ($arPull = $rsPull->fetch())
    {
        $arMessage = Array (
            "USER_ID" => $arPull['USER_ID'], //Идентификатор пользователя
            "TITLE" => $_POST['title'], //заголовок, только для Android
            "APP_ID" => BX_APP_NAME, //Идентификатор приложения
            "MESSAGE" => $_POST['message'],
            "EXPIRY" => 0, //время жизни уведомления на сервере Apple и Google
            "PARAMS"=>array("PARAMS" => $arParams),
            "BADGE" => 1 //счетчик на иконке приложения
        );
        $arMessages[] = $arMessage;
        
            
    }
    
    $manager = new CPushManager();
    $res = $manager->SendMessage($arMessages);
    if ($res)
        LocalRedirect($APPLICATION->GetCurPageParam('success=y'));
    
}
echo "</pre>";
?>
<? if ($_REQUEST['success'] == 'y'): ?>
<p style="color: green;">Push уведомления успешно отправлены</p>
<? endif; ?>
<form method="post">
    <h1>Отправить push уведомление</h1>
    <div>
        <label>Кому отправляем? *</label>
        <select name="to" required="required">
            <option>* Выбрать *</option>
            <option value="all">Всем пользователям мобильного приложения</option>
            <option value="auth">Всем авторизованным пользователям</option>
            <option value="anonymous">Всем анонимным пользователям</option>
        </select>
    </div>
    <div>
        <label>Заголовок (только для Android) *</label>
        <input name="title" required="required" type="text" />
    </div>
    
    <div>
        <label>Текст сообщения *</label>
        <textarea name="message" required="required"></textarea>
    </div>
    
    <div>
        <label>Страница в приложении после открытия уведомления</label>
        <input name="open_page" type="text" />
    </div>
    
    
    <button type="submit">Отправить</button>
    <br/>
    <br/>
    <br/>
    <label><input name="agree" value="y" type="checkbox" /> Я 10 раз проверил заголовок и текст уведомления, и понимаю, что обратить отправку будет НЕВОЗМОЖНО</label>
    
</form>

<style>
    * {
        font-family: Arial;
    }
    
    form > div {
        margin-bottom: 10px;
    }
    
    form label {
        display: block;
    }
    
    form input[type=text], form textarea, form select {
        border: 1px solid #ccc;
        padding: 4px 10px;
        width: 500px;
        display: block;
        font-size: 13px;
        color: #333;
    }
</style>