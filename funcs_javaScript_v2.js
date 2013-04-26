// Função que faz chamar alguma função do php
	function doPost(formName, actionName) {
		var hiddenControl = document.getElementById('action');
		var theForm = document.getElementById(formName);
		
		hiddenControl.value = actionName;
		theForm.submit();
	}
	
// Funções auxiliares ao formulário    
	// Para administrador de testes
		// Confirma exclusão do administrador de teste
	function confirma_exclusao_adTeste (id_form){
	    if (window.confirm('Desejas excluir realmente este administrador de testes?')){
		    document.getElementById(id_form).submit();
		}
		else{
		    alert('Ok, este administrador não será excluído!');
		}
	}
		// Confirma alteração do administrador de testes
	function confirma_alteracao_adTeste (id_form){
	    if (window.confirm('Desejas alterar realmente este administrador de testes?')){
		    form_3.lo_.disabled=false;
			document.getElementById(id_form).submit();
		}
		else {
		    alert('Ok, os dados deste administrador não serão alterados!');
		}
	}
	
	// Confirma alteracao depois do login
	function confirma_alter_adSite(){
		if (window.confirm('Desejas alterar realmente seus dados?')){
		    login=document.getElementById('lo').value;
			nome=document.getElementById('n0').value;
			senha=document.getElementById('s0').value;
			
			c="funcoes_php_requeridas.php?f=26&l0="+login+"&n0="+nome+"&s0="+senha;
			loadXMLDoc(c);
		}
		else {
		    alert('Ok, os dados deste administrador não serão alterados!');
		}
	}
	function confirma_alter_adTeste(){
		if (window.confirm('Desejas alterar realmente seus dados?')){
		    nome=document.getElementById('n1').value;
			instituto=document.getElementById('i1').value;
			nucleo=document.getElementById('nu1').value;
			login=document.getElementById('l1').value;
			senha=document.getElementById('s1').value;
			
			c="funcoes_php_requeridas.php?f=27&l1="+login+"&n1="+nome+"&s1="+senha+"&i1="+instituto+"&nu1="+nucleo;
			loadXMLDoc(c);
		}
		else {
		    alert('Ok, os dados deste administrador não serão alterados!');
		}
	}
	
		// Tratar os dados de alteração de admin de testes
	function pesquisar_dados_adTeste(){
	    login=form_3.lo_.value;
		senha=form_3.se.value;
		c="funcoes_php_requeridas.php?f=1&login="+login+"&senha="+senha;
		loadXMLDoc(c);
	}
	
	function processa_resp_adTeste(r){
		if (!(r[0]=='Não foi encontrado nenhum registro com esta combinação de login e senha!')){
			document.getElementById('co').value=r[0];
			document.getElementById('n').value=r[1];
			document.getElementById('i').value=r[2];
			document.getElementById('nu').value=r[3];
			
			form_3.lo_.disabled=true;
			showDiv2('antes',false);
			showDiv2('depois',true);
			showDiv2('l_',true);
			showDiv2('l2',true);
			showDiv2('l3',true);
			showDiv2('l4',true);
			showDiv2('b_antes',false);
			showDiv2('b_depois',true);
		}
		else {
			alert(r[0]);
		}
	}
	
		// Tratar os dados da pesquisa parametrizada
	function pesquisa_param_adTeste(){
	    indice = document.aux1.b.selectedIndex; 
		campo = document.aux1.b.options[indice].value;
		valor=aux1.var_search.value;
		
		c="funcoes_php_requeridas.php?f=2&campo="+campo+"&valor="+valor;
		loadXMLDoc(c);
	}
	
		// Mostra todos os administradores de teste
	function mostra_tudo_adTeste(){
	    c="funcoes_php_requeridas.php?f=3";
		loadXMLDoc(c);
	}
	
	// Para administrador de site
	
		// Pesquisa dados do administrador do site que está logado
	function pesquisa_dados_adSite(){
		c="funcoes_php_requeridas.php?f=4";
		loadXMLDoc(c);
	}
	
	// Lembrete de senha com login
	function lembra_senha(){
	    var tipo="";
		if(form_5.tipo[0].checked){
		    tipo=form_5.tipo[0].value;
		}
		else if(form_5.tipo[1].checked){
		    tipo=form_5.tipo[1].value;
		}
		
		if (tipo==""){
			if (form_5.l0.value==""){
			    alert("Digite o email de login e marque algum dos tipos de administrador!");
			}
			else{
				alert("Marque algum dos tipos de administrador!");
			}
		}
		else{
			if (form_5.l0.value==""){
			    alert("Digite o email de login!");
			}
			else {
				login=form_5.l0.value;
				showDiv2('progresso',true);
			    c="funcoes_php_requeridas.php?f=5&tipo="+tipo+"&login="+login;
				loadXMLDoc(c);
			}
		}
	}
	
		// Pesquisa dados do administrador do teste que está logado
	function pesquisa_dados_adTeste(){
	    c="funcoes_php_requeridas.php?f=6";
		loadXMLDoc(c);
	}
	
	function mostra_tudoGrupo(){
		c="funcoes_php_requeridas.php?f=7";
		loadXMLDoc(c);
	}
	
	function pesquisa_param_grupo(){
		indice = document.aux01.d.selectedIndex; 
		campo = document.aux01.d.options[indice].value;
		valor=aux01.var_search0.value;
		
		c="funcoes_php_requeridas.php?f=17&campo="+campo+"&valor="+valor;
		loadXMLDoc(c);
	}
	
	function mostra_tudo_tipoTeste(){
		c="funcoes_php_requeridas.php?f=8";
		loadXMLDoc(c);
	}
	
	function pesquisa_param_tipoTeste(){
		indice = document.aux11.f.selectedIndex; 
		campo = document.aux11.f.options[indice].value;
		valor=aux11.var_search1.value;
		
		c="funcoes_php_requeridas.php?f=18&campo="+campo+"&valor="+valor;
		loadXMLDoc(c);
	}
	
	function exporta_dados_bateria_secoes(){
	    id = prompt("Digite o código da bateria para exportar seus dados e de suas seções: ");
		if (id==""){
		    alert("Código inválido!");
		}
		else {
		    c="funcoes_php_requeridas.php?f=22&id="+id;
			loadXMLDoc(c);
		}
	}
	
	function pesquisa_dadosNedeedForteste(p,s){
	    id_teste=0;
		co=0;
		if (p==0){
			id_teste=form0_1.id_teste_g.value; 
		}
		if (p==1) {
		    id_teste=form0_3.id_tt0.value;
			form0_3.co00.disabled=false;
			co=form0_3.co00.value;
		}
		
		c="funcoes_php_requeridas.php?f=9&id="+id_teste+"&op="+s+"&co="+co;
		loadXMLDoc(c);
	}
	
	function pesquisar_dados_tipoTeste(){
		id_teste=form1_3.co11.value;
	
	    c="funcoes_php_requeridas.php?f=10&id="+id_teste;
		loadXMLDoc(c);
	}
	
	// Para tipo de testes
		// Confirma exclusão do administrador de teste
	function confirma_exclusao_tipoTeste (id_form){
	    if (window.confirm('Desejas excluir realmente este tipo de testes?')){
		    document.getElementById(id_form).submit();
		}
		else{
		    alert('Ok, tipo de testes não será excluído!');
		}
	}	
	
	// Confirma alteração de tipo teste
	function confirma_alteracao_tipoTeste (id_form){
	    if (window.confirm('Desejas alterar realmente este tipo de teste?')){
		    form1_3.co11.disabled=false;
			document.getElementById(id_form).submit();
		}
		else {
		    alert('Ok, os dados deste tipo de teste não serão alterados!');
		}
	}
	
	function pesquisa_dados_alteracao_grupo(){
		id_teste=form0_3.co00.value;
	    
	    c="funcoes_php_requeridas.php?f=11&id="+id_teste;
		loadXMLDoc(c);
	}
	
	// Para grupo
		// Confirma exclusão do grupo
	function confirma_exclusao_grupo (id_form){
	    if (window.confirm('Desejas excluir realmente este perfil de teste?')){
		    document.getElementById(id_form).submit();
		}
		else{
		    alert('Ok, este perfil de teste não será excluído!');
		}
	}
	// Confirma alteração do perfil de grupo
	function confirma_alteracao_grupo (id_form) {
	    if (window.confirm('Desejas alterar realmente este perfil de teste?')){
		    form0_3.co00.disabled=false;
			document.getElementById(id_form).submit();
		}
		else {
		    alert('Ok, os dados deste perfil de teste não serão alterados!');
		}
	}
	
	// Envia os dados a pessoa
	function cadastra_pessoa(app_atual){
	    valida=0;
		var idade, nome, s, comp, lado;
		
		if (app_atual==1){
			if (document.getElementById("i_p").value!=""){
				idade=parseInt(document.getElementById("i_p").value);
				for (var i=1; i<=105; i++){
					if (idade==i){
						valida=1;
					}
				}
			}
			
			if (document.getElementById("n_p").value!="" ){
				nome=document.getElementById("n_p").value;
				if  (valida==1)
					valida=1;
			}
			else {
				valida=0;
			}
			
			if (cad_pessoa.sexo[0].checked==true){
				s=cad_pessoa.sexo[0].value;
				if  (valida==1)
					valida=1;
			}
			else {
				if (cad_pessoa.sexo[1].checked==true){
					s=cad_pessoa.sexo[1].value;
					if  (valida==1)
						valida=1;
				}
				else {
					valida=0;
				}
			}
			
			if (cad_pessoa.computador[0].checked==true){
				comp=cad_pessoa.computador[0].value;
				if  (valida==1)
					valida=1;
			}
			else {
				if (cad_pessoa.computador[1].checked==true){
					comp=cad_pessoa.computador[1].value;
					if  (valida==1)
						valida=1;
				}
				else {
					valida=0;
				}
			}
			
			if (cad_pessoa.dom_manual[0].checked==true){
				lado=cad_pessoa.dom_manual[0].value;
				if  (valida==1)
					valida=1;
			}
			else {
				if (cad_pessoa.dom_manual[1].checked==true){
					lado=cad_pessoa.dom_manual[1].value;
					if  (valida==1)
						valida=1;
				}
				else {
					valida=0;
				}
			}
		}
		else if (app_atual==2){
			if (document.getElementById("i_p_2").value!=""){
				idade=parseInt(document.getElementById("i_p_2").value);
				for (var i=1; i<=105; i++){
					if (idade==i){
						valida=1;
					}
				}
			}
			
			if (document.getElementById("n_p_2").value!="" ){
				nome=document.getElementById("n_p_2").value;
				if  (valida==1)
					valida=1;
			}
			else {
				valida=0;
			}
			
			if (cad_pessoa_2.sexo_2[0].checked==true){
				s=cad_pessoa_2.sexo_2[0].value;
				if  (valida==1)
					valida=1;
			}
			else {
				if (cad_pessoa_2.sexo_2[1].checked==true){
					s=cad_pessoa_2.sexo_2[1].value;
					if  (valida==1)
						valida=1;
				}
				else {
					valida=0;
				}
			}
			
			if (cad_pessoa_2.computador_2[0].checked==true){
				comp=cad_pessoa_2.computador_2[0].value;
				if  (valida==1)
					valida=1;
			}
			else {
				if (cad_pessoa_2.computador_2[1].checked==true){
					comp=cad_pessoa_2.computador_2[1].value;
					if  (valida==1)
						valida=1;
				}
				else {
					valida=0;
				}
			}
			
			if (cad_pessoa_2.dom_manual_2[0].checked==true){
				lado=cad_pessoa_2.dom_manual_2[0].value;
				if  (valida==1)
					valida=1;
			}
			else {
				if (cad_pessoa_2.dom_manual_2[1].checked==true){
					lado=cad_pessoa_2.dom_manual_2[1].value;
					if  (valida==1)
						valida=1;
				}
				else {
					valida=0;
				}
			}
		}
		else if (app_atual==3){
			if (document.getElementById("i_p_3").value!=""){
				idade=parseInt(document.getElementById("i_p_3").value);
				for (var i=1; i<=105; i++){
					if (idade==i){
						valida=1;
					}
				}
			}
			
			if (document.getElementById("n_p_3").value!="" ){
				nome=document.getElementById("n_p_3").value;
				if  (valida==1)
					valida=1;
			}
			else {
				valida=0;
			}
			
			if (cad_pessoa_3.sexo_3[0].checked==true){
				s=cad_pessoa_3.sexo_3[0].value;
				if  (valida==1)
					valida=1;
			}
			else {
				if (cad_pessoa_3.sexo_3[1].checked==true){
					s=cad_pessoa_3.sexo_3[1].value;
					if  (valida==1)
						valida=1;
				}
				else {
					valida=0;
				}
			}
			
			if (cad_pessoa_3.computador_3[0].checked==true){
				comp=cad_pessoa_3.computador_3[0].value;
				if  (valida==1)
					valida=1;
			}
			else {
				if (cad_pessoa_3.computador_3[1].checked==true){
					comp=cad_pessoa_3.computador_3[1].value;
					if  (valida==1)
						valida=1;
				}
				else {
					valida=0;
				}
			}
			
			if (cad_pessoa_3.dom_manual_3[0].checked==true){
				lado=cad_pessoa_3.dom_manual_3[0].value;
				if  (valida==1)
					valida=1;
			}
			else {
				if (cad_pessoa_3.dom_manual_3[1].checked==true){
					lado=cad_pessoa_3.dom_manual_3[1].value;
					if  (valida==1)
						valida=1;
				}
				else {
					valida=0;
				}
			}
		}
		if (valida==1){
			c="funcoes_php_requeridas.php?f=12&n="+nome+"&i="+idade+"&s="+s+"&c="+comp+"&l="+lado+"&app_atual="+app_atual;
			loadXMLDoc(c);
		}
		else {
			alert ("Preencha todos os dados e corretamente");
		}
	}
	
	function prepara_teste(modo, app){
		if (modo==1){
			
			if (document.getElementById('id_a_'+app).value!="" && document.getElementById('id_a_'+app).value!=0){
				id_=document.getElementById('id_a_'+app).value;
				c="funcoes_php_requeridas.php?f=13&id_grupo="+id_+"&modo=fixo"+"&app_atual="+app;
				loadXMLDoc(c);
			}
			else {
				alert ("O valor de identificação não pode ser nulo!");
				showDiv2("app_"+app,false);
			}
		}
		else {
			if(modo==2){
				
				c="funcoes_php_requeridas.php?f=13&modo=aleatorio"+"&app_atual="+app;
				loadXMLDoc(c);
			}
		}
	}

	// Para a bateria
	function mostra_tudoBateria(){
		c="funcoes_php_requeridas.php?f=16";
		loadXMLDoc(c);
	}
	
	function pesquisa_param_bateria(){
		indice = document.aux02.g.selectedIndex; 
		campo = document.aux02.g.options[indice].value;
		valor=aux02.var_search2.value;
		
		c="funcoes_php_requeridas.php?f=19&campo="+campo+"&valor="+valor;
		loadXMLDoc(c);
	}
	
	// Para a secao
	function mostra_tudoSecao(){
		c="funcoes_php_requeridas.php?f=20";
		loadXMLDoc(c);
	}
	
	function pesquisa_param_secao(){
		indice = document.aux03.h.selectedIndex; 
		campo = document.aux03.h.options[indice].value;
		valor=aux03.var_search3.value;
		
		c="funcoes_php_requeridas.php?f=21&campo="+campo+"&valor="+valor;
		loadXMLDoc(c);
	}
	
	// Para a mensagem
	function mostra_tudo_msg(){
		c="funcoes_php_requeridas.php?f=23";
		loadXMLDoc(c);
	}
	
	function pesquisa_param_msg(){
		indice = document.aux04.i.selectedIndex; 
		campo = document.aux04.i.options[indice].value;
		valor=aux04.var_search4.value;
		
		c="funcoes_php_requeridas.php?f=24&campo="+campo+"&valor="+valor;
		loadXMLDoc(c);
	}
	
	function troca_status(id){
		c="funcoes_php_requeridas.php?f=25&id="+id;
		loadXMLDoc(c);
	}
	
	// Para gerar o gráfico
	function gera_grafico(){
		id = prompt("Digite o código da bateria para visualizar o tempo e a correção das tentativas: ");
		if(id!=""){
			prefix="http://cog_test_center.4sql.net/ontologia_ykira/onto_cog_site.owl";
			ns="http://localhost/teste_sun/indice.php";
			
			var link = document.getElementsByType(prefix+"#session")[0];
			a=link.data.id;
			
			var time = document.data.getValues(link.href,"http://cog_test_center.4sql.net/ontologia_ykira/onto_cog_site.owl#time_of_answer");
			
			q=0;
			uri_bateria=ns+"#battery_"+id;
			var links = document.getElementsByType(prefix+"#session");
			
			tempos= new Array();
			correct= new Array();
			
			for(y=0;y<links.length;y++){
				a= links[y].data.id;
				suj=document.data.getSubject(a);
				
				if (suj.predicates[prefix+"#has_battery"].objects[0].value==uri_bateria){
					pr=suj.predicates[prefix+"#time_of_answer"].objects[0].value;
					tempos[q]=pr;
					cor=suj.predicates[prefix+"#correction"].objects[0].value;
					correct[q]=cor;
					//alert(tempos[q]+'|||'+correct[q]);
					q++;
				}
				
			}
			
			draw(tempos, correct);
		}
		else{
			alert('Código inválido');
		}
	}
	
	function draw (time, correction){
		showDiv2('graph', true);
		
		data_set= new Array();
		for (w=0; w<time.length; w++){
			array_aux=new Array();
			array_aux[0]=(w+1)+"ª";
			array_aux[1]=parseInt(time[w]);
			data_set[w]=array_aux;
		}
		
		var myChart = new JSChart('graph', 'line');
		
		myChart.setDataArray(data_set);
		
		myChart.setTitle('Gráfico de tempos e correção das tentativas');
		myChart.setTitleColor('#000000');
		myChart.setTitleFontSize(11);
		
		myChart.setAxisNameX('Seções');
		myChart.setAxisNameY('Tempos');
		myChart.setAxisColor('#4682B4');
		myChart.setAxisValuesColor('#949494');
		
		myChart.setAxisPaddingLeft(100);
		myChart.setAxisPaddingRight(120);
		myChart.setAxisPaddingTop(50);
		myChart.setAxisPaddingBottom(40);
		myChart.setAxisValuesDecimals(0);
		myChart.setAxisValuesNumberX(10);
		
		myChart.setShowXValues(false);
		myChart.setShowYValues(true);
		myChart.setGridColor('#C5A2DE');
		myChart.setLineColor('#BBBBBB');
		myChart.setLineWidth(2);
		myChart.setFlagColor('#000000');
		myChart.setFlagRadius(4);
		
		for (w=0; w<correction.length; w++){
			myChart.setTooltip([(w+1)+"ª", 'Correção: '+correction[w]+'<br />Tempo: '+time[w]]);
		}
		/*for (w=0; w<correction.length; w++){
			myChart.setLabelY([parseInt(time[w]), time[w]]);
		}*/
		
		myChart.setSize(616, 321);
		
		myChart.draw();
	}
	
	var req;

	function loadXMLDoc(c) {
		req = null;
		// Procura por um objeto nativo (Mozilla/Safari)
		if (window.XMLHttpRequest) {
			req = new XMLHttpRequest();
			req.onreadystatechange = processReqChange;
			req.open("GET", c, true);
			req.send(null);
			// Procura por uma versão ActiveX (IE)
		} 
		else {
			if (window.ActiveXObject) {
				req = new ActiveXObject("Microsoft.XMLHTTP");
				
				if (req) {
					req.onreadystatechange = processReqChange;
					req.open("GET", c, true);
					req.send();
				}
			}
		}
	}
  
	function processReqChange() {
		// apenas quando o estado for "completado"
		if (req.readyState == 4) {
		
		// apenas se o servidor retornar "OK"
			if (req.status == 200) {
			    op = req.responseText.split("&");
				
				if (op[0]=='1'){
					if(op[1]=="Não foi encontrado nenhum registro com esta combinação de login e senha!"){
						alert("Não foi encontrado nenhum registro com esta combinação de login e senha!");
					}
					else{
						r=op[1].split("-");
						processa_resp_adTeste(r);
					}
				}
				if (op[0]=='2'){
					showDiv2('todos',false);
					document.getElementById('res_pesquisa').innerHTML=op[1];
					showDiv2('res_pesquisa',true);
				}
				if (op[0]=='3'){
				    showDiv2('todos',false);
					document.getElementById('res_pesquisa').innerHTML=op[1];
					showDiv2('res_pesquisa',true);
					aux1.var_search.value="";
				}
				if (op[0]=='4'){
					r=op[1].split("-");
					document.getElementById('co0').value=r[0];
					document.getElementById('n0').value=r[1];
					document.getElementById('lo').value=r[2];
					document.getElementById('s0').value=r[3];
					
					document.getElementById('lo').disabled=true;
					
					showDiv2('altera_adSite', true);
				}
				if (op[0]=='5'){
				    showDiv2('progresso',false);
				    if(form_5.tipo[0].checked){
						tipo=form_5.tipo[0].checked=false;
					}
					else if(form_5.tipo[1].checked){
						tipo=form_5.tipo[1].checked=false;
					}
					form_5.l0.value="";
					alert(op[1]);
					location.href="indice.php";
				}
				if (op[0]=='6'){
				    r=op[1].split("-");
				    document.getElementById('co1').value=r[0];
					document.getElementById('n1').value=r[1];
					document.getElementById('i1').value=r[2];
					document.getElementById('nu1').value=r[3];
					document.getElementById('l1').value=r[4];
					document.getElementById('s1').value=r[5];
					
					document.getElementById('l1').disabled=true;
					showDiv2('altera_adTeste', true);
				}
				if (op[0]=='7'){
				    showDiv2('todos_grupo',false);
					document.getElementById('res_pesquisa_grupo').innerHTML=op[1];
					showDiv2('res_pesquisa_grupo',true);
					aux01.var_search0.value="";
				}
				if (op[0]=='8'){
				    showDiv2('todos_tipoTeste',false);
					document.getElementById('res_pesquisa_tipoTeste').innerHTML=op[1];
					showDiv2('res_pesquisa_tipoTeste',true);
					aux11.var_search1.value="";
				}
				if (op[0]=='9'){
					
					if (op[1]!='Não existe tipo de teste com este código!'){
					    if (op[2]=='c'){
							document.getElementById('dados_teste').innerHTML=op[1];
							showDiv2('dados_teste',true);
						}
						if (op[2]=='a'){
							form0_3.co00.disabled=true;
							document.getElementById('dados_teste_a').innerHTML=op[1];
							showDiv2('dados_teste_a',true);
							
							t=op[3].split('-');
							quanti=parseInt(op[4]);
							
							for (u=0; u<quanti;u++){
							    if (t[u].length<4){
									ind='y'+u;
									document.getElementById(ind).value=t[u];
								}
								else {
									ind='y'+u;
									elem = document.getElementById(ind);
									cont = elem.length; 
									
									for(uk=0; uk<cont; uk++) {
										if (t[u].indexOf("_")!=(-1)){
										    res=t[u].split('_');
											if (elem.options[uk].value==res[0]) { 
												showDiv2(res[0]+u, true);
												document.getElementById(res[0]+u).value=res[1];
												
												elem.options[uk].selected="true";
												break;
											}
										}
										else {
											if (elem.options[uk].value==res[0]) { 
												elem.options[uk].selected="true";
												break;
											}
										}
									}
								}
							}
						}
					}
					else {
					    alert(op[1]);
					}
					
				}
				if (op[0]=='10'){
					if (op[1]!='Não foi encontrado nenhum registro com este código!'){
					    r=op[1].split("-");
						document.getElementById('co11').value=r[0];
						document.getElementById('nome1').value=r[1];
						document.getElementById('descricao1').value=r[2];
						document.getElementById('area1').value=r[3];
						document.getElementById('obj1').value=r[4];
						document.getElementById('data_info1').value=r[5];
						
						form1_3.co11.disabled=true;
						showDiv2('antes1',false);
						showDiv2('depois1',true);
						showDiv2('l11',true);
						showDiv2('l12',true);
						showDiv2('l13',true);
						showDiv2('l14',true);
						showDiv2('l15',true);
						showDiv2('b1_antes',false);
						showDiv2('b1_depois',true);
					}
					else {
					    alert('Não foi encontrado nenhum registro com este código!');
					}
				}
				if (op[0]=='11'){
					
					if (op[1]!='Não foi encontrado nenhum registro com este código!'){
						r=op[1].split("|");
						document.getElementById('co00').value=r[0];
						document.getElementById('d0').value=r[1];
						document.getElementById('id_p').value=r[2];
						document.getElementById('id_tt0').value=r[3];
						
						if (r[5].indexOf("_")!=(-1)){
							
							while (r[5].indexOf("_") != -1) {
								r[5] = r[5].replace("_", ",");
							}
							form0_3.mod_a[0].checked=true;
							showDiv2('tec_a',true);
							document.getElementById('teclas_a').value=r[5].substring(8);
						}
						else {
							form0_3.mod_a[1].checked=true;
							document.getElementById('teclas_a').value="";
						}
						
						document.getElementById('q_secoes_a').value=r[6];
						
						form0_3.co00.disabled=true;
						form0_3.d0.disabled=true;
						form0_3.id_p.disabled=true;
						showDiv2('antes0',false);
						showDiv2('depois0',true);
						showDiv2('l01',true);
						showDiv2('l02',true);
						showDiv2('l03',true);
						showDiv2('l04',true);
						showDiv2('l05',true);
						showDiv2('b0_antes',false);
						showDiv2('b0_depois',true);
					}
					else {
					    alert('Não foi encontrado nenhum registro com este código!');
					}
				}
				if (op[0]=='12'){
				    alert(op[1]);
					
					showDiv2('dados_pessoa'+op[3], false);
					showDiv2('init'+op[3], false);
					
					if(op[2]=='logsim'){
						document.getElementById('id_a'+op[3]).value="";
					    showDiv2('dados_carregar_teste'+op[3],true);
					}
					else if (op[2]=='lognao') {
						showDiv2('carregar_teste_direto'+op[3],true);
					}
					
				}
				if (op[0]=='13'){
					if (op[1]!='Não foi encontrado nenhum registro com este código!'){
						r=op[1].split("-");
						if (op[2]=='_1'){
							seta_config_app1(r[0], r[1], r[2], r[3], r[4]);
							timer();
						}
						else if(op[2]=='_2'){
							seta_config_app2(r[0], r[1], r[2], r[3], r[4]);
							timer_2();
						}
						else if(op[2]=='_3'){
							seta_config_app3(r[0], r[1], r[2], r[3], r[4], r[5]);
							timer_3();
						}
							
						showDiv2('app'+op[2], true);
						showDiv2('dados_carregar_teste'+op[2], false);
						showDiv2('carregar_teste_direto'+op[2], false);
					}
					else {
						alert('Não foi encontrado nenhum registro com este código!');
					}
				}
				if (op[0]=='14'){
					if(op[1]=='ok_final'){
						showDiv2('app_'+op[2], false);
						showDiv2('init_'+op[2], true);
						location.href='indice.php';
					}
					else if(op[1]=='ok_parcial'){
						if (op[2]=='1'){
							timer();
						}
					    else if(op[2]=='2'){
							timer_2();
						}
						else if(op[2]=='3'){
							timer_3();
						}
					}
					else if(op[1]=='no'){
					    alert('Houve um erro ao salvar os dados!');
					}
				}
				if (op[0]=='15'){
				    
				}
				if (op[0]=='16'){
				    showDiv2('todos_bateria',false);
					document.getElementById('res_pesquisa_bateria').innerHTML=op[1];
					showDiv2('res_pesquisa_bateria',true);
					aux02.var_search2.value="";
				}
				if (op[0]=='17'){
					showDiv2('todos_grupo',false);
					document.getElementById('res_pesquisa_grupo').innerHTML=op[1];
					showDiv2('res_pesquisa_grupo',true);
				}
				if (op[0]=='18'){
					showDiv2('todos_tipoTeste',false);
					document.getElementById('res_pesquisa_tipoTeste').innerHTML=op[1];
					showDiv2('res_pesquisa_tipoTeste',true);
				}
				if (op[0]=='19'){
					showDiv2('todos_bateria',false);
					document.getElementById('res_pesquisa_bateria').innerHTML=op[1];
					showDiv2('res_pesquisa_bateria',true);
				}
				if (op[0]=='20'){
					showDiv2('todos_secao',false);
					document.getElementById('res_pesquisa_secao').innerHTML=op[1];
					showDiv2('res_pesquisa_secao',true);
					aux03.varsearch3.value="";
				}
				if (op[0]=='21'){
					showDiv2('todos_secao',false);
					document.getElementById('res_pesquisa_secao').innerHTML=op[1];
					showDiv2('res_pesquisa_secao',true);
				}
				if (op[0]=='22'){
				    if(op[1]=='ok'){
					    location.href="results.xls";
					}
				}
				if (op[0]=='23'){
					document.getElementById('res_pesquisa_msg').innerHTML=op[1];
					showDiv2('res_pesquisa_msg',true);
					aux04.var_search4.value="";
				}
				if (op[0]=='24'){
					document.getElementById('res_pesquisa_msg').innerHTML=op[1];
					showDiv2('res_pesquisa_msg',true);
					aux04.var_search4.value="";
					
					//Imprime algum erro que possa ter ocorrida na consulta (Nenhuma mensagem, p. ex.)
					if(op[2]!=""){
						alert(op[2]);
					}
				}
				if (op[0]=='25'){
					document.getElementById('res_pesquisa_testAdd').innerHTML=op[1];
					alert(op[2]);
				}
				if (op[0]=='26'){
					showDiv2('altera_adSite', false);
					alert(op[1]);
					location.href="indice.php";
				}
				if (op[0]=='27'){
					showDiv2('altera_adTeste', false);
					alert(op[1]);
					location.href="indice.php";
				}
			} 
			else {
				alert("Houve um problema ao obter os dados:\n" + req.statusText);
			}
		}
	}
	
	function limpa_conjunto_forms(info){
		if (info==1){
			form_1.nome.value="";
			form_1.inst.value="";
			form_1.nucleo.value="";
			form_1.email.value="";
			form_1.senha.value="";
			
			form_2.l.value="";
			form_2.s.value="";
			
			form_3.co.value="";
			form_3.n.value="";
			form_3.i.value="";
			form_3.nu.value="";
			form_3.lo_.value="";
			form_3.se.value="";
		}
		if (info==2){
		    form0_1.id_teste_g.value="";
			for (var i=0; i < form0_1.dif_.length; i++)
				form0_1.dif_[i].checked = false;
			document.getElementById('dados_teste').innerHTML="";
			showDiv2('dados_teste', false);
			form0_1.quant.value=0;
			for (var i=0; i < form0_1.mod_.length; i++)
				form0_1.mod_[i].checked = false;
			form0_1.sim.value="";
			form0_1.nao.value="";
			showDiv2('teclas', false);
			form0_1.q_secoes.value="";
			
			form0_2.id_grupo.value="";
			
			form0_3.co00.disabled=false;
			form0_3.d0.disabled=false;
			form0_3.id_p.disabled=false;
			form0_3.co00.value="";
			form0_3.d0.value="";
			form0_3.id_p.value="";
			form0_3.id_tt0.value="";
			for (var i=0; i < form0_3.dif_a.length; i++)
				form0_3.dif_a[i].checked = false;
			form0_3.quant_a.value=0;	
			for (var i=0; i < form0_3.mod_a.length; i++)
				form0_3.mod_a[i].checked = false;
			form0_3.sim_a.value="";
			form0_3.nao_a.value="";
			showDiv2('teclas_a', false);
			form0_3.q_secoes_a.value="";	
		}
		if (info==3){
			form1_1.nome0.value="";
			form1_1.descricao.value="";
			form1_1.area0.value="";
			form1_1.obj0.value="";
			form1_1.data_info.value="";
			
			form1_2.id_tipoTeste.value="";
			
			form1_3.co11.value="";
			form1_3.nome1.value="";
			form1_3.descricao1.value="";
			form1_3.area1.value="";
			form1_3.obj1.value="";
			form1_3.data_info1.value="";
		}
		if (info==4){
			cad_pessoa.n_p.value="";
			cad_pessoa.i_p.value="";
			for (var i=0; i < cad_pessoa.sexo.length; i++)
				cad_pessoa.sexo[i].checked = false;
			
			for (var i=0; i < cad_pessoa.computador.length; i++)
				cad_pessoa.computador[i].checked = false;
			
			for (var i=0; i < cad_pessoa.dom_manual.length; i++)
				cad_pessoa.dom_manual[i].checked = false;
		}
		if (info==5){
			cad_pessoa_2.n_p_2.value="";
			cad_pessoa_2.i_p_2.value="";
			for (var i=0; i < cad_pessoa_2.sexo_2.length; i++)
				cad_pessoa_2.sexo_2[i].checked = false;
			
			for (var i=0; i < cad_pessoa_2.computador_2.length; i++)
				cad_pessoa_2.computador_2[i].checked = false;
			
			for (var i=0; i < cad_pessoa_2.dom_manual_2.length; i++)
				cad_pessoa_2.dom_manual_2[i].checked = false;
		}
	}
	
