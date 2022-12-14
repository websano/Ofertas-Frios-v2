<?php
$cod = $_GET['cod'];
$connect = mysqli_connect("192.168.0.210", "root", "bigmais.123", "ticket_atendimento_geral");
$query = "
SELECT * from ofertas_acougue where codProduto = '$cod'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result); 	
	$seqProduto = $row['seqProduto'];											
	$codProduto = $row['codProduto'];											
	$loja = $_GET['loja'];
	$json = file_get_contents('http://192.168.0.210/intra/api/consinco/produtos.php?loja='.$loja.'&seq='.$seqProduto.'&cod='.$codProduto);					
	$obj = json_decode($json);
	$preco = $obj->{'PRECO'};
	
	if($preco < 1){
		$json = file_get_contents('http://192.168.0.210/intra/api/consinco/acougue.php?loja='.$loja.'&seqproduto='.$seqProduto);							
		$obj = json_decode($json);
		$preco = $obj->{'PRECOUNIT'};	
	}
	
	
	$preco = number_format($preco,2,",",".");	
	
	if(strlen($preco) < 5){
		$preco_dec = substr($preco, 0, 2);	
		$preco_cent = substr($preco, 2, 2);
		$style_cent = 'font-size:70px;position:absolute;left:120px;bottom:90px;';
	}else{
		$preco_dec = substr($preco, 0, 3);	
		$preco_cent = substr($preco, 3, 2);	
		$style_cent = 'font-size:70px;position:absolute;left:220px;bottom:90px;';
	}
	
	
	$dtinicio = date('d/m/Y', strtotime ($_GET['dtinicio']));
	$dtfinal = date('d/m/Y', strtotime ($_GET['dtfinal']));
	$imagem = str_replace('uploads','',$row['imagem']);

?>
<img class="item slide-fwd-top" src="uploads<?php echo $imagem;?>" width="600px">
<div class="descricao tracking-in-expand"><?php echo utf8_encode($row['descricao']);?></div>
<div class="preco scale-up-center"><?php echo $preco_dec; ?><span style="<?php echo $style_cent; ?>"><?php echo $preco_cent; ?></span></div>


<div class="rodape">Ofertas válidas nesta loja de <strong class="dtofertas"><?php echo $dtinicio;?></strong> 
a <strong class="dtofertas"><?php echo $dtfinal;?></strong> <br>ou enquanto durarem os estoques</div>
    