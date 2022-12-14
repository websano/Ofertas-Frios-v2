<?php 

include 'custom/header.php';
include 'database_connection.php'; 

session_start(); 	

if(isset($_GET['loja'])){			
	$_SESSION['loja'] = $_GET['loja'];
}
	

?>
  
  <script src="../dist/jquery-2.1.3.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script type="text/javascript" src="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

  <link rel="stylesheet" type="text/css" href="../css/geral.css">	
  
<style>
body{margin:1%;  margin-top:0px; padding-top:0px; background-image: url("../../img/bg_sand.jpg");}
button{margin-bottom:5%;}
.altura{width:100%; margin:0 auto;border-radius:0px 0px 30px 30px;height:auto;}
.up{font-weight:700;}
.table-bordered td, .table-bordered th {vertical-align: middle;}
.esconde{display:none !important;}
.btnpeg{width:30%;height:30px;margin:5px;}
.grey{color:#999;}
.btn-secondary{background-color:#ccc;border-color:#666;}
.btn-secondary:hover{background-color:#999;border-color:#666;}

	body{margin:1%; margin-right:1.9%; background-image: url("../img/bg_sand.jpg");}
	button{margin-bottom:5%;}
	.altura{width:100%; margin:0 auto;border-radius:30px;height:auto;}
	.up{font-weight:700;}
	.table-bordered td, .table-bordered th {vertical-align: middle;}
	.esconde{display:none !important;}
	.btnpeg{width:30%;height:30px;margin:5px;}
	.grey{color:#999;}
	
	
	.btn-group.special {display: flex;}
	.special .btn {flex: 1;}
	.btn{margin:5px;}
	.btn:focus{background-color:#00577d;border-color:#0e2756;}
	
	
</style>
<body>		

	<div class="container-fluid ">							
	<div class="card altura">			
	<div class="card-body"> 														            													
	<div class="panel panel-default">               
   <div class="panel-heading">
    <div class="row"
	style="text-align: center;
    color: #000;
    width: 100%;
    border: 1px solid #ccc;
    padding-top: 27px;
    border-radius: 14px;
    background: rgb(230,230,230);
	background: linear-gradient(90deg, rgba(230,230,230,1) 0%, rgba(255,255,255,1) 46%, rgba(235,235,235,1) 100%);">
	
	<div class="col-md-4">
	<?php
	$iptv = '';	
	switch ($_SESSION['loja']) {
    case '1':
        $nomeloja = '1 - Jardim Pérola';
        $iptv = '192.168.1.144';
		break;
    case '2':
        $nomeloja = '2 - Treze de Maio';
		$iptv = '192.168.2.58';
        break;
    case '4':
        $nomeloja = '4 - Lagoa Santa';
		$iptv = '192.168.4.36';
        break;
	case '5':
        $nomeloja = '5 - Altinópolis';
		$iptv = '';
        break;
	case '8':
        $nomeloja = '8 - Vila Isa';
		$iptv = '192.168.8.158';
        break;	
	case '9':
        $nomeloja = '9 - São Pedro';
		$iptv = '192.168.9.186';
        break;
	}
	?>
	
	
	<h3 class="h3">Loja <?php echo $nomeloja; ?></span></h3>
   </div>
   <div class="col-md-4">
		<input type="text" name="search" id="search" placeholder="Busca r&aacute;pida" class="form-control" style="font-size: 1.5em;">	
   </div>
   <div class="col-md-4">
   <button type="button" name="add"  id="add_button" data-toggle="modal" data-target="#userModal" onclick="resetForm()" class="btn btn-lg btn-success btn-block" data-toggle="collapse" data-target="#user_collapse"><i class="fa fa-plus"></i> CADASTRAR PRODUTO</button>
   </div>   
   </div>
   </div>
<div class="container box">        
 <div id="userModal" class="modal modalproduto">
	<div class="modal-dialog modal-lg">
   <div class="modal-content">
				<div class="modal-header">					
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
    <form method="post" id="user_form">
     <div class="row">	 	 
	 <div class="col-md-6">	 
	
	 
	
	 <div class="form-group">
			<div class="descBanco">
			<label for="descricao">Descrição</label>
			<select name="descricao_banco" id="descricao_banco" class="form-control synch synch2"  onchange="pegadescricao(event)" readonly>
			<?php 									
				$stmt = $concentrador->prepare("SELECT * FROM vW_consulta_produtos_frios order by descricao");
				if ($stmt->execute()){
				$VerificaProduto = $stmt->fetch();				
				while($VerificaProduto = $stmt->fetch()){
					?>					
						<option value="<?php echo $VerificaProduto['descricao']; ?>"><?php echo $VerificaProduto['descricao']; ?></option>				
					<?php
					}
				}			 
			 ?>			 
			 </select>			 
			 <hr>
			 </div>
			<label for="descricao">Descrição para o cliente:</label>
			 <input type="text" name="descricao" id="descricao" class="form-control" placeholder = "Definir nome para o cliente" style="margin-top:4px;">

		 </div>
		 
		 <script> /////////////// DEFINIR NOME PARA O CLIENTE //////////////////  
			
				function pegadescricao(e) {
					document.getElementById("descricao").value = e.target.value
				}
		 </script>
     
		
			<div class="form-group">
			<label for="codProduto">Código produto:</label>
			<select name="codProduto" id="codProduto" class="form-control synch" readonly>
			<?php 									
				$stmtCod = $concentrador->prepare("SELECT * FROM vW_consulta_produtos_frios order by descricao");
				if ($stmtCod->execute()){
				$VerificaCodigo = $stmtCod->fetch();				
				while($VerificaCodigo = $stmtCod->fetch()){
					?>				
						<option value="<?php echo $VerificaCodigo['codigo_ean']; ?>"><?php echo $VerificaCodigo['codigo_ean']; ?></option>
					
					<?php
					}
				}			 
			 ?>
			 </select>			 
		 </div>	
	<div class="form-group">
			<label for="codProduto">Seq produto:</label>
			<select name="seqProduto" id="seqProduto" class="form-control synch2" readonly>
			<?php 									
				$stmtCod = $concentrador->prepare("SELECT * FROM vW_consulta_produtos_frios order by descricao");
				if ($stmtCod->execute()){
				$VerificaCodigo = $stmtCod->fetch();				
				while($VerificaCodigo = $stmtCod->fetch()){
					?>				
						<option value="<?php echo $VerificaCodigo['codigo_produto']; ?>"><?php echo $VerificaCodigo['codigo_produto']; ?></option>
					
					<?php
					}
				}			 
			 ?>
			 </select>			 
		 </div>			 
	 </div>	 	
	 <div class="col-md-6">		 
		<div id="form-imagem" class="atualizar_foto">			
			<label for="file" class="btn btn-info btn-lg" id="btn-imagem" style="margin-top: 32px;padding: 3px;width:100%;"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Anexar foto</label>
				<input type="file" name="file" style="visibility:hidden;" id="file"/>
				<img name="arquivo_imagem_atualizar" id="arquivo_imagem_atualizar" style="max-width:300px;">
				<input type="text" name="arquivo_imagem_atualizar" class="arquivo_imagem_atualizar" style="display:none;">
			</div>   
		<span id="upload_image"></span>	 

	 </div>	 	 
	 </div>	 	 
	 </div>	 
     <br />	 
	 <div class="modal-footer">	      
      <input type="hidden" name="action" id="action" />
      <input type="hidden" name="user_id" id="user_id" />
      <button type="buttom" name="button_action" id="button_action" class="btn btn-success btn-block" style="font-size:1.3em; font-weight:700;"/>GRAVAR</button>
	  <!--div id="divMsg"><img src="../img/carregando.gif" width="150px" /></div-->
	 </div>	 			 
	</div>     

		<script>
			var $synch = $(".synch").on('change', function() {
			  $synch.not(this).get(0).selectedIndex = this.selectedIndex;
			});	
			var $synch2 = $(".synch2").on('change', function() {
			  $synch2.not(this).get(0).selectedIndex = this.selectedIndex;
			});			
		</script>


 	</div>	 
	 </div>
    </form>   	

</div>  
</div>        
   <div id="user_table" class="table-responsive">   
   </div>
   <br />
   <br />
   <br />
   <br />
   <span style="black;width:100%;position:absolute;bottom:3px;"><center style="font-size:0.7em;"><a href="../../"><img src="../img/logo-bigmais.svg" width="100px"></a><br>© <?php echo date('Y'); ?> - Todos os direitos reservados</center></span>
  </div>
  
							
			</div>
		</div>
	</div>
	</div>
<div id="tv"></div>

</body>
</html>



<script type="text/javascript">

function resetForm(){
	document.forms["user_form"].reset(); 
    $('#divMsg').hide(); 
	$('.arquivo_imagem_atualizar').val('');
    $("#arquivo_imagem_atualizar").prop("src",'');
    $('#upload_image').hide(); 
	$('.descBanco').show();
    $('#btn-imagem').show();
	$("#arquivo_imagem_atualizar").removeProp("src"); 	
	$('#arquivo_imagem_atualizar').val('');
	$("#button_action").removeAttr('disabled');	
	$("#codProduto").removeAttr('disabled');		
	$("#seqProduto").removeAttr('disabled');		
	$('.cod_preco').show();
	$('.up').hide();	
	document.getElementById("descricao").value = $("#descricao_banco option:first").val();
	
}


 $(document).ready(function(){  
  load_data();
  $('.anexar_foto').show();
  // $('.atualizar_foto').hide();
  $('.cod_preco').show();
  $('#action').val("Gravar");
  $('#add').click(function(){  
   $('#user_form')[0].reset();   
   $('#uploaded_image').html('');
   $('#button_action').val("Gravar");
  });

  
////////////////
  
 
function load_data(page)
  {
   var action = "Load";
   $.ajax({
    url:"action.php",
    method:"POST",
    data:{action:action, page:page},
    success:function(data)
    {	 
     $('#user_table').html(data);
	 $('#userModal').modal('hide');
	 $('.cod_preco').show();
	 
    }
   });   
  }

  
/// INSERT 

  $('#user_form').on('submit', function(event){
   event.preventDefault();   
   var descricao = $('#descricao').val();
   var codProduto = $('#codProduto').val();
   var seqProduto = $('#seqProduto').val();
   var arquivo_imagem_atualizar = $('#arquivo_imagem_atualizar').val();      
    $.ajax({
     url:"action.php",
     method:"POST",
     data:new FormData(this),
     contentType:false,
     processData:false,
     success:function(data)
     {	  
      $('#user_form')[0].reset();	  
	  load_data();      
      $('#action').val("Gravar");
      $('#button_action').val("Gravar");
      // $('#arquivo_imagem_atualizar').html('');	  
     location.reload();
	 }
    })	 
         //your client side validation here
         if(valid)
            return true;
         else
            {
              $(this).removeAttr('disabled');
              $('#divMsg').hide();			  
              return false;
            }
	});
	
	
	
  
  // UPDATE
  $(document).on('click', '.update', function(){
   var user_id = $(this).attr("id");
   var action = "Fetch Single Data";   
   
   $.ajax({
    url:"action.php",
    method:"POST",
    data:{user_id:user_id, action:action},
    dataType:"json",
    success:function(data)
    {
	 $('.arquivo_imagem_atualizar').val(data.arquivo_imagem_atualizar);
	 $("#arquivo_imagem_atualizar").prop("src",data.arquivo_imagem_atualizar);
     $('.modalproduto').modal("show");
	 $('.anexar_foto').hide();
	 $('.descBanco').hide();
	 $('.up').show();	 
	 $('.atualizar_foto').show();			  
     $('#descricao').val(data.descricao);     
     $('#codProduto').val(data.codProduto);  	 
     $('#seqProduto').val(data.seqProduto);  	 
     $('#button_action').val("Editar");
     $('#action').val("Editar");
     $('#user_id').val(user_id);
    }
   });
  });
  
  // DELETAR
  $(document).on('click', '.delete', function(){
   var user_id = $(this).attr("id");
   var action = "Delete";
   if(confirm("Deseja mesmo excluir?"))
   {
    $.ajax({
     url:"action.php",
     method:"POST",
     data:{user_id:user_id, action:action},
     success:function(data)
     {
      //alert(data);
      load_data();
     }
    });
   }
   else
   {
    return false;
   }
  });
  
  
  // STATUS
  $(document).on('click', '.status', function(){
   var user_id = $(this).attr("ids");
   var acao = $(this).attr("acao");   
   var action = "Status";   
   var status = "Ativado";   
    $.ajax({
		url:"action.php",
		method:"POST",
		data:{user_id:user_id, action:action, status:status, acao:acao},
		success:function(data)
		{			
			$(".load"+user_id).css('display', 'block');
			$(".btn"+user_id).hide();
			$('#tv').load("http://192.168.0.210/intra/sistemas/bigmais/refresh/ssh.php?ip=<?php echo $iptv; ?>").fadeIn("slow");  			
			load_data();
		}
    });
  });
  
  
  // BUSCA  
  
  $('#search').keyup(function(){
   var query = $('#search').val();
   var action = "Search";
   if(query != '')
   {
    $.ajax({
     url:"action.php",
     method:"POST",
     data:{query:query, action:action},
     success:function(data)
     {
      $('#user_table').html(data);
     }
    });
   }
   else
   {
    load_data();
   }
  }); 


  
 });


	$(document).ready(function(){
	 $(document).on('change', '#file', function(){
	  var name = document.getElementById("file").files[0].name;
	  var form_data = new FormData();
	  var ext = name.split('.').pop().toLowerCase();
	  if(jQuery.inArray(ext, ['jpg','jpeg','png','webp']) == -1) 
	  {
	   alert("Arquivo inválido!");
	  }
	  var oFReader = new FileReader();
	  oFReader.readAsDataURL(document.getElementById("file").files[0]);
	  var f = document.getElementById("file").files[0];
	  var fsize = f.size||f.fileSize;
	  if(fsize > 20000000)
	  {
	   alert("Arquivo muito grande!");
	  }
	  else
	  {
	   form_data.append("file", document.getElementById('file').files[0]);
	   $.ajax({
		url:"up_imagem.php",
		method:"POST",
		data: form_data,
		contentType: false,
		cache: false,
		processData: false,
		beforeSend:function(){
		 // $('#upload_image').html("<label class='text-success'><img src='../img/carregando.gif'  width='40px'> Carregando arquivo...</label>");
		},   
		success:function(data)
		{
		 $('#upload_image').show(); 
		 $('#upload_image').html(data);
		 $("#arquivo_imagem_atualizar").css('display', 'none');		 
		}
	   });
	  }
	 });
	});
	
</script>