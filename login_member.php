<?
session_start();
if(!$_SESSION['protect'])  {
    $_SESSION['protect'] = 0;
}
if($_SESSION['protect']> 10) {
    ?>
    <script>
        alert('You Are Blocked! Please contact us, Or reopen your browser')
    </script>
    <?
    die('You Are Blocked! Please contact us, Or reopen your browser');
}
$_SESSION['protect']++;
header('Content-Type: text/html;charset=UTF-8');
include "logs/function.php";
secure_website();
$email = $_POST['email'];
$pass = $_POST['pass'];

$email=addslashes($email);
$pass=addslashes($pass);
if(trim($_POST["email"]) == "" && trim($_POST["pass"]) == "" && $_POST["reg"] == "login-123-876" ){
    ?>
    <script type="text/javascript" language="javascript">
        alert("الرجاء التأكد من كافة الحقول");
        history.go(-1);
    </script>
    <?
    exit;
}
$log=mysqli_query2("select * from t_members where active=1 and  t_email = '".$_POST["email"]."' and t_pass = '".$_POST["pass"]."' ") or die("Enter User Name and Password");
$rlog=mysqli_fetch_array($log);
if(mysqli_affected_rows2() <= 0 ){
    ?>
    <script type="text/javascript" language="javascript">
        alert("خطأ في البريد الالكتروني أو كلمة السر, يرجى التأكد");
        history.go(-1);
    </script>
    <?
    die();
}
$_SESSION["email_u"] = $rlog["t_email"];
$_SESSION["pass_u"] = $rlog["t_pass"];
$_SESSION["mid"] = $rlog["id"];
$_SESSION['protect'] = 0;
//email
//@mail("email@email.com","رسالة من your website", "لقد قام  العضو ".$email." بتسجيل دخوله إلى  الموقع, الايميل: ".$rlog["email"]);

if($_POST["last"] && !preg_match("/login$/",$_POST["last"])){
    $ttype= $_POST["last"];
    ?>
    <script type="text/javascript" language="javascript">
        location.href= "<?=$ttype?>";
    </script>
    <?
    exit;
}else{
    ?>
    <script type="text/javascript" language="javascript">
        location.href= "ar";
    </script>
    <?
    exit;
}
