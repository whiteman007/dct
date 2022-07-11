<?
include "../admincpanel/cookie.php";
if ($_POST["act"]=="add"){
                set_time_limit (6000);
                $emails = explode("\n", str_replace("\r", "", $_POST["emails"]));
                $emails = array_filter($emails);
////////////////////////////////////////////////////////////////////////				 
                $seperator = ",";

                if( !is_array($emails)){
                        header("location:../admincpanel/process.php?err=18");
                        exit;
				}
				//$q = mysqli_query2("delete from category") or die("can't delete");
                $i =0;
                //$q_del = mysqli_query2("TRUNCATE TABLE  company_details");
				foreach($emails as $key => $val){
                    $i ++;
					$arr_1 = explode( $seperator,$val);
					if (is_array($arr_1)){
                        $col = $arr_1;
                        $email = trim(strtolower(iconv("windows-1256","utf-8",$col[0])));

                            $q = mysqli_query2("select id,email from emails where email like '".$email."'");
                            if(mysqli_affected_rows($GLOBALS["db_link"]) < 1){
                                $query = mysqli_query2("insert into emails (`email`,`sent`) values('".$email."','0')") ;
                            }

					}
				}


			header("location:../admincpanel/process.php?status=18");
			exit;	
//////////////////////////////////////////////////////////////////////////////				 
                 }

include "../admincpanel/head.php";
include "../admincpanel/navigation.php";
?>
<form method="POST" enctype="multipart/form-data">
<table border="0" width="800" id="table1" align=center dir="rtl" class="ftab">
    <tr>
        <td>
            <table border="0" width="100%" id="table2" align="center" dir="rtl" >
                    <tr>
                        <td dir="rtl"  align="center" class="admin" colspan="2" height="40" valign="top"> اضافة ايميلات
                        (كل بريد الكتروني بسطر)
                        </td>
                    </tr>

                    <tr>
                        <td  dir="rtl" class="text" colspan="2" >
                        <textarea style="direction: ltr" name="emails" rows="10" class="w3-form w3-input tahoma" required></textarea>
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td align="right"  height="50">
                                <input name="act" type="hidden" value="add">
                                <input type="submit" value="<?=$_GET[id]==''?'اضافة':'اضافة'?>"  name="B1" class="form1">
                                <input type="button" name="button" value="عودة" class=form1 onclick="javascript:location.href='<?=$page_refer?>?pa_id=<?=$_GET["pa_id"]?>&page=<?=$_GET[page]?>&id=<?=$_GET[id]?>'"></td>
                    </tr>
            </table>
        </td></tr></table></form>
<? include"../admincpanel/foot.php"?>