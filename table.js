function addRow(field,value,vote,values,element){
    var newRow = document.getElementById(element).insertRow(null);
    var oCel2 = newRow.insertCell(null);

    oCel2.innerHTML = "";

    var oCell = newRow.insertCell(null);
    oCell.innerHTML = "<input type='text' class='form1' size=30 name="+field+" value='"+value+"'> ";
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