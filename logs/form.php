<?
class  form{
	var $align = "right";
	var $dir	= "rtl";

    function  FormFile($title, $name,$old="oldpic[]", $value, $dd="d1", $important= "", $class="form1"){
        global $i,$row,$ClassName,${$ClassName};
        if($dd == "d2"){$src=$row["src_2"];}else{$src=$row["src"];}
        ?>
        <tr>
            <td dir="rtl"  align="right" class="text_head"><?=$title?></td>
            <td  dir="rtl" class="text_head">
                <input type="file" name="<?=$name?>" <?=$dd?>="<?=intval($i)?>" size="19" class="<?=$class?>">
                <input type="hidden"  name="<?=$old?>" class="oldpic" value="<?=$value?>">
                <?
                if($src != ""){
                    $src =  ${$ClassName}->folder_name ."/".$src;?>
                    <span class="link" style="color:#FF0000">
            <? ${$ClassName}->view_company($src,${$ClassName}->admin_path."/images/edit1.gif",${$ClassName}->admin_path."/images/disedit.gif","");
                        $src="";?>
             </span>
                    <? if($dd !="d2"){ ?>
                    <input type="image" align="absbottom"    name="del_image" vid="<?=$row[id]?>" src="<?=${$ClassName}->admin_path?>/images/del1.gif"  />
                <?
                    }
                }?>

            </td>
        </tr>
        <?
    }
	function FormHidden($name, $value){
	?>
		<input type="hidden" name="<?=$name?>" value="<?=$value?>"  size="45">
	<?
	}
	
		
	function FormText($title, $name, $value, $important= "", $class="form1"){
		
	?>
		<tr>
			<td class="text_head"><?=$title?>: <?=$important !="" ? "<span class='star'>*</span>" : ""?></td>
			<td align="<?=$align?>"><input type="text" name="<?=$name?>" value="<?=$value?>"  size="45" class="<?=$class?>"></td>
		</tr>
	<?
	}
	function FormTextArea($title, $name, $value, $important= "", $class="form1"){		
	?>
        <tr>
                <td width="142" dir="rtl" align="center" class="text_head"><?=$title?> : </span></td>
                <td  dir="<?=$this->dir?>"   class="text_head" align="<?=$this->align?>">
					<textarea rows="30" class="<?=$class?>"  name="<?=$name?>" cols="40"><?=$value?></textarea>
                </td>
        </tr>
	<?
	}
	function FormSelect($title, $name, $value,$array, $important= "", $class="form1"){
		?>
			<tr>
			  <td align="right" class="text_head" dir="rtl"> <?=$title?>: </td>
			  <td align="right">
				<select name="<?=$name?>" class="<?=$class?>">
					<?
					if(is_array($array)){
							foreach($array as $key => $val){
									?>
										<option value="<?=$key?>" <?=$value == $key ? "selected" : ""?>><?=$val?></option>
									<?				
								}
					}
					?>                
				</select>
			  </td>
			</tr> 		
		<?
	}
		
		
		}
			//////////////////////////////////////////
	
$form = new form;
?>
