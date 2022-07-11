<?
if ($_POST["reg"]=="add-123-876"){
         if (!trim($_POST["name"]) == "" && !trim($_POST["pass"]) == "" && !trim($_POST["email"]) == ""  && $_POST["confirm"] == "5"){
             $e_date = date("Y-m-d");
             ///////////////////////////////
             $randi = time();
             if($_POST["pass"] != $_POST["pass_confirm"]){
                ?>
                 <script>
                     alert("يرجى التأكد ان كلمة السر و تأكيد كلمة السر متطابقين");
                     history.go(-1)
                 </script>
                 <?
                 die();
             }
             /////////////////////// add email to mailing list
             if($_POST["add_newsletters"]){
                 $arr =array($_POST["email"],"0");
                 AddUpdate("emails","",$arr,"","");
             }
             ///////////////////////////// add account
             $arr = array($randi, $_POST["name"],$_POST["pass"],$_POST["email"],$_POST["company"],$_POST["phone"],$_POST["lang_1"],$_POST["lang_2"]
             ,$_POST["lang_3"],0,$e_date);
             AddUpdate("t_members","",$arr,"","");
             @sendMail($rsettings["contact_email"],"عضو جديد '".strip_tags($_POST["name"])."' from ".$_SERVER['HTTP_HOST'],"<div style='direction: rtl'>الاسم:".strip_tags($_POST["name"])."<br>الايميل:".strip_tags($_POST["email"])."</div>",$addReply = "smtp@".$_SERVER['HTTP_HOST']);
                ?>
                <script>
                    alert("تم تسجيل عضويتك بنجاح, يرجى الدخول للتأكد");
                    location.href="login"
                </script>
             <?
             exit;
         }else{
                ?>
             <script>
                 alert("الرجاء ملأ كافة الحقول");
                 history.go(-1)
             </script>
             <?
         }
}
