<?php
	// Para tratar strings com acentuação para por no value
	function removeAcentos($var) {
	    $array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç" 
						,"Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", " " ); 
						
		$array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c" 
						,"A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "_" ); 
						
		$var = str_replace( $array1, $array2, $var);
		
		$var = mb_strtolower($var);
		
		return $var;
	 }
	
	// Para o banco de dados
    function conecta_ao_bd(){
		$con=mysql_connect('localhost','root','yasmmin') or die ("Houve um erro ao fazer a conexão com o servidor.<br>".mysql_error());
		mysql_query("SET NAMES 'utf8'");
        mysql_query('SET character_set_connection=utf8');
        mysql_query('SET character_set_client=utf8');
        mysql_query('SET character_set_results=utf8');
		
		$projeto='sun';
		mysql_select_db($projeto);
	}
	
	function getNome ($d,$l){
	    if ($d=='site'){
			$consulta="select nome from admin_site where login='".$l."';";
		}		
		if ($d=='teste'){
			$consulta="select nome from admin_teste where login='".$l."';";
		}
		
		$res=mysql_query($consulta);
		$num_busca=mysql_num_rows($res);
			
		if ($num_busca==1){
			$resultado=mysql_fetch_row($res);
			return $resultado;
		}
		else {
			echo "<script>alert('Nenhum nome encontrado!');</script>";
		}
		
	}
	
	// Autenticação de administradores
	function logar() {
		$t = $_POST["tipo"];   
		$l = $_POST["login"];
		$s = $_POST["senha"];
		
		if ($t=='site'){
			$consulta="select nome, cod from admin_site where login='".$l."' and senha='".$s."'";
			$res=mysql_query($consulta) or die (mysql_error());
			$num_busca=mysql_num_rows($res) ;
			
			if ($num_busca==1){
				$resultado=mysql_fetch_row($res);
				setcookie("log", 'limssim-'.$l, time()+7200);
				setcookie("nome",$resultado[0],time()+7200);
				setcookie("id_p",$resultado[1],time()+7200);
				echo "<script>location.href = 'indice.php';</script>";
			}
			else {
				echo "<script>alert('Login ou senha incorretos!');</script>";
			}
		}	
		else {
			if ($t=='teste') {
				$consulta="select nome, cod from admin_teste where login='".$l."' and senha='".$s."'";
				$res=mysql_query($consulta);
				$num_busca=mysql_num_rows($res);
				
				if ($num_busca==1){
					$resultado=mysql_fetch_row($res);
					setcookie("log", 'limtsim-'.$l, time()+7200);
					setcookie("nome",$resultado[0],time()+7200);
					setcookie("id_p",$resultado[1],time()+7200);
					echo "<script>location.href = 'indice.php';</script>";
				}
				else {
					echo "<script>alert('Login ou senha incorretos!');</script>";
				}
			}
		}
	}
	
	// Sair da sessão
	function sair(){
		setcookie ("log");
		setcookie ("nome");
	}
	
	// Função para enviar email
	function enviar_mail($para,$assunto,$mensagem){
		date_default_timezone_set('UTC');
		require("phpmailer/class.phpmailer.php");
		$mail = new PHPMailer(); 
		$mail->IsSMTP(); // send via SMTP
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = "site.testes.cog"; // SMTP username
		$mail->Password = "Poliushko"; // SMTP password
		
		$webmaster_email = "site.testes.cog@gmail.com"; //Reply to this email ID
		$mail->From = $webmaster_email;
		$mail->FromName = "Ykirá - Sistema web de aplicação e avaliação de testes cognitivos";
		$mail->AddReplyTo($webmaster_email,"Webmaster");
		
		$email=$para; // Recipients email ID
		$name="Ykirá - Sistema web de aplicação e avaliação de testes cognitivos"; // Recipient's name
		$mail->AddAddress($email,$name);
		
		$mail->WordWrap = 50; // set word wrap
		$mail->IsHTML(true); // send as HTML
		$mail->Subject = $assunto;
		$mail->Body = $mensagem; //HTML Body
		$mail->AltBody = "This is the body when user views in plain text format"; //Text Body
		
		return $mail->Send();
	}
	
	// Lembra a senha dos administradores
	function buscar_enviar_senha(){
		$tipo=$_GET['tipo'];
		$login=$_GET['login'];
		
	    $consulta="select nome, senha from admin_".$tipo." where login='".$login."';";
		$res=mysql_query($consulta)or die(mysql_error());
		$num_busca=mysql_num_rows($res);
		
		$result="5&";
		if ($num_busca==1){
			$resultado=mysql_fetch_row($res);
			$mensagem="Olá ".$resultado[0].", sua senha é ".$resultado[1];
			
			if(enviar_mail($login,"Lembrete de senha",$mensagem)){
				$result.="Sua senha foi enviada para seu e-mail de login!";
			}
			else {
				$result.="O e-mail não pôde ser enviado, verifique o login digitado!-".$login."-Lembrete de senha-".$mensagem;
			}
		}
		else {
			$result.="Esta combinação de login e tipo estão incorretos ou este login não está no sistema!";
		}
		echo $result;
	}
	
	// Para gerenciar o administrador de testes
		// Incluir e alterar
	function cadastraAtualiza_AdTeste($param){
		$chamada="";
		
		if ($param=='cadastro'){
			$nome=$_POST['nome'];
			$instituto=$_POST['inst'];
			$nucleo=$_POST['nucleo'];
			$login=$_POST['email'];
			$senha=$_POST['senha'];
			
			$chamada="call inserir_adminTeste ('$nome','$instituto','$nucleo','$login','$senha');";
		}
		if ($param=='atualiza1'){
			$nome=$_POST['n'];
			$instituto=$_POST['i'];
			$nucleo=$_POST['nu'];
			$login=$_POST['lo_'];
			$senha=$_POST['se'];
			
			$chamada="call alterar_adminTeste ('$login','$nome','$instituto','$nucleo','$senha');";
		}
		if ($param=='atualiza2'){
			$nome=$_GET['n1'];
			$instituto=$_GET['i1'];
			$nucleo=$_GET['nu1'];
			$login=$_GET['l1'];
			$senha=$_GET['s1'];
			
			$chamada="call alterar_adminTeste ('$login','$nome','$instituto','$nucleo','$senha');";
		}
		
		$pos= array();
		$pos[0]=strpos($login,'iff.edu.br');
		$pos[1]=strpos($login,'hotmail.com');
		$pos[2]=strpos($login,'gmail.com');
		$pos[3]=strpos($login,'yahoo.com.br');
		
		$pos1=strpos($login,'@');
		
		$valida=false;
		
		for ($i=0;$i<4;$i++){
			if ($pos[$i]>0 and $pos1>0){
				$valida=true;
			}
		}
		if (strpos($login,'"')>0 or strpos($login,"'")>0 or strpos($login,'\\')>0 or strpos($login,'/')>0){
			$valida=false;
		}
		if (strpos($nome,'"')>0 or strpos($nome,"'")>0 or strpos($nome,'\\')>0 or strpos($nome,'/')>0){
			$valida=false;
		}
		if (strpos($instituto,'"')>0 or strpos($instituto,"'")>0 or strpos($instituto,'\\')>0 or strpos($instituto,'/')>0){
			$valida=false;
		}
		if (strpos($nucleo,'"')>0 or strpos($nucleo,"'")>0 or strpos($nucleo,'\\')>0 or strpos($nucleo,'/')>0){
			$valida=false;
		}
		if (strpos($senha,'"')>0 or strpos($senha,"'")>0 or strpos($senha,'\\')>0 or strpos($senha,'/')>0){
			$valida=false;
		}
		
		if ($valida){
			if (strlen($senha)==7 or strlen($senha)==8 or strlen($senha)==9 or strlen($senha)==10){
				$grava = mysql_query($chamada)or die(mysql_error());
				
				$num_busca=mysql_num_rows($grava);
				if ($num_busca>0){
					$r="";
					for ($i=0;$i<$num_busca;$i++){
						$resultado=mysql_fetch_row($grava);
						for ($j=0;$j<count($resultado);$j++){
							$r.=$resultado[$j];
						}
					}
					if($param=='atualiza2'){
						echo "27&".$r;
					}
					else{
						echo "<script>alert('".$r."')</script>";
						echo "<script>location.href = 'indice.php';</script>";
					}
				}
			}
			else{
				echo "<script>alert('A senha deve ter de 7 a 10 caracteres!')</script>";
			}
		}
		else{
			echo "<script>alert('Os campos não foram preenchidos corretamente!')</script>";
		}
	}
	
		// Excluir
	function exclui_AdTeste(){
		$login=$_POST['l'];
		$senha=$_POST['s'];
		
		$pos= array();
		$pos[0]=strpos($login,'iff.edu.br');
		$pos[1]=strpos($login,'hotmail.com');
		$pos[2]=strpos($login,'gmail.com');
		$pos[3]=strpos($login,'yahoo.com.br');
		
		$pos1=strpos($login,'@');
		
		$valida=false;
		
		for ($i=0;$i<4;$i++){
			if ($pos[$i]>0 and $pos1>0){
				$valida=true;
			}
		}
		if (strpos($login,'"')>0 or strpos($login,"'")>0 or strpos($login,'\\')>0 or strpos($login,'/')>0){
			$valida=false;
		}
		if (strpos($senha,'"')>0 or strpos($senha,"'")>0 or strpos($senha,'\\')>0 or strpos($senha,'/')>0){
			$valida=false;
		}
		//senha de 7 a 10 dígitos.
		if ($valida){
			if (strlen($senha)==7 or strlen($senha)==8 or strlen($senha)==9 or strlen($senha)==10){
				$excluir="call excluir_adminTeste ('$login','$senha');";
				$grava = mysql_query($excluir)or die(mysql_error());
				
				$num_busca=mysql_num_rows($grava);
				if ($num_busca>0){
					$r="";
					for ($i=0;$i<$num_busca;$i++){
						$resultado=mysql_fetch_row($grava);
						for ($j=0;$j<count($resultado);$j++){
							$r.=$resultado[$j];
						}
					}
					echo "<script>alert('".$r."')</script>";
					echo "<script>location.href = 'indice.php';</script>";
				}
			}
			else{
				echo "<script>alert('A senha deve ter de 7 a 10 caracteres!')</script>";
			}
		}
		else{
			echo "<script>alert('Os campos não foram preenchidos corretamente!')</script>";
		}
	}
	
		// Consulta todos os registros
	function mostra_tudo_adTeste($a){
		$consulta='select * from admin_teste;';
		
		$properties=array("", "has_name", "has_institute","has_researchCore", "has_login", "has_password");
		
		$result="";
		$res=mysql_query($consulta);
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($res);
				$result.='<tr typeof="administrator_test" resource="#adminTest_'.$resultado[0].'">';
				for ($j=0;$j<count($resultado);$j++){
					if($j==0){
						$result.="<td>".$resultado[$j]."</td>";
					}
					else{
						if($j==count($resultado)-1){
							$result.="<td property='".$properties[$j]."' >".md5($resultado[$j])."</td>";
						}
						else {
							$result.="<td property='".$properties[$j]."' >".$resultado[$j]."</td>";
						}
					}
				}
				$result.="</tr>";
			}
		}
		else {
			$result.="<font color='#b22222'>Não há nenhum cadastrado!</font>";
		}
		if($a=='1'){
		    return $result;
		}
		if($a=='2'){
		    echo "3&<table>".$result."</table>";
		}
	}	
		// Consulta a partir de parâmetros
	function pesquisa_com_parametro_adTeste(){
		$campo=$_GET['campo'];
		$valor=$_GET['valor'];
		
		conecta_ao_bd();
		
		$consulta='select * from admin_teste where '.$campo.' like "%'.$valor.'%";';
		$properties=array("", "has_name", "has_institute","has_researchCore", "has_login", "has_password");
		
		$result="2&<table>";
		$res=mysql_query($consulta);
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($res);
				$result.='<tr typeof="administrator_test" resource="#adminTest_'.$resultado[0].'">';
				for ($j=0;$j<count($resultado);$j++){
					if($j==0){
						$result.="<td>".$resultado[$j]."</td>";
					}
					else{
						if($j==count($resultado)-1){
							$result.="<td property='".$properties[$j]."' >".md5($resultado[$j])."</td>";
						}
						else {
							$result.="<td property='".$properties[$j]."' >".$resultado[$j]."</td>";
						}
					}
				}
				$result.="</tr>";
			}
		}
		else {
			$result.="<font color='#b22222'>Não há nenhum registro com estes itens de pesquisa!</font>";
		}
		
		echo $result."</table>";
	}
	
	// Pesquisa dados para preencher os campos a serem atualizados
	function consulta_preenche_campos_adTeste(){
	    $l=$_GET['login'];
		$s=$_GET['senha'];
		
		conecta_ao_bd();
		
		$consulta='select * from admin_teste where login="'.$l.'" and senha="'.$s.'";';
		$result="1&";
		$res=mysql_query($consulta)or die(mysql_error());
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($res);
				for ($j=0;$j<count($resultado);$j++){
				    if ($j==count($resultado)-1){
					    $result.=$resultado[$j];
					}
					else {
					    $result.=$resultado[$j]."-";
					}
				}
			}
		}
		else {
		    $result='Não foi encontrado nenhum registro com esta combinação de login e senha!';
		}
		echo $result;
	}	
	
	// Pesquisa dados para preencher os campos a serem atualizados
	function pesquisa_admin($ad){
	    $a = explode("-",$_COOKIE["log"]);
		
		conecta_ao_bd();
		$result="";
		if ($ad=='site'){
		    $consulta='select * from admin_site where login="'.$a[1].'";';
			$result.="4&";
		}
		if ($ad=='teste'){
		    $consulta='select * from admin_teste where login="'.$a[1].'";';
			$result.="6&";
		}
		
		$res=mysql_query($consulta)or die(mysql_error());
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($res);
				for ($j=0;$j<count($resultado);$j++){
				    if ($j==count($resultado)-1){
					    $result.=$resultado[$j];
					}
					else {
					    $result.=$resultado[$j]."-";
					}
				}
			}
		}
		else{
		    $result='Não foi encontrado nenhum registro com esta combinação de login e senha!';
		}
		echo $result;
	}	
	
	// Altera administrador de site 
	function altera_adSite(){
	    $login=$_GET['l0'];
		$nome=$_GET['n0'];
		$senha=$_GET['s0'];
		
		$chamada="call alterar_adminSite('$login','$nome','$senha');";
		$grava = mysql_query($chamada)or die(mysql_error());
				
		$num_busca=mysql_num_rows($grava);
		if ($num_busca>0){
			$r="26&";
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($grava);
				for ($j=0;$j<count($resultado);$j++){
				    $r.=$resultado[$j];
				}
			}
			echo $r;
		}
	}
	
	// Para gerenciar grupo
		// Mostra todos os dados de grupo
	function mostra_tudo_grupo($a){
		$consulta='select * from grupo where cod_pesquisador='.$_COOKIE['id_p'].';';
		
		$properties=array("","has_date","has_administrator","has_typeTest","data_value_config","mode_answer","number_of_attempts");
		$contents=array("#adminTest_","#typeTest_");
		$fr=0;
		
		$result="";
		$res=mysql_query($consulta);
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$fr=0;
				$resultado=mysql_fetch_row($res);
				$result.='<tr typeof="profile_test" resource="#profileTest_'.$resultado[0].'">';
				for ($j=0;$j<count($resultado);$j++){
					if($j==0){
						$result.="<td>".$resultado[$j]."</td>";
					}
					else{
						if($j==2 or $j==3){
							$result.="<td property='".$properties[$j]."' resource='".$contents[$fr].$resultado[$j]."'>".$resultado[$j]."</td>";
							$fr++;
						}
						else{
							$result.="<td property='".$properties[$j]."' >".$resultado[$j]."</td>";
						}
					}
				}
				$result.="</tr>";
			}
		}
		else {
			$result.="<font color='#b22222'>Não há nenhum cadastrado!</font>";
		}
		if($a=='1'){
		    return $result;
		}
		if($a=='2'){
		    echo "7&<table>".$result."</table>";
		}
	}
		// Consulta os dados para fazer o formulário de dados específicos dos testes
	function consulta_dadosForTest() {
	    $id_teste=$_GET['id'];
	    $consulta='select dados_campo from tipo_teste where cod='.$id_teste.';';
		
		$id1=$_GET['co'];
		
		$result="";
		$final="";
		
		$res=mysql_query($consulta)or die(mysql_error());
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($res);
				$result.=$resultado[0];
			}
		}
		else {
			$final.="9&Não existe tipo de teste com este código!";
		}
		
		if ($final=="") {
			$medium = explode(";",$result);
			$final.="9&<div id='title_extra'>Dados específicos para o teste escolhido:</div><table>";
			
			$adicionais = substr_count($result, '&campo_lista');
			$aux=0;
			
			for ($j=0;$j<(count($medium));$j++){
				if (($j+1) %2!=0){
					$final.='<tr>';
					$final.='<td>';
					if (strpos($medium[$j],'|')>0){
						$c=explode(":",$medium[$j]);
						$final.='<label>'.$c[0].':</label>';
						
						if (strpos($c[1], 'campo_lista')>0){
							$str_aux="";
							$final.="<select id='y".$j."' name='y".$j."' onChange='if (this.value==\"palavras\") {showDiv2(this.value+\"".$j."\", true);} else {showDiv2(\"palavras".$j."\", false);}'>";
							$ops=explode('|',$c[1]);
							for ($h=0;$h<count($ops);$h++){
								if(strpos($ops[$h], 'campo_lista')>0){
									$g=explode('#',$ops[$h]);
									$final.="<option value='".removeAcentos($g[0])."'>".$g[0]."</option>";
									$str_aux.=removeAcentos($g[0]).$j;
								}
								else {
									$final.="<option value='".removeAcentos($ops[$h])."'>".$ops[$h]."</option>";
								}
								
								
							}
							$final.="</select>";
							$final.="<textarea name='".$str_aux."' id='".$str_aux."' cols='20' rows='3' maxLength='200' onkeypress='limitar(this)' onpaste='limitar(this)' placeholder='palavra1, palavra2...até 9 palavras!' style='display:none'></textarea>";
						}
						else {
							$final.="<select id='y".$j."' name='y".$j."'>";
							$ops=explode('|',$c[1]);
							for ($h=0;$h<count($ops);$h++){
								$final.="<option value='".removeAcentos($ops[$h])."'>".$ops[$h]."</option>";
							}
							$final.="</select>";
						}
						
					}
					else {
						$final.='<label>'.$medium[$j].'</label>';
						$final.='<input type="text" name="y'.$j.'" id="y'.$j.'"  size="10">';
					}
					$final.='</td>';
					
					if ($j==(count($medium)-1)){
						$final.='</tr><br>';
					}
				}
				else {
					$final.='<td>';
					if (strpos($medium[$j],'|')>0){
						$c=explode(":",$medium[$j]);
						$final.='<label>'.$c[0].':</label>';
						
						if (strpos($c[1], 'campo_lista')>0){
							$str_aux="";
							$final.="<select id='y".$j."' name='y".$j."' onChange='if (this.value==\"palavras\") {showDiv2(this.value+\"".$j."\", true);} else {showDiv2(\"palavras".$j."\", false);}'>";
							$ops=explode('|',$c[1]);
							for ($h=0;$h<count($ops);$h++){
								if(strpos($ops[$h], 'campo_lista')>0){
									$g=explode('#',$ops[$h]);
									$final.="<option value='".removeAcentos($g[0])."'>".$g[0]."</option>";
									$str_aux.=removeAcentos($g[0]).$j;
								}
								else {
									$final.="<option value='".removeAcentos($ops[$h])."'>".$ops[$h]."</option>";
								}
								
								
							}
							$final.="</select>";
							$final.='<input type="text" name="'.$str_aux.'" id="'.$str_aux.'" placeholder="palavra1,palavra2"  size="10" style="display:none">';
						}
						else {
							$final.="<select id='y".$j."' name='y".$j."'>";
							$ops=explode('|',$c[1]);
							for ($h=0;$h<count($ops);$h++){
								$final.="<option value='".removeAcentos($ops[$h])."'>".$ops[$h]."</option>";
							}
							$final.="</select>";
						}
					}
					else {
						$final.='<label>'.$medium[$j].'</label>';
						$final.='<input type="text" name="y'.$j.'" id="y'.$j.'"  size="10">';
					}
					$final.='</td>';
					$final.='</tr><br>';
				}
			}
			$qw=count($medium);
			setcookie("qct", "".$qw, time()+3600);
			
			if ($_GET['op']==0){
				echo $final.'</table>&c';
			}
			if ($_GET['op']==1){
				$consult='select dados from grupo where cod='.$id1.';';
				$resu="";
				$res=mysql_query($consult)or die(mysql_error());
				$num_busca=mysql_num_rows($res);
				if ($num_busca>0){
					for ($i=0;$i<$num_busca;$i++){
						$resulta=mysql_fetch_row($res);
						$resu.=$resulta[$i];
					}
				}
				else {
					$result='Não foi encontrado nenhum registro com este código!';
				}
			
				echo $final.'</table>&a&'.$resu.'&'.$qw;
			}
		}
		else {
		    echo $final;
		}
	}
		// Cadastra e atualiza grupo
	function cadastra_atualiza_grupo($param){
		$chamada="";
		$erro="";
		
		$valida=1;
		
		if ($param=='cadastro'){
		    // Obtem id do pesquisador atual
			if (empty($_COOKIE["id_p"]) or $_COOKIE["id_p"]==''){
				$valida=0;			 
			}
			else {
				$id_pes=$_COOKIE["id_p"]; 
			}
			
			// Id do tipo de teste
			if (empty($_POST["id_teste_g"]) or $_POST["id_teste_g"]==''){
				$valida=0;			 
			}
			else {
				$id_teste=$_POST["id_teste_g"];
			}
			
			// Obtem a quantidade de seções
			if (empty($_POST["q_secoes"]) or $_POST["q_secoes"]==''){
				$valida=0;			 
			}
			else {
				$secoes=$_POST["q_secoes"];
			}
			
			// Trata os dados
			$dados="";
			if (empty($_COOKIE["qct"]) or $_COOKIE["qct"]==''){
				$valida=0;			 
			}
			else {
				$quant_=$_COOKIE["qct"];
				settype($quant_, "integer");
				for ($r=0;$r<$quant_;$r++){
					if (empty($_POST['y'.$r]) or $_POST['y'.$r]==''){
						$valida=0;
					}
					else {
						if ($r!=$quant_-1){
							$dados.=$_POST['y'.$r];
							$word=$_POST['y'.$r];
							if(isset($_POST[$word.$r])){
								if (empty($_POST[$word.$r]) or $_POST[$word.$r]==''){
									$valida=0;
								}
								else {
									$dados.='_'.$_POST[$word.$r].'-';
								}
							}
							else {
								$dados.='-';
							}
						}
						else {
							$dados.=$_POST['y'.$r];
							$word=$_POST['y'.$r];
							if(isset($_POST[$word.$r])){
								if (empty($_POST[$word.$r]) or $_POST[$word.$r]==''){
									$valida=0;
								}
								else {
									$dados.='_'.$_POST[$word.$r];
								}
							}
						}
					}
				}
			}
			
			if ($valida==0){
				$erro.='\nPreencha todos os campos.';
			}
			else {
				// Modo de resposta
				if (empty($_POST["mod_"]) or $_POST["mod_"]==''){
					$valida=0;			 
				}
				else {
					$mod_res=$_POST["mod_"];
					if ($mod_res=='teclado'){
						if (empty($_POST["teclas"]) or $_POST["teclas"]==''){
							$valida=0;
						}
						else {
						    $valida=1;
						}
						$comp="";
						if ($valida==1) {
							$teclas = explode(",", $_POST['teclas_a']);
							
							for ($i=0; $i<count($teclas); $i++){
							
								if (strlen($teclas[$i])>1){
									$erro.="As teclas para responder via teclado devem ter somente um caracter.";
									$valida=0;
								}
								else {
									$cvalidos="abcdefghijklmnopqrstuwxyz0123456789";
									if (strpos($cvalidos,$teclas[$i])===false ){
										$erro.="As teclas para responder via teclado devem ser números ou letras minúsculas.";
										$valida=0;
									}
									else {
										$cont=0;
										for ($j=0; $j<count($teclas);$j++){
											if ($teclas[$i]==$teclas[$j]){
											   $cont+=1;
											}
										}
										if ($cont>1){
											$erro.="As teclas para responder via teclado devem ser diferentes.";
											$valida=0;
										}
										else {
											$comp.= '_'.$teclas[$i];
											$valida=1;
										}
									}
								}
							}
						}
						else {
							$erro.='\nPreencha todos os campos.';
						}
						
						if ($valida==1){
							$mod_res.=$comp;
							$chamada="call inserir_grupo ($id_pes, $id_teste, '$dados', '$mod_res', $secoes)";
						}
						
					}
					else {
						$valida=1;
						$chamada="call inserir_grupo ($id_pes, $id_teste, '$dados', '$mod_res', $secoes)";
					}
				}
			}
		}
		if ($param=='atualiza') {
		    $co=$_POST["co00"];
			
			if (empty($_COOKIE["id_p"]) or $_COOKIE["id_p"]==''){
				$valida=0;			 
			}
			else {
				$id_pes=$_COOKIE["id_p"]; 
			}
			if (empty($_POST["id_tt0"]) or $_POST["id_tt0"]==''){
				$valida=0;			 
			}
			else {
				$id_teste=$_POST["id_tt0"];
			}
						
			if (empty($_POST["q_secoes_a"]) or $_POST["q_secoes_a"]==''){
				$valida=0;			 
			}
			else {
				$secoes=$_POST["q_secoes_a"];
			}
			
			// Trata os dados
			$dados="";
			if (empty($_COOKIE["qct"]) or $_COOKIE["qct"]==''){
				$valida=0;			 
			}
			else {
				$quant_=$_COOKIE["qct"];
				settype($quant_, "integer");
				for ($r=0;$r<$quant_;$r++){
					if (empty($_POST['y'.$r]) or $_POST['y'.$r]==''){
						$valida=0;
					}
					else {
						if ($r!=$quant_-1){
							$dados.=$_POST['y'.$r];
							$word=$_POST['y'.$r];
							if(isset($_POST[$word.$r])){
								if (empty($_POST[$word.$r]) or $_POST[$word.$r]==''){
									$valida=0;
								}
								else {
									$dados.='_'.$_POST[$word.$r].'-';
								}
							}
							else {
								$dados.='-';
							}
						}
						else {
							$dados.=$_POST['y'.$r];
							$word=$_POST['y'.$r];
							if(isset($_POST[$word.$r])){
								if (empty($_POST[$word.$r]) or $_POST[$word.$r]==''){
									$valida=0;
								}
								else {
									$dados.='_'.$_POST[$word.$r];
								}
							}
						}
					}
				}
			}
			
			if ($valida==0){
				$erro.='\nPreencha todos os campos.';
			}
			else {
				// Modo de resposta
				if (empty($_POST["mod_a"]) or $_POST["mod_a"]==''){
					$valida=0;			 
				}
				else {
					$mod_res=$_POST["mod_a"];
					if ($mod_res=='teclado'){
						if (empty($_POST["teclas_a"]) or $_POST["teclas_a"]==''){
							$valida=0;
						}
						else {
						    $valida=1;
						}
						$comp="";
						if ($valida==1) {
							$teclas = explode(",", $_POST['teclas_a']);
							
							for ($i=0; $i<count($teclas);$i++){
							
								if (strlen($teclas[$i])>1){
									$erro.="As teclas para responder via teclado devem ter somente um caracter.";
									$valida=0;
								}
								else {
									$cvalidos="abcdefghijklmnopqrstuwxyz0123456789";
									if (strpos($cvalidos,$teclas[$i])===false ){
										$erro.="As teclas para responder via teclado devem ser números ou letras minúsculas.";
										$valida=0;
									}
									else {
										$cont=0;
										for ($j=0; $j<count($teclas);$j++){
											if ($teclas[$i]==$teclas[$j]){
											   $cont+=1;
											}
										}
										if ($cont>1){
											$erro.="As teclas para responder via teclado devem ser diferentes.";
											$valida=0;
										}
										else {
											$comp.= '_'.$teclas[$i];
											$valida=1;
										}
									}
								}
							}
						}
						else {
							$erro.='\nPreencha todos os campos.';
						}
						if ($valida==1){
							$mod_res.=$comp;
							$chamada="call alterar_grupo ($co, $id_teste, '$dados', '$mod_res',$secoes)";
						}
					}
					else {
						$valida=1;
						$chamada="call alterar_grupo ($co, $id_teste, '$dados', '$mod_res',$secoes)";
					}
				}
			}
		}
		
		if ($valida==1){
			$grava = mysql_query($chamada)or die(mysql_error());
			
			$num_busca=mysql_num_rows($grava);
			if ($num_busca>0){
				$p="";
				for ($i=0;$i<$num_busca;$i++){
					$resultado=mysql_fetch_row($grava);
					for ($j=0;$j<count($resultado);$j++){
						$p.=$resultado[$j];
					}
				}
				echo "<script>alert('".$p."')</script>";
				echo "<script>location.href = 'indice.php';</script>";
			}
		 }
		 else {
		 	 echo "<script>alert('".$erro."');</script>";
		 }
		 
	}
		// Exclui grupo
	function exclui_grupo(){
	    if (!empty($_POST['id_grupo']) or $_POST['id_grupo']==' '){
			$cod=$_POST['id_grupo'];
			
			$excluir="call excluir_grupo ('$cod');";
			$grava = mysql_query($excluir)or die(mysql_error());
			
			$num_busca=mysql_num_rows($grava);
			if ($num_busca>0){
				$r="";
				for ($i=0;$i<$num_busca;$i++){
					$resultado=mysql_fetch_row($grava);
					for ($j=0;$j<count($resultado);$j++){
						$r.=$resultado[$j];
					}
				}
				echo "<script>alert('".$r."')</script>";
				echo "<script>location.href = 'indice.php';</script>";
			}
		}
		else {
		    echo "<script>alert('Preencha o campo!')</script>";
		}
	}
		// Pesquisa dados para alterar 
	function pesquisa_dados_grupo(){
	    $id=$_GET['id'];
		
		conecta_ao_bd();
		
		$consulta='select * from grupo where cod='.$id.';';
		$result="11&";
		$res=mysql_query($consulta)or die(mysql_error());
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($res);
				for ($j=0;$j<count($resultado);$j++){
				    if ($j==count($resultado)-1){
					    $result.=$resultado[$j];
					}
					else {
					    $result.=$resultado[$j]."|";
					}
				}
			}
		}
		else {
		    $result='Não foi encontrado nenhum registro com este código!';
		}
		
		echo $result;
	}
	
	// Para gerenciar Tipo de teste
		// Cadastra e atualiza tipo de teste
	function cadastra_atualiza_tipoTeste ($param){
		$chamada="";
		
		if ($param=='cadastro'){
		    $nom=$_POST['nome0'];
			$desc=$_POST['descricao'];
			$area=$_POST['area0'];
			$obje=$_POST['obj0'];
			$dados=$_POST['data_info'];
			
			$chamada="call inserir_tipoTeste ('$nom','$desc','$area','$obje','$dados');";
		}
		if ($param=='atualiza'){
			$cod=$_POST['co11'];
			$nom=$_POST['nome1'];
			$desc=$_POST['descricao1'];
			$area=$_POST['area1'];
			$obje=$_POST['obj1'];
			$dados=$_POST['data_info1'];
			
			$chamada="call alterar_tipoTeste ('$cod','$nom','$desc','$area','$obje','$dados');";
		}
		
		if (strlen($nom)>0 and strlen($desc)>0 and strlen($area)>0 and strlen($obje)>0 and strlen($dados)>0){
			$grava = mysql_query($chamada)or die(mysql_error());
			
			$num_busca=mysql_num_rows($grava);
			if ($num_busca>0){
				$r="";
				for ($i=0;$i<$num_busca;$i++){
					$resultado=mysql_fetch_row($grava);
					for ($j=0;$j<count($resultado);$j++){
						$r.=$resultado[$j];
					}
				}
				echo "<script>alert('".$r."')</script>";
				echo "<script>location.href = 'indice.php';</script>";
			}
		}
		else {
			echo "<script>alert('Há campo(s) vazio(s)!')</script>";
		}
	}
		
		// Mostra todos os dados de tipo de teste	
	function mostra_tudo_tipoTeste($a){
	    $consulta='select * from tipo_teste;';
		
		$properties=array("","has_name","has_description","has_area","has_objective","data_field_config","has_status");
		
		$result="";
		$res=mysql_query($consulta) ;
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($res);
				$result.='<tr typeof="type_test" resource="#typeTest_'.$resultado[0].'">';
				for ($j=0;$j<count($resultado);$j++){
					if($j==0){
						$result.="<td>".$resultado[$j]."</td>";
					}
					else{
						$result.="<td property='".$properties[$j]."' >".$resultado[$j]."</td>";
					}
				}
				$result.="</tr>";
			}
		}
		else {
			$result.="<font color='#b22222'>Não há nenhum cadastrado!</font>";
		}
		if($a=='1'){
		    return $result;
		}
		if($a=='2'){
		    echo "8&<table>".$result."</table>";
		}
	}
	
		// Exclui tipo de teste
	function exclui_tipoTeste(){
	    $cod=$_POST['id_tipoTeste'];
		
		$excluir="call excluir_tipoTeste ('$cod');";
		$grava = mysql_query($excluir)or die(mysql_error());
		
		$num_busca=mysql_num_rows($grava);
		if ($num_busca>0){
			$r="";
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($grava);
				for ($j=0;$j<count($resultado);$j++){
					$r.=$resultado[$j];
				}
			}
			echo "<script>alert('".$r."')</script>";
			echo "<script>location.href = 'indice.php';</script>";
		}
	}
	
		// Pesquisa dados para alterar 
	function pesquisa_tipoTeste(){
	    $id=$_GET['id'];
		
		conecta_ao_bd();
		
		$consulta='select * from tipo_teste where cod='.$id.';';
		$result="10&";

		$res=mysql_query($consulta)or die(mysql_error());

		$num_busca=mysql_num_rows($res);

		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($res);
				for ($j=0;$j<count($resultado);$j++){
				    if ($j==count($resultado)-1){
					    $result.=$resultado[$j];
					}
					else {
					    $result.=$resultado[$j]."-";
					}
				}
			}
		}
		else {
		    $result='Não foi encontrado nenhum registro com este código!';
		}
		
		echo $result;
	}
	
	// Para pessoa
	function cad_pessoa(){
	    conecta_ao_bd();
		
		$nome=$_GET["n"];
		$idade=$_GET["i"];
		$sexo=$_GET["s"];
		$comp=$_GET["c"];
		$lado=$_GET["l"];
		
		$chamada="call inserir_pessoa('$nome','$idade','$sexo','$comp','$lado');";
		
		$grava = mysql_query($chamada)or die(mysql_error());
			
		$num_busca=mysql_num_rows($grava);
		if ($num_busca>0){
			$r="12&";
			$resp_="";
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($grava);
				for ($j=0;$j<count($resultado);$j++){
					$resp_.=$resultado[$j];
				}
			}
			
			$f=explode(":",$resp_);
			$r.=$f[0];
			$id_pessoa=$f[1];
			
			if ($r=='12&Cadastro feito com sucesso!'){
			    if(!empty($_COOKIE['log'])){
					if (strpos($_COOKIE['log'],'tsim')>0){
						$r.='&logsim';
					}
					else {
					    $r.=$_COOKIE['log'];
					}
				}
				else {
				    $r.='&lognao';
				}
				 
				 setcookie('pessoa', $id_pessoa.'', time()+3600);
			}
			else {
			
			}
			echo $r.'&_'.$_GET['app_atual'];;
		}
	}
	
	// Obtém a configuração do jogo para preparar
	function consulta_config_1 (){
	    $modo=$_GET['modo'];
		conecta_ao_bd();
		
		if ($modo=='fixo'){
			$id=$_GET['id_grupo'];
			
			$consulta='select dados, via_resp, num_secoes from grupo where cod='.$id.' and cod_tipo_teste='.$_GET['app_atual'].';';
			$result="13&";
			$res=mysql_query($consulta)or die(mysql_error());
			$num_busca=mysql_num_rows($res);
			if ($num_busca>0){
				for ($i=0;$i<$num_busca;$i++){
					$resultado=mysql_fetch_row($res);
					for ($j=0;$j<count($resultado);$j++){
						if ($j==count($resultado)-1){
							$result.=$resultado[$j];
						}
						else {
							$result.=$resultado[$j]."-";
						}
					}
				}
				
				setcookie("grupo",$id,time()+3600);
				setcookie("modo",$modo,time()+3600);
			
			}
			else {
				$result.='Não foi encontrado nenhum registro com este código!';
			}
			
			echo $result.'&_'.$_GET['app_atual'];
			
		}
		if ($modo=='aleatorio'){
			$count=0;
			
			$list= array();
			
			$cons='select cod from grupo where cod_tipo_teste='.$_GET['app_atual'].';';
			$re=mysql_query($cons) or die(mysql_error());
			$num_search =mysql_num_rows($re);
			if($num_search>0){
				for($k=0;$k<$num_search;$k++){
					$resp=mysql_fetch_row($re);
					$list[$k]=$resp[0];
				}
			}
			
			shuffle($list);
			
			$consulta='select dados, via_resp, num_secoes from grupo where cod='.$list[0].';';
			$result="13&";
			$res=mysql_query($consulta)or die(mysql_error());
			$num_busca=mysql_num_rows($res);
			if ($num_busca>0){
				for ($i=0;$i<$num_busca;$i++){
					$resultado=mysql_fetch_row($res);
					for ($j=0;$j<count($resultado);$j++){
						if ($j==count($resultado)-1){
							$result.=$resultado[$j];
						}
						else {
							$result.=$resultado[$j]."-";
						}
					}
				}
				
				setcookie("grupo",$list[0],time()+3600);
				setcookie("modo",$modo,time()+3600);
				
			}
			else {
				$result.='Não foi encontrado nenhum registro com este código!';
			}
			echo $result.'&_'.$_GET['app_atual'];
			
		}
	}
	
	function cria_bateria(){
	    $id_pessoa=$_COOKIE['pessoa'];
		$id_grupo=$_COOKIE['grupo'];
		$modo=$_COOKIE['modo'];
				
		conecta_ao_bd();
		
		$chamada="call inserir_bateria ( $id_grupo, $id_pessoa, '$modo' );";
		$grava = mysql_query($chamada)or die(mysql_error());
		
		$num_busca=mysql_num_rows($grava);
		if ($num_busca>0){
			$id_bateria=0;
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($grava);
				for ($j=0;$j<count($resultado);$j++){
					$id_bateria = $resultado[$j];
				}
			}
			
			setcookie("bateria",$id_bateria,time()+3600);
			setcookie("grupo");
			setcookie("modo");
			
			echo "15&".$id_bateria;
		}
	}
	
	
	function envia_result_test(){
		$mod=$_GET['mod'];
		
	    $id_bateria=$_COOKIE['bateria'];
		
		if ($mod=='final'){
			$media_tempos=$_GET['media_tempos'];
			$media_acertos=$_GET['media_acertos'];
			
			$flag=$_GET['flag'];
			
			$r='14&';
			
			conecta_ao_bd();
			
			$chamada="update bateria set media_tempo=concat(media_tempo, '$media_tempos'), media_acertos=concat(media_acertos,'$media_acertos') where cod=$id_bateria;";
			$grava = mysql_query($chamada)or die(mysql_error());
				
			$num_busca=mysql_affected_rows();
			if ($num_busca>0){
				if ($flag==1){
					$r.="ok_final".'&'.$_GET['app'];
					echo $r;
				}
				
			}	
			else {
				$r.='no';
			}		
			
			
		}
		else if($mod=='parcial'){
			$tempo = $_GET['tempo'];
			$correcao = $_GET['correcao'];
			$estimulo = $_GET['estimulo_dado'];
			$resposta = $_GET['resposta_obtida'];
			$quant_elem = $_GET['quant_'];
			
			$r='14&';
			
			conecta_ao_bd();
			
			$cont=0;
			$sql="call inserir_secao ( $id_bateria, '$estimulo', '$resposta', $tempo, '$correcao', $quant_elem);";  
				
			$grava = mysql_query($sql)or die(mysql_error());
				
			$num_busca=mysql_num_rows($grava);
			if ($num_busca>0){
				$r.="ok_parcial".'&'.$_GET['app'];
				echo $r;
			}
			else {
				$r.='no';
			}	
		} 
		
	}
	
	// Para gerenciar bateria
		// Mostra todos os dados da bateria
	function mostra_tudo_bateria($a){
		$consulta='select bateria.cod, bateria.cod_grupo, pessoa.sexo, pessoa.idade, bateria.media_tempo, bateria.media_acertos, bateria.modo, bateria.data from bateria, pessoa, grupo where bateria.cod_grupo=grupo.cod and pessoa.cod=bateria.cod_pessoa ;';
		
		$properties=array("","has_profileTest","","","average_time","average_successes","mode_control","has_date");
		$contents=array("#profileTest_");
		$fr=0;
		
		$result="";
		$res=mysql_query($consulta);
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$fr=0;
				$resultado=mysql_fetch_row($res);
				$result.='<tr typeof="battery" resource="#battery_'.$resultado[0].'">';
				for ($j=0;$j<count($resultado);$j++){
					
					if(strpos($resultado[$j], "-")>0){
					    $nova_data="";
						$data=explode("-", $resultado[$j]);
						$nova_data.=$data[2]."/".$data[1]."/".$data[0];
						$resultado[$j]=$nova_data;
					}
					if($j==0 or $j==3 or $j==3){
						$result.="<td>".$resultado[$j]."</td>";
					}
					else{
						if($j==1){
							$result.="<td property='".$properties[$j]."' resource='".$contents[$fr].$resultado[$j]."'>".$resultado[$j]."</td>";
							$fr++;
						}
						else{
							$result.="<td property='".$properties[$j]."' >".$resultado[$j]."</td>";
						}
					}
				}
				$result.="</tr>";
			}
		}
		else {
			$result.="<font color='#b22222'>Não há nenhum cadastrado!</font>";
		}
		if($a=='1'){
		    return $result;
		}
		if($a=='2'){
		    echo "16&<table>".$result."</table>";
		}
	}
	
		// Consulta a partir de parâmetros
	function pesquisa_com_parametro_grupo(){
		$campo=$_GET['campo'];
		$valor=$_GET['valor'];
		
		conecta_ao_bd();
		
		$consulta='select * from grupo where '.$campo.' like "%'.$valor.'%" and cod_pesquisador='.$_COOKIE['id_p'].';';
		
		$properties=array("","has_date","has_administrator","has_typeTest","data_value_config","mode_answer","number_of_attempts");
		$contents=array("#adminTest_","#typeTest_");
		$fr=0;
		
		$result="17&<table>";
		$res=mysql_query($consulta);
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$fr=0;
				$resultado=mysql_fetch_row($res);
				$result.='<tr typeof="profile_test" resource="#profileTest_'.$resultado[0].'">';
				for ($j=0;$j<count($resultado);$j++){
					if($j==0){
						$result.="<td>".$resultado[$j]."</td>";
					}
					else{
						if($j==2 or $j==3){
							$result.="<td property='".$properties[$j]."' resource='".$contents[$fr].$resultado[$j]."'>".$resultado[$j]."</td>";
							$fr++;
						}
						else{
							$result.="<td property='".$properties[$j]."' >".$resultado[$j]."</td>";
						}
					}
				}
				$result.="</tr>";
			}
		}
		else {
			$result.="<font color='#b22222'>Não há nenhum registro com estes itens de pesquisa!</font>";
		}
		
		echo $result."</table>";
	}
	
		// Consulta a partir de parâmetros
	function pesquisa_com_parametro_tipoTeste(){
		$campo=$_GET['campo'];
		$valor=$_GET['valor'];
		
		conecta_ao_bd();
		if ($campo=='cod'){
			$consulta='select * from tipo_teste where '.$campo.'="'.$valor.'" ;';
		}
		else {
			$consulta='select * from tipo_teste where '.$campo.' like "%'.$valor.'%" ;';
		}
		
		$properties=array("","has_name","has_description","has_area","has_objective","data_field_config","has_status");
		
		$result="18&<table>";
		$res=mysql_query($consulta) ;
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$resultado=mysql_fetch_row($res);
				$result.='<tr typeof="type_test" resource="#typeTest_'.$resultado[0].'">';
				for ($j=0;$j<count($resultado);$j++){
					if($j==0){
						$result.="<td>".$resultado[$j]."</td>";
					}
					else{
						$result.="<td property='".$properties[$j]."' >".$resultado[$j]."</td>";
					}
				}
				$result.="</tr>";
			}
		}
		else {
			$result.="<font color='#b22222'>Não há nenhum registro com estes itens de pesquisa!</font>";
		}
		
		echo $result."</table>";
	}
	
		// Consulta a partir de parâmetros
	function pesquisa_com_parametro_bateria(){
		$campo=$_GET['campo'];
		$valor=$_GET['valor'];
		
		conecta_ao_bd();
		if ($campo=='modo') {
			$consulta='select bateria.cod, bateria.cod_grupo, pessoa.sexo, pessoa.idade, bateria.media_tempo, bateria.media_acertos, bateria.modo, bateria.data from bateria, pessoa, grupo where bateria.'.$campo.'="'.$valor.'" and bateria.cod_grupo=grupo.cod and pessoa.cod=bateria.cod_pessoa ;';
		}
		else if($campo=='idade' or$campo=='sexo'){
			$consulta='select bateria.cod, bateria.cod_grupo, pessoa.sexo, pessoa.idade, bateria.media_tempo, bateria.media_acertos, bateria.modo, bateria.data from bateria, pessoa, grupo where pessoa.'.$campo.'="'.$valor.'" and bateria.cod_grupo=grupo.cod and pessoa.cod=bateria.cod_pessoa ;';
		}
		else {
			$consulta='select bateria.cod, bateria.cod_grupo, pessoa.sexo, pessoa.idade, bateria.media_tempo, bateria.media_acertos, bateria.modo, bateria.data from bateria, pessoa, grupo where bateria.'.$campo.'='.$valor.' and bateria.cod_grupo=grupo.cod and pessoa.cod=bateria.cod_pessoa ;';
		}
		
		$properties=array("","has_profileTest","","","average_time","average_successes","mode_control","has_date");
		$contents=array("#profileTest_");
		$fr=0;
		
		$result="19&<table>";
		$res=mysql_query($consulta);
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$fr=0;
				$resultado=mysql_fetch_row($res);
				$result.='<tr typeof="battery" resource="#battery_'.$resultado[0].'">';
				for ($j=0;$j<count($resultado);$j++){
					
					if(strpos($resultado[$j], "-")>0){
					    $nova_data="";
						$data=explode("-", $resultado[$j]);
						$nova_data.=$data[2]."/".$data[1]."/".$data[0];
						$resultado[$j]=$nova_data;
					}
					if($j==0 or $j==3 or $j==3){
						$result.="<td>".$resultado[$j]."</td>";
					}
					else{
						if($j==1){
							$result.="<td property='".$properties[$j]."' resource='".$contents[$fr].$resultado[$j]."'>".$resultado[$j]."</td>";
							$fr++;
						}
						else{
							$result.="<td property='".$properties[$j]."' >".$resultado[$j]."</td>";
						}
					}
				}
				$result.="</tr>";
			}
		}
		else {
			$result.="<font color='#b22222'>Não há nenhum registro com estes itens de pesquisa!</font>";
		}
		
		echo $result."</table>";
	}
	
	// Para gerenciar seção
		// Mostra todos os dados da seção
	function mostra_tudo_secao($a){
		$consulta='select secao.cod, secao.cod_bateria, secao.estimulo_dado, secao.resposta_obtida, secao.tempo_resposta, secao.correcao, secao.data, secao.quant_elem from bateria, secao, grupo where bateria.cod_grupo=grupo.cod and secao.cod_bateria=bateria.cod order by cod_bateria;';
		
		$properties=array("","has_battery","stimulus_given","answer_given","time_of_answer","correction","has_date","number_of_elements");
		$contents=array("#battery_");
		$fr=0;
		
		$result="";
		$res=mysql_query($consulta);
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$fr=0;
				$resultado=mysql_fetch_row($res);
				$result.='<tr typeof="session" resource="#session_'.$resultado[0].'">';
				for ($j=0;$j<count($resultado);$j++){
					
					if(strpos($resultado[$j], ":")>0){
					    $nova_data="";
						$sep= explode(" ", $resultado[$j]);
						$data=explode("-", $sep[0]);
						$nova_data.=$data[2]."/".$data[1]."/".$data[0]." ".$sep[1];
						$resultado[$j]=$nova_data;
					}
					if($j==0){
						$result.="<td>".$resultado[$j]."</td>";
					}
					else{
						if($j==1){
							$result.="<td property='".$properties[$j]."' resource='".$contents[$fr].$resultado[$j]."'>".$resultado[$j]."</td>";
							$fr++;
						}
						else{
							$result.="<td property='".$properties[$j]."' >".$resultado[$j]."</td>";
						}
					}
				}
				$result.="</tr>";
			}
		}
		else {
			$result.="<font color='#b22222'>Não há nenhum cadastrado!</font>";
		}
		if($a=='1'){
		    return $result;
		}
		if($a=='2'){
		    echo "20&<table>".$result."</table>";
		}
	}

		// Consulta a partir de parâmetros
	function pesquisa_com_parametro_secao(){
		$campo=$_GET['campo'];
		$valor=$_GET['valor'];
		
		conecta_ao_bd();
		if ($campo=='estimulo_dado' or $campo=='resposta_obtida' or $campo=='correcao' or $campo=='data') {
			$consulta='select secao.cod, secao.cod_bateria, secao.estimulo_dado, secao.resposta_obtida, secao.tempo_resposta, secao.correcao, secao.data, secao.quant_elem from bateria, secao, grupo where secao.'.$campo.' like "%'.$valor.'%" and bateria.cod_grupo=grupo.cod and secao.cod_bateria=bateria.cod ;';
		}
		else {
			$consulta='select secao.cod, secao.cod_bateria, secao.estimulo_dado, secao.resposta_obtida, secao.tempo_resposta, secao.correcao, secao.data, secao.quant_elem from bateria, secao, grupo where secao.'.$campo.'='.$valor.'   and bateria.cod_grupo=grupo.cod and secao.cod_bateria=bateria.cod ;';
		}
		
		$properties=array("","has_battery","stimulus_given","answer_given","time_of_answer","correction","has_date","number_of_elements");
		$contents=array("#battery_");
		$fr=0;
		
		$result="21&<table>";
		$res=mysql_query($consulta);
		$num_busca=mysql_num_rows($res);
		if ($num_busca>0){
			for ($i=0;$i<$num_busca;$i++){
				$fr=0;
				$resultado=mysql_fetch_row($res);
				$result.='<tr typeof="session" resource="#session_'.$resultado[0].'">';
				for ($j=0;$j<count($resultado);$j++){
					
					if(strpos($resultado[$j], ":")>0){
					    $nova_data="";
						$sep= explode(" ", $resultado[$j]);
						$data=explode("-", $sep[0]);
						$nova_data.=$data[2]."/".$data[1]."/".$data[0]." ".$sep[1];
						$resultado[$j]=$nova_data;
					}
					if($j==0){
						$result.="<td>".$resultado[$j]."</td>";
					}
					else{
						if($j==1){
							$result.="<td property='".$properties[$j]."' resource='".$contents[$fr].$resultado[$j]."'>".$resultado[$j]."</td>";
							$fr++;
						}
						else{
							$result.="<td property='".$properties[$j]."' >".$resultado[$j]."</td>";
						}
					}
				}
				$result.="</tr>";
			}
		}
		else {
			$result.="<font color='#b22222'>Não há nenhum registro com estes itens de pesquisa!</font>";
		}
		
		echo $result."</table>";
	}
	
	function enviar_mensagem(){
	    $assunto=$_POST['subject'];
		$mensagem=$_POST['mensagem'];
		$id=$_COOKIE['id_p'];
		$tipo="";
		
		$pos1=strpos($_COOKIE["log"],'tsim');
		$pos2=strpos($_COOKIE["log"],'ssim');
		
		if ($pos1 > 0){
			$tipo='teste';
		}
		else if($pos2>0){
			$tipo='site';
		}
		$chamada="call adiciona_mensagem ('$assunto','$mensagem',$id, '$tipo');";
		
		
		if (strlen($assunto)>0 and strlen($mensagem)>0 ){
			$grava = mysql_query($chamada)or die(mysql_error());
			
			$num_busca=mysql_num_rows($grava);
			if ($num_busca>0){
				$r="";
				for ($i=0;$i<$num_busca;$i++){
					$resultado=mysql_fetch_row($grava);
					for ($j=0;$j<count($resultado);$j++){
						$r.=$resultado[$j];
					}
				}
				echo "<script>alert('".$r."')</script>";
				echo "<script>location.href = 'indice.php';</script>";
			}
		}
		else {
			echo "<script>alert('Há campo(s) vazio(s)!')</script>";
		}
	}
	
	function dados_bateria_secoes_export(){
		
		include("excelwriter.inc.php");

		$id=$_GET['id'];
	
		$excel=new ExcelWriter("results.xls");

		if($excel==false){
			echo $excel->error;
		}
        
		$myArr=array(" "," ","Relatório completo: "," "," "," ");
		$excel->writeLine($myArr);
		
		$myArr=array(" "," "," "," "," "," ");
		$excel->writeLine($myArr);
		
		$myArr=array("Dados de configuração: "," "," "," "," "," ");
		$excel->writeLine($myArr);
		
		$id_teste=0;
		$query = "select tipo_teste.dados_campo, tipo_teste.cod from tipo_teste, grupo, bateria where tipo_teste.cod=grupo.cod_tipo_teste and grupo.cod=bateria.cod_grupo and bateria.cod=".$id.";";
		$executar_query = mysql_query($query);
		while($ret = mysql_fetch_array($executar_query)){
			$myArr=array();
			$myArr[0]='Nome do avaliador';
			$id_teste=$ret['cod'];
			$retorno_0=$ret['dados_campo'];
			$f=explode(";", $retorno_0);
			$i=0;
			for($i; $i<count($f);$i++){
				$t=explode(':', $f[$i]);
			    $myArr[$i+1]=$t[0];
			}
			$myArr[$i+1]='Modo de resposta';
			
			$excel->writeLine($myArr);
		}
		
		
		$query = "select admin_teste.nome, grupo.dados, grupo.via_resp from grupo, bateria, admin_teste where admin_teste.cod=grupo.cod_pesquisador and grupo.cod=bateria.cod_grupo and bateria.cod=".$id.";";
		$executar_query = mysql_query($query);
		while($ret = mysql_fetch_array($executar_query)){
			$retorno_0 = $ret['nome'];
			$retorno_1 = $ret['dados'];
			$f=explode("-", $retorno_1);
			
			$retorno_2 = $ret['via_resp'];
			if(strpos($retorno_2,'_')>0){
			    $r=explode('_',$retorno_2);
				if($id_teste==1){
					$retorno_2=$r[0]." Letras: ".$r[1]."-Sim"." e ".$r[2]."-Não";
				}
			}
			
			$myArr=array();
			$myArr[0]=$retorno_0;
			$i=0;
			for($i; $i<count($f);$i++){
			    $myArr[$i+1]=$f[$i];
			}
			$myArr[$i+1]=$retorno_2;
			
			$excel->writeLine($myArr);
		}
		
		$myArr=array(" "," "," "," "," "," ");
		$excel->writeLine($myArr);
		
		$myArr=array("Dados da pessoa: "," "," "," "," "," ");
		$excel->writeLine($myArr);
		
		$myArr=array('Nome', 'Idade', 'Sexo', 'Usa computador', 'Dominância manual');
		$excel->writeLine($myArr);
		
		$query = "select pessoa.nome, pessoa.idade, pessoa.sexo, pessoa.usa_computador, pessoa.dominancia_manual from bateria, pessoa where pessoa.cod=bateria.cod_pessoa and bateria.cod=".$id.";";
		$executar_query = mysql_query($query);
		while($ret = mysql_fetch_array($executar_query)){
			$retorno_0 = $ret['nome'];
			$retorno_1 = $ret['idade'];
			$retorno_2 = $ret['sexo'];
			$retorno_3 = $ret['usa_computador'];
			$retorno_4 = $ret['dominancia_manual'];
			
			$myArr=array($retorno_0, $retorno_1, $retorno_2, $retorno_3, $retorno_4);
			$excel->writeLine($myArr);
		}
		
		$myArr=array(" "," "," "," "," "," ");
		$excel->writeLine($myArr);
		
		$myArr=array("Dados da bateria: "," "," "," "," "," ");
		$excel->writeLine($myArr);
		
		$myArr=array('Código do grupo', 'Médias parciais dos tempos para os níveis', 'Médias parciais de acertos para os níveis', 'Modo', 'Data');
		$excel->writeLine($myArr);

		$query = "select bateria.cod, bateria.cod_grupo, bateria.media_tempo, bateria.media_acertos, bateria.modo, bateria.data from bateria where bateria.cod=".$id.";";
		$executar_query = mysql_query($query);
		while($ret = mysql_fetch_array($executar_query)){
			$retorno_0 = $ret['cod_grupo'];
			$retorno_2 = $ret['media_tempo'];
			$retorno_3 = $ret['media_acertos'];
			$retorno_4 = $ret['modo'];
			$retorno_6 = $ret['data'];
			
			$nova_data="";
			$data=explode("-", $retorno_6);
			$nova_data.=$data[2]."/".$data[1]."/".$data[0];
			$retorno_6=$nova_data;
			
			$myArr=array($retorno_0, $retorno_2, $retorno_3, $retorno_4, $retorno_6);
			$excel->writeLine($myArr);
		}
		
		$myArr=array(" "," "," "," "," "," ");
		$excel->writeLine($myArr);
		
		$myArr=array("Dados das seções: "," "," "," "," "," ");
		$excel->writeLine($myArr);
        
		$pos=0;
		$myArr=array();
		if($id_teste==1){
		    $myArr[0]='Sequência de estímulo';
		    $myArr[1]='Sonda';
		    $pos+=2;
		   
		}
		else if($id_teste==2){
			$myArr[0]='Cor da palavra';
			$myArr[1]='Conteúdo da palavra';
			$pos+=2;
		}
		else if($id_teste==3){
			$myArr[0]='Sequência apresentada';
			$pos+=1;
		}
		$myArr[$pos]='Resposta obtida';
		$myArr[$pos+1]='Tempo de resposta';
		$myArr[$pos+2]='Correção';
		$myArr[$pos+3]='Quantidade de elementos';
		$myArr[$pos+4]='Código';
		
		$excel->writeLine($myArr);

		$query = "select * from secao where cod_bateria=".$id." ;";
		$executar_query = mysql_query($query);
		while($ret = mysql_fetch_array($executar_query)){
			$retorno_0 = $ret['cod'];
			$retorno_3 = $ret['resposta_obtida'];
			$retorno_4 = $ret['tempo_resposta'];
			$retorno_5 = $ret['correcao'];
			$retorno_6 = $ret['quant_elem'];
			
			$retorno_2 = $ret['estimulo_dado'];
			$pos=0;
			$myArr=array();
			if($id_teste==1){
				$r=explode(';', $retorno_2);
				for($i=0; $i<count($r); $i++){
				    $temp=explode('-', $r[$i]);
					$myArr[$pos]=$temp[1];
					$pos+=1;
				}
			   
			}
			else if($id_teste==2){
				$r=explode(';', $retorno_2);
				for($i=0; $i<count($r); $i++){
				    $temp=explode('-', $r[$i]);
					$myArr[$pos]=$temp[1];
					$pos+=1;
				}
			}
			else if($id_teste==3){
				$temp=explode('-', $retorno_2);
				$myArr[$pos]=$temp[1];
				$pos+=1;
			}
			$myArr[$pos]=$retorno_3;
			$myArr[$pos+1]=$retorno_4;
			$myArr[$pos+2]=$retorno_5;
			$myArr[$pos+3]=$retorno_6;
			$myArr[$pos+4]=$retorno_0;
			
			$excel->writeLine($myArr);
		}

		$excel->close();
		
		echo "22&ok";
	}
	
	function carrega_msg_adSite($param){
		
		$result="<p class='titulo'> Mensagens";
		
		if($param ==1 or $param==2){
			$query = "select * from mensagem where tipo='teste' order by data desc;";
		
		}
		if($param==3){
			$campo=$_GET['campo'];
			$valor=$_GET['valor'];
			
			if($campo=='assunto' or $campo=='mensagem' or $campo=='data'){
				if($campo=='data'){
					if(strpos($valor,'/')>0){
						$novo_valor="";
						$aux_=explode("/",$valor);
						for ($i=count($aux_)-1; $i==0; $i-=1){
							if($i==0){
								$novo_valor.=$aux[$i];
							}
							else{
								$novo_valor.=$aux[$i].'-';
							}
						}
						$valor=$novo_valor;
					}
				}
				
				$query = "select * from mensagem where $campo like '%$valor%' and tipo='teste' order by data;";
			}
			else if($campo=='cod' or $campo=='id_admin'){
				$query = "select * from mensagem where $campo=$valor and tipo='teste' order by data;";
			}
		}
		
		$erro="";
		$cont=0;
		$executar_query = mysql_query($query);
		while($ret = mysql_fetch_array($executar_query)){
			$retorno_0 = $ret['cod'];
			$retorno_1 = $ret['assunto'];
			$retorno_2 = $ret['mensagem'];
			$retorno_3 = $ret['id_admin'];
			$retorno_5 = $ret['data'];
			
			$nova_data="";
			$sep= explode(" ", $retorno_5);
			$data=explode("-", $sep[0]);
			$nova_data.=$data[2]."/".$data[1]."/".$data[0];
			$retorno_5=$nova_data.' '.$sep[1];
			
			$result.="  <div id='$retorno_0' name='$retorno_0' class='each_msg' align='center' typeof='message' resource='#message_$retorno_0'>
			                <div id='identifica_msg'> msg#$retorno_0 | Data: <span property='has_date'>$retorno_5</span> | Pesquisador id#<span property='has_author' resource='#adminTest_$retorno_3'>$retorno_3 </div>
							Assunto: <div class='campos_msg'><span property='has_subject'>$retorno_1</span></div>
							Mensagem: <div class='campos_msg' ><span property='has_content'>$retorno_2</span></div>
						</div>	
			";
			$cont++;
		}
		
		if($cont==0){
			$erro="Não há mensagens correspondentes ao filtro de pesquisa utilizado.";
		}
		
		if($param==1){
		    return $result;
		}
		if($param==2){
		    echo '23&'.$result;
		}
		if($param==3){
		    echo '24&'.$result.'&'.$erro;
		}
	}
	
	function carrega_testAdd($param){
		
		$result="<p class='titulo'> Testes a serem adicionados</p>";
		
		if($param ==1 or $param==2){
			$query = "select cod, descricao, dados_campo from tipo_teste where status='nao adicionado';";
		
		}
		$cont=0;
		$executar_query = mysql_query($query);
		while($ret = mysql_fetch_array($executar_query)){
			$retorno_0 = $ret['cod'];
			$retorno_1 = $ret['descricao'];
			$retorno_2 = $ret['dados_campo'];
			
			$aux_campos="";
			$fr=explode(";",$retorno_2);
			for($r=0;$r<count($fr);$r++){
				$aux_campos.=$fr[$r].'<br />';
			}
			
			$result.="  <div id='add_$retorno_0' name='add_$retorno_0' class='each_msg' align='center'>
			                <div id='identifica_add'> Teste#$retorno_0 </div>
							Descrição: <div class='campos_msg'>$retorno_1</div>
							Campos que deve ter: <div class='campos_msg' >$aux_campos</div>
							<input type=\"button\" name=\"troca_status\" value=\"Trocar status para adicionado\" href=\"javascript:void(0)\" onclick=\"troca_status($retorno_0)\">
						</div>	
			";
			$cont++;
		}
		
		if($cont==0){
			$result.="<br />Não há testes a serem adicionados.";
		}
		
		if($param==1){
		    return $result;
		}
	}
	
	function troca_status_test(){
		$id=$_GET['id'];
		
		$r='25&';
			
		conecta_ao_bd();
		
		$chamada="update tipo_teste set status='adicionado' where cod=$id;";
		$grava = mysql_query($chamada)or die(mysql_error());
			
		$num_busca=mysql_affected_rows();
		if ($num_busca>0){
			$res=carrega_testAdd(1);
			$r.=$res.'&O status foi alterado com sucesso - Teste adicionado!';
		}	
		else {
			$r.='&Ocorreu um erro!';
		}
		
		echo $r;
	}
	
	if(!empty($_GET['f'])){
	    $op=$_GET['f'];
		
		if($op==1){
			consulta_preenche_campos_adTeste();
		}
		if($op==2){
			pesquisa_com_parametro_adTeste();
		}
		if($op==3){
			conecta_ao_bd();
		    mostra_tudo_adTeste('2');
		}
		if ($op==4){
		    pesquisa_admin('site');
		}
		if($op==5){
		    conecta_ao_bd();
		    buscar_enviar_senha();
		}
		if ($op==6){
		    pesquisa_admin('teste');
		}
		if ($op==7){
			conecta_ao_bd();
		    mostra_tudo_grupo('2');
		}
		if ($op==8){
		    conecta_ao_bd();
			mostra_tudo_tipoTeste('2');
		}
		if ($op==9){
			conecta_ao_bd();
		    consulta_dadosForTest();
		}
		if ($op==10){
		   pesquisa_tipoTeste();
		}
		if ($op==11){
		   pesquisa_dados_grupo();
		}
		if ($op==12){
		   cad_pessoa();
		}
		if ($op==13){
		    consulta_config_1();
		}
		if ($op==14){
		    envia_result_test();
		}
		if ($op==15){
		    cria_bateria();
		}
		if ($op==16){
			conecta_ao_bd();
		    mostra_tudo_bateria('2');
		}
		if ($op==17){
			conecta_ao_bd();
		    pesquisa_com_parametro_grupo();
		}
		if ($op==18){
			conecta_ao_bd();
		    pesquisa_com_parametro_tipoTeste();
		}
		if ($op==19){
			conecta_ao_bd();
		    pesquisa_com_parametro_bateria();
		}
		if ($op==20){
		    conecta_ao_bd();
			mostra_tudo_secao('2');
		}
		if ($op==21){
			conecta_ao_bd();
		    pesquisa_com_parametro_secao();
		}
		if ($op==22){
			conecta_ao_bd();
		    dados_bateria_secoes_export();
		}
		if ($op==23){
			conecta_ao_bd();
		    carrega_msg_adSite(2);
		}
		if ($op==24){
			conecta_ao_bd();
		    carrega_msg_adSite(3);
		}
		if ($op==25){
			troca_status_test();
		}
		if ($op==26){
			conecta_ao_bd();
			altera_adSite();
		}
		if ($op==27){
			conecta_ao_bd();
			cadastraAtualiza_AdTeste('atualiza2');
		}
	}
	
?>