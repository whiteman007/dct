function change(value,n){
        if(value==1){
  document.all(n).disabled= false;
        }
        else{
  document.all(n).disabled= true;
        }
}
function mc(d){
dc('101');
dc('102');
dc('103');
dc('104');
if(d=='102'){
mc('104');
}
if( document.all(d).style.display == 'none' ){
                document.all(d).style.display = 'inline';
        }else{
                document.all(d).style.display = 'none';
        }
}
function dc(d){
document.all(d).style.display = 'none';
}
function enable_c(d){
document.all(d).style.display = 'inline';
}
function addRow()
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
    oCell.innerHTML = "<input type='button' style='font-size:11px;font-family: tahoma' value='ÍÐÝ' onclick=\"removeRow(this);c=c-1;\"/>";
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