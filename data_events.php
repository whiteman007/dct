<?
include "cookie.php";
$table="events";
$page_name="events.php";

$c_mains = mysqli_query2("select * from ".$table." where id='".$_GET[id]."' ");
$row = mysqli_fetch_array($c_mains);
?>
<script type="text/javascript">
$(document).ready(function(){

	})
</script>
    <table border="0" width="90%" dir="ltr" cellpadding="4" class="text">
        <tr>
            <td class="label" width="40%"> Event Title </td>
            <td align="<?=$align?>"><?=$row["title"]?></td>
        </tr>
        <tr>
            <td class="label">Specialty : </td>
            <td align="<?=$align?>"><?=$row["specialty"]?></td>
        </tr>
        <tr>
            <td class="label">City: </td>
            <td align="<?=$align?>"><?=$row["city"]?></td>
        </tr>

        <tr>
            <td class="label">Country : </td>
          <td align="<?=$align?>">
            <?=$row["country"]?>
          </td>
        </tr>
        <tr>
            <td class="label"> Start Date :  </td>
            <td align="<?=$align?>">
                <?=$row["start_date"]?>
            </td>
        </tr>
        <tr>
            <td class="label"> End Date : </td>
            <td align="<?=$align?>">
                <?=$row["end_date"]?>
            </td>
        </tr>
        <tr>
            <td class="label">Website Link :</td>
            <td align="<?=$align?>">
                <?=$row["website"]?>
            </td>
        </tr>
        <tr>
            <td class="label">Contact Information :</td>
            <td align="<?=$align?>">
                <?=$row["contact_information"]?>
            </td>
        </tr>
        <tr>
            <td class="label">Relevant information :</td>
            <td align="<?=$align?>">
                <?=$row["message"]?>
            </td>
        </tr>
    </table>