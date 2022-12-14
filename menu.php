<?php session_start(); 	?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<title>OFERTAS DO DIA</title>	
	<link rel="stylesheet" href="../dist/bootstrap.min.css">	
<style>
	body{margin:1%; margin-right:1.9%; background-image: url("../img/bg_sand.jpg");}
	button{margin-bottom:2%;}
	.altura{width:100%; margin:0 auto;border-radius:30px;height:auto;}
	.up{font-weight:700;}
	.table-bordered td, .table-bordered th {vertical-align: middle;}
	.esconde{display:none !important;}
	.btnpeg{width:30%;height:30px;margin:5px;}
	.grey{color:#999;}
	
	.btn-group.special {display: flex;}
	.special .btn {flex: 1;}
	.btn{margin:5px;}	
	.btn:focus{background-color:#00577d;border-color:#000;}
	
</style>
</head>
<body>

<div class="container-fluid ">						
	<div class="card altura">			
    <div class="card-body" style="padding-bottom:100px;"> 
				<div class="card-header d-flex align-items-center  p-2">
				  <h5 class="h5 p-1" style="text-align:center;color:#000; width:100%;">Gerenciamento de Ofertas dos <strong>FRIOS</strong> por loja</span></h5>
				</div>									            
            <div class="panel panel-default">               
               <div class="panel-heading p-2">
   <div class="row">
   <div class="col-md-12">   
   
      
   <div class="btn-group special" role="group">
		<button type="button" onclick="window.open('carrega.php?loja=1','loja');" class="btn btn-danger">LOJA 01</button>		
		<button type="button" onclick="window.open('carrega.php?loja=2','loja');" class="btn btn-danger">LOJA 02</button>		
		<button type="button" onclick="window.open('carrega.php?loja=4','loja');" class="btn btn-danger">LOJA 04</button>		
		<button type="button" onclick="window.open('carrega.php?loja=5','loja');" class="btn btn-danger">LOJA 05</button>		
		<button type="button" onclick="window.open('carrega.php?loja=8','loja');" class="btn btn-danger">LOJA 08</button>		
		<button type="button" onclick="window.open('carrega.php?loja=9','loja');" class="btn btn-danger">LOJA 09</button>				
	</div>   
   
	
   </div>
   </div>
   
   </div>    
   </div>  
   </div>   
   </div>   
   </div>   

</body>
</html>

