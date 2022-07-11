function addRow(id,value,field,element)
{
if(id){
var newRow = document.getElementById(element).insertRow(null);
var oCel2 = newRow.insertCell(null);

oCel2.innerHTML = "<input type='button' style='font-size:11px;font-family:arial'  value='حذف' onclick='delete_row(this)'/>";

var oCell = newRow.insertCell(null);
oCell.style.width="30%"
oCell.style.textAlign="right"
oCell.style.fontSize="12px"
oCell.style.fontFamily="tahoma"
oCell.innerHTML = "<input type='hidden' size=20 name="+field+" value="+id+">"+value;
}

}


function removeRow(src,element)
   {
    /* src refers to the input button that was clicked.
       to get a reference to the containing <tr> element,
       get the parent of the parent (in this case <tr>)
    */
    var oRow = src.parentNode.parentNode.parentNode ;
 //once the row reference is obtained, delete it passing in its rowIndex
   document.getElementById(element).deleteRow(oRow.rowIndex);
   }


function delete_row(node) {
var td = node.parentNode;
while (td.tagName.toLowerCase() != "tr")
td = td.parentNode;
td.parentNode.removeChild(td);
}