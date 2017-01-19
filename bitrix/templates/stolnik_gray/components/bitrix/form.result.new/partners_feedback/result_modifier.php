<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


$parts = explode('<input', $arResult['FORM_HEADER']);
unset($parts[0]);
$sid = $arResult['arForm']['SID'];
$arResult['FORM_HEADER'] = '<form class="form form_' . $sid . '" name="' . $sid . '" action="" method="POST" enctype="multipart/form-data"><input' . implode('<input', $parts);

