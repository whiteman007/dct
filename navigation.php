<div style="text-align: center; direction: <?=$dir?>;" class='nav'>
<div style="text-align: center">
 <div style="background: url('../<?=$admin_name?>/images/banner.jpg') left center; width: 100%; height: 83px"></div>
 <div style="background: #565656; width: 100%; height: 20px; direction:<?=$dir?>;   text-align:<?=$align_r?>"><a href="#"   class="nav_white"><img  src="../admincpanel/images/support.gif" style="vertical-align:middle; border:0;position: relative;top: -3px" />&nbsp;<?=$label_support?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

<div style="width: 20%; float: <?=$align?>; padding: 5px; direction: <?=$dir?>; text-align: <?=$align?>">


    <div class="menu_main">
         <a href='../<?=$admin_name?>/members.php' class='nav' style=" <?=active_nav("members.php")?>"><?=$label_home_page?> </a>  </div>
    <div class="w3-hide <?php if(!$check_admin) print 'hide'; ?> menu_main">
        <a href='../t_users/view.php' class='nav' style="  <?=active_nav("users")?>">ادارة المستخدمين</a>  </div>
    <div class="<?php print $is_content;?> menu_main">
         <a href='../pages/view.php?reset=1' class='nav' style="  <?=active_nav("pages")?>"><?=$label_content_management?></a>  </div>
    <div class="<?php print $is_content;?> menu_main">
        <a href='../members/view.php' class='nav' style="  <?=active_nav("members")?>">
            ادارة الأعضاء
        </a>  </div>
    <div class="w3-hide <?php print $is_app_poll;?> menu_main">
        <a href='../app_poll/view.php' class='nav' style="  <?=active_nav("poll")?>">
ادارة الاستطلاع
        </a>  </div>
    <div class="w3-hide <?php print $is_comments;?> menu_main">
        <a href='../<?=$admin_name?>/comments.php' class='nav' style="  <?=active_nav("comments")?>">
            ادارة التعليقات
        </a>  </div>
    <div class=" <?php print $is_mailinglist;?> menu_main">
        <a href='../mailinglist/send_create.php' class='nav' style="  <?=active_nav("mailinglist")?>"><?=$label_newsletter?> </a>  </div>
    <div class="<?php print $is_settings;?> menu_main">
         <a href='../settings/data_view.php' class='nav' style="  <?=active_nav("social")?>"><?=$label_settings?> </a>  </div>
    <div class="menu_main">
         <a href='../<?=$admin_name?>/password.php' class='nav' style=" <?=active_nav("password.php")?>"><?=$label_change_password?> </a> </div>
    <div class="menu_main">
         <a href='../<?=$admin_name?>/logout.php' class='nav'><?=$label_log_out?></a> </div>
</div>
<div style=" text-align: center; float: <?=$align?>; margin: 0 auto; direction: ltr; width: 75%; height: 100%">
<?
if(preg_match("/a_file.php/i", $_SERVER['PHP_SELF'])){
	$qqq = mysqli_query2("select * from news where id ='".$_COOKIE['a_id']."'");
	$r_qqq = mysqli_fetch_array($qqq);
	if( mysqli_affected_rows($GLOBALS["db_link"]) > 0 ){
		$tt = $r_qqq['name'];
		$the_title = "<div class='header_text'> - ".$tt." -</div>";
	}
}else{
	$the_title = "";
}
?>
<div style="text-align: center" class="admin"><?=$the_title?></div>
<p>&nbsp;</p>