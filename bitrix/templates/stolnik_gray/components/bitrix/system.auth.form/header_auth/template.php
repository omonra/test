<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult["FORM_TYPE"] == "login"):?>
    <a href="#registration" class="register jsform">Регистрация</a>
    <a href="#login" class="enter jsform">Войти</a>
<?else:?>
    <a class="enter" href="/?logout=yes">Выход</a>
    <a class="enter" href="/personal/order/cart/">Мои заказы</a>
    <a class="enter" href="/personal/">Профиль</a>
<?endif;?>

<script>
	$(document).ready(function(){
		$('#login').click(function(){
			$('#popup-base-in').load('/login/ .auth_block');
			$('#popup-base').show();
		});
		$('#register').click(function(){
			$('#popup-base-in').load('/login/?register=yes .reg_block');
			$('#popup-base').show();
		});
		$('#phone').click(function(){
			$('#popup-base-in').load('/zakazat-zvonok.php .call-phone');
			$('#popup-base').show();
		});
		$('#popup-base .close').click(function(){
			$('#popup-base').hide();
		});
	});
</script>
