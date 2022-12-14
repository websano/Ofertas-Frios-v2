<?php

$connect = new PDO("mysql:host=localhost; dbname=ticket_atendimento_geral", "root", "bigmais.123");

$limit = '5';
$page = 1;
if($_POST['page'] > 1)
{
  $start = (($_POST['page'] - 1) * $limit);
  $page = $_POST['page'];
}
else
{
  $start = 0;
}

$query = "
SELECT t1.descricao, t1.imagem, t1.codProduto, t1.opcoes, t1.catProd, t2.id, t2.nomecat FROM app_bigcarnes as t1, app_categorias as t2 WHERE t2.id = t1.catProd ";


if($_POST['query'] != '')
{
  $query .= '
  AND t1.descricao LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"     
  OR t2.nomecat LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"     
  ';
}

$query .= 'ORDER BY t1.descricao ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();

$output = '
<label>Total de registros - '.$total_data.'</label>
<style>td{height:104px;}</style>
<table class="table  table-bordered table-hover">
     <th width="40%">DESCRIÇÃO</th>    
    <th width="10%">PREÇO</th>
    <th width="10%">CATEGORIA</th>
    <th width="5%">IMAGEM</th>
	<th width="5%">OPÇÕES</th>    
	<th width="5%">DELETAR</th>    
   </tr>
';
if($total_data > 0)
{
  foreach($result as $row)
  {
    $output .= '
    <tr>               
  <td><h6>'.$row["descricao"].'</h6></td>';
  
  require '../database_connection.php'; 
				$codProduto = '';
				$codProduto = $row["codProduto"];
				$stmt = $concentrador->prepare("SELECT * FROM pdv_prodcodigoacougue WHERE CODACESSO = ".$codProduto." group by CODACESSO");
				if ($stmt->execute()){
				while($VerificaProduto = $stmt->fetch()){					 
					
					
				$output .= '<td><h4 class="text-success">R$ '.number_format($VerificaProduto["PRECO"], 2, ',','.').'</h4></td>';
					
					
						}
					}			 
					
  $output .= '  
  <td><h6>'.$row["nomecat"].'</h6></td>';
    
	$ext = $row["imagem"];
	$ext = explode('.', $ext);
	$ext = end($ext);  
	if($ext == 'webp')
	{
		$img_style = 'border:1px solid white;';	
	}
	else{
		$img_style = '';
	}
	
    $output .= '
	 <td><a href="" data-toggle="modal" data-target="#popimagem'.$row["id"].'"><img src="'.$row["imagem"].'" width="100px"></a></td>
     <td><button type="button" name="update" id="'.$row["id"].'" data-toggle="modal" data-target="#userModal'.$row["id"].'" class="btn btn-success btn-xs update"><span class="fa fa-edit" aria-hidden="true"></span> OPÇÕES</button></td>
     <td><button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete"><span class="fa fa-trash" aria-hidden="true"></span> EXCLUIR</button></td>	 
    </tr>
	
	
	<div id="popimagem'.$row["id"].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="popimagem'.$row["id"].'" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <img src="'.$row["imagem"].'" class="img-responsive" style="max-width:100%;">
        </div>
    </div>
  </div>
</div>	
	
	';
  }
}
else
{
  $output .= '
  <tr>
    <td colspan="2" align="center">Nenhum registro encontrado!</td>
  </tr>
  ';
}

$output .= '
</table>
<br />
<div style="width:700px;margin:0 auto;">
  <ul class="pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

//echo $total_links;

if($total_links > 4)
{
  if($page < 5)
  {
    for($count = 1; $count <= 5; $count++)
    {
      $page_array[] = $count;
    }
    $page_array[] = '...';
    $page_array[] = $total_links;
  }
  else
  {
    $end_limit = $total_links - 5;
    if($page > $end_limit)
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $end_limit; $count <= $total_links; $count++)
      {
        $page_array[] = $count;
      }
    }
    else
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $page - 1; $count <= $page + 1; $count++)
      {
        $page_array[] = $count;
      }
      $page_array[] = '...';
      $page_array[] = $total_links;
    }
  }
}
else
{
  for($count = 1; $count <= $total_links; $count++)
  {
    $page_array[] = $count;
  }
}

for($count = 0; $count < count($page_array); $count++)
{
  if($page == $page_array[$count])
  {
    $page_link .= '
    <li class="page-item active">
      <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
    </li>
    ';

    $previous_id = $page_array[$count] - 1;
    if($previous_id > 0)
    {
      $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'"><< Anterior</a></li>';
    }
    else
    {
      $previous_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#"><< Anterior</a>
      </li>
      ';
    }
    $next_id = $page_array[$count] + 1;
    if($next_id >= $total_links)
    {
      $next_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#">Próxima >></a>
      </li>
        ';
    }
    else
    {
      $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(1)" id="'.$next_id.'" data-page_number="'.$next_id.'">Próxima >></a></li>';
    }
  }
  else
  {
    if($page_array[$count] == '...')
    {
      $page_link .= '
      <li class="page-item disabled">
          <a class="page-link" href="#">...</a>
      </li>
      ';
    }
    else
    {
      $page_link .= '
      <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
      ';
    }
  }
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
  </ul>

</div>
';

echo $output;

?>

