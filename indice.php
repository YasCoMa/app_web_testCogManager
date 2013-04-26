<html  xmlns="http://www.w3.org/1999/xhtml"  lang="pt-BR" version='XHTML+RDFa 1.0'>

	<head>
         <title>Ykirá - Sistema web de aplicação e avaliação de testes cognitivos</title>
		 <meta http-equiv="Content-Type" content="aplication/xhtml+xml; charset=UTF-8" />
		 <link rel="stylesheet" type="text/css" href="parteEsteticaDoSite.css" />
		 <script language="JavaScript" src="funcs_javaScript_v2.js"></script>
		 <script language="JavaScript" src="RDFa.0.21.0.js"></script>
		 <script language="JavaScript" src="jscharts.js"></script>
		 <link rel="shortcut icon" href="imagens/cabecalho_e_fundo/favicon.ico" type="image/x-icon">
	</head>
	
	<?php
	    
		include('funcoes_php_requeridas.php');
		conecta_ao_bd();
		
		if (isset( $_REQUEST["action"] ) && $_REQUEST["action"] != ' '){
			$funcao = $_REQUEST['action'];
		
			if (function_exists($funcao)) {
					call_user_func($funcao);
					echo "<script>location.href = 'indice.php';</script>";
			}
		}
		
		if (!empty($_POST['info_id_funcao'])){
			if ($_POST['info_id_funcao']=='cad_msg'){
			    enviar_mensagem();
			}
			if ($_POST['info_id_funcao']=='cad_1'){
			    cadastraAtualiza_AdTeste('cadastro');
			}
			if ($_POST['info_id_funcao']=='del_1'){
			    exclui_AdTeste();
			}
			if ($_POST['info_id_funcao']=='alter_1'){
			    cadastraAtualiza_AdTeste('atualiza1');
			}
			if ($_POST['info_id_funcao']=='cad_1_1'){
			    cadastra_atualiza_tipoTeste('cadastro');
			}
			if ($_POST['info_id_funcao']=='del_1_1'){
			    exclui_tipoTeste();
			}
			if ($_POST['info_id_funcao']=='alter_1_1'){
			    cadastra_atualiza_tipoTeste('atualiza');
			}
			if ($_POST['info_id_funcao']=='cad_1_0'){
				cadastra_atualiza_grupo('cadastro');
			}
			if ($_POST['info_id_funcao']=='del_1_0'){
				exclui_grupo('cadastro');
			}
			if ($_POST['info_id_funcao']=='alter_1_0'){
				cadastra_atualiza_grupo('atualiza');
			}
		}
		
    ?>
	<!-- http://cog_test_center.4sql.net/ontologia_ykira/onto_cog_site.owl# -->
	<body background='imagens/cabecalho_e_fundo/fundo_mosaico.png' vocab="http://cog_test_center.4sql.net/ontologia_ykira/onto_cog_site.owl#" prefix="foaf: http://xmlns.com/foaf/0.1/  dc: http://purl.org/dc/terms/ og: http://ogp.me/ns# rdf: http://www.w3.org/1999/02/22-rdf-syntax-ns# owl: http://www.w3.org/2002/07/owl#" >
		
		<div id="tudo">
			<div id="conteudo"  >
			    <table  width="1000px" height="800"> 
					<table width="1000px" height="200" class="fig_head" bgcolor='#fff'>
						<td width="400px" height="200" valign="middle" align="center"><a rel="foaf:workplaceHomepage" href="http://www.iff.edu.br"  title="Instituto Federal Fluminense" target="_blank"><img src="imagens/cabecalho_e_fundo/logoiff.gif"/></a></td>
						<td width="300px" height="200" valign="middle" align="center"><a href="indice.php" property="og:image" content='imagens/cabecalho_e_fundo/ykira.jpg' title="Página inicial"><img src="imagens/cabecalho_e_fundo/ykira.jpg"/></a></td>
						<td width="400px" height="200" valign="middle" align="center"><a rel="foaf:homepage" href="indice.php" title="Sobre neurocognição "><img src="imagens/cabecalho_e_fundo/head_fig_2.jpeg"/></a></td> 
					</table>
					 <script> n_divs='5'	</script>
					<div id="separador" align="center"><font color="#066">_____________________________________________________________________________________________________________________</font><font face="Goudy Old Style" color="#fff">@ 2013</font></div>
					 
					<table id="m" width ="1000px" height="100">
					    <!-- Primeira coluna/ Menu e login, se houver. -->
					    <td width="300px" height="100px" Valign="top">
					     			
						<!-- Parte do menu -->		
						    <ul id="menu"><font color="#cff">______</font><font face="Curlz MT">Menu principal</font>
							    <li><a id="a" class="item" href="javascript:void(0)" onClick="showDiv2('mdiv2',false); showDiv2('mdiv1',false); showDiv('dados_1',n_divs)" onmouseover="reveza('a'); showDiv2('mdiv1',false); showDiv2('mdiv2',false);" onmouseout="volta('a')">Página inicial</a>
								</li>
								 
								<li><a id="b" class="item" href="javascript:void(escondediv('1',n_divs))" onmouseover="reveza('b'); showDiv2('mdiv1',true); showDiv2('mdiv2',false);" onmouseout="volta('b')"> Atenção</a>
								    <div id="mdiv1"  style="display:none">
										<br><a class="link_subMenu" href="javascript:void(0)" onClick=" showDiv2('mdiv1',false); showDiv2('mdiv2',false); showDiv('dados_3',n_divs);">Efeito Stroop</a><br>
									<!--	<a class="link_subMenu" href="javascript:void(0)" onClick="showDiv2('mdiv1',false); showDiv2('mdiv2',false); showDiv('dados_5',n_divs)">Escolha de resposta</a><br>-->
									</div>
								</li>
								 
								<li><a id="c" class="item" href="javascript:void(escondediv('2',n_divs))" onmouseover="reveza('c'); showDiv2('mdiv1',false); showDiv2('mdiv2',true);" onmouseout="volta('c')"> Memória</a>
								    <div id="mdiv2"  style="display:none">
										<br><a class="link_subMenu" href="javascript:void(0)" onClick=" showDiv2('mdiv2',false); showDiv2('mdiv1',false); showDiv('dados_4',n_divs);">Memory Span</a><br>
										<a class="link_subMenu" href="javascript:void(0)" onClick="showDiv2('mdiv2',false); showDiv2('mdiv1',false); showDiv('dados_2',n_divs); ">Sternberg Search</a><br>
										<!--<a class="link_subMenu" href="javascript:void(0)" onClick="showDiv('dados_6',n_divs)">Efeito Simon</a><br>-->
										<!--<a class="link_subMenu" href="javascript:void(0)" onClick="showDiv('dados_7',n_divs)">Posição Serial</a><br>-->
									</div>
								</li>
								 
								<li><a id="d" class="item" href="javascript:void(0)" onClick="showDiv2('mdiv2',false); showDiv2('mdiv1',false); showDiv('dados_5',n_divs)" onmouseover="reveza('d');  showDiv2('mdiv1',false); showDiv2('mdiv2',false);" onmouseout="volta('d')">Área de administração</a>
								</li>
								
							</ul>
						</td>
						 
						<!-- Segunda coluna com as informações principais -->
						<td class="medium" height="500px" Valign="top">
						    <!-- Conteúdo página inicial -->
						    <div id="dados_1" style="">  
							    <div class="titulo"> Informações gerais sobre o sistema <span property='dc:title'>Ykirá</span></div>
								 
								<p property="og:description" class="sobre">Este site contém testes para fazer a avaliação de funções cognitivas como a memória, atenção, raciocínio lógico, etc., estes testes são dirigidos a uso de pesquisadores 
												com um grupo de pessoas, mas neste site qualquer um pode experimentar e ver suas descrições, além disso provê para os pesquisadores uma área para vizualização, controle e 
												análise de resultados, além de configurações de parâmetros para os testes disponibilizados.</p>
								<p class="sobre">Logo, para os pesquisadores há diversas funcionalidades na Área de administração. Basta requisitar um cadastro nesta seção e caso realmente os dados forem validados (a 
												pessoa realmente for da área) o login será liberado.</p>
								<p class="sobre">Há testes para a área de atenção e memória, por enquanto. Basta navegar por estas áreas no Menu para saber um pouco mais sobre cada um deles, seus objetivos, o modo de 
												executá-los e podes até experimentar um alatoriamente.</p>
								
								<div align='center'>
									<div class="titulo" style="display:inline"> Informação do responsável pelo sistema Ykirá: </div><br />
									<div id='info_me' style="display:inline" typeof='administrator_site' property="dc:creator" resource='#adminSite_me' align='center'>
										<span property='has_name'>Yasmmin Côrtes Martins</span>
										<span property='owl:sameAs' resource='http://yasmmin.4sql.net/foaf_me.rdf#me'>.</span><br/><br/>
										Graduanda em Análise e desenvolvimento de sistemas no: <span property='foaf:schoolHomepage' content='http://iff.edu.br' ><a class='link_comum' target='_blank'href='http://iff.edu.br'>Instituto Federal Fluminense</a></span>
										<br />Contatos:<br />
										<span property='foaf:account' typeof='foaf:OnlineAccount' resource='#fb_me' >
											<a class='link_contact' property='foaf:accountServiceHomepage' style='margin-left:300' target='_blank' href='https://www.facebook.com/yasmmin.martins'>Facebook</a>
										</span>
										<span property='foaf:account' typeof='foaf:OnlineAccount' resource='#twitter_me'>
											<a class='link_contact' property='foaf:accountServiceHomepage' target='_blank' href='https://twitter.com/yasmminPlovets'>Twitter</a>
										</span>
										<span property='foaf:mbox' resource='mailto:yasmmincm@hotmail.com' >
											<a class='link_contact' target='_blank' href='mailto:yasmmincm@hotmail.com'>E-mail</a>
										</span>
									</div> 
								</div>
							</div>
							 
							<!-- Conteúdo página do primeiro teste (Instruções, preencher dados para começar) -->
						    <div id="dados_2" style="display: none" typeof="type_test" resource="#tt_1">  
							    <div class="titulo"> Teste de nome <span property="has_name">Sternberg Search</span> do grupo de <span property="has_area">Memória</span></div>
								<dl>
								    <dt> <li type="circle">Objetivo</li></dt>
									<dd><p class="sobre" property="has_objective">Este teste permite avaliar se a pessoa percebeu que um elemento estava contido em uma determinada série de números, letras ou palavras, entre 1 a 9, previamente visualizada, medindo a memória de curto prazo
									      de acordo com o tempo que a pessoa levou para localizar aquele elemento no conjunto em memória.</p>
									
									<dt> <li type='circle'>Opções</li></dt>
									<dd><div id='init_1'>
											<label>Executar um teste:</label>
											<input type='button' name='iniciar1' value='Ir' href='javascript:void(0)' onClick='showDiv2("dados_pessoa_1",true); limpa_conjunto_forms(4); showDiv2("init_1" , false);' />
										</div>
										
										<!--  Parte referente ao 1º teste -->
										<div id='dados_carregar_teste_1' style='display:none'>
											<label>Digite a id do grupo para carregar o teste:</label> <input type='text' name='id_a_1' id='id_a_1' size='5' /> 
											<input type='button' name='app1_go' value='Carregar' href='javascript:void(0)' onClick='prepara_teste(1,1); ' />
										</div>	
										
										<div id='carregar_teste_direto_1' style='display:none'>
											<label>Carregar o teste:</label> 
											<input type='button' name='app1_go' value='Carregar' href='javascript:void(0)' onClick='prepara_teste(2,1); ' />
										</div>
										
										<div align='center'>
											<div id='dados_pessoa_1' style='display:none'>
												<div class='titulo_form'>Digite alguns dados seus:</div>
												<form name="cad_pessoa" method='POST' action=''>
													<label>Digite seu nome completo:</label> <input type='text' name='n_p' id='n_p' size='25' maxLength='45' onkeypress='limitar(this)' onpaste='limitar(this)' /><br>
													<label>Digite sua idade:</label> <input type='text' name='i_p' id='i_p'  size='4' maxLength='3' onkeypress='limitar(this)' onpaste='limitar(this)' /><br>
													<label>Escolha o sexo:</label> <input type='radio' name='sexo' value='feminino' />Feminino <input type='radio' name='sexo' value='masculino' />Masculino <br>
													<label>Usas o computador:</label> <input type='radio' name='computador' value='sim' />Sim <input type='radio' name='computador' value='nao' />Não <br>
													<label>Escolha qual lado você prefere nas atividades:</label> <input type='radio' name='dom_manual' value='direito' />Direito <input type='radio' name='dom_manual' value='esquerdo' />Esquerdo <br>
													<p>
													<input type='button' name='go' value='Continuar' href='javascript:void(0)' onClick='cadastra_pessoa(1)'/>
													<input type='button' name='exit' value='Cancelar' href='javascript:void(0)' onClick='showDiv2("dados_pessoa_1",false); showDiv2("init_1", true);'/>
												</form>
											</div>
										</div>
										
										<?php
											include('testes_prontos/teste_app_1.php');
										?>
										<div align='center'>
											<div id='app_1' style='display:none'>
												<br>
												<div id ='info_nivel' align='center'></div><br>
												<div id ='ti' align='center' style='display:none'></div><br>
												
												<!-- Apresenta a série de números -->
												<div id='serie_numerica' style='display:none'>
													<div id='v' > </div>
												</div>
												
												<!-- Apresenta um número apenas -->
												<div id='num' align='center' style='display:none'>
													<input type='text' id='v1' value='' readonly size='5'/>
												</div>
												
												<!-- Mouse - seleciona se o número único estava na série ou não -->
												<div id='resposta_mouse' align='center' style='display:none'>
													<input type='text' name='q_sec' id='q_sec' value='4' style='display:none' />
													
													<input type="button" value="sim" href='javascript:void(0)' onClick='verifica_mouse(1);'/>
													<input type="button" value="não" href='javascript:void(0)' onClick='verifica_mouse(2);'/>
												</div>
												
												<br>
												
											</div>
										</div>
										
									<dd><div id='ajuda_app_1'>
											<label>Ver instruções do teste:</label> 
											<input type='button' name='help1_go' value='Ajuda' href='javascript:void(0)' onClick='showDiv2("ajuda_dados_2",true)'/><br>  
											<div align='center'>
												<div id='ajuda_dados_2' style='display:none'>
													<?php
														$ponteiro = fopen ("Arquivos_ajuda_apps/ajuda_sternberg-search.txt", "r");
														$conteudo="";
														while (!feof ($ponteiro)) {
														   $linha = fgets($ponteiro, 4096);
														   $conteudo.=$linha.'<br>';
														}
														fclose ($ponteiro);
														
														echo "<p class='sobre'>".$conteudo."</p>";
													?>
													<input type='button' name='help1_out' value='Esconder ajuda' href='javascript:void(0)' onClick='alert("A exclusão foi feita!"); showDiv2("ajuda_dados_2",false)'/>
												</div>
											</div>
										</div>
											
											<?php
												/*
											    if (empty($_COOKIE['log']) or $_COOKIE['log']==''){
													echo "<div id='pre_app'><input type='button' name='app1_go' value='Executar o teste' href='javascript:void(0)' onClick='prepara_teste(2)' /> </div>";
												}
												else {	
													$pos=strpos($_COOKIE["log"],'sim');
													if ($pos > 0){
													    echo "<div id='pre_app'>
																		<label>Digite a id do grupo para carregar o teste:</label> <input type='text' name='id_a' id='id_a' size='5' /> 
																		<input type='button' name='app1_go' value='Carregar' href='javascript:void(0)' onClick='prepara_teste(1)' />
																	</div>";
													}
												}
												*/
											?>	
										
								</dl>
								 
							</div>
							 
							<!-- Conteúdo página do segundo teste (Instruções, preencher dados para começar) -->
						    <div id="dados_3" style="display: none" typeof="type_test" resource="#tt_2">  
							    <div class="titulo"> Teste de nome <span property="has_name">Efeito Stroop</span> do grupo de <span property="has_area">Atenção</span><span property='owl:sameAs' resource='http://dbpedia.org/resource/Stroop_effect'>.</span></div>
								<dl>
								    <dt> <li type="circle">Objetivo</li></dt>
									<dd><p class="sobre" property="has_objective">Este teste permite avaliar se a pessoa consegue reter sua atenção apenas à cor sem deixar o significado da palavra com aquela cor interferir
									                     na sua resposta. Esperando pela resposta da cor do estímulo.</p>
									
									<dt> <li type='circle'>Opções</li></dt>
									<dd><div id='init_2'>
											<label>Executar um teste:</label>
											<input type='button' name='iniciar1' value='Ir' href='javascript:void(0)' onClick='showDiv2("dados_pessoa_2",true); limpa_conjunto_forms(5); showDiv2("init_2" , false);' />
										</div>
										
										<!--  Parte referente ao 2º teste -->
										<div id='dados_carregar_teste_2' style='display:none'>
											<label>Digite a id do grupo para carregar o teste:</label> <input type='text' name='id_a_2' id='id_a_2' size='5' /> 
											<input type='button' name='app2_go' value='Carregar' href='javascript:void(0)' onClick='prepara_teste(1,2); ' />
										</div>	
										
										<div id='carregar_teste_direto_2' style='display:none'>
											<label>Carregar o teste:</label> 
											<input type='button' name='app2_go' value='Carregar' href='javascript:void(0)' onClick='prepara_teste(2,2); ' />
										</div>
										
										<div align='center'>
											<div id='dados_pessoa_2' style='display:none'>
												<div class='titulo_form'>Digite alguns dados seus:</div>
												<form name="cad_pessoa_2" method='POST' action=''>
													<label>Digite seu nome completo:</label> <input type='text' name='n_p_2' id='n_p_2' size='25' maxLength='45' onkeypress='limitar(this)' onpaste='limitar(this)' /><br>
													<label>Digite sua idade:</label> <input type='text' name='i_p_2' id='i_p_2'  size='4' maxLength='3' onkeypress='limitar(this)' onpaste='limitar(this)' /><br>
													<label>Escolha o sexo:</label> <input type='radio' name='sexo_2' value='feminino' />Feminino <input type='radio' name='sexo_2' value='masculino' />Masculino <br>
													<label>Usas o computador:</label> <input type='radio' name='computador_2' value='sim' />Sim <input type='radio' name='computador_2' value='nao' />Não <br>
													<label>Escolha qual lado você prefere nas atividades:</label> <input type='radio' name='dom_manual_2' value='direito' />Direito <input type='radio' name='dom_manual_2' value='esquerdo' />Esquerdo <br>
													<p>
													<input type='button' name='go' value='Continuar' href='javascript:void(0)' onClick='cadastra_pessoa(2)'/>
													<input type='button' name='exit' value='Cancelar' href='javascript:void(0)' onClick='showDiv2("dados_pessoa_2",false); showDiv2("init_2", true)'/>
												</form>
											</div>
										</div>
										
										<?php
											include('testes_prontos/teste_app_2.php');
										?>
										<div align='center'>
											<div id='app_2' style='display:none'>
												<br>
												
												<div id ='ti_2' align='center' style='display:none'></div><br>
												
												<div id='texto' align='center' style='display:none'></div><br>
												
												<!-- Mouse - seleciona se o número único estava na série ou não -->
												<div id='resposta_mouse_2' align='center' style='display:none'>
													
													<input type="button" id='a_2' name='a_2' value="" href='javascript:void(0)' onClick='verifica_mouse_2(1);'/>
													<input type="button" id='b_2' name='b_2' value="" href='javascript:void(0)' onClick='verifica_mouse_2(2);'/>
													<input type="button" id='c_2' name='c_2' value="" href='javascript:void(0)' onClick='verifica_mouse_2(3);'/>
												</div>
												
												<br>
												
											</div>
										</div>
										<br />
										
									<dd><div id='ajuda_app_2'>
											<label>Ver instruções do teste:</label> 
											<input type='button' name='help1_go' value='Ajuda' href='javascript:void(0)' onClick='showDiv2("ajuda_dados_3",true)'/><br>  
											<div align='center'>
												<div id='ajuda_dados_3' style='display:none'>
													<?php
														$ponteiro = fopen ("Arquivos_ajuda_apps/ajuda_efeito-stroop.txt", "r");
														$conteudo="";
														while (!feof ($ponteiro)) {
														   $linha = fgets($ponteiro, 4096);
														   $conteudo.=$linha.'<br>';
														}
														fclose ($ponteiro);
														
														echo "<p class='sobre'>".$conteudo."</p>";
													?>
													<input type='button' name='help1_out' value='Esconder ajuda' href='javascript:void(0)' onClick='showDiv2("ajuda_dados_3",false)'/>
												</div>
											</div>
										</div>
								</dl>
							</div>
							 
							<!-- Conteúdo página inicial 
						    <div id="dados_4" style="display: none">  
							    <h3 class="titulo"> Objetivos gerais </h3>
								<p>Esta página contém testes para fazer a avaliação de funções cognitivas, estes testes são dirigidos a uso de pesquisadores </p>
							</div>-->
							 
							<!-- Conteúdo página do terceiro teste (Instruções, preencher dados para começar) -->
						    <div id="dados_4" style="display: none" typeof="type_test" resource="#tt_3">  
								<div class="titulo"> Teste de nome <span property="has_name">Memory Span</span> do grupo de <span property="has_area">Memória</span><span property='owl:sameAs' resource='http://dbpedia.org/resource/Memory_span'>.</span></div>
								<dl>
								    <dt> <li type="circle">Objetivo</li></dt>
									<dd><p class="sobre"><span property="has_objective">Este teste serve para avaliar a capacidade de memorizar uma lista de números, palavras ou letras 
									dentro de um tempo.</span> <span property="has_description">Neste teste são apresentados separadamente elementos de uma sequência e o usuário depois, dentro de 
									um tempo, deve listar na mesma ordem os elementos anteriores</span></p>
									
									<dt> <li type='circle'>Opções</li></dt>
									<dd><div id='init_3'>
											<label>Executar um teste:</label>
											<input type='button' name='iniciar2' value='Ir' href='javascript:void(0)' onClick='showDiv2("dados_pessoa_3",true); limpa_conjunto_forms(5); showDiv2("init_3" , false);' />
										</div>
										
										<!--  Parte referente ao 2º teste -->
										<div id='dados_carregar_teste_3' style='display:none'>
											<label>Digite a id do grupo para carregar o teste:</label> <input type='text' name='id_a_3' id='id_a_3' size='5' /> 
											<input type='button' name='app3_go' value='Carregar' href='javascript:void(0)' onClick='prepara_teste(1,3); ' />
										</div>	
										
										<div id='carregar_teste_direto_3' style='display:none'>
											<label>Carregar o teste:</label> 
											<input type='button' name='app3_go' value='Carregar' href='javascript:void(0)' onClick='prepara_teste(2,3); ' />
										</div>
										
										<div align='center'>
											<div id='dados_pessoa_3' style='display:none'>
												<div class='titulo_form'>Digite alguns dados seus:</div>
												<form name="cad_pessoa_3" method='POST' action=''>
													<label>Digite seu nome completo:</label> <input type='text' name='n_p_3' id='n_p_3' size='25' maxLength='45' onkeypress='limitar(this)' onpaste='limitar(this)' /><br>
													<label>Digite sua idade:</label> <input type='text' name='i_p_3' id='i_p_3'  size='4' maxLength='3' onkeypress='limitar(this)' onpaste='limitar(this)' /><br>
													<label>Escolha o sexo:</label> <input type='radio' name='sexo_3' value='feminino' />Feminino <input type='radio' name='sexo_3' value='masculino' />Masculino <br>
													<label>Usas o computador:</label> <input type='radio' name='computador_3' value='sim' />Sim <input type='radio' name='computador_3' value='nao' />Não <br>
													<label>Escolha qual lado você prefere nas atividades:</label> <input type='radio' name='dom_manual_3' value='direito' />Direito <input type='radio' name='dom_manual_3' value='esquerdo' />Esquerdo <br>
													<p>
													<input type='button' name='go2' value='Continuar' href='javascript:void(0)' onClick='cadastra_pessoa(3)'/>
													<input type='button' name='exit2' value='Cancelar' href='javascript:void(0)' onClick='showDiv2("dados_pessoa_3",false); showDiv2("init_3", true)'/>
												</form>
											</div>
										</div>
										
										<?php
											include('testes_prontos/teste_app_3.php');
										?>
										<div align='center'>
											<div id='app_3' style='display:none'>
												<br>
												
												<div id ='ti_3' align='center' style='display:none'></div><br>
												
												<div id='elemento' align='center' style='display:none'></div><br>
												
												<!-- Mouse - seleciona se o número único estava na série ou não -->
												<div id='resposta_mouse_3' align='center' style='display:none'>
													
													<input type="button" id='bot_1' name='bot_1' value="" href='javascript:void(0)' onClick='verifica_mouse_3("bot_1");'/>
													<input type="button" id='bot_2' name='bot_2' value="" href='javascript:void(0)' onClick='verifica_mouse_3("bot_2");'/>
													<input type="button" id='bot_3' name='bot_3' value="" href='javascript:void(0)' onClick='verifica_mouse_3("bot_3");'/> <br />
													
													<input type="button" id='bot_4' name='bot_4' value="" href='javascript:void(0)' onClick='verifica_mouse_3("bot_4");'/>
													<input type="button" id='bot_5' name='bot_5' value="" href='javascript:void(0)' onClick='verifica_mouse_3("bot_5");'/>
													<input type="button" id='bot_6' name='bot_6' value="" href='javascript:void(0)' onClick='verifica_mouse_3("bot_6");'/> <br />
													
													<input type="button" id='bot_7' name='bot_7' value="" href='javascript:void(0)' onClick='verifica_mouse_3("bot_7");'/>
													<input type="button" id='bot_8' name='bot_8' value="" href='javascript:void(0)' onClick='verifica_mouse_3("bot_8");'/>
													<input type="button" id='bot_9' name='bot_9' value="" href='javascript:void(0)' onClick='verifica_mouse_3("bot_9");'/> <br />
												</div>
												
												<br>
												
											</div>
										</div>
										<br />
										
									<dd><div id='ajuda_app_3'>
											<label>Ver instruções do teste:</label> 
											<input type='button' name='help2_go' value='Ajuda' href='javascript:void(0)' onClick='showDiv2("ajuda_dados_4",true)'/><br>  
											<div align='center'>
												<div id='ajuda_dados_4' style='display:none'>
													<?php
														$ponteiro = fopen ("Arquivos_ajuda_apps/ajuda_memory-span.txt", "r");
														$conteudo="";
														while (!feof ($ponteiro)) {
														   $linha = fgets($ponteiro, 4096);
														   $conteudo.=$linha.'<br>';
														}
														fclose ($ponteiro);
														
														echo "<p class='sobre'>".$conteudo."</p>";
													?>
													<input type='button' name='help1_out' value='Esconder ajuda' href='javascript:void(0)' onClick='showDiv2("ajuda_dados_4",false)'/>
												</div>
											</div>
										</div>
								</dl>
							</div>
							 
							<!-- Conteúdo página inicial 
						    <div id="dados_6" style="display: none">  
							    <h3 class="titulo"> Objetivos gerais </h3>
								<p>Esta página contém testes para fazer a avaliação de funções cognitivas, estes testes são dirigidos a uso de pesquisadores </p>
							</div>-->
							 
							<!-- Conteúdo página inicial 
						    <div id="dados_7" style="display: none">  
							    <div class="titulo"> Objetivos gerais </div>
								<p>Esta página contém testes para fazer a avaliação de funções cognitivas, estes testes são dirigidos a uso de pesquisadores </p>
							</div>-->
							 
							<!-- Conteúdo página inicial -->
						    <div id="dados_5" style="display: none">  
							<!-- O formulário do login -->
							    <?php    
								include ('partes_html_Com_Php.php');
							    if (empty($_COOKIE['log']) or $_COOKIE['log']==''){
								   html_login();
								}
								else {	
									$pos=strpos($_COOKIE["log"],'sim');
									if ($pos > 0){
									    $a = explode("-",$_COOKIE["log"]);
										
										if ($a[0][3]=='s'){
											$fnom =getNome('site',$a[1]);
										    $result=mostra_tudo_adTeste('1');
											html_adminSite($fnom[0],$result);
										}
										if ($a[0][3]=='t') {
											$fnom =getNome('teste',$a[1]);
											html_adminTeste($fnom[0]);
										}
									}
								}
								?>
								<br />
							</div>
							
							<div id='dados_10' style='display:none'><p>yas</div>
						</td>
					</table>
					 
				</table>	 
			</div>
		</div>
	</body>	
	
</html>