<?
session_start();
    $email_u = $_SESSION["email_u"];
    $pass_u = $_SESSION["pass_u"];
    $id_u = $_SESSION["mid"];

    $quser = mysqli_query2("select * from t_members where  active=1 and t_email like '".$email_u."' and t_pass like '".$pass_u."' and id='".$id_u."'");
    if(mysqli_affected_rows2() > 0){
        $ruser = mysqli_fetch_array($quser);
    }else{
        header("location:login");
        die();
    }
?>
