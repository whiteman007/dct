<?
if(main != "true"){
die("Access Denied");
}
$qc=mysqli_query2("select * from page where id='".$_GET["pid"]."'");
$rc = mysqli_fetch_array($qc);

$param = strip_tags($_GET["param"]);
if($param !=""){
    $query =" and (name_en like '%".$param."%' or text_en like '%".$param."%' ) ";
}else{
    $query = " and parent_id = '".$rc["id"]."' ";
}


$qsub = mysqli_query2("select * from page where 1=1   $query");
?>

<table style="width: 95% !important;" cellpadding="0" cellspacing="0">

<tbody><tr>
    <td>&nbsp;</td>
</tr>
<tr>
<td>
<table style="width: 100%" cellpadding="0" cellspacing="0">

<tbody><tr>
    <td class="bgHeaderPaginagan">
        <table style="width: 100%" cellpadding="0" cellspacing="0" class="style1">
            <tbody>

            <tr <?=$param !="" ? 'style="display:none"' : '' ?>>
                <td style="width: 17px">
                    <img alt="" src="images/arrow_catogory.jpg" width="21" height="39"></td>
                <td>&nbsp;Category Type:<a href="index.php?type=category&pid=<?=$_GET['pid']?>"><?=$rc["name_en"]?></a></td>

            </tr>
            </tbody></table>
    </td>
</tr>
<tr>
<td>
<table style="width: 100%" cellpadding="0" cellspacing="0">

<tbody>
<?
$i=0;
while($rsub = mysqli_fetch_array($qsub)){
    $i++;
    if(fmod($i,2) == 0){
        $class= "fristRowCatgory";
    }else{
        $class= "scondRowCatgory";
    }
?>
    <tr>
        <td class="<?=$class?>">    <a href="index.php?type=page&pid=<?=$rsub['id']?>" class="course_listing_li_develop"><?=$rsub["name_en"]?></a>
        </td>
    </tr>
<?
}
?>






</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>