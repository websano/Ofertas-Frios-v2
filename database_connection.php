<?php
	session_start(); 	
	
	$loja = $_SESSION['loja'];
	
	//database_connection.php
	if($loja == '1'){$codigo_nivel = $loja.'1';} 
	if($loja == '2'){$codigo_nivel = $loja.'2';} 
	if($loja == '4'){$codigo_nivel = $loja.'4';} 
	if($loja == '5'){$codigo_nivel = $loja.'5';} 
	if($loja == '9'){$codigo_nivel = $loja.'9';} 
		
	$host = '192.168.0.210';
	$usuario = 'root';
	$senha = 'bigmais.123';
	$banco = 'ticket_atendimento_geral';
	$dsn = "mysql:host={$host};dbname={$banco};charset=utf8";

	try
	{
		// Conectando
		$connect = new PDO($dsn, $usuario, $senha);
	}
	catch (PDOException $e)
	{
		// Se ocorrer algum erro na conexão
		die($e->getMessage());
	}
	
	$concentrador = new PDO("mysql:host=192.168.0.251; dbname=concentrador", "econect", "123456");	
	// $concentrador9 = new PDO("mysql:host=192.168.9.251; dbname=concentrador", "root", "B4nc0my5q1");	
		
	// }
	
		
	// else{
		
		// echo  "<script>alert('Loja não encontrada!');</script>";
	// }
?>