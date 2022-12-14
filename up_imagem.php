<?php
if($_FILES["file"]["name"] != '')
{
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = "produto_frios".rand(999999, 10000000) . '.' . $ext;
 $location = '../uploads/'.$name;  
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 echo '<input type="hidden" name="arquivo_imagem_atualizar" value="'.$location.'" class="form-control" />
 <div style="border:1px dashed #333; padding:5px;"><img src="'.$location.'" width="300px" ></div>';
 }
?>

