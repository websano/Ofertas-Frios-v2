<!-- DEMAIS LOJAS -->

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<title>OFERTAS DO DIA</title>
	<script src="http://192.168.0.210/intra/sistemas/tv/dist/js/jquery.min.js"></script>
	<script src="http://192.168.0.210/intra/sistemas/tv/dist/js/bootstrap.min.js"></script>
	
	<style>
		body{margin:0px;padding:0px;}
		.container {padding:0px;margin:0px;background: url('img/fundo_ofertas.jpg') no-repeat;height:826px;background-size:1025px 830px;}
		.item{position: absolute;top: 220px;left: 100px;}
		.descricao{position: absolute;top: 50px;left: 60px;color: #ffffff;font-size: 2.9em;font-family: arial;font-weight: 700;text-shadow: 5px 5px 5px black;width:790px;}	
		.preco{position: absolute;top: 165px; right: 140px; color: #ff6a00;font-size: 10em;font-family: serif;font-weight: 700;text-shadow: 5px 5px 5px black;}				
		.preconormal{position: absolute;top: 149px; right: 140px;color: #fff;font-size: 1.5em;font-weight: 700;text-shadow: 5px 5px 5px black;}				
		.promocao{position: fixed;top: 380px; left: 650px;}
		.rodape {position: absolute;top: 680px; left: 5%;color: #FFF;font-size: 1.7em;font-family: arial;font-weight: 400;text-shadow: 2px 2px 5px black;}
		.dtofertas{color:#ff6a00;}
		.precokilo{position:absolute;display:block;color:white;width:200px;font-family: arial;font-size:1.0em;padding:5px 10px;font-weight:600;}
		.slide-fwd-top {animation: slide-fwd-top 0.45s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;}
		.tracking-in-expand {animation: tracking-in-expand 0.7s cubic-bezier(0.215, 0.610, 0.355, 1.000) both;}
		.scale-up-center {animation: scale-up-center 0.4s cubic-bezier(0.175, 0.885, 0.320, 1.275) 300ms both;}
		
/*
 * ----------------------------------------
 * animation slide-fwd-top
 * ----------------------------------------
 */
 
 
@-webkit-keyframes slide-fwd-top {
  0% {transform: translateZ(0) translateY(0);}
  100% {translateZ(160px) translateY(-100px);
  transform: translateZ(160px) translateY(-100px);}
}

@keyframes slide-fwd-top {
  0% {
    -webkit-transform: translateZ(0) translateY(0);
            transform: translateZ(0) translateY(0);
  }
  100% {
    -webkit-transform: translateZ(160px) translateY(-100px);
            transform: translateZ(160px) translateY(-100px);
  }
}


/*
 * ----------------------------------------
 * animation tracking-in-expand
 * ----------------------------------------
 */
 
@-webkit-keyframes tracking-in-expand {
  0% {
    letter-spacing: -0.5em;
    opacity: 0;
  }
  40% {
    opacity: 0.6;
  }
  100% {
    opacity: 1;
  }
}
@keyframes tracking-in-expand {
  0% {
    letter-spacing: -0.5em;
    opacity: 0;
  }
  40% {
    opacity: 0.6;
  }
  100% {
    opacity: 1;
  }
}


/*
 * ----------------------------------------
 * animation scale-up-center
 * ----------------------------------------
 */
 
@-webkit-keyframes scale-up-center {
  0% {
    -webkit-transform: scale(0.5);
            transform: scale(0.5);
  }
  100% {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
}
@keyframes scale-up-center {
  0% {
    -webkit-transform: scale(0.5);
            transform: scale(0.5);
  }
  100% {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
}


</style>

<?php 
	$loja = $_GET['loja'];

	$usuario ='consinco';
	$senha = 'consinco';
	$host = '192.168.0.245/bigmais';
	$porta = '1521';

	$conn = oci_connect($usuario,$senha,"$host:$porta");
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}else{
		// echo "Conexão ok!<br>";
	}
	
	// $promocoes = "'OFERTA INTERNA', '3 TV QQ 17-18/11', 'FOLHETO 18/11-01/12'";
	
	// final conexão oracle
	$stProd = oci_parse($conn,	
	"SELECT DESCCOMPLETA,SEQPRODUTO,DTAINICIO,DTAFIM,PROMOCAO,NROEMPRESA,PRECO,STATUS
		  FROM (SELECT
          V.DESCCOMPLETA,
          V.SEQPRODUTO,
          V.DTAINICIO,
          V.DTAFIM,
          V.PROMOCAO,
          V.NROEMPRESA,          
          REPLACE(TO_CHAR(V.PRECOUNIT, 'fm99G999D00'), '.', ',') AS PRECO,
          CASE
            WHEN (SELECT B.SEQPRODUTO
                    FROM BIGMAIS.OFERTAS_FRIOS B
                   WHERE B.SEQPRODUTO = V.SEQPRODUTO
                     AND V.NROEMPRESA = B.LOJA) IS NOT NULL THEN
             'ATIVO'
            ELSE
             'INATIVO'
          END AS STATUS,
          ROW_NUMBER() OVER(PARTITION BY V.SEQPRODUTO ORDER BY V.PRECOUNIT ASC) AS NUM_LINHA

          FROM CONSINCO.VIEW_PROMOCAO_FRIOS V
		   WHERE V.NROEMPRESA = '".$loja."'
           AND V.DTAINICIO <= to_char(SYSDATE, 'YYYY-MM-DD')
           AND V.DTAFIM >= to_char(SYSDATE, 'YYYY-MM-DD')
           AND V.NROSEGMENTO = '1'           
		   AND V.PROMOCAO NOT IN
               ('TESTE',
                'COLETA DATA - PERECIVEIS',
                'OFERTA INTERNA - PERECIVEIS')          
         ORDER BY V.PROMOCAO, V.DTAINICIO DESC ) RELATORIO
            WHERE RELATORIO.NUM_LINHA = 1");
		
	if(oci_execute($stProd)){
		while (($rowProduto = oci_fetch_assoc($stProd)) != false) {
			if($rowProduto['STATUS'] == 'ATIVO'){
				$arrayProd .= "\"carrega_ofertax.php?seqproduto=".$rowProduto['SEQPRODUTO']."&loja=".$loja."&dtinicio=".$rowProduto['DTAINICIO']."&dtfinal=".$rowProduto['DTAFIM']."\",";							
			}		
		}
	}
?>

<script>
    var linkArray=[<?php echo substr($arrayProd, 0, -1);?>];
    var timeout = 0;
    var counter = 0;
    var arrayCount = linkArray.length; 

    changeContent(timeout, counter, arrayCount);        

    function changeContent(def_timeout, def_counter, def_arrayCount) {

        // setTimeout(function() {$("#ofertas").load(linkArray[def_counter])}, def_timeout);
        $("#ofertas").load(linkArray[def_counter]);

        def_counter++;

        if (def_counter >= def_arrayCount)
            def_counter = 0;

        def_timeout = def_timeout + 5000;

        setTimeout(function() {changeContent(def_timeout, def_counter, def_arrayCount)}, 5000);
        }        

</script>	
</head>
<body>
<div class="container" id="ofertas"></div>
</body>
</html>

