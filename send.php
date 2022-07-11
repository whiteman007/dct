<?
include "cookie.php";
$subject= strip_tags($_POST['title']);
$note = strip_tags($_POST['elm1']);
$note= nl2br($note);
$note= str_replace('\"','"',$note);
$body = "<html dir=<?=$dir?>><body>";
$body .= "
<style>
.td          {  color: #333333; font-family: Tahoma; font-size: 9pt; background-color: #ddddd1; direction:ltr}
.th          {  color: #D50211; font-family: Tahoma; font-size: 8pt; font-weight: bold; border: 1px solid #FFFFFF; background-color: #333333}
.cart{
     background-color:#D50211; 
	 color:#333333; 
	 width:535px; 
	 height:20px; 
	 padding-top:5px; 
	 padding-left:5px
}
.text{
	font-family:tahoma;
	font-size:13px;
	color:#000000;

}
</style>";
$body .= "<div dir='<?=$dir?>' align='right' class='text'>".$note."</div>";

$body .= "</body></html>";


    $headers = "From: \"Nesreena Magazine\" <info@nesreena-mag.com>\r\n";
         //specify MIME version 1.0
    $headers .= "MIME-Version: 1.0\r\n";
         //unique boundary
    $boundary = uniqid("COREPHP");
         //tell e-mail client this e-mail contains
    $headers .= "Content-Type: multipart/alternative" .
    "; boundary = $boundary\r\n\r\n";
         //understand MIME
    $headers .= "This is a MIME encoded message.\r\n\r\n";
            //HTML version of message
    $headers .= "--$boundary\r\n" .
    "Content-Type: text/html; charset=utf-8\r\n" .
    "Content-Transfer-Encoding: base64\r\n\r\n";
    $headers .= chunk_split(base64_encode($body));





if(is_array($_POST['emails'])){
while(list($a,$b) = each($_POST['emails'])){
        $q=mysqli_query2("select email from user where id= '".$a."'");
		$r=mysqli_fetch_array($q);


if(!@mail($r['email'],$subject,"",$headers)) {
	echo "<div align='center'> �� ��� �������: $r[email] </div>";
	$senderror = 1;
}


		//@mail($r['email'],$subject,$message,$headers) or print "The message Not send to $r[email]<br>";
}
}
if($senderror !="1"){
?>
<script language="javascript">location.href='process.php?status=ok&page=<?=$_POST[page]?>'</script>
<?
exit;
}
?>