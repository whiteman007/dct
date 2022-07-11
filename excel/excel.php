<? session_start(); 
include "../logs/data.php";
#### Roshan's very simple code to export data to excel   
#### Copyright reserved to Roshan Bhattarai - nepaliboy007@yahoo.com
#### if you have any problem contact me at http://roshanbh.com.np
#### fell free to visit my blog http://php-ajax-guru.blogspot.com
	
	//first of all unset these variables
	unset($_SESSION['report_header']);
	unset($_SESSION['report_values']);
	//note that the header contain the three columns and its a array
	$_SESSION['report_header']=array("�����", "�����", "������", "�����", "����� ��������", "�����  �������", "������", "�����", "�������"); 
	
   // now the excel data field should be two dimentational array with three column

if(is_array($_POST['emails'])){
$i=0;
while(list($a,$b) = each($_POST['emails'])){
        $q=mysqli_query2("select * from user where id= '".$a."'");
		$r=mysqli_fetch_array($q);
 
   		 $_SESSION['report_values'][$i][0]=$r['id']." ";
		 $_SESSION['report_values'][$i][1]=iconv("utf-8","windows-1256",$r['user_fname'])." ";
		 $_SESSION['report_values'][$i][2]=iconv("utf-8","windows-1256",$r['user_lname'])." ";
		 $_SESSION['report_values'][$i][3]=iconv("utf-8","windows-1256",$r['sex'])." ";
		 $_SESSION['report_values'][$i][4]=iconv("utf-8","windows-1256",$r['add_date'])." ";
		 $_SESSION['report_values'][$i][5]=$r['y']."/".$r['m']."/".$r['d'];
		 $_SESSION['report_values'][$i][6]=$r['mobile'];
		 $_SESSION['report_values'][$i][7]=$r['email'];
		 $_SESSION['report_values'][$i][8]=$r['address'];									
		 "<br>";
$i++;
}
}

header("location:excel/export_report.php?fn=member_report");
exit;  
  ?>
