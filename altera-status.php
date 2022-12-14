<?php
	session_start(); 	
	
	
	// $loja = $_POST['loja'];
	// $produto = $_POST['produto'];	
	
	$loja = $_POST['loja'];
	$produto = $_POST['produto'];	
	
	$usuario ='consinco';
	$senha 	= 'consinco';
	$host 	= '192.168.0.245/bigmais';
	$porta 	= '1521';	
	
	$conexao = oci_connect($usuario, $senha, "$host:$porta");
	$sql  = oci_parse($conexao, "SELECT COUNT(*) AS TOTAL from BIGMAIS.OFERTAS_FRIOS WHERE SEQPRODUTO = '".$produto."' AND LOJA = '".$loja."'");
	oci_execute($sql);
	$row = oci_fetch_assoc($sql);
	if($row['TOTAL'] > 0)	
	{
		$sql  = oci_parse($conexao, "DELETE FROM BIGMAIS.OFERTAS_FRIOS WHERE SEQPRODUTO = '".$produto."' AND LOJA = '".$loja."'");
		if(oci_execute($sql))
		{
			echo "INATIVO";
		}	
		
		}else{
		
		$sql  = oci_parse($conexao, "INSERT INTO BIGMAIS.OFERTAS_FRIOS (SEQPRODUTO, LOJA) 
		VALUES ('".$produto."', '".$loja."')");
		if(oci_execute($sql))
		{
			echo "ATIVO";
		}	
		
	}			