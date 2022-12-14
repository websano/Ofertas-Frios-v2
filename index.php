<?php
	session_start(); 
	
	if(isset($_GET['loja']))
	{
		$ip = $_GET['loja'];	
	}else{
	
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);	
		$ip = explode('.',$ip);	
		$ip = $ip[2];		
	}
	
	switch ($ip) {
		
		case '1':
		$_SESSION['loja'] = '1';	
		$_SESSION['nomeloja'] = 'Pérola';				
		$_SESSION['tv'] = '192.168.1.144';
		break;
		
		case '2':
		$_SESSION['loja'] = '2';	
		$_SESSION['nomeloja'] = 'Treze de Maio';				
		$_SESSION['tv'] = '192.168.2.58';
		break; 
		
		case '4':
		$_SESSION['loja'] = '4';	
		$_SESSION['nomeloja'] = 'Lagoa Santa';				
		$_SESSION['tv'] = '192.168.4.36';				
		break;	
		
		case '5':
		$_SESSION['loja'] = '5';	
		$_SESSION['nomeloja'] = 'Altinópolis';
		break;		
		
		case '6':
		$_SESSION['loja'] = '2';	
		$_SESSION['nomeloja'] = 'Treze de Maio';
		$_SESSION['tv'] = '192.168.2.58';				
		break;		
		
		case '8':
		$_SESSION['loja'] = '8';	
		$_SESSION['nomeloja'] = 'Vila Isa';
		$_SESSION['tv'] = '192.168.8.158';				
		break;		
		
		case '9':
		$_SESSION['loja'] = '9';	
		$_SESSION['nomeloja'] = 'São Pedro';
		$_SESSION['tv'] = '192.168.9.186';				
		break;						
	}
?>

