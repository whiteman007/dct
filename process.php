<?
include "head.php";
include "../logs/function.php";
print "<p class='err' align='center' dir='rtl'>";
print "<br>";
$err = $_GET['err'];
if($err == 1){
    print "تأكد من صحة كافة الحقول";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 2){
    print "اسم المستخدم أو كلمة السر خاطئة.";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 3){
    ?>
    <script>
        location.href='index.php'
    </script>
<?
}elseif($err == 3){
    print "لست مخولا للقيام لهذه العملية";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 4){
    print "كلمة السر لا تتطابق مع تأكيد كلمة السر.";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 5){
    print "يوجد قيمة مكررة أو قيمة خالية, الرجاء التأكد من البيانات.<br> فشل في انجاز العملية.";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 6){
    print "رقم حساب أو ترتيب خاطئ";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}
elseif($err==7)
{
    print "لا يمكن الإضافة فوق هذا العدد.";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 8){
    print "تحذير, لم يتم إضافة الأصناف بشكل كامل";
    print "<br>";
    print "<a href='company.php' class='err'>عودة</a>";
}elseif($err == 9){
    print "املأ كافة الحقول المطلوبة";
    print "<br>";
    print "<a href='javascript:history.go(-2)' class='err'>عودة</a>";
}elseif($err == 10){
    print " تم الاستيراد بنجاح.";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}
elseif($err == 11){
    $ttt=$_COOKIE[t_type];
    print " $tests[$ttt] ليس له قيم";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}
elseif($err == 12){
    $ttt=$_COOKIE[t_type];
    print "قيمة الترتيب الذي أدخلتها موجودة مسبقاً !";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}
elseif($err == 13){
    $ttt=$_COOKIE[t_type];
    print " $tests[$ttt] ليس له مجال نتائج";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 14){
    print "اسم الدخو موجود مسبقاً";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 15){
    print "الايميل موجود مسبقاً";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 16){
    print "كلمة المرور القديمة غير صحيحة";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 26){
    print "الرجاء إدخال ملف CSV";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($_GET["status"] == 17){
    print "تم استيراد البيانات بنجاح..";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($err == 18){
    print "استيراد ملف خاطئ ! , لم يتم استيراد الملف..";
    print "<br>";
    print "<a href='javascript:history.go(-1)' class='err'>عودة</a>";
}elseif($_GET[status] == "ok"){
    print "تم الإرسال بنجاح";
    print "<br>";
    print "<a href='users.php?page=$_GET[page]' class='err'>عودة</a>";
}elseif($_GET[status] == "sended"){
    print "تم الإرسال بنجاح";
    print "<br>";
    print "<a href='send_messages.php' class='err'>عودة</a>";
}

print "</p>";
include "foot.php";
?>