// Função para mostrar formulários
	function mostra_form(o){
	    if (o=='1'){
			var indice = document.aux.a.selectedIndex; 
			var valor = document.aux.a.options[indice].value;
		    
			if (valor=='cadastrar'){
			    showDiv2('cadastro',true);
				
				if (document.getElementById( 'exclusao' ).style.display==""){
					showDiv2('exclusao',false);
				}
				if (document.getElementById( 'infoAtualiza' ).style.display==""){
					showDiv2('infoAtualiza',false);
				}
			}
			
			if (valor=='excluir'){
				showDiv2('exclusao',true);
				
				if (document.getElementById( 'cadastro' ).style.display==""){
					showDiv2('cadastro',false);
				}
				if (document.getElementById( 'infoAtualiza' ).style.display==""){
					showDiv2('infoAtualiza',false);
				}
			}
			
			if (valor=='alterar'){
				showDiv2('alteracao',true);
				
				form_3.lo_.disabled=false;
				showDiv2('antes',true);
				showDiv2('depois',false);
				showDiv2('l1',false);
				showDiv2('l2',false);
				showDiv2('l3',false);
				showDiv2('l4',false);
				showDiv2('b_antes',true);
				showDiv2('b_depois',false);
					
				if (document.getElementById( 'cadastro' ).style.display==""){
					showDiv2('cadastro',false);
				}
				if (document.getElementById( 'exclusao' ).style.display==""){
					showDiv2('exclusao',false);
				}
			}
			
			limpa_conjunto_forms(1);
		}
		
		if (o=='2') {
		    var indice = document.aux0.c.selectedIndex; 
			var valor = document.aux0.c.options[indice].value; 
			
			if (document.getElementById( 'dados_teste_a' ).style.display==""){
				showDiv2('dados_teste_a',false);
			}
			
			if (valor=='cadastrar'){
			    showDiv2('cadastro0',true);
			    
				if (document.getElementById( 'exclusao0' ).style.display==""){
				    showDiv2('exclusao0',false);
				}
				if (document.getElementById( 'alteracao0' ).style.display==""){
				    showDiv2('alteracao0',false);
				}
			}
			else {
				if (valor=='excluir'){
					showDiv2('exclusao0',true);
					
					if (document.getElementById( 'cadastro0' ).style.display==""){
						showDiv2('cadastro0',false);
					}
					if (document.getElementById( 'alteracao0' ).style.display==""){
						showDiv2('alteracao0',false);
					}
				}
				else {
					if (valor=='alterar'){
						showDiv2('alteracao0',true);
						
						form0_3.co00.disabled=false;
						showDiv2('antes0',true);
						showDiv2('depois0',false);
						showDiv2('l01',false);
						showDiv2('l02',false);
						showDiv2('l03',false);
						showDiv2('l04',false);
						showDiv2('l05',false);
						showDiv2('b0_antes',true);
						showDiv2('b0_depois',false);
							
						if (document.getElementById( 'cadastro0' ).style.display==""){
							showDiv2('cadastro0',false);
						}
						if (document.getElementById( 'exclusao0' ).style.display==""){
							showDiv2('exclusao0',false);
						}
					}
				}
			}
			limpa_conjunto_forms(2);
		}
		
		if (o=='3') {
		    var indice = document.aux1.e.selectedIndex; 
			var valor = document.aux1.e.options[indice].value; 
			
			if (valor=='cadastrar'){
			    showDiv2('cadastro1',true);
				
				if (document.getElementById( 'exclusao1' ).style.display==""){
				    showDiv2('exclusao1',false);
				}
				if (document.getElementById( 'alteracao1' ).style.display==""){
				    showDiv2('alteracao1',false);
				}
			}
			else {
				if (valor=='excluir'){
					showDiv2('exclusao1',true);
					
					if (document.getElementById( 'cadastro1' ).style.display==""){
						showDiv2('cadastro1',false);
					}
					if (document.getElementById( 'alteracao1' ).style.display==""){
						showDiv2('alteracao1',false);
					}
				}
				else {
					if (valor=='alterar'){
						showDiv2('alteracao1',true);
						
						form1_3.co11.disabled=false;
						showDiv2('antes1',true);
						showDiv2('depois1',false);
						showDiv2('l11',false);
						showDiv2('l12',false);
						showDiv2('l13',false);
						showDiv2('l14',false);
						showDiv2('l15',false);
						showDiv2('b1_antes',true);
						showDiv2('b1_depois',false);
							
						if (document.getElementById( 'cadastro1' ).style.display==""){
							showDiv2('cadastro1',false);
						}
						if (document.getElementById( 'exclusao1' ).style.display==""){
							showDiv2('exclusao1',false);
						}
					}
				}
			}
			limpa_conjunto_forms(3);
		}
		if(op=='4'){
		    showDiv2('dados_pessoa',true);
			limpa_conjunto_forms(4);
		}
	} 
	
	function showDiv2( idName, value ){  
		objDiv = document.getElementById( idName );  
		if ( value )  {
			objDiv.style.display = ""; 		
		}			
		else{  
			objDiv.style.display = "none";
		}			
	} 

