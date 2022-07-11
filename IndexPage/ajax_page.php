<?
include "../../logs/function.php";
$pid = intval($_POST["pid"]);
$ext = $_POST["ext"];
if($ext == "_en"){
    $align= "left";
    $dir = "ltr";
    $label_more = "More ...";
}else{
    $align= "right";
    $dir = "rtl";
    $label_more = "المزيد ...";
}
$sp1 = mysqli_query2("select * from page where id = '".$pid."'");
while($rp1 = @mysqli_fetch_array($sp1)){
    $type_page = $rp1["type_page"];
    if($type_page == ""){$type_page = "page";}
    if($type_page != "" and $type_page !="page"){$pid_page = "";}else{$pid_page = "&pid=".$rp1['id'];}
    if($rp1["ext_link"] !=""){
        $link_page = $rp1["ext_link"];
        if($ext_page == "_ar"){
            $link_page = str_replace("index.php","index_ar.php",$link_page);
        }
    }else{
        $link_page = "index".$ext_page.".php?type=".$type_page.$pid_page;
    }
    if($rp1["src"] !=""){


?>
    <div style="width: 100%; overflow: hidden; height: 360px;background: url('pages/photos/<?=$rp1[src]?>') no-repeat"></div>

<?
    }
}