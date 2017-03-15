$(document).ready(function(){
	$(".defer .checkbox").change(function(){
		$('#basket_form').submit();
	});
	$(".del .checkbox").change(function(){
		$('#basket_form').submit();
	});
	$(".count .text_input").change(function(){
		$('#basket_form').submit();
	});

    $('#clearButton3').click(function(e){
        e.preventDefault();
        $.get(
            '/tools/clearbasket.php?fuser='+$(this).attr('data-user'),
            '',
            function(){
                location.href = "/personal/cart/";
            });
    })

    $('#basketClearButton2').fancybox({
        padding: 0
    });
});