// Mostra as divs das entidades diferentes
	function  troca_entidade(a){
	    if (a==1){
		    document.getElementById('link_aba1').className="aba_setada";
			document.getElementById('link_aba2').className="title_aba";
			document.getElementById('link_aba3').className="title_aba";
			document.getElementById('link_aba4').className="title_aba";
			
			document.getElementById('grupo').style.display="";
			document.getElementById('bateria').style.display="none";
			document.getElementById('secao').style.display="none";
			document.getElementById('tipo_teste').style.display="none";

			document.getElementById('graph').style.display="none";
			
		}
		if (a==2){
		    document.getElementById('link_aba1').className="title_aba";
			document.getElementById('link_aba2').className="aba_setada";
			document.getElementById('link_aba3').className="title_aba";
			document.getElementById('link_aba4').className="title_aba";
			
			document.getElementById('grupo').style.display="none";
			document.getElementById('bateria').style.display="";
			document.getElementById('secao').style.display="none";
			document.getElementById('tipo_teste').style.display="none";
			
			document.getElementById('graph').style.display="none";
			
			document.getElementById('dados_teste').style.display="none";
			document.getElementById('dados_teste_a').style.display="none";
		}
		if (a==3){
		    document.getElementById('link_aba1').className="title_aba";
			document.getElementById('link_aba2').className="title_aba";
			document.getElementById('link_aba3').className="aba_setada";
			document.getElementById('link_aba4').className="title_aba";
			
			document.getElementById('grupo').style.display="none";
			document.getElementById('bateria').style.display="none";
			document.getElementById('secao').style.display="";
			document.getElementById('tipo_teste').style.display="none";
			
			document.getElementById('graph').style.display="none";
			
			document.getElementById('dados_teste').style.display="none";
			document.getElementById('dados_teste_a').style.display="none";
		}
		if (a==4){
		    document.getElementById('link_aba1').className="title_aba";
			document.getElementById('link_aba2').className="title_aba";
			document.getElementById('link_aba3').className="title_aba";
			document.getElementById('link_aba4').className="aba_setada";
			
			document.getElementById('grupo').style.display="none";
			document.getElementById('bateria').style.display="none";
			document.getElementById('secao').style.display="none";
			document.getElementById('tipo_teste').style.display="";
			
			document.getElementById('graph').style.display="none";
			
			document.getElementById('dados_teste').style.display="none";
			document.getElementById('dados_teste_a').style.display="none";
		}
	}
	
	function limitar(obj){
		var tecla = window.event.keyCode;
		var res = new RegExp("","g");  
		var x = obj.value.replace(res,"").length;
		
		if ((x >= obj.maxLength) && ((tecla > 33 && tecla < 255) || (tecla > 95 && tecla < 106)) && (tecla != 13)){
		    if(obj.erro){
			    alert("O número máximo de caracteres foi atingido.");
		    }
		    window.event.returnValue=false;      
		}
		
		// tratamento para o texto colado
		if ((obj.value.length >= obj.maxLength) && (window.event.type == 'paste')){
		    var texto = obj.value;
		    obj.value = "";
		    obj.value = texto.slice(0, obj.maxLength - 1);
		} 
    } 
	
	function show_message(){
		o=document.getElementById('ver_msg');
		if(o.style.display=='none'){
			document.getElementById('link_msg').className="link_setado";
			document.getElementById('link_msg').innerHTML='Fechar área de mensagens';
			o.style.display="";
		}
		else{
			document.getElementById('link_msg').className="link_normal";
			document.getElementById('link_msg').innerHTML='Abrir área de mensagens';
			o.style.display="none";
		}
	}
	
	function show_testAdd(){
		o=document.getElementById('ver_testAdd');
		if(o.style.display=='none'){
			document.getElementById('link_testAdd').className="link_setado";
			document.getElementById('link_testAdd').innerHTML='Fechar área de testes a adicionar';
			o.style.display="";
		}
		else{
			document.getElementById('link_testAdd').className="link_normal";
			document.getElementById('link_testAdd').innerHTML='Abrir área de testes a adicionar';
			o.style.display="none";
		}
	}
	
// Funções que controlam a parte estética		
	function showDiv( idName, n ){ 
		
		for(i=1;i<=10;i++){
			if (('dados_'+i)==idName){
				document.getElementById(idName).style.display="";
			}
			else {
				document.getElementById( 'dados_'+i ).style.display="none";
			}
		}
		verifica_submenus_abertos();
	}
	
	function verifica_submenus_abertos(){
		if (document.getElementById('mdiv1').style.display==''){ 
			escondediv('1',n_divs); 
		} 
		else if (document.getElementById('mdiv2').style.display==''){ 
			escondediv('2',n_divs); 
		}
	}
	
	c=0
	du=""; 
	function escondediv(dv,n){		
		for(i=1;i<=n;i++){			
			if ((i+"")==dv ) {
				if (du!=dv) {
					document.getElementById('mdiv'+i).style.display="";
					du=dv;
				}
				else {
				   du="";
				   document.getElementById('mdiv'+i).style.display="none";
				}
			}
			else {
				 document.getElementById('mdiv'+i).style.display="none"	;				 
			}				
		}		
	}

	function reveza(qq){
		document.getElementById(qq).className="item_2"
	}
	function volta(qq){
		document.getElementById(qq).className="item"
	}