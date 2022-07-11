<?php
if ($_POST["reg"]=="update-123-876"){
    if (!trim($ruser['company_id']) == ""){
        /*<script>
        alert("Please make sure your password and Confirm password is match");
        history.go(-1)
        </script>*/
        $pic = AddUpdateImage("src","pages/photos","600","","oldpic");
        $pic_3 = AddUpdateImageMultiple("src_3","pages/photos","1920","","oldpic_3");
        $q = mysqli_query2("update page set description = '".$_POST["description"]."',text = '".$_POST["text"]."',src = '".$pic."',src_3 = '".$pic_3."' where id = '".$ruser['company_id']."'");
        ///////////////////////
        ?>
        <script>
            alert("تم تعديل صفحتك الشخصية");
            location.href="update"
        </script>
        <?
        exit;
    }else{
        ?>
        <script>
            alert("Please fill required fields");
            history.go(-1)
        </script>
        <?
        exit;
    }
}