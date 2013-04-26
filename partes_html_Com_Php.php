<?php
	
    function html_login() {
		echo "<div id=\"sem_login\" align=\"center\" style=\"none\">
				<div class=\"titulo\" id='log_normal'> Escolha o tipo de administrador e coloque seu login e senha para entrar na área de administração!</div>
				<div class='titulo' id='log_sem_senha' style='display:none'> Digite o tipo de administrador e seu login e será enviado um email com a senha. </div>
				
				<div id=\"log\" align=\"center\">
					<form method=\"post\" id=\"form_log\" name=\"form_log\" action=\"\">
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						Tipo:
						<select name=\"tipo\">
							<option value=\"site\">Do site</option>
							<option value=\"teste\">De testes</option>
						</select><br>
						
						Login:<br>
						<input type=\"text\" name=\"login\" size=\"15\"/><br>
						
						Senha:<br>
						<input type=\"password\" name=\"senha\" size=\"15\"/><br>
						
						<input type=\"button\" name=\"enviar\" value=\"Enviar\" href=\"javascript:void(0)\" onclick=\"doPost('form_log', 'logar')\" />
						<input type=\"button\" name=\"esqueceu_senha\" value=\"Esqueci minha senha\" href=\"javascript:void(0)\" onclick=\"showDiv2('log',false);showDiv2('form_lembra',true);showDiv2('log_normal',false);showDiv2('log_sem_senha',true);form_log.login.value='';form_log.senha.value='';\" />
						<input type=\"button\" name=\"requisita_novo_adminTest\" value=\"Requisita conta de pesquisador\" href=\"javascript:void(0)\" onclick=\"showDiv2('info_novo_pesquisador',true)\" />
					</form>
				</div>
				<br />
				<div id='form_lembra' align='center' style='display:none'>
					<form method='post' id='form_5' name='form_5' action='indice.php'>
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='lembrar_senha' style='display: none'>
						Tipo:<br>
						<input type='radio' name='tipo' value='site'>De site</input>
						<input type='radio' name='tipo' value='teste'>De testes</input><BR>
						
						Login:<br>
						<input type=\"text\" name=\"l0\" size=\"15\" placeholder='Email de login'/><br>
						
						<input type=\"button\" name=\"volta\" value=\"Voltar\" href=\"javascript:void(0)\" onclick=\"showDiv2('log',true);showDiv2('form_lembra',false);showDiv2('log_normal',true);showDiv2('log_sem_senha',false);form_5.l0.value=''; for (var i=0; i < form_5.tipo.length; i++){	form_5.tipo[i].checked = false; } \" />
						<input type=\"button\" name=\"enviar\" value=\"Enviar\" href=\"javascript:void(0)\" onclick=\"lembra_senha()\" />
					</form>
				</div>
				<h4 id='progresso' style='display:none'><font color='#fff'>Aguarde resposta do servidor...</font></h4>
				
				<div id='info_novo_pesquisador' align='center' style='display:none'>
					<p class='sobre'> 
						Para requisitar uma conta de pesquisador/administrador de testes basta enviar um email para site.cog.testes@gmail.com com as seguintes informações:<br />
						Nome completo, nome do instituto que atua, nome do núcleo de pesquisa, o email (login) e a senha (que depois poderá ser trocada). E então, ao comprovar a 
						veracidade dos dados iremos cadastrar estas informações e receberás um email de volta com a confirmação.
					</p>
					<input type=\"button\" name=\"fechar\" value=\"Fechar\" href=\"javascript:void(0)\" onclick=\"showDiv2('info_novo_pesquisador',false)\" />
				</div
				
			</div> ";
	}
	
	function html_adminSite ($y,$result){
	   echo "<div align='center'>
			<div id=\"logado\" style=\"none\">
				<form method=\"post\" id=\"form_out\" name=\"form_out\" action=\"\">
					<div class=\"titulo\"> 
						Olá, ".$y.". Bem-vindo(a) ao seu painel.
						<input type=\"button\" name=\"sair\" value=\"Sair\" href=\"javascript:void(0)\" onclick=\"doPost('form_out', 'sair')\">
						<input type='button' name='alterar_adSite' value='Alterar meus dados' href=\"javascript:void(0)\" onclick=\"pesquisa_dados_adSite()\">
					</div>
					<p>
					<div align=\"center\">
						<div id=\"altera_adSite\" style=\"display: none\" align=\"center\">
							<p class=\"titulo_form\">Dados para alteração</p>
							<form method=\"post\" id='form_0' name=\"form_0\" action=\"\" >
								<input type='text' id='info_id_funcao' name='info_id_funcao' value='alter_adSite' style='display: none'>
								<input type=\"hidden\" id=\"action\" name=\"action\" />
								<table align=\"center\">
									<tr><td><label>Código:</label> <input type='text' name='co0' id='co0' disabled></td> <td><label>Nome:</label> <input type='text' name='n0' id='n0'></td></tr>
									<tr><td><label>Login:</label> <input type='text' name='lo' id='lo' ></td> <td><label>Senha:</label> <input type='password' name='s0' id='s0' placeholder='Senha'></td></tr>
								</table>
								<div align=\"center\">
									<input type='button' name='enviar' value='Enviar' href=\"javascript:void(0)\" onclick=\"confirma_alter_adSite()\">
									<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('altera_adSite', false)\">
								</div>
							</form>	
						</div>
					</div>
					<p>
					<input type=\"hidden\" id=\"action\" name=\"action\" />
				</form>
			</div><br />";
		
			gerencia_adminTeste($result);
			
		echo"<a id='link_msg' class='link_normal' href='javascript:void(0)' onClick='show_message()'>Abrir área de mensagens</a>
			<div id='ver_msg' style='display:none'> 
				<div id='res_pesquisa_msg'>";
		echo		carrega_msg_adSite(1);	
		echo"	</div>";
		echo"	
				<div align='center'><div id='params_pesquisa_msg'>
					<div class=\"param_pesquisa\" align=\"center\">
						<form method=\"post\" id=\"aux04\" name=\"aux04\" action=\"\">
							<input type='text' id='info_id_funcao' name='info_id_funcao' value='searchPam_4' style='display: none'>
							Pesquisar com a informação: 
							<input type=\"hidden\" id=\"action\" name=\"action\" />
							<select id=\"i[]\" name=\"i\">
								<option value=\"cod\">Código</option>
								<option value=\"assunto\">Trecho do assunto</option>
								<option value=\"mensagem\">Trecho da mensagem</option>
								<option value=\"id_admin\">Código do pesquisador</option>
								<option value=\"data\">Data (ex. 10/03/2001)</option>
							</select>
							<input type=\"text\" placeholder='informação de busca' name=\"var_search4\" size=15>
							<input type=\"button\" name=\"pesquisar\" value=\"Pesquisar\" href=\"javascript:void(0)\" onclick=\"pesquisa_param_msg()\">
							<input type=\"button\" name=\"mostra_tudo\" value=\"Mostrar todas\" href=\"javascript:void(0)\" onclick=\"mostra_tudo_msg()\">
						</form>
					</div>
				</div></div>	
			</div><br />";
		
		echo"<a id='link_testAdd' class='link_normal' href='javascript:void(0)' onClick='show_testAdd()'>Abrir área de testes a adicionar</a><br />
			<div id='ver_testAdd' style='display:none'> 
				<div id='res_pesquisa_testAdd'>";
		echo		carrega_testAdd(1);	
		echo"	</div>";
		
		echo "</div><br />";
	}
	
	
	function gerencia_adminTeste($result){
		// Determina o formulário a ser mostrado
		echo "
		    <form method=\"post\" id=\"aux\" name=\"aux\" action=\"indice.php\">
				<p>Para gerenciar um administrador de testes, escolha a opção que desejas fazer: 
				
				<select id=\"a[]\" name=\"a\">
					<option value=\"cadastrar\">Cadastrar</option>
					<option value=\"excluir\">Excluir</option>
					<option value=\"alterar\">Alterar</option>
				</select>
				<input type=\"button\" name=\"mostrar\" value=\"Mostrar\" href=\"javascript:void(0)\" onclick=\"mostra_form('1')\">
			</form>";	
		
		// Faz a pesquisa e mostra os registros que já possui		
		echo "
		    <div class=\"tabela_consulta\" align=\"center\">
				<table class=\"cabeca_fixa\">
				    <tr>
					    <th>Código</th> <th>Nome</th> <th>Instituto</th> <th>Núcleo</th> <th>Login</th> <th>Senha</th>
					</tr>
				</table>
				
				<div class=\"scroll_movel\">
					<div id='todos'><table>".$result."</table></div>
					<div id='res_pesquisa' style='display:none'></div>
				</div>	
				
				<div class=\"param_pesquisa\" align=\"center\">
					<form method=\"post\" id=\"aux1\" name=\"aux1\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='searchPam_1' style='display: none'>
						Pesquisar com a informação do: 
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<select id=\"b[]\" name=\"b\">
							<option value=\"cod\">Código</option>
							<option value=\"nome\">Nome</option>
							<option value=\"instituto\">Instituto</option>
							<option value=\"nucleo\">Núcleo</option>
							<option value=\"login\">Login</option>
							<option value=\"senha\">Senha</option>
						</select>
						<input type=\"text\" placeholder='informação de busca' name=\"var_search\" size=15>
						<input type=\"button\" name=\"pesquisar\" value=\"Pesquisar\" href=\"javascript:void(0)\" onclick=\"pesquisa_param_adTeste()\">
						<input type=\"button\" name=\"mostra_tudo\" value=\"Mostrar todos\" href=\"javascript:void(0)\" onclick=\"mostra_tudo_adTeste()\">
					</form>
				</div>
			</div>
		";
		
		// Cadastra um administrador de testes
		echo "<p>
			<div align=\"center\">
				<div id=\"cadastro\" style=\"display: none\" align=\"center\">
					<p class=\"titulo_form\">Formulário de cadastro</p>
					<form method=\"post\" id=\"form_1\" name=\"form_1\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='cad_1' style='display: none'>
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<table align=\"center\">
							<tr><td><label>Digite o nome:</label> <input type='text' name='nome' placeholder='Nome'></td> <td><label>Digite o Instituto:</label> <input type='text' name='inst' placeholder='Instituto'></td></tr>
							<tr><td><label>Digite o núcleo:</label> <input type='text' name='nucleo' placeholder='Núcleo de pesquisa'></td> <td><label>Digite o login (email):</label> <input type='text' name='email' placeholder='Email para login'></td></tr>
							<tr><td><label>Digite o senha:</label> <input type='password' name='senha' placeholder='Senha (7 a 10 caracteres)'></td></tr>
						</table>
						<div align=\"center\">
							<input type='submit' name=\"enviar\" value=\"Enviar\" >
							<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('cadastro', false)\">
						</div>
					</form>	
				</div>
			</div>
			<p>
		";
		
		// Exclui 
		echo "<p>
			<div align=\"center\">
				<div id=\"exclusao\" style=\"display: none\" align=\"center\">
					<p class=\"titulo_form\">Dados para exclusão</p>
					<form method=\"post\" id=\"form_2\" name=\"form_2\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='del_1' style='display: none'>
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<table align=\"center\">
							<tr><td><label>Digite o login (email):</label> <input type='text' name='l' placeholder='Email de login'></td> <td><label>Digite o senha:</label> <input type='password' name='s' placeholder='Senha'></td></tr>
						</table>
						<div align=\"center\">
							<input type='button' name=\"enviar\" value=\"Enviar\" href=\"javascript:void(0)\" onclick=\"confirma_exclusao_adTeste('form_2')\">
							<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('exclusao', false)\">
						</div>
					</form>	
				</div>
			</div>
			<p>
		";
		
		// Altera
		echo "<p>
			<div align=\"center\">
				<div id=\"alteracao\" style=\"display: none\" align=\"center\">
					<p class=\"titulo_form\" id='antes'>Digite as seguintes informações para carregar os dados para alteração</p>
					<p class=\"titulo_form\" id='depois' style='display:none'>Dados para alteração</p>
					<form method=\"post\" id=\"form_3\" name=\"form_3\" action=\"\">
					    <input type='text' id='info_id_funcao' name='info_id_funcao' value='alter_1' style='display: none'>
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<table align=\"center\">
							<tr><td id='l_' style='display:none'><label>Código:</label> <input type='text' name='co' id='co' disabled></td> <td id='l2' style='display:none'><label>Nome:</label> <input type='text' name='n' id='n'></td></tr>
							<tr><td id='l3' style='display:none'><label>Instituto:</label> <input type='text' name='i' id='i'></td> <td id='l4' style='display:none'><label>Núcleo:</label> <input type='text' name='nu' id='nu'></td></tr>
							<tr><td><label>Digite o login (email):</label> <input type='text' name='lo_' id='lo_' placeholder='Email de login'></td> <td><label>Digite a senha:</label> <input type='password' name='se' id='se' placeholder='Senha'></td></tr>
						</table>
						<div align=\"center\">
							<div id='b_antes'><input type='button' name=\"carregar\" value=\"Carregar\" href=\"javascript:void(0)\" onclick=\"pesquisar_dados_adTeste()\"></div>
							<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('alteracao', false)\">
							<div id='b_depois' style='display:none'><input type='button' name='enviar' value='Enviar' href=\"javascript:void(0)\" onclick=\"confirma_alteracao_adTeste('form_3')\"></div>
						</div>
					</form>	
				</div>
			</div>
			<p>
		";
	}
	
	function html_adminTeste ($y){
	   echo "
			<div id=\"logado\" style=\"none\">
				<form method=\"post\" id=\"form_out\" name=\"form_out\" action=\"\">
					<div class=\"titulo\"> 
						Olá, ".$y.". Bem-vindo(a) ao seu painel.
						<input type=\"button\" name=\"sair\" value=\"Sair\" href=\"javascript:void(0)\" onclick=\"doPost('form_out', 'sair')\">
						<input type='button' name='alterar_adTeste' value='Alterar meus dados' href=\"javascript:void(0)\" onclick=\"pesquisa_dados_adTeste()\">
					</div>
					<p>
					<div align=\"center\">
						<div id=\"altera_adTeste\" style=\"display: none\" align=\"center\">
							<p class=\"titulo_form\">Dados para alteração</p>
							<form method=\"post\" id='form_0_0' name=\"form_0_0\" action=\"\" >
								<input type='text' id='info_id_funcao' name='info_id_funcao' value='alter_adminTeste' style='display: none'>
								<input type=\"hidden\" id=\"action\" name=\"action\" />
								<table align=\"center\">
									<tr><td><label>Código:</label> <input type='text' name='co1' id='co1' disabled></td> <td><label>Nome:</label> <input type='text' name='n1' id='n1' placeholder='Nome'></td></tr>
									<tr><td><label>Instituto:</label> <input type='text' name='i1' id='i1' placeholder='Instituto'></td> <td><label>Núcleo:</label> <input type='text' name='nu1' id='nu1' placeholder='Núcleo de pesquisa'></td></tr>
									<tr><td><label>Login:</label> <input type='text' name='l1' id='l1' ></td> <td><label>Senha:</label> <input type='password' name='s1' id='s1' placeholder='Senha'></td></tr>
								</table>
								<div align=\"center\">
									<input type='button' name='enviar' value='Enviar' href=\"javascript:void(0)\" onclick=\"confirma_alter_adTeste();\">
									<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('altera_adTeste', false)\">
								</div>
							</form>	
						</div>
					</div>
					<p>
					<input type=\"hidden\" id=\"action\" name=\"action\" />
				</form>
			</div>
			<p>";
		
		echo "<div align='center'>";
		
		echo "
			<div id='abas' align='center' >
				<a id='link_aba1' style='float:left' class='aba_setada' href='javascript:void(0)' onClick='troca_entidade(1)'>Gerencia Perfil de teste</a>
				<a id='link_aba2' style='float:left' class='title_aba' href='javascript:void(0)' onClick='troca_entidade(2)'>Gerencia Bateria</a>
				<a id='link_aba3' style='float:left' class='title_aba' href='javascript:void(0)' onClick='troca_entidade(3)'>Gerencia Tentativa</a>
			   	<a id='link_aba4' style='float:left' class='title_aba' href='javascript:void(0)' onClick='troca_entidade(4)'>Gerencia Teste</a>
			</div><br><br>
		";	
		
		echo "	<div id='grupo'>";
			        gerencia_grupo(); 
		echo "  </div>";
		
		echo "	<div id='bateria' style='display:none'>";
			         gerencia_bateria(); 
			
			         echo "<br /><div align='center'>
					           Fazer o download dos dados para excel: 
					           <input type=\"button\" name=\"download\" value=\"Clique aqui\" href=\"javascript:void(0)\" onclick=\"exporta_dados_bateria_secoes()\" /><br />
							   Visualizar tempos e correção das tentativas de uma bateria:
						       <input type=\"button\" name=\"grafical_vision\" value=\"Ver gráfico\" href=\"javascript:void(0)\" onclick=\"gera_grafico()\" />
							   <input type=\"button\" name=\"grafical_close\" value=\"Ocultar gráfico\" href=\"javascript:void(0)\" onclick=\"showDiv2('graph',false)\" />
							</div><br />";
		echo "  </div>";
		
		echo "	<div id='secao' style='display:none'>";
			        gerencia_secao(); 
					
		echo "      <br />
				</div>";
		
		echo "	<div id='tipo_teste' style='display:none'>";
			        gerencia_tipoTeste(); 
		echo "  </div>";
		
		echo "  <br />
				<div id='graph' >
					
				</div>
		";
		echo "  <br />
				<div id='area_mensagem' align='center'>
					<p class=\"titulo_form\">Área de mensagens</p>
					<form method=\"post\" id=\"form_msg\" name=\"form_msg\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='cad_msg' style='display: none'>
						Assunto: <input type='text' name='subject' id='subject'/><br />
						Mensagem: <textarea name='mensagem' id='mensagem' cols='50' rows='4' ></textarea><br />
						<input type='submit' name='send' value='Enviar' />
					</form>	
				</div>
		";
			
		echo "</div>";
			//gerencia_adminTeste($result);
	}
	
	function gerencia_grupo(){
	    $result=mostra_tudo_grupo('1');
		
		// Determina o formulário a ser mostrado
		echo "
		    <form method=\"post\" id=\"aux0\" name=\"aux0\" action=\"indice.php\">
				<p>Para gerenciar um perfil de teste, escolha a opção que desejas fazer: 
				
				<select id=\"c[]\" name=\"c\">
					<option value=\"cadastrar\">Cadastrar</option>
					<option value=\"excluir\">Excluir</option>
					<option value=\"alterar\">Alterar</option>
				</select>
				<input type=\"button\" name=\"mostrar\" value=\"Mostrar\" href=\"javascript:void(0)\" onclick=\"mostra_form('2')\">
			</form>";	
		
		// Faz a pesquisa e mostra os registros que já possui		
		echo "
		    <div class=\"tabela_consulta\" align=\"center\">
				<div class='cabeca'>	
					<table class=\"cabeca_fixa\">
						<tr>
							<th>Código</th> <th>Data</th> <th>Código-Pesquisador</th> <th>Código-Teste</th> <th>Dados</th> <th>Via-respostas</th> <th>Quantidade de seções</th>
						</tr>
					</table>
				</div>
				
				<div class=\"scroll_movel\">
					<div id='todos_grupo'><table>".$result."</table></div>
					<div id='res_pesquisa_grupo' style='display:none'></div>
				</div>	
				
				<div class=\"param_pesquisa\" align=\"center\">
					<form method=\"post\" id=\"aux01\" name=\"aux01\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='searchPam_2' style='display: none'>
						Pesquisar com a informação do: 
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<select id=\"d[]\" name=\"d\">
							<option value=\"cod\">Código</option>
							<option value=\"data\">Data</option>
							<option value=\"cod_pesquisador\">Código-pesquisador</option>
							<option value=\"cod_tipo_teste\">Código-teste</option>
							<option value=\"via_resp\">Via-resposta</option>
							<option value=\"num_secoes\">Número de secoes</option>
						</select>
						<input type=\"text\" placeholder='informação de busca' name=\"var_search0\" size=15/>
						<input type=\"button\" name=\"pesquisar\" value=\"Pesquisar\" href=\"javascript:void(0)\" onclick=\"pesquisa_param_grupo()\" />
						<input type=\"button\" name=\"mostra_tudo\" value=\"Mostrar todos\" href=\"javascript:void(0)\" onclick=\"mostra_tudoGrupo()\" />
					</form>
				</div>
			</div>
		";
		
		// Cadastra um grupo de perfil de teste
		echo "<p>
			<div align=\"center\">
				<div id=\"cadastro0\" style=\"display: none\" align=\"center\">
					<p class=\"titulo_form\">Formulário de cadastro</p>
					<form method=\"post\" id=\"form0_1\" name=\"form0_1\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='cad_1_0' style='display: none'>
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<div align='center'>
						<table>
							<tr>
								<td>
									<label>Digite o código do teste desejado:</label> 
									<input type='text' name='id_teste_g' placeholder='id do teste' size='10' maxLength='10' onkeypress='limitar(this)' onpaste='limitar(this)'>
									<input type='button' name='dados_teste_' value='...' href='javascript:void(0)' onClick='pesquisa_dadosNedeedForteste(0,0);'>
								</td> 
								<td>
									<label>Selecione o modo de resposta:</label> 
									<div align='center' valign='middle'>
										<input type='radio' name='mod_' value='teclado' onClick='showDiv2(\"tec\",true)'/>Teclado
										<div id='tec' style='display:none'>
										    <input type='text' id='teclas' name='teclas' placeholder='tecla 1,tecla 2,tecla n' size=4 />
										</div>
										<br>
										<input type='radio' name='mod_' value='mouse' onClick='showDiv2(\"tec\",false)'/>Mouse
									</div>	
								</td>
							</tr>
							
							<tr>
								<td><label>Digite o número de seções (tentativas):</label> <input type='text' name='q_secoes' placeholder='quantidade de seções' maxLength='4' onkeypress='limitar(this)' onpaste='limitar(this)' ></td>
							</tr>
							
							<div id='dados_teste' align='center' style='none'>
								
							</div>
						
						</table>
						</div>
						<div align=\"center\">
							<input type='submit' name=\"enviar\" value=\"Enviar\" >
							<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('cadastro0', false); showDiv2('dados_teste', false);\">
						</div>
					</form>	
				</div>
			</div>
			<p>
		";
		
		// Exclui 
		echo "<p>
			<div align=\"center\">
				<div id=\"exclusao0\" style=\"display: none\" align=\"center\">
					<p class=\"titulo_form\">Dados para exclusão</p>
					<form method=\"post\" id=\"form0_2\" name=\"form0_2\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='del_1_0' style='display: none'>
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<table align=\"center\">
							<tr><td><label>Digite o código do perfil de teste:</label> <input type='text' name='id_grupo' placeholder='id do perfil a excluir (pesquise acima)' maxLength='10' onkeypress='limitar(this)' onpaste='limitar(this)' ></td> </tr>
						</table>
						<div align=\"center\">
							<input type='button' name=\"enviar\" value=\"Enviar\" href=\"javascript:void(0)\" onclick=\"confirma_exclusao_grupo('form0_2')\">
							<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('exclusao0', false)\">
						</div>
					</form>	
				</div>
			</div>
			<p>
		";
		
		// Altera
		echo "<p>
			<div align=\"center\">
				<div id=\"alteracao0\" style=\"display: none\" align=\"center\">
					<p class=\"titulo_form\" id='antes0'>Digite a seguinte informação para carregar os dados para alteração</p>
					<p class=\"titulo_form\" id='depois0' style='display:none'>Dados para alteração</p>
					<form method=\"post\" id=\"form0_3\" name=\"form0_3\" action=\"\">
						<input type='text' id='quant_a' name='quant_a' style='display: none'>
					    <input type='text' id='info_id_funcao' name='info_id_funcao' value='alter_1_0' style='display: none'>
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<div align='center'>
						<table align=\"center\">
							<tr>
								<td><label>Código do perfil:</label> <input type='text' name='co00' id='co00' placeholder='Código do perfil a alterar' size='10' maxLength='10' onkeypress='limitar(this)' onpaste='limitar(this)' ></td> 
								<td id='l01' style='display:none'><label>Data:</label> <input type='text' name='d0' id='d0' size='10'></td>
							</tr>
							<tr>
								<td id='l02' style='display:none'><label>Código do pesquisador:</label> <input type='text' name='id_p' id='id_p' size='10' maxLength='10' onkeypress='limitar(this)' onpaste='limitar(this)'></td> 
								<td id='l03' style='display:none'><label>Código do tipo de teste:</label> <input type='text' name='id_tt0' id='id_tt0' size='10' maxLength='10' onkeypress='limitar(this)' onpaste='limitar(this)' /> 
									<input type='button' name='alter_dt' id='alter_dt' value='Alterar' href='javascript:void(0)' onClick='pesquisa_dadosNedeedForteste(1,1);'> </td>
							</tr>
							<tr>								
								<td id='l04' style='display:none'>
									<label>Número de seções (tentativas):</label> 
									<input type='text' name='q_secoes_a' id='q_secoes_a' placeholder='quantidade de seções' size='10'maxLength='4' onkeypress='limitar(this)' onpaste='limitar(this)'></td>
								</td>
								<td id='l05' style='display:none'>
									<label>Modo de resposta:</label> 
									<div align='center' valign='middle'>
										<input type='radio' name='mod_a' value='teclado' onClick='showDiv2(\"tec_a\",true)' />Teclado
										<div id='tec_a' style='display:none'>
										    <input type='text' id='teclas_a' name='teclas_a' placeholder='tecla 1,tecla 2,tecla n' size=4 />
										</div>
										<input type='radio' name='mod_a' value='mouse' onClick='showDiv2(\"tec_a\",false)' />Mouse
									</div>	
								</td> 
							</tr>	
							
							<div id='dados_teste_a' align='center' style='none'>
								
							</div>
						</table>
						</div>
						<div align=\"center\">
							<div id='b0_antes'><input type='button' name=\"carregar\" value=\"Carregar\" href=\"javascript:void(0)\" onclick=\"pesquisa_dados_alteracao_grupo()\"></div>
							<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('alteracao0', false)\">
							<div id='b0_depois' style='display:none'><input type='button' name='enviar' value='Enviar' href=\"javascript:void(0)\" onclick=\"confirma_alteracao_grupo('form0_3')\"></div>
						</div>
					</form>	
				</div>
			</div>
			<p>
		";
	}
	
	function gerencia_tipoTeste(){
	    $result=mostra_tudo_tipoTeste('1');
		
		// Determina o formulário a ser mostrado
		echo "
		    <form method=\"post\" id=\"aux1\" name=\"aux1\" action=\"indice.php\">
				<p>Para gerenciar um tipo de teste, escolha a opção que desejas fazer: 
				
				<select id=\"e[]\" name=\"e\">
					<option value=\"cadastrar\">Cadastrar</option>
					<option value=\"excluir\">Excluir</option>
					<option value=\"alterar\">Alterar</option>
				</select>
				<input type=\"button\" name=\"mostrar\" value=\"Mostrar\" href=\"javascript:void(0)\" onclick=\"mostra_form('3')\">
			</form>";	
		
		// Faz a pesquisa e mostra os registros que já possui		
		echo "
		    <div class=\"tabela_consulta\" align=\"center\">
				<div class='cabeca'>	
					<table class=\"cabeca_fixa\">
						<tr>
							<th>Código</th> <th>Nome</th> <th>Descrição</th> <th>Área</th> <th>Objetivo</th> <th>Dados necessários</th>
						</tr>
					</table>
				</div>
				
				<div class=\"scroll_movel\">
					<div id='todos_tipoTeste'><table>".$result."</table></div>
					<div id='res_pesquisa_tipoTeste' style='display:none'></div>
				</div>	
				
				<div class=\"param_pesquisa\" align=\"center\">
					<form method=\"post\" id=\"aux11\" name=\"aux11\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='searchPam_3' style='display: none'>
						Pesquisar com a informação do: 
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<select id=\"f[]\" name=\"f\">
							<option value=\"cod\">Código</option>
							<option value=\"nome\">Nome</option>
							<option value=\"desc\">Descrição</option>
							<option value=\"area\">Área</option>
							<option value=\"obj\">Objetivo</option>
						</select>
						<input type=\"text\" placeholder='informação de busca' name=\"var_search1\" size=15/>
						<input type=\"button\" name=\"pesquisar\" value=\"Pesquisar\" href=\"javascript:void(0)\" onclick=\"pesquisa_param_tipoTeste()\" />
						<input type=\"button\" name=\"mostra_tudo\" value=\"Mostrar todos\" href=\"javascript:void(0)\" onclick=\"mostra_tudo_tipoTeste()\" />
					</form>
				</div>
			</div>
		";
		
		// Cadastra um tipo de teste
		echo "<p>
			<div align=\"center\">
				<div id=\"cadastro1\" style=\"display: none\" align=\"center\">
					<p class=\"titulo_form\">Formulário de cadastro</p>
					<form method=\"post\" id=\"form1_1\" name=\"form1_1\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='cad_1_1' style='display: none'>
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<table align=\"center\">
							<tr>
								<td><label>Digite o nome do teste:</label> <input type='text' name='nome0' placeholder='Nome do teste' size='10' maxLength='30' onkeypress='limitar(this)' onpaste='limitar(this)'></td> 
								<td><label>Digite a descrição:</label> <textarea name='descricao' cols='20' rows='3' maxLength='200' onkeypress='limitar(this)' onpaste='limitar(this)' ></textarea></td>
							</tr>
							<tr>
							    <td><label>Digite a área que ele pertence:</label> <input type='text' name='area0' placeholder='Área do teste' size='10' maxLength='15' onkeypress='limitar(this)' onpaste='limitar(this)' ></td> 
								<td><label>Digite a objetivo:</label> <textarea name='obj0' cols='20' rows='3' maxLength='200' onkeypress='limitar(this)' onpaste='limitar(this)' ></textarea></td>
							</tr>
							<tr>
							    <td><label>Digite as informações para fazê-lo (separe com (;)):</label> <textarea name='data_info' cols='20' rows='3' maxLength='200' onkeypress='limitar(this)' onpaste='limitar(this)' ></textarea></td>
							</tr>
						</table>
						<div align=\"center\">
							<input type='submit' name=\"enviar\" value=\"Enviar\" >
							<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('cadastro1', false)\">
						</div>
					</form>	
				</div>
			</div>
			<p>
		";
		
		// Exclui 
		echo "<p>
			<div align=\"center\">
				<div id=\"exclusao1\" style=\"display: none\" align=\"center\">
					<p class=\"titulo_form\">Dados para exclusão</p>
					<form method=\"post\" id=\"form1_2\" name=\"form1_2\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='del_1_1' style='display: none'>
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<table align=\"center\">
							<tr><td><label>Digite o código do tipo de teste:</label> <input type='text' name='id_tipoTeste' placeholder='id do teste a excluir (pesquise acima)' maxLength='10' onkeypress='limitar(this)' onpaste='limitar(this)' ></td> </tr>
						</table>
						<div align=\"center\">
							<input type='button' name=\"enviar\" value=\"Enviar\" href=\"javascript:void(0)\" onclick=\"confirma_exclusao_tipoTeste('form1_2')\">
							<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('exclusao1', false)\">
						</div>
					</form>	
				</div>
			</div>
			<p>
		";
		
		// Altera
		echo "<p>
			<div align=\"center\">
				<div id=\"alteracao1\" style=\"display: none\" align=\"center\">
					<p class=\"titulo_form\" id='antes1'>Digite a seguinte informação para carregar os dados para alteração</p>
					<p class=\"titulo_form\" id='depois1' style='display:none'>Dados para alteração</p>
					<form method=\"post\" id=\"form1_3\" name=\"form1_3\" action=\"\">
					
					    <input type='text' id='info_id_funcao' name='info_id_funcao' value='alter_1_1' style='display: none'>
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<div align='center'>
							<table>
								<tr>
									<td><label>Código do tipo do teste:</label> <input type='text' name='co11' id='co11' placeholder='Código do teste a alterar' maxLength='10' onkeypress='limitar(this)' onpaste='limitar(this)' ></td> 
									<td id='l11' style='display:none'><label>Nome do teste:</label> <input type='text' name='nome1' id='nome1' placeholder='Nome do teste' size='10' maxLength='30' onkeypress='limitar(this)' onpaste='limitar(this)' ></td>
								</tr>
								<tr>
									<td id='l12' style='display:none'><label>Digite a descrição:</label> <textarea name='descricao1' id='descricao1' cols='20' rows='3' maxLength='200' onkeypress='limitar(this)' onpaste='limitar(this)' ></textarea></td>
									<td id='l13' style='display:none'><label>Digite a área que ele pertence:</label> <input type='text' name='area1' id='area1' placeholder='Área do teste' size='10' maxLength='15' onkeypress='limitar(this)' onpaste='limitar(this)' ></td> 
								</tr>
								<tr>
									<td id='l14' style='display:none'><label>Digite a objetivo:</label> <textarea name='obj1' id='obj1' cols='20' rows='3' maxLength='200' onkeypress='limitar(this)' onpaste='limitar(this)' ></textarea></td>
									<td id='l15' style='display:none'><label>Digite as informações necessárias para fazê-lo (separe (;)):</label> <textarea name='data_info1' id='data_info1' cols='20' rows='3' maxLength='200' onkeypress='limitar(this)' onpaste='limitar(this)' ></textarea></td>
								</tr>
							</table>
						</div>
						
						<div align=\"center\">
							<div id='b1_antes'><input type='button' name=\"carregar\" value=\"Carregar\" href=\"javascript:void(0)\" onclick=\"pesquisar_dados_tipoTeste()\"></div>
							<input type='button' name=\"cancelar\" value=\"Cancelar\" href=\"javascript:void(0)\" onclick=\"showDiv2('alteracao1', false)\">
							<div id='b1_depois' style='display:none'><input type='button' name='enviar' value='Enviar' href=\"javascript:void(0)\" onclick=\"confirma_alteracao_tipoTeste('form1_3')\"></div>
						</div>
					</form>	
				</div>
			</div>
			<p>
		";
	}
	
	function gerencia_bateria(){
	    $result=mostra_tudo_bateria('1');
		
		echo "
		    <div align='center'><p> Visualização dos dados das baterias: </div>
		";
		
		// Faz a pesquisa e mostra os registros que já possui		
		echo "
		    <div class=\"tabela_consulta\" align=\"center\">
				<div class='cabeca'>	
					<table class=\"cabeca_fixa\">
						<tr>
							<th>Código</th> <th>Código - grupo</th> <th>Pessoa - sexo</th> <th>Pessoa - idade</th> <th>Média de tempo</th> <th>Média de acertos</th> <th>Modo</th> <th>Data</th> 
						</tr>
					</table>
				</div>
				
				<div class=\"scroll_movel\">
					<div id='todos_bateria'><table>".$result."</table></div>
					<div id='res_pesquisa_bateria' style='display:none'></div>
				</div>	
				
				<div class=\"param_pesquisa\" align=\"center\">
					<form method=\"post\" id=\"aux02\" name=\"aux02\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='searchPam_3' style='display: none'>
						Pesquisar com a informação do: 
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<select id=\"g[]\" name=\"g\">
							<option value=\"cod\">Código</option>
							<option value=\"cod_grupo\">Código do perfil de teste</option>
							<option value=\"media_tempo\">Média do tempo</option>
							<option value=\"media_acertos\">Média de acertos(0 a 1)</option>
							<option value=\"modo\">Modo</option>
							<option value=\"idade\">Idade</option>
							<option value=\"sexo\">Sexo</option>
						</select>
						<input type=\"text\" placeholder='informação de busca' name=\"var_search2\" size=15/>
						<input type=\"button\" name=\"pesquisar\" value=\"Pesquisar\" href=\"javascript:void(0)\" onclick=\"pesquisa_param_bateria()\" />
						<input type=\"button\" name=\"mostra_tudo\" value=\"Mostrar todos\" href=\"javascript:void(0)\" onclick=\"mostra_tudoBateria()\" />
					</form>
				</div>
			</div>
		";
	}
	
	function gerencia_secao(){
	    $result=mostra_tudo_secao('1');
		
		echo "
		    <div align='center'><p> Visualização dos dados das tentativas: </div>
		";
		
		// Faz a pesquisa e mostra os registros que já possui		
		echo "
		    <div class=\"tabela_consulta\" align=\"center\">
				<div class='cabeca'>	
					<table class=\"cabeca_fixa\">
						<tr>
							<th>Código</th> <th>Código - bateria</th> <th>Estimulo dado</th> <th>Resposta obtida</th> <th>Tempo de resposta</th> <th>Correção</th> <th>Data</th> <th>Quantidade de elementos</th>
						</tr>
					</table>
				</div>
				
				<div class=\"scroll_movel\">
					<div id='todos_secao'><table>".$result."</table></div>
					<div id='res_pesquisa_secao' style='display:none'></div>
				</div>	
				
				<div class=\"param_pesquisa\" align=\"center\">
					<form method=\"post\" id=\"aux03\" name=\"aux03\" action=\"\">
						<input type='text' id='info_id_funcao' name='info_id_funcao' value='searchPam_4' style='display: none'>
						Pesquisar com a informação do: 
						<input type=\"hidden\" id=\"action\" name=\"action\" />
						<select id=\"h[]\" name=\"h\">
							<option value=\"cod\">Código</option>
							<option value=\"cod_bateria\">Código da bateria</option>
							<option value=\"estimulo_dado\">Estímulo dado</option>
							<option value=\"resposta_obtida\">Resposta obtida</option>
							<option value=\"tempo_resposta\">Tempo de resposta</option>
							<option value=\"correcao\">Correção</option>
							<option value=\"data\">Data</option>
							<option value=\"quant_elem\">Quantidade de elementos</option>
						</select>
						<input type=\"text\" placeholder='informação de busca' name=\"var_search3\" size=15/>
						<input type=\"button\" name=\"pesquisar\" value=\"Pesquisar\" href=\"javascript:void(0)\" onclick=\"pesquisa_param_secao()\" />
						<input type=\"button\" name=\"mostra_tudo\" value=\"Mostrar todos\" href=\"javascript:void(0)\" onclick=\"mostra_tudoSecao()\" />
					</form>
				</div>
			</div>
		";
	}

?>