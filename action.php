<?php
//action.php

session_start(); 	
$loja = $_SESSION['loja'];

include 'crud.php';

$object = new Crud();
if(isset($_POST["action"]))
{
 if($_POST["action"] == "Load")
 {
  $record_per_page = 100;
  $page = '';

if(isset($_POST["page"]))
  {
   $page = $_POST["page"];
  }
  else
  {
   $page = 1;
  }
  $start_from = ($page - 1) * $record_per_page;

  echo $object->get_data_in_table("SELECT id, descricao, imagem, seqProduto, codProduto, status".$loja." as status FROM ofertas_frios ORDER BY descricao LIMIT $start_from, $record_per_page");
  echo '<center><ul class="pagination">';
  echo $object->make_pagination_link("SELECT id, descricao, imagem, seqProduto, codProduto, status".$loja." as status FROM ofertas_frios ORDER BY descricao ", $record_per_page);  
  echo '</ul></center>';
 }  
 
 if($_POST["action"] == "Gravar")
 {
  $descricao = mysqli_real_escape_string($object->connect, $_POST["descricao"]);        
  $seqProduto = mysqli_real_escape_string($object->connect, $_POST["seqProduto"]);        
  $codProduto = mysqli_real_escape_string($object->connect, $_POST["codProduto"]);  
  $imagem = mysqli_real_escape_string($object->connect, $_POST["arquivo_imagem_atualizar"]);    
  $query = "
  INSERT INTO ofertas_frios
  (descricao, seqProduto, codProduto, imagem) 
  VALUES ('".$descricao."', '".$seqProduto."', '".$codProduto."', '".$imagem."')";
  
$object->execute_query($query);  
  
	echo "Dados gravados com sucesso!";
 }
 
 if($_POST["action"] == "Fetch Single Data")
 {
  $output = '';
  $query = "SELECT id, descricao, imagem, seqProduto, codProduto FROM ofertas_frios WHERE id = '".$_POST["user_id"]."'";
  $result = $object->execute_query($query);
  while($row = mysqli_fetch_array($result))
  {   
   $output["descricao"] = $row['descricao'];     
   $output["seqProduto"] = $row['seqProduto'];
   $output["codProduto"] = $row['codProduto'];
   $output["arquivo_imagem_atualizar"] = $row['imagem'];   
	}
    
 echo json_encode($output);
 }

 if($_POST["action"] == "Editar")
 { 
  $descricao = mysqli_real_escape_string($object->connect, $_POST["descricao"]);
  $imagem = mysqli_real_escape_string($object->connect, $_POST["arquivo_imagem_atualizar"]);  
  $query = "UPDATE ofertas_frios SET descricao = '".$descricao."', imagem = '".$imagem."' WHERE id = '".$_POST["user_id"]."'";
  $object->execute_query($query);
  echo 'Dados atualizados!';  
 }
 
 if($_POST["action"] == "Delete")
 {
  $query = "DELETE FROM ofertas_frios WHERE id = '".$_POST["user_id"]."'";
  $object->execute_query($query);      
 } 
 
 
 
 if($_POST["action"] == "Status")
 {
	$status = $_POST["acao"];			
	$query = "UPDATE ofertas_frios SET status".$loja." = '".$status."' WHERE id = '".$_POST["user_id"]."'";
	$object->execute_query($query);      
 }
 
 
}
?>