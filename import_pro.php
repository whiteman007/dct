<?
include "cookie.php";
if ($_POST["act"]=="add"){
    set_time_limit (6000);
         $file_name_1 = $_FILES['file_1']['name'];
         $file_temp_1 = $_FILES['file_1']['tmp_name'];
		 
	        if ( !preg_match("/csv$/",$file_name_1)){
				header("location:process.php?err=26");
				exit;						
             }else{			 
				 $pic_1= rand(1,10000000)."_".$file_name_1;
////////////////////////////////////////////////////////////////////////				 
				$ar = file($file_temp_1);
                $seperator = ";";
				$arrc = explode($seperator,$ar[0]);
                if(sizeof($arrc) < 6){
                    $seperator = ",";
                    $arrc = explode($seperator,$ar[0]);

                    if(sizeof($arrc) < 6){
                        header("location:process.php?err=18");
                        exit;
                    }
				}
				//$q = mysqli_query2("delete from category") or die("can't delete");
                $i =0;
                $q_del = mysqli_query2("TRUNCATE TABLE  company_details");
				foreach($ar as $key => $val){
                    $i ++;
                    if($i == 1){
                        continue;
                    }
					$arr_1 = explode( $seperator,$val);
					if (is_array($arr_1)){
                        $col = $arr_1;
                        $email = iconv("windows-1256","utf-8",$col[0]);
                        $fax = iconv("windows-1256","utf-8",$col[1]);
                        $phone = iconv("windows-1256","utf-8",$col[2]);
                        $mobile = iconv("windows-1256","utf-8",$col[3]);
                        $industry = iconv("windows-1256","utf-8",$col[4]);
                        $product = iconv("windows-1256","utf-8",$col[5]);
                        $name = iconv("windows-1256","utf-8",$col[6]);
                        if($name !=""){
                            $query = mysqli_query2("insert into company_details (`name`,`email`,`fax`,`phone`, `mobile`,`industry`,`product`) values('".$name."','".$email."','".$fax."', '".$phone."', '".$mobile."','".$industry."','".$product."')") ;
                        }
					}
				}
			}

			header("location:process.php?status=17");
			exit;	
//////////////////////////////////////////////////////////////////////////////				 
                 }

include "head.php";
include "navigation.php";
?>
<form method="POST" enctype="multipart/form-data">
<table border="0" width="800" id="table1" align=center dir="rtl" class="ftab">
    <tr>
        <td>
            <table border="0" width="100%" id="table2" align="center" dir="rtl" >
                    <tr>
                        <td dir="rtl"  align="center" class="admin" colspan="2" height="40" valign="top"> استيراد المنتجات </td>
                    </tr>

                    <tr>
                        <td dir="rtl"  align="center" class="text"> الملف المستورد (CSV) : </td>
                        <td  dir="rtl" class="text" >
                            <input type="file" name="file_1" size="19" class="form1"></td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td align="right"  height="50">
                                <input name="act" type="hidden" value="add">
                                <input type="submit" value="<?=$_GET[id]==''?'استيراد':'استيراد'?>"  name="B1" class="form1">
                                <input type="button" name="button" value="عودة" class=form1 onclick="javascript:location.href='<?=$page_refer?>?pa_id=<?=$_GET["pa_id"]?>&page=<?=$_GET[page]?>&id=<?=$_GET[id]?>'"></td>
                    </tr>
            </table>
        </td></tr></table></form>
<? include"foot.php"?>