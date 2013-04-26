<?php
    echo "";
?>
<script language="javascript" type="text/javascript"> 
<!--

// Entradas  para configuração do aplicativo
var tempo_resposta, cores, forma, mod_res, quant;

function seta_config_app2(tr, cor, form, vr, q_secoes){
	tempo_resposta=parseInt(tr)*1000;
	cores=cor;
	forma=form;
	mod_res=vr;
	quant=parseInt(q_secoes);
}

// Resultado do usuário do aplicativo
tempos_resp = new Array();
correcao = new Array();

be=0;

x=-1;


hexa_choice="";
conteudo="";

cont="";
s = 0 ;

function conta_tempo_2(flag) {
	s=s+10;
	if (flag==1){
		cont=setTimeout("conta_tempo_2(1)",10);
		if (s==tempo_resposta){
		    clearTimeout(cont);
			tempos_resp[x]=s;
			correcao[x]='nao respondeu';
			res_='nenhuma';
			alert(correcao[x]);
			
			c="funcoes_php_requeridas.php?f=14&estimulo_dado=Cor-"+traduz_cor(hexa_choice)+";Conteudo-"+conteudo+"&resposta_obtida="+res_+"&tempo="+tempos_resp[x]+"&correcao="+correcao[x]+"&quant_=0&mod=parcial&app=2";
			loadXMLDoc(c);
		
		}
	}
	else {
		if (flag==0){
		    if (be==1){
				tempos_resp[x]=s;
				clearTimeout(cont);
				
     			alert(correcao[x]);
				
				if(res_==""){
					res_="nao_respondeu";
				}
				
				c="funcoes_php_requeridas.php?f=14&estimulo_dado=Cor-"+traduz_cor(hexa_choice)+";Conteudo-"+conteudo+"&resposta_obtida="+res_+"&tempo="+tempos_resp[x]+"&correcao="+correcao[x]+"&quant_=0&mod=parcial&app=2";
				loadXMLDoc(c);
			
			}
		}
	}
}

shuffle = function(v){
    for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
    return v;
};


function timer_2(){
    be=0;
	s=0;
	
	showDiv2('texto', false);
	showDiv2('resposta_mouse_2',false);
	
	
	if (x==quant-1) {
	    showDiv2('ti_2',false);
		
		alert("Você terminou as tentativas deste teste!");
	    
		soma=0;
		soma_acertos=0;
		
		for ( i=0; i<=x; i++){
		    soma+=tempos_resp[i];
			
			if (correcao[i]=='certo'){
			    soma_acertos+=1;
			}
			
		}
		
		media_tempo=soma/(x+1); 
		media_acertos=soma_acertos/(x+1);
		
		tempos_resp = new Array();
		correcao = new Array();
		
		x=-1;
		
		c="funcoes_php_requeridas.php?f=14&media_tempos="+media_tempo+"&media_acertos="+media_acertos+"&mod=final&flag=1&app=2";
		loadXMLDoc(c);
			
		
	}
	else {
		if(x==-1){
			inicializa();
			c="funcoes_php_requeridas.php?f=15";
			loadXMLDoc(c);
		}
		
		x++;
		
		document.getElementById('ti_2').innerHTML='<font face="Poor Richard" size="8pt" color="#20B2AA">Tentativa '+(x+1)+'...</font>';
		showDiv2('ti_2',true);
		
		s=0;
		res_="";
		carac="";
	    setTimeout('muda_contexto()',3000);
		
	}
}

cores_hexa= new Array("#090", "#FFC", "#630", "#03C", "#F00", "#FF0");
cores_nomes= new Array("verde", "branco", "marrom", "azul", "vermelho", "amarelo");

