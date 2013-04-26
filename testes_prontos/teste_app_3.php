<?php
    echo "";
?>
<script language="javascript" type="text/javascript"> 
<!--

// Entradas  para configuração do aplicativo
var tempo_resposta, tempo_apresenta, quant_elem, forma, mod_res, quant;

function seta_config_app3(tr, tp, q_elem, form, vr, q_secoes){
	tempo_resposta=parseInt(tr)*1000;
	tempo_apresenta=parseInt(tp)*1000;
	quant_elem=parseInt(q_elem);
	forma=form;
	mod_res=vr;
	quant=parseInt(q_secoes);
}

// Resultado do usuário do aplicativo
tempos_resp = new Array();
correcao = new Array();

be=0;

x=-1;

cont="";
s = 0 ;

function conta_tempo_3(flag) {
	s=s+10;
	if (flag==1){
		cont=setTimeout("conta_tempo_3(1)",10);
		if (s==tempo_resposta){
		    clearTimeout(cont);
			tempos_resp[x]=s;
			
			if(res_==""){
				correcao[x]='nao respondeu';
				res_='nenhuma';
			}
			else {
				correcao[x]='errado';
			}
			alert(correcao[x]);
			
			c="funcoes_php_requeridas.php?f=14&estimulo_dado=Sequencia-"+val+"&resposta_obtida="+res_+"&tempo="+tempos_resp[x]+"&correcao="+correcao[x]+"&quant_=0&mod=parcial&app=3";
			loadXMLDoc(c);
		}
	}
	else {
		if (flag==0){
		    if (be==1){
				tempos_resp[x]=s;
				clearTimeout(cont);
				
     			alert(correcao[x]);
			
				c="funcoes_php_requeridas.php?f=14&estimulo_dado=Sequencia-"+val+"&resposta_obtida="+res_+"&tempo="+tempos_resp[x]+"&correcao="+correcao[x]+"&quant_=0&mod=parcial&app=3";
				loadXMLDoc(c);
			}
		}
	}
}

shuffle = function(v){
    for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
    return v;
};


function timer_3(){
    be=0;
	s=0;
	
	showDiv2('elemento', false);
	showDiv2('resposta_mouse_3',false);
	
	
	if (x==quant-1) {
	    showDiv2('ti_3',false);
		
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
		
		c="funcoes_php_requeridas.php?f=14&media_tempos="+media_tempo+"&media_acertos="+media_acertos+"&mod=final&flag=1&app=3";
		loadXMLDoc(c);
		
		
	}
	else {
		if(x==-1){
			inicializacao();
			c="funcoes_php_requeridas.php?f=15";
			loadXMLDoc(c);
		}
		
		x++;
		
		val="";
		res_="";
		vezes=0;
		document.getElementById('elemento').innerHTML="";
		
		document.getElementById('ti_3').innerHTML='<font face="Poor Richard" size="8pt" color="#20B2AA">Tentativa '+(x+1)+'...</font>';
		showDiv2('ti_3',true);
		
		s=0;
	    setTimeout("start_sequencia()", 2000);
		
	}
}

function inicializacao(){
	num=new Array();
	for (j=0;j<10;j++){
		num[j]=j;
	}
	
	letras=new Array( "B", "C", "D", "F", "G", "H", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "W", "X", "Y", "Z");
	
	palavras= new Array();
}

function start_sequencia(){
	
	showDiv2('elemento',true);
	
	document.getElementById('ti_3').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">Elementos da sequência: </font>';
	
	if (forma.indexOf('consoantes')!=(-1)){
	    shuffle(letras);
		indi=0
		setTimeout(function(){troca_elemento_letra(letras[indi]);},1000);
		
	}
	if (forma.indexOf('numeros')!=(-1)){
		shuffle(num);
		indi=0;
		setTimeout(function(){troca_elemento_numero(num[indi]);},1000);
		
	}
	if (forma.indexOf('palavras')!=(-1)){
		ax=forma.split('_');
		palavras=ax[1].split(',');
		
		shuffle(palavras);
		tam=0;
		if(palavras.length>=quant_elem){
		    tam=quant_elem;
		}
		else {
			tam=palavras.length;
		}
		indi=0;
		setTimeout(function(){troca_elemento_palavra(palavras[indi]);},1000);
		
	}
}

