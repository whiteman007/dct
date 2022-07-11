$("#form_vote").submit(function(){
	//////////////////////// confirm

	if (document.form_vote.note.value == ''){
		alert('الرجاء إضافة تعليق');
		document.form_vote.note.focus();
		return false;
	}
	///////////////////////////////////////
	var vote_form_data = $(this).serialize()
	$("#voting").html("<div align='center' style='padding: 20px'><img src='images/wait.gif'> </div>");
	$.post("app_test/vote/requests.php",vote_form_data,function(data){
		if(data == "success"){
			$("#voting").load("app_test/vote/vote.php",{"pro_id":"<?=$pid?>"},function(){
			});

		}
	});
	return false;
});