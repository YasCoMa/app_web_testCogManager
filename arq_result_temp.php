<?php
	include('funcoes_php_requeridas.php');
	conecta_ao_bd();
	 
	
	/* 
	$arquivo = 'Resultado_exportacao_bateriaEsecoes.xls';
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/x-msexcel");
	header ("Content-Disposition: attachment; filename={$arquivo}" );
	header ("Content-Description: PHP Generated Data" );
	 
	$lines= dados_bateria_secoes_export();
	 
	for ($i=0; $i<count($lines); $i++){
	    echo $lines[$i];
	}*/
	
	include("excelwriter.inc.php");
	
    $id=$_GET['id'];
	
	$excel=new ExcelWriter("results.xls");

    if($excel==false){
        echo $excel->error;
    }
   
    $myArr=array('Código do grupo', 'Sexo da pessoa', 'Idade da pessoa', 'Média do tempo', 'Média de acertos', 'Modo');
    $excel->writeLine($myArr);
	
	$query = "select bateria.cod, bateria.cod_grupo, pessoa.sexo, pessoa.idade, bateria.media_tempo, bateria.media_acertos, bateria.modo from bateria, pessoa where pessoa.cod=bateria.cod_pessoa and bateria.cod=".$id.";";
	$executar_query = mysql_query($query);
    while($ret = mysql_fetch_array($executar_query)){
	    $retorno_0 = $ret['cod_grupo'];
		$retorno_1 = $ret['sexo'];
		$retorno_2 = $ret['media_tempo'];
		$retorno_3 = $ret['media_acertos'];
		$retorno_4 = $ret['modo'];
		$retorno_5 = $ret['idade'];
		
		$myArr=array($retorno_0, $retorno_1, $retorno_5, $retorno_2, $retorno_3, $retorno_4;
		$excel->writeLine($myArr);
	}
	
	$excel->writeLine("","","","","","");
	
	$myArr=array('Código', 'Estímulo dado', 'Resposta obtida', 'Tempo de resposta', 'Correção', 'Data');
    $excel->writeLine($myArr);
	
	$query = "select * from secao where cod_bateria=".$id." ;";
	$executar_query = mysql_query($query);
    while($ret = mysql_fetch_array($executar_query)){
	    $retorno_0 = $ret['cod'];
		$retorno_2 = $ret['estimulo_dado'];
		$retorno_3 = $ret['resposta_obtida'];
		$retorno_4 = $ret['tempo_resposta'];
		$retorno_5 = $ret['correcao'];
		$retorno_6 = $ret['data'];
		
		$nova_data="";
		$sep= explode(" ", $retorno_6);
		$data=explode("-", $sep[0]);
		$nova_data.=$data[2]."/".$data[1]."/".$data[0]." ".$sep[1];
		$retorno_6=$nova_data;
		
		$myArr=array($retorno_0, $retorno_2, $retorno_3, $retorno_4, $retorno_5, $retorno_6);
		$excel->writeLine($myArr);
	}
	
	$excel->close();
	
	echo "<script>location.href='results.xls'</script>"
?>