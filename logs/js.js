//note: userAgent in IE7 WinXP returns: Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727)
var i=-1;
if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){
i=-2
}



function selectAll(x) {
for(var i=0,l=x.form.length; i<l; i++)
if(x.form[i].type == 'checkbox' && x.form[i].name != 'sAll')
x.form[i].checked=x.form[i].checked?false:true
}


 function change_item2(s){
 if(s==5){
 document.form1.group_id1.value=1;
 }
 if(s==6){
document.form1.group_id1.value = 2;
 }
 if(s==7){
document.form1.group_id1.value = 3;
 }
 if(s==8){
document.form1.group_id1.value = 4;
 }
 if(s==1){
document.form1.group_id1.value=5;
 }
 if(s==2){
document.form1.group_id1.value = 6;
 }
 if(s==3){
document.form1.group_id1.value = 7;
 }
 if(s==4){
document.form1.group_id1.value = 8;
 }
}


 function change_item1(s){
 if(s==5){
 document.form1.group_id2.value=1;
 }
 if(s==6){	
 document.form1.group_id2.value = 2;
 }
 if(s==7){
 document.form1.group_id2.value = 3;
 }
 if(s==8){
 document.form1.group_id2.value = 4;
 }
 if(s==1){
 document.form1.group_id2.value=5;
 }
 if(s==2){
 document.form1.group_id2.value = 6;
 }
 if(s==3){
 document.form1.group_id2.value = 7;
 }
 if(s==4){
 document.form1.group_id2.value = 8;
 }
 }
 
   function View_1(id,max){ 
       				//alert("id="+id);
					
                 if(document.getElementById(id).style.display=="none") 
                 {   
                 	//alert ("plus");           
                  	document.getElementById(id).style.display="";
                  	document.getElementById("minus"+id).style.display="";
                  }
                 else
                 {
                	//alert ("minus"); 
                 	document.getElementById(id).style.display="none";
                 	document.getElementById("minus"+id).style.display="none";


                 }
                 	
 }
  function View(id,max){ 
       				//alert("id="+id);


                  $("#"+id).slideToggle();

                 	
 }

  function View_once(id,max){ 
       				//alert("id="+id);
					
                 if(document.getElementById(id).style.display=="none") 
                 {   
                 	//alert ("plus");           
                  	document.getElementById(id).style.display="";
                  	//document.getElementById("minus"+id).style.display="";
	                //document.getElementById("plus"+id).style.display="none";
                  }

 }
 
    function hide_id(id){ 
     document.getElementById(id).style.display="none";
	 if(id =="result_6"){
	 document.forms[0].elements["result_6_1"].value=""
	 }
	 if(id =="result_5"){
	 document.forms[0].elements["result_5_1"].value=""
	 }

   }
function mc(d){
        if( $("#" + d).css("display") == 'none' ){
                $("#" + d).css("display", "block");
        }else{
                $("#" + d).css("display", "none");
        }
}

function addRow(field,value,vote,values,element){
    var newRow = document.getElementById(element).insertRow(null);
var oCel2 = newRow.insertCell(null);

oCel2.innerHTML = "";

var oCell = newRow.insertCell(null);
oCell.innerHTML = "<input type='text' class='form1' size=30 name="+field+" value='"+value+"'> ";
}


function addRow_2()
{
    var newRow = document.all("tblGrid").insertRow();
    //add 3 cells (<td>) to the new row and set the innerHTML to contain text boxes
    var oCell = newRow.insertCell();
    oCell.innerHTML = "<input type='text' size=21 name='need[]'>";
    oCell = newRow.insertCell();
    oCell.innerHTML = "<input type='text' size=15 name='exp[]'>";
    oCell = newRow.insertCell();
    oCell.innerHTML = "<input type='text' size=15 name='sal[]'>";
    oCell = newRow.insertCell();
    oCell.innerHTML = "<input type='text' size=21 name='not[]'>";
    oCell = newRow.insertCell();
    oCell.innerHTML = "<input type='button' style='font-size:11px;font-family: tahoma' value='???' onclick=\"removeRow(this);c=c-1;\"/>";
}

//deletes the specified row from the table
function removeRow(src)
{
    /* src refers to the input button that was clicked.
     to get a reference to the containing <tr> element,
     get the parent of the parent (in this case <tr>)
     */
    var oRow = src.parentElement.parentElement;
    //once the row reference is obtained, delete it passing in its rowIndex
    document.all("tblGrid").deleteRow(oRow.rowIndex);
}


function confirm_form(form){



    $(form).find(".email_text").remove();
    $(form).find(".empty_text").remove();
    $(form).find(".pass_text").remove();

    $(form).find(".email").removeClass("error");
    $(form).find(".email").addClass("form");


    $(form).find(".email").each(function (i,val) {
        if(!validateEmail($(this).val()) && $(this).val() !=""){
            $(this).addClass("error");
            $(this).after("<span class='email_text'>&nbsp;<img width='20px'  src='images/error_2.png'>       تأكد من صحة الايميل       </span>");
        }
    })

    if($(form).find(".email").is(".error") === true){
        return false;
    }

    $(form).find(".pass").removeClass("error");
    $(form).find(".pass").addClass("form");

    $(form).find(".confirm_pass").removeClass("error");
    $(form).find(".confirm_pass").addClass("form");


    if ($(form).find(".confirm_pass").val() != $(form).find(".pass").val()){
        $(form).find(".pass").after("<span class='pass_text'>&nbsp;<img width='20px'  src='images/error_2.png'>      كلمة السر و تأكيدها غير متطابقان     </span>");
        $(form).find(".confirm_pass").addClass("error");
        $(form).find(".pass").addClass("error");
    }
    if($(form).find(".pass").is(".error") === true){
        return false;
    }


    $(form).find(".empty").removeClass("error");
    $(form).find(".empty").addClass("form");

    $(form).find(".empty").each(function (i,val) {

        if($(this).val() == ""){
            $(this).after("<span class='empty_text'>&nbsp;<img width='20px'  src='images/error_2.png'>       الرجاء ادخال قيمة      </span>");
            $(this).addClass("error");
        }
    })
    if($(form).find(".empty").is(".error") === true){
        return false;
    }


}