function troca_elemento_letra(el){
	if(indi!=quant_elem-1){
		val+=letras[indi]+'_';
		document.getElementById('elemento').innerHTML=el;
		indi++;
		setTimeout(function(){troca_elemento_letra(letras[indi]);},tempo_apresenta);
		
	}
	else{
		val+=letras[indi];
		document.getElementById('elemento').innerHTML=el;
		setTimeout("prepara_botoes_resposta()",tempo_apresenta);
	}
}
function troca_elemento_numero(el){
	if(indi!=quant_elem-1){
		val+=num[indi]+'_';
		document.getElementById('elemento').innerHTML=el;
		indi++;
		setTimeout(function(){troca_elemento_numero(num[indi]);},tempo_apresenta);
	}
	else{
		val+=num[indi];
		document.getElementById('elemento').innerHTML=el;
		setTimeout("prepara_botoes_resposta()",tempo_apresenta);
	}
}
function troca_elemento_palavra(el){
	if(indi!=tam-1){
		val+=palavras[indi]+'_';
		document.getElementById('elemento').innerHTML=el;
		indi++;
		setTimeout(function(){troca_elemento_palavra(palavras[indi]);},tempo_apresenta);
	}
	else{
		val+=palavras[indi];
		document.getElementById('elemento').innerHTML=el;
		setTimeout("prepara_botoes_resposta()",tempo_apresenta);
	}
}

function prepara_botoes_resposta(){
	showDiv2('elemento',false);
	showDiv2('resposta_mouse_3', true);
	
	document.getElementById('ti_3').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">Digite os elementos da sequência anterior em ordem com os botões abaixo: </font>';
	
	aux_=val.split("_");
	tam=9-aux_.length;
	
	if(tam==0){
		shuffle(aux_);
		for (j=0;j<9;j++){
			ind_="bot_"+(j+1);
			document.getElementById(ind_).value=aux_[j];
		}
	}
	else {
		shuffle(aux_);
		for (j=0;j<aux_.length;j++){
			ind_="bot_"+(j+1);
			document.getElementById(ind_).value=aux_[j];
		}
		
		for (j=aux_.length;j<9;j++){
			if (forma.indexOf('consoantes')!=(-1)){
				shuffle(letras);
				aux_2=aux_;
				dif=libera_diferente(letras[0]);
				while(!dif){
					shuffle(letras);
					dif=libera_diferente(letras[0]);
				}
				
				ind_="bot_"+(j+1);
				document.getElementById(ind_).value=letras[0];
			}
			if (forma.indexOf('numeros')!=(-1)){
				shuffle(num);
				aux_2=aux_;
				dif=libera_diferente(num[0]);
				while(!dif){
					shuffle(num);
					dif=libera_diferente(num);
				}
				
				ind_="bot_"+(j+1);
				document.getElementById(ind_).value=num[0];
			}
			if (forma.indexOf('palavras')!=(-1)){
				shuffle(palavras);
				aux_2=aux_;
				dif=libera_diferente(palavras[0]);
				while(!dif){
					shuffle(palavras);
					dif=libera_diferente(palavras[0]);
				}
				
				ind_="bot_"+(j+1);
				document.getElementById(ind_).value=palavras[0];
			}
			
		}
	}
	
	conta_tempo_3(1);
}

function libera_diferente(fr){
	cont=0;
	for(k=0;k<aux_2.length;k++){
		if(fr==aux_2[k]){
			cont++;
		}
	}
	if(cont==0){
		aux_2.push(fr);
		return true;
	}
	else if(cont>0){
		return  false;
	}
	
}

function verifica_mouse_3(hug){
	be=1;
		
	vezes+=1;

	if(vezes!=quant_elem){
		res_+=document.getElementById(hug).value+'_';
	}
	else{
		res_+=document.getElementById(hug).value;
		
		if (val==res_){
			correcao[x]='certo';
		}
		else { 
			correcao[x]='errado';
		}
		conta_tempo_3(0);
	}
	//alert(va+'-'+val);
}

function verifica_teclado_3(e){
	be=1;
    var carac = String.fromCharCode(e.which);
	
	if (forma.indexOf('palavras')!=(-1)){
	
	}
	else if (forma.indexOf('consoantes')!=(-1) || forma.indexOf('numeros')!=(-1)){
		vezes+=1;

		if(vezes!=quant_elem){
			res_+=carac+'_';
		}
		else{
			res_+=carac;
			
			if (val==res_){
				correcao[x]='certo';
			}
			else { 
				correcao[x]='errado';
			}
			conta_tempo_3(0);
		}
	}
	/*
	if(carac==tecla_1){
	    res_=res_tecla1; 
	}
	if(carac==tecla_2){
	    res_=res_tecla2;
	}
	if(carac==tecla_3){
	    res_=res_tecla3;
	}
	else {
		res_="nao_respondeu";
	}
	
	if ((traduz_cor(hexa_choice)==res_tecla1 && carac == tecla_1) || (traduz_cor(hexa_choice)==res_tecla2 && carac == tecla_2) || (traduz_cor(hexa_choice)==res_tecla3 && carac == tecla_3)) {
	    correcao[x]='certo';
	}
	else {
		correcao[x]='errado';
	}
	conta_tempo_2(0);*/
}


-->
</script>