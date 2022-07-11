<?
if(main != "true"){
die("Access Denied");
}
?>
<script type="text/javascript" src="plugins/jquery/jqFancyTransitions.1.8.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
        $('#example').jqFancyTransitions({ effect: 'zipper',  position: 'top', direction: 'fountain',width: '1600', height: '400', links:"true" });
	})
</script>
        <div id="example" style="position: relative; margin: 0 auto">
<?
$q_headers=mysqli_query2("select * from flasha order by the_order, id desc");
while($r_headers= mysqli_fetch_array($q_headers)){
?>
	<img  src="flasha/photos/<?=$r_headers[src]?>" alt="" border="0"/>
    <a href="<?=$r_headers[link]?>" target="_blank"></a>
<?
}
?>      

        </div>
<!-- تعليق -->
