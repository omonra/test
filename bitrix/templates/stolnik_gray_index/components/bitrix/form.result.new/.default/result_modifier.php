<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


$parts = explode('<input', $arResult['FORM_HEADER']);
unset($parts[0]);
$sid = $arResult['arForm']['SID'];
$arResult['FORM_HEADER'] = '<form class="form form_' . $sid . '" name="' . $sid . '" action="/ajax/form.php?form_name=' . $sid .'" method="POST" enctype="multipart/form-data" onsubmit="return stolnik.AjaxFormSubmit(this, \'ajax_form_container_' . $sid . '\')" target="_top"><input' . implode('<input', $parts);