function inicializa(){
	
	indice=0;
	combinacao_cores_1= new Array();
	for (k=0;k<3;k++){
		for(l=0;l<3;l++){
			combinacao_cores_1[indice]=cores_hexa[k]+"-"+cores_nomes[l];
			indice++;
		}
	}

	indice=0;
	combinacao_cores_2= new Array();
	for (k=3;k<6;k++){
		for(l=3;l<6;l++){
			combinacao_cores_2[indice]=cores_hexa[k]+"-"+cores_nomes[l];
			indice++;
		}
	}
	

	res_tecla1="";
	res_tecla2="";
	res_tecla3="";

	if(cores.indexOf("branco")!=(-1)){
		res_tecla1="branco";
		res_tecla2="marrom";
		res_tecla3="verde";
	}
	else if(cores.indexOf("amarelo")!=(-1)){
		res_tecla1="amarelo";
		res_tecla2="azul";
		res_tecla3="vermelho";
	}
	
	comb_efetiva=new Array();	
	if(forma=='congruentes'){
		comb_efetiva=new Array();
		indice=0;
		for(l=0;l<9;l++){
			if(l==0 || l==4 || l==8){
				if(cores.indexOf("branco")!=(-1)){
					comb_efetiva[indice]=combinacao_cores_1[l];
				}
				else if(cores.indexOf("amarelo")!=(-1)){
					comb_efetiva[indice]=combinacao_cores_2[l];
				}
				indice++;
			}
		}
	}
	else if(forma=='incongruentes'){
		comb_efetiva=new Array();
		indice=0;
		for(l=0;l<9;l++){
			if(l!==0 && l!=4 && l!=8){
				if(cores.indexOf("branco")!=(-1)){
					comb_efetiva[indice]=combinacao_cores_1[l];
				}
				else if(cores.indexOf("amarelo")!=(-1)){
					comb_efetiva[indice]=combinacao_cores_2[l];
				}
				indice++;
			}
		}
	}
	else if(forma=='misturar_os_dois'){
		comb_efetiva=new Array();
		indice=0;
		for(l=0;l<9;l++){
			if(cores.indexOf("branco")!=(-1)){
				comb_efetiva[indice]=combinacao_cores_1[l];
			}
			else if(cores.indexOf("amarelo")!=(-1)){
				comb_efetiva[indice]=combinacao_cores_2[l];
			}
			indice++;
		}
	}

	maximo=new Array();
	resto=quant % comb_efetiva.length;
	if(resto==0){
		max_repete=quant/comb_efetiva.length;
		for (l=0; l<comb_efetiva.length; l++){
			maximo[l]=max_repete; 
		}
	}
	else{
		max_repete=parseInt(quant/comb_efetiva.length);
		for (l=0; l<comb_efetiva.length; l++){
			maximo[l]=max_repete;
			if(l<resto){
				maximo[l]+=1;
			}
		}
	}

	comp_efetivo=comb_efetiva.length;
}

tecla_1="";
tecla_2="";
tecla_3="";
/**/
function muda_contexto(){
	
	showDiv2('texto', true);
	
	alis=new Array();
	for (l=0; l<comp_efetivo; l++){
		alis[l]=l;
	}
	shuffle(alis);
	rom=alis[0];
	hexa_choice="";
	
	while(maximo[rom]==0){
	    shuffle(alis);
		rom=alis[0];
	}
	
	separa=comb_efetiva[rom].split("-");
	hexa_choice=separa[0];
	conteudo=separa[1];
	maximo[rom]-=1;
	
	document.getElementById('texto').innerHTML='<font face="Arial" size="6pt" color="'+hexa_choice+'">'+conteudo+'</font>';
	
	if(mod_res.indexOf("teclado")!=(-1)){
		aux=mod_res.split("_");
		tecla_1=aux[1];
		tecla_2=aux[2];
		tecla_3=aux[3];
		
		document.getElementById('ti_2').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">Qual é a cor da palavra abaixo? Digite '+tecla_1+' se for '+res_tecla1+' ou '+tecla_2+' se for '+res_tecla2+' ou '+tecla_3+' se for '+res_tecla3+'</font>';
	
		document.captureEvents(Event.KEYPRESS);
		document.onkeypress = verifica_teclado_2;
		conta_tempo_2(1);
	}
	else {
		showDiv2("resposta_mouse_2", true);
		document.getElementById('a_2').value=res_tecla1;
		alert(document.getElementById('a_2').value);
		document.getElementById('b_2').value=res_tecla2;
		document.getElementById('c_2').value=res_tecla3;
	
		document.getElementById('ti_2').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">Qual é a cor da palavra abaixo? </font>';
		
		conta_tempo_2(1);
	}
	
}

res_="";
function verifica_mouse_2(hug){
	be=1;
	if(hug==1){
	    res_=res_tecla1; 
	}
	if(hug==2){
	    res_=res_tecla2;
	}
	if(hug==3){
		res_=res_tecla3;
	}
	
    if ((traduz_cor(hexa_choice)==res_tecla1 && hug==1) || (traduz_cor(hexa_choice)==res_tecla2 && hug==2) || (traduz_cor(hexa_choice)==res_tecla3 && hug==3)){
	    correcao[x]='certo';
	}
	else { 
	    correcao[x]='errado';
	}
	conta_tempo_2(0);
	//alert(va+'-'+val);
}

function verifica_teclado_2(e){
	be=1;
    var carac = String.fromCharCode(e.which);
	
	if(carac==tecla_1){
	    res_=res_tecla1; 
	}
	if(carac==tecla_2){
	    res_=res_tecla2;
	}
	if(carac==tecla_3){
	    res_=res_tecla3;
	}
	
	if ((traduz_cor(hexa_choice)==res_tecla1 && carac == tecla_1) || (traduz_cor(hexa_choice)==res_tecla2 && carac == tecla_2) || (traduz_cor(hexa_choice)==res_tecla3 && carac == tecla_3)) {
	    correcao[x]='certo';
	}
	else {
		correcao[x]='errado';
	}
	conta_tempo_2(0);
}

function traduz_cor(hexa){
	cor="";
    if(hexa=="#090"){
		cor="verde";
	}
	else if(hexa=="#FFC"){
		cor="branco";
	}
	else if(hexa=="#630"){
		cor="marrom";
	}
	else if(hexa=="#03C"){
		cor="azul";
	}
	else if(hexa=="#F00"){
		cor="vermelho";
	}
	else if(hexa=="#FF0"){
		cor="amarelo";
	}
	
	return cor;
}


-->
</script>