<!DOCTYPE html>
	<html lang="pt-br" translate="no">
    <meta name="google" content="notranslate">
    <meta charset="utf-8">
	<head>
		<title>PAINEL / OFERTAS FRIOS</title>	
		
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
		
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>	
		<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>	
		<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>			
		<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script> 		
		
		<meta name="viewport" 
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">		
			

		
		<style>			
			
			body {
			padding-top:20px;
			background-image: url("img/fundo_frios.jpg");
			background-attachment: fixed;
			width: 100%;
			height: auto;
			}
			
			#data-table{width: 65%;margin: auto;}
			
			.dataTables_length, .panel-heading, .dataTables_filter, table.dataTable tbody tr {background-color: white;}
			
			table {background-color: transparent !important;}			
			
			
			.cards tbody tr {
				float: left;
				margin: 10px;
				border: 1px solid #aaa;
				box-shadow: 3px 3px 6px rgba(0,0,0,0.25);
				background-color: white;
			}
			
			.cards tbody td {display: block;width: 340px;overflow: hidden;text-align: left;}			
			
			.table {background-color: #fff;}
			.table tbody label {display: none;margin-right: 5px;width: 50px;}   
			.table .glyphicon {font-size: 20px;}			
			
			.cards tbody label {display: inline;position: relative;font-size: 85%;font-weight: normal;
			top: -5px;left: -3px;float: left;color: #808080;}
				
			.cards tbody td:nth-child(1) {text-align: center;}			
			.imagem{margin:0 auto;width:100px;height:100px;}			
			
			.cards tbody td:nth-child(1) {
				text-align: center;
				position: absolute;
				margin-left: 128px;
				margin-top: 260px;				
				background-color: white;
				width: 162px;
				align-items: center;
			}		
			
			.sorting_1{background-color:transparent !important;border-top:0px;}
			
				
			@media (min-width: 800px){				
			.container{width:1360px;}
			.cards tbody td:nth-child(1) {margin-left: 150px;margin-top: 260px;}								
			}
			
			#tv_refresh{width:80px;position: fixed;z-index: 9999;right: 300px;top: 151px;}
			
			@media (max-width: 800px){
			.panel {background-color: transparent;}						
				.cards tbody tr {margin: 6px;}
				#tv_refresh{width:50px;position: fixed;z-index: 9999;right: 30px;top: 131px;}
				.cards tbody td {display: block;width: 300px;overflow: hidden;text-align: left;}				
			}			
			
			.table th, .table td {border-top:0px;}
			
			.lab{font-size:0.9em;color:#999;}
			
			div.dataTables_wrapper div.dataTables_paginate ul.pagination {justify-content: center;}
			table{padding-left:3%;}
			
			
		</style>
		
		<script>
			$(document).ready(function(){
				
				
				$("#data-table").toggleClass('cards')
				$("#data-table thead").toggle();
				var url_base = "/intra/sistemas/banco-imagens/uploads/png/";
				$.getJSON( "/intra/api/consinco/frios_lista.php?loja=<?php echo $_SESSION['loja']; ?>", function(data){              
					
					$('#data-table').DataTable({						
						dom: 'lpftrip',
						
						lengthMenu: [
							[12, 36, 68, -1],
							[12, 36, 68, 'Todos'],
						],
						
						"data" : data,                 				 
						columns : [
							{"data" : "IMG"},					
							{"data" : "DESCRICAO"},
							{"data" : "PROMOCAO"},
							{"data" : "CODIGO"},
							{"data" : "INICIO"},
							{"data" : "FIM"},
							{"data" : "LOJA"},
							{"data" : "PRECO"},
							{"data" : "STATUS"}						
						],
						
						columnDefs:
						[{
							"targets": 0,
							"data": 'IMG',
							"render": function (data, type, row, meta) {								
								return "<div style='box-sizing: border-box !important; margin:0 auto;height:100px;width:160px !important; background-size:contain; background-position:center;background-repeat: no-repeat;background-image:url(" + url_base + data + ".png')';><div class='imagem'></div></div>";
							},
						},						
						{
							"targets": 1,
							"data": 'DESCRICAO',
							"render": function (data, type, row, meta) {								
								return "<p style='height:40px;font-size:1.5em;'><strong>" + data + "</strong></p>";
							},
						},
						{
							"targets": 2,
							"data": 'PROMOCAO',
							"render": function (data, type, row, meta) {								
								return "<span class='lab'>PROMOÇÃO:</span> <strong>" + data  + "</strong>";
							},
						},
						{
							"targets": 3,
							"data": 'CODIGO',
							"render": function (data, type, row, meta) {								
								return "<span class='lab'>CÓDIGO:</span> <strong>" + data + "</strong>";
							},
						},
						{
							"targets": 4,								
							"data": 'INICIO',
							"render": function ( data, type, row ) {
								return '<span class="lab">INÍCIO:</span> <strong>'+data['8']+data['9']+'/'+data['5']+data['6']+'/'+ data['0']+data['1']+data['2']+data['3']+'</strong>';						 						 
							},
						},
						{
							"targets": 6,
							"data": 'LOJA',
							"render": function (data, type, row, meta) {								
								return "<span class='lab'>LOJA</span> <strong>" + data + "</strong>";
							},
						},
						{
							"targets": 7,
							"data": 'PRECO',
							"render": function (data, type, row, meta) {								
								return "<p style='font-size:1.5em;'>R$  <strong>" + data +"</strong></p>";
							},
						},												
						{
							"targets": 8,								
							
							"data": 'STATUS',
							
							"render": function ( data, type, row ) {
								
								if(data == 'ATIVO')
								{
									var status = "btn-success";								
									}else{
									var status = "btn-default";
								}
								return '<button type="button" class="btn '+status+' btn-block status'+ row['CODIGO'] +'" id='+row['CODIGO']+' class="btn btn-primary">'+ data +'</button>';							
							},
						},						
						{
							"targets": 5,								
							"data": 'FIM',
							"render": function ( data, type, row ) {
								return '<span class="lab">FIM:</span> <strong>'+data['8']+data['9']+'/'+data['5']+data['6']+'/'+ data['0']+data['1']+data['2']+data['3']+'</strong></span>';						 						 
							},
						}
						],
						
						
						"oLanguage": {
							"sProcessing": "Aguarde enquanto os dados são carregados ...",
							"sLengthMenu": "Mostrar _MENU_ registros por pagina",
							"sZeroRecords": "Nenhum registro correspondente ao criterio encontrado",
							"sInfoEmtpy": "Exibindo 0 a 0 de 0 registros",
							"sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
							"sInfoFiltered": "",
							"sSearch": "Procurar : ",
							"oPaginate": {
								"sFirst":    "Primeiro",
								"sPrevious": "Anterior",
								"sNext":     "Próximo",
								"sLast":     "Último"
							}
						}
					});
				});
				
				$('#data-table').on('click', 'button', function () {															
					
					var table = $('#data-table').DataTable();																				
					
					var produto = $(this).attr("id");										
					
					var loja = <?php echo $_SESSION['loja']; ?>;										
					
					$.ajax({
						url:"altera-status.php",
						method:"POST",
						data:{produto:produto, loja:loja},
						success:function(data)
						{ 
							$('.status'+produto).html(data);
							
							if(data == 'INATIVO')
							{
								$('.status'+produto).removeClass('btn-success').addClass('btn-default');
								$('.cards'+produto).css('opacity', '0.5');
								
								
								}else{
								$('.status'+produto).removeClass('btn-default').addClass('btn-success');
							}
						}
					});					
				});					
					$('#tv_refresh').on('submit', function(event){						
						event.preventDefault();      
						$.ajax({
						 url:"http://192.168.0.210/intra/sistemas/bigmais/refresh/ssh.php?ip=<?php echo $_SESSION['tv']; ?>",
						 method:"POST",
						 data:new FormData(this),
						 contentType:false,
						 processData:false,
						 success:function(data)
							{								
							}
						})   
					});
				});						
		</script>		
	</head>
	<body> 
		<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<a href="index.php"><img src="/intra/sistemas/bigmais/img/logo_big_100.png" width="60px"> OFERTAS FRIOS - Loja <?php echo $_SESSION['nomeloja']; ?> </a>				
				<form name="tv_refresh" id="tv_refresh" method="POST">					
					<button name="submit" title="Atualizar TV">
						<img src="img/tv_refresh.png" style="width: 43px;">
					</button>
				</form>				
				</div>
				<div id="screen"></div>
				  <div class="card-body">
					<table id="data-table" class="table" width="100%">
						<thead>
							<tr>
								<th>IMG</th>
								<th>DESCRIÇÃO</th>
								<th>PROMOÇÃO</th>
								<th>SEQPRODUTO</th>
								<th>INÍCIO</th>
								<th>FIM</th>
								<th>LOJA</th>								
								<th>PREÇO</th>
								<th>AÇÕES</th>								
							</tr>
						</thead> 
					</table>
				</div>
			</div>
		</div>
	</body>
</html>