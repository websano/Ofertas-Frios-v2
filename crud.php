<?php
class Crud
{
 //crud class
 
 public $connect;
 private $host = "localhost";
 private $username = 'root';
 private $password = 'bigmais.123';
 private $database = 'ticket_atendimento_geral';  
 
 function __construct()
 {
  $this->database_connect();
 }

 public function database_connect()
 {
  $this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->database);
  mysqli_set_charset( $this->connect, 'utf8');
 } 

 public function execute_query($query)
 {
  return mysqli_query($this->connect, $query);
 }

 public function get_data_in_table($query)
 {
  $output = '';
  $result = $this->execute_query($query);
  
  $output .= '
  
  <section class="pt-3 pb-3">
  <div class="container">
    <div class="row mb-md-2">';
  
  if(mysqli_num_rows($result) > 0)
  {
   $precopromocao = '';
   $preconormal = '';
   $loja = '';
   session_start(); 	
   $loja = $_SESSION['loja'];
   while($row = mysqli_fetch_object($result))
   {  
	
		$seqProduto = $row->seqProduto;												
		$json = file_get_contents('http://192.168.0.210/intra/api/consinco/frios.php?loja='.$loja.'&seqproduto='.$seqProduto);					
		$obj = json_decode($json);
		$precopromocao = $obj->{'PRECOUNIT'};
		if(isset($precopromocao)){
			$oferta = 'border: 2px dashed red !important';			
		}else{
			$oferta = 'border: 0';			
		}
		
		$imagem = '';
		
		if(strlen($row->imagem) > 0)
		{
			$imagem = $row->imagem;			
		}else{
			$imagem = "http://192.168.0.210/intra/sistemas/banco-imagens/uploads/png/".$row->seqProduto.".png";
		}
		
		$codProduto = $row->codProduto;	
		$json = file_get_contents('http://192.168.0.210/intra/api/consinco/produtos.php?loja='.$loja.'&produto='.$codProduto);
		$obj = json_decode($json);		
		$preconormal = $obj->{'PRECO'};
		
	
	$output .= '
	<div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-md border-light mb-3" style="'.$oferta.'">
                <div class="position-relative" style="cursor:pointer; text-align:center;">';              

				if($row->status == 'Desativado'){						
						$output .= ' <span data-toggle="modal" data-target="#popimagem'.$row->id.'" class="card-img-top" style="background-image: url('.$imagem.');background-size:contain;background-position: bottom;background-repeat: no-repeat;height:200px;width:200px;opacity:0.4" alt="image"></span> </div>';						
					}else{
						$output .= ' <span data-toggle="modal" data-target="#popimagem'.$row->id.'" class="card-img-top" style="background-image: url('.$imagem.');background-size:contain;background-position: bottom;background-repeat: no-repeat;height:200px;width:200px;" alt="image"></span> </div>';
					}			
		
			$output .= '<div class="card-body" style="padding:5px; height: 210px;">
                        <h6 class="font-weight-strong">'.$row->descricao.'</h6>
						<div class="post-meta grey">Código: <strong>'.$row->codProduto.'</strong></div>
						<div class="post-meta grey">Seq Produto: <strong>'.$row->seqProduto.'</strong></div>
						<div class="d-flex my-4">                        
						<div class="d-flex justify-content-between">
                        
		<div class="row" style="max-width: 99%;position: absolute;bottom: 0px;">
		<div class="col-sm-6">
			
		</div>
		<div class="col-sm-6">
			
		</div>
		';
		
	
	if($row->status == 'Desativado'){
		
		$output .= ' <div class="col-sm-6"><button type="button" name="status" acao="Ativado" ids="'.$row->id.'" class="status btn btn-secondary btn-xs btn-block btn'.$row->id.'"><span class="fa fa-remove" aria-hidden="true"></span></button></div><img src="img/loading.gif" width="40" class="load'.$row->id.'" style="display:none;position:absolute;bottom:7px;left:35px;">';		
		
	}else{

		$output .= ' <div class="col-sm-6"><button type="button" name="status" acao="Desativado" ids="'.$row->id.'" class="status btn btn-success btn-xs btn-block btn'.$row->id.'"><span class="fa fa-check" aria-hidden="true"></span></button></div><img src="img/loading.gif" width="40" class="load'.$row->id.'" style="display:none;position:absolute;bottom:7px;left:35px;">';		
		
	}	
		
	if(isset($precopromocao)){
		$output .= ' <div class="col-sm-6"><span class="preco btn btn-primary btn-xs status btn-block" style="padding-top:2px;font-weight: 600;">'.number_format($precopromocao,2,",",".").'</span></div>';			
	}else{
		$output .= ' <div class="col-sm-6"><span class="preco btn btn-default btn-xs status btn-block" style="padding-top:2px;font-weight: 600;">'.number_format($preconormal,2,",",".").'</span></div>';			
	}
					
					$output .= '</div></div>
                </div>
            </div>
        </div>
    </div> 
	
	<div id="popimagem'.$row->id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="popimagem'.$row->id.'" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <img src="'.$imagem.'" class="img-responsive" style="max-width:100%;">
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
     <p align="center">Nenhum registro encontrado!</p>    
   ';
  } 
    $output .= '	
</div>
</section>';
  return $output; 
 }
 // function upload_file($file)
 // {
  // if(isset($file))
  // {
   // date_default_timezone_set('America/Sao_Paulo');
   // $extension = explode('.', $file["name"]);  
   // $data = date('Y-m-d');   
   // $hora = date('H.i');   
   // $numero = rand(100,999);
   // $new_name = 'produto'.$numero.'_'.$data.'_'.$hora.'.'.$extension[1];
   // $destination = '../uploads/' . $new_name;
   // move_uploaded_file($file['tmp_name'], $destination);
   // return $new_name;
  // }
 // }
 function make_pagination_link($query, $record_per_page)
 {
  
  return $output;
 }
}
?>