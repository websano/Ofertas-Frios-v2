<?php
	
	$loja = $_GET['loja'];		

	$seqProduto = $_GET['seqproduto'];

	/// CONEXÃO ORACLE
	
	$usuario ='consinco';
	$senha = 'consinco';
	$host = '192.168.0.245/bigmais';
	$porta = '1521';

	$loja   = $_GET['loja'];
	
	$conexao = oci_connect($usuario, $senha, "$host:$porta");
	$sql  = oci_parse($conexao, "
					
			SELECT * FROM VIEW_PROMOCAO_FRIOS V 
			WHERE V.NROEMPRESA = '".$loja."'
			AND V.DTAINICIO <= to_char( SYSDATE, 'YYYY-MM-DD' ) 
			AND V.DTAFIM >= to_char( SYSDATE, 'YYYY-MM-DD' ) 
			AND V.NROSEGMENTO = '1' 
			AND V.PROMOCAO NOT IN ('TESTE', 'COLETA DATA - PERECIVEIS')				
			AND V.SEQPRODUTO = '".$seqProduto."'");

	if(oci_execute($sql)){		
		$row = oci_fetch_assoc($sql);
		$promocao = $row['PROMOCAO'];
		$preconormal = $row['PRECOUNIT'];
		$descricao = $row['DESCCOMPLETA'];
	}	
	
	

	// $preconormal = number_format($preconormal,2,",",".");		
		
		// if(strlen($preconormal) < 5){
		// $preconormal_dec = substr($preconormal, 0, 2);	
		// $preconormal_cent = substr($preconormal, 2, 2);
		// $style_normal_cent = 'font-size:1.5em';
	// }else{
		// $preconormal_dec = substr($preconormal, 0, 3);	
		// $preconormal_cent = substr($preconormal, 3, 2);	
		// $style_normal_cent = 'font-size:1.5em';
	// }	
	
	// $preconormal = number_format($preconormal,2,",",".");		
	
	// $preco = number_format($preconormal,2,",",".");		

	// if($seqProduto == '29872'){
		// $preco = '29,99';
	// }else{
		$preco = number_format($preconormal,2,",",".");		
	// } 
	


	switch ($loja) {
    case '1':
        if(strlen($preco) < 5){
		$preco_dec = substr($preco, 0, 2);	
		$preco_cent = substr($preco, 2, 2);
		$style_cent = 'font-size:65px;position:absolute;left:90px;bottom:80px;';
		$style_precokilo = 'top:349px;left:760px;';
		}else{
		$preco_dec = substr($preco, 0, 3);	
		$preco_cent = substr($preco, 3, 2);	
		$style_cent = 'font-size:65px;position:absolute;left:180px;bottom:85px;';
		$style_precokilo = 'top:349px;left:700px;';
		}	
		break;
	case '2':
		if(strlen($preco) < 5){
		$preco_dec = substr($preco, 0, 2);	
		$preco_cent = substr($preco, 2, 2);
		$style_cent = 'font-size:65px;position:absolute;left:120px;bottom:90px;';
		$style_precokilo = 'top:349px;left:760px;';
		}else{
		$preco_dec = substr($preco, 0, 3);	
		$preco_cent = substr($preco, 3, 2);	
		$style_cent = 'font-size:65px;position:absolute;left:215px;bottom:90px;';
		$style_precokilo = 'top:349px;left:650px;';
		}	
		break;
	case '4':
		if(strlen($preco) < 5){
			$preco_dec = substr($preco, 0, 2);	
			$preco_cent = substr($preco, 2, 2);
			$style_cent = 'font-size:65px;position:absolute;left:150px;bottom:85px;';
			$style_precokilo = 'top:349px;left:800px;';
		}else{
		$preco_dec = substr($preco, 0, 3);	
		$preco_cent = substr($preco, 3, 2);	
		$style_cent = 'font-size:65px;position:absolute;left:170px;bottom:85px;';
		$style_precokilo = 'top:349px;left:730px;';
		}	
		break;
	case '8':
		if(strlen($preco) < 5){
		$preco_dec = substr($preco, 0, 2);	
		$preco_cent = substr($preco, 2, 2);
		$style_cent = 'font-size:65px;position:absolute;left:110px;bottom:90px;';
		$style_precokilo = 'top:349px;left:755px;';
		}else{
		$preco_dec = substr($preco, 0, 3);	
		$preco_cent = substr($preco, 3, 2);	
		$style_cent = 'font-size:65px;position:absolute;left:215px;bottom:90px;';
		$style_precokilo = 'top:349px;left:650px;';
		}	
		break;	
	}
	
	$dtinicio = date('d/m/Y', strtotime ($_GET['dtinicio']));	
	$dtfinal = date('d/m/Y', strtotime ($_GET['dtfinal']));		
	
	
	// $precoquery = $row['PRECOUNIT'];
	$precoquery = $preconormal;

	
	$sql  = oci_parse($conexao, "
				SELECT '".$precoquery."' as PRECO, 	
				'P/ ' || e.multeqpembalagem || ' R$ ' || trunc('".$precoquery."' / to_number( nvl(e.multeqpemb,0.00001)) ) || ',' || lpad(('".$precoquery."' / to_number( nvl(e.multeqpemb,0.00001)) - trunc('".$precoquery."' / to_number( nvl(e.multeqpemb,0.00001)) )) * 100, 2, 0) AS EMBALAGEM,
				trunc('".$precoquery."' / to_number( nvl(e.multeqpemb,0.00001)) ) || '.' || lpad(('".$precoquery."' / to_number( nvl(e.multeqpemb,0.00001)) - trunc('".$precoquery."' / to_number( nvl(e.multeqpemb,0.00001)) )) * 100, 2, 0) AS PRECO_EMB
				FROM  GE_EMPRESA B, MRL_PRODUTOEMPRESA C, map_produto d , map_famembalagem e
				WHERE d.seqfamilia           =  e.seqfamilia
				AND b.NROEMPRESA             =  '".$loja."'
				AND b.NROEMPRESA             =  C.NROEMPRESA
				AND C.SEQPRODUTO             =  '".$seqProduto."'
				AND C.SEQPRODUTO             =  D.SEQPRODUTO
				AND E.QTDEMBALAGEM = 1");
		oci_execute($sql);		
		$rows = oci_fetch_assoc($sql);		
		
		$precoembalagem = $rows['PRECO_EMB'];		
		
		// $precoembalagem = number_format($precoembalagem,2,",",".");			
			
		if($seqProduto == '29872'){
			$precoembalagem = '29,99';
		}else{
			$precoembalagem = number_format($precoembalagem,2,",",".");		
		} 	
	
	
	?>

<img class="item slide-fwd-top" src="/intra/sistemas/banco-imagens/uploads/png/<?php echo $seqProduto;?>.png" style="max-height:500px; max-width:600px; -webkit-filter: drop-shadow(5px 5px 5px #222); filter: drop-shadow(5px 5px 5px #222);">
<div class="descricao tracking-in-expand"><?php echo $descricao;?></div>
<div class="preco scale-up-center"><?php echo $preco_dec; ?><span style="<?php echo $style_cent; ?>"><?php echo $preco_cent; ?></span></div>

<?php
	
	

	// echo '<div class="preconormal scale-up-center">De <strong style="font-size:1.5em;">'.$preconormal_dec.'</strong><span style="'.$style_normal_cent.'">'.$preconormal_cent.' por</span></div>';
	// echo '<div class="promocao scale-up-center"><img src="img/logo_bigmaisvc_novo.png" width="280px"></div>';


?>

<?php
	if($precoembalagem !== $preco){
		echo '<span class="precokilo" style="'.$style_precokilo.'">'.$rows["EMBALAGEM"].'</span>';
	}
?>


<div class="rodape">Ofertas válidas nesta loja de <strong class="dtofertas"><?php echo $dtinicio;?></strong> a <strong class="dtofertas"><?php echo $dtfinal;?></strong> <br>ou enquanto durarem os estoques</div>    