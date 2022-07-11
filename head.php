<?
include "languages/ar.php";
if(!preg_match("/users.php|confirm|process|sort.php/",$_SERVER['PHP_SELF'])){
@setcookie("filter_search","");
}
$admin_name = "admincpanel";
include "../plugins/ckeditor/ckeditor.php";
?>
<!DOCTYPE>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../admincpanel/style<?=$ext?>.css">
<link rel="stylesheet" type="text/css" href="../plugins/w3c/w3.css">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<title><?=$label_title?></title>
<script language="javascript" src="../logs/js.js"></script>
<script language="javascript" src="../admincpanel/table.js"></script>
<link rel="stylesheet" type="text/css" href="../plugins/jquery/jquery-ui.css">
<script src="../plugins/jquery/jquery.js"></script>
<script src="../plugins/jquery/jquery-ui.js"></script>
<script src="../plugins/jquery/jquery.corner.js"></script>

<script language="javascript">
$(document).ready(function(){
        $("#tabs").tabs({
            height:"300px"
        });
		$(".header_text").corner("8px");
        $(".menu_main").hover(
             function(){$(this).css("border-bottom","2px solid #e40613");},
             function(){$(this).css("border-bottom","2px solid #565656");})

	})

</script>
    <!--  TINY MICE  -->
    <script type="text/javascript" src="../plugins/jscripts/tiny_mce/tiny_mce.js"></script>
</head>
<body>

