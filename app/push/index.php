<?php

define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (!$USER->IsAdmin())
    die('');

if (!CModule::IncludeModule("pull"))
    die('�� ���������� ������ pull');

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
            "USER_ID" => $arPull['USER_ID'], //������������� ������������
            "TITLE" => $_POST['title'], //���������, ������ ��� Android
            "APP_ID" => BX_APP_NAME, //������������� ����������
            "MESSAGE" => $_POST['message'],
            "EXPIRY" => 0, //����� ����� ����������� �� ������� Apple � Google
            "PARAMS"=>array("PARAMS" => $arParams),
            "BADGE" => 1 //������� �� ������ ����������
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
<p style="color: green;">Push ����������� ������� ����������</p>
<? endif; ?>
<form method="post">
    <h1>��������� push �����������</h1>
    <div>
        <label>���� ����������? *</label>
        <select name="to" required="required">
            <option>* ������� *</option>
            <option value="all">���� ������������� ���������� ����������</option>
            <option value="auth">���� �������������� �������������</option>
            <option value="anonymous">���� ��������� �������������</option>
        </select>
    </div>
    <div>
        <label>��������� (������ ��� Android) *</label>
        <input name="title" required="required" type="text" />
    </div>
    
    <div>
        <label>����� ��������� *</label>
        <textarea name="message" required="required"></textarea>
    </div>
    
    <div>
        <label>�������� � ���������� ����� �������� �����������</label>
        <input name="open_page" type="text" />
    </div>
    
    
    <button type="submit">���������</button>
    <br/>
    <br/>
    <br/>
    <label><input name="agree" value="y" type="checkbox" /> � 10 ��� �������� ��������� � ����� �����������, � �������, ��� �������� �������� ����� ����������</label>
    
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