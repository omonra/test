<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? if (!defined("NO_NAVIGATION") || !defined("NO_WRAPPER")): ?>
</div>
<? endif; ?>

<script>
var params = {
        timeout: "20",
        enabled: true,
        callback: function (){
            BXMobileApp.UI.Page.reload();
        }, 
        pullText: "��������, ����� �������������",
        releaseText: "��������� ����� ��������",
        loadText: "��������..."
        };
BXMobileApp.UI.Page.Refresh.setParams(params);
</script>


</body>
</html>