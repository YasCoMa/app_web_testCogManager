<?php
    echo "";
?>
<script language="javascript" type="text/javascript"> 
<!-- 
// Entradas  para configuração do aplicativo
var tempo_passo1, tempo_passo2, tipo_passo1, tempo_resposta, via_resp;

function seta_config_app1 ( tp1, tp2, tip1, tr, vr){
	
    tempo_passo1=parseInt(tp1)*1000;
	tempo_passo2=parseInt(tp2)*1000;
	tipo_passo1=tip1;
	tempo_resposta=parseInt(tr)*1000;
	via_resp=vr;
}

// Resultado do usuário do aplicativo
tempos_resp = new Array();
correcao = new Array();

// Inicialização de atributos internos

quant_elem=new Array(1,2,3,5,7,8,9);
nivel=new Array(1,2,3,4,5,6,7);
num_secoes=new Array(2,3,5,5,5,10,10);
maximo_acerto=new Array(2,3,5,4,3,8,9);
total_secoes=0;

be=0;

x=-1;

cont="";
s = 0 ;

function conta_tempo(flag) {
	s=s+10;
	if (flag==1){
		cont=setTimeout("conta_tempo(1)",10);
		if (s==tempo_resposta){
		    clearTimeout(cont);
			tempos_resp[x]=s;
			correcao[x]='nao respondeu';
			res_='nenhuma';
			alert(correcao[x]);
			
			c="funcoes_php_requeridas.php?f=14&estimulo_dado=Sequencia-"+val+";Sonda-"+va+"&resposta_obtida="+res_+"&tempo="+tempos_resp[x]+"&correcao="+correcao[x]+"&quant_="+quant_elem[pass]+"&mod=parcial&app=1";
			loadXMLDoc(c);
			//timer();
		}
	}
	else {
		if (flag==0){
		    if (be==1){
				tempos_resp[x]=s;
				clearTimeout(cont);
				
     			alert(correcao[x]);
				
				if(res_==""){
					res_="nao respondeu";
				}
				
				c="funcoes_php_requeridas.php?f=14&estimulo_dado=Sequencia-"+val+";Sonda-"+va+"&resposta_obtida="+res_+"&tempo="+tempos_resp[x]+"&correcao="+correcao[x]+"&quant_="+quant_elem[pass]+"&mod=parcial&app=1";
				loadXMLDoc(c);
				//timer();
			}
		}
	}
}

num=new Array();
for (j=0;j<10;j++){
    num[j]=j;
}
letras=new Array( "B", "C", "D", "F", "G", "H", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "W", "X", "Y", "Z");
/*
os_dois=new Array();
for (j=0;j<(num.length+letras.length);j++){
    if (j<num.length){
	    os_dois[j]=num[j];
	}
	else {
	    os_dois[j]=letras[j-10];
	}
}
 */
shuffle = function(v){
    for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
    return v;
};


 pass=0;
 
function timer(){
    be=0;
	s=0;
	showDiv2('resposta_mouse',false);
	
	f=parseInt(document.getElementById('q_sec').value);
	
	if (x==num_secoes[pass]-1) {
	    showDiv2('ti',false);
		
		alert("Você terminou as chances deste nível!");
	    
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
		
		if (pass==6){
			alert("Parabéns chegou ao último nível!");
			c="funcoes_php_requeridas.php?f=14&media_tempos=_"+media_tempo+"&media_acertos=_"+media_acertos+"&mod=final&flag=1&app=2";
			loadXMLDoc(c);
		}
		else {
		    if(soma_acertos>=maximo_acerto[pass]){
				if(pass==0){
					c="funcoes_php_requeridas.php?f=14&media_tempos="+media_tempo+"&media_acertos="+media_acertos+"&mod=final&flag=0&app=2";
				}
				else {
					c="funcoes_php_requeridas.php?f=14&media_tempos=_"+media_tempo+"&media_acertos=_"+media_acertos+"&mod=final&flag=0&app=2";
				}
				loadXMLDoc(c);
				pass++;
				timer();
			}
			else {
				if(pass==0){
					c="funcoes_php_requeridas.php?f=14&media_tempos="+media_tempo+"&media_acertos="+media_acertos+"&mod=final&flag=1&app=2";
				}
				else {
					c="funcoes_php_requeridas.php?f=14&media_tempos=_"+media_tempo+"&media_acertos=_"+media_acertos+"&mod=final&flag=1&app=2";
				}
				loadXMLDoc(c);
			    alert('Não obteve o rendimento esperado para passar para o próximo nível!');
			}
			
			
		}
		
			
		
	}
	else {
		if(x==-1 && pass==0){
			c="funcoes_php_requeridas.php?f=15";
			loadXMLDoc(c);
		}
		
		x++;
		
		document.getElementById('info_nivel').innerHTML='Você está no nível '+nivel[pass]+' de 7.';
		document.getElementById('ti').innerHTML='<font face="Poor Richard" size="8pt" color="#20B2AA">Tentativa '+(x+1)+'...</font>';
		showDiv2('ti',true);
		
		res_="";
		carac="";
		s=0;
	    setTimeout('muda_texto()',3000);
		
	}
}

val="";
palavras= new Array();
function muda_texto(){ 
	be=0;
    val="";
	if (tipo_passo1.indexOf('numeros')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">'+(x+1)+'ª série de números:</font>';
	if (tipo_passo1.indexOf('consoantes')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">'+(x+1)+'ª série de letras:</font>';
	if (tipo_passo1.indexOf('palavras')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">'+(x+1)+'ª série de palavras:</font>';
	
    showDiv2('serie_numerica',true);
	
	
	if (tipo_passo1.indexOf('consoantes')!=(-1)){
	    shuffle(letras);
		for (j=0;j<quant_elem[pass];j++){
			val+=letras[j]+"  ";
		}
	}
	if (tipo_passo1.indexOf('numeros')!=(-1)){
		shuffle(num);
		for (j=0;j<quant_elem[pass];j++){
			val+=num[j]+"  ";
		}
	}
	if (tipo_passo1.indexOf('palavras')!=(-1)){
		ax=tipo_passo1.split('_');
		palavras=ax[1].split(',');
		
		shuffle(palavras);
		tam=0;
		if(palavras.length>=quant_elem[pass]){
		    tam=quant_elem[pass];
		}
		else {
			tam=palavras.length;
		}
		for (j=0;j<tam;j++){
			val+=palavras[j]+"  ";
		}
	}
	
	document.getElementById('v').innerHTML=val;
	setTimeout('troca_num_sozinho()',tempo_passo1);
	//timer(y); 
	
}

va="";
tecla_s = "";
tecla_n = "";
function troca_num_sozinho(){
	be=0;
	if (tipo_passo1.indexOf('numeros')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">Número procurado:</font>';
	if (tipo_passo1.indexOf('consoantes')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">Letra procurada:</font>';
	if (tipo_passo1.indexOf('palavras')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">Palavra procurada:</font>';
    
	showDiv2('serie_numerica',false);
	showDiv2('num',true);
	
	if (tipo_passo1.indexOf('consoantes')!=(-1)){
	    shuffle(letras);
		va=letras[0]+"";
	}
	if (tipo_passo1.indexOf('numeros')!=(-1)){
		shuffle(num);
		va=num[0]+"";
	}
	if (tipo_passo1.indexOf('palavras')!=(-1)){
		shuffle(palavras);
		va=palavras[0]+"";
	}
	
	document.getElementById('v1').size=va.length;
	document.getElementById('v1').value=va;
	
	if (via_resp.indexOf('mouse')!=(-1)){
		// Escolheu dar a resposta com mouse
		setTimeout('resp_mouse()', tempo_passo2);
	}
	if (via_resp.indexOf('teclado')!=(-1)){
		teclas=via_resp.split('_');
		tecla_s=teclas[1];
		tecla_n=teclas[2];
		// Escolheu dar a resposta com teclado
		setTimeout('resp_teclado()', tempo_passo2);
	}
}

function resp_mouse (){
	be=1;
	if (tipo_passo1.indexOf('numeros')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">O número apresentado estava na lista?</font>';
	if (tipo_passo1.indexOf('consoantes')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">A letra apresentada estava na lista?</font>';
	if (tipo_passo1.indexOf('palavras')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">A palavra apresentada estava na lista?</font>';
	
	
    showDiv2('num',false);
	showDiv2('resposta_mouse',true);
	conta_tempo(1);
	
	// se for passar de seção automaticamente usa isso se não ativa com uma tecla
	//setTimeout('timer()',3000);
	
}

function resp_teclado (){
    be=1;
	if (tipo_passo1.indexOf('numeros')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">O número apresentado estava na lista? Digite '+tecla_s+' para Sim e '+tecla_n+' para Não!</font>';
	if (tipo_passo1.indexOf('consoantes')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">A letra apresentada estava na lista? Digite '+tecla_s+' para Sim e '+tecla_n+' para Não!</font>';
	if (tipo_passo1.indexOf('palavras')!=(-1))
		document.getElementById('ti').innerHTML='<font face="Cooper Black" size="4pt" color="#0000EE">A palavra apresentada estava na lista? Digite '+tecla_s+' para Sim e '+tecla_n+' para Não!</font>';
		
	showDiv2('num',false);
	
	document.captureEvents(Event.KEYPRESS);
	document.onkeypress = verifica_teclado;
	conta_tempo(1);
	
}

res_="";
function verifica_mouse(hug){
	if(hug==1){
	    res_="sim"; 
	}
	if(hug==2){
	    res_="nao";
	}
	
    if ((val.indexOf(va)>(-1) && hug==1) || (val.indexOf(va)==(-1) && hug==2)){
	    correcao[x]='certo';
	}
	else { 
	    correcao[x]='errado';
	}
	conta_tempo(0);
	//alert(va+'-'+val);
}

function verifica_teclado(e){
    var carac = String.fromCharCode(e.which);
	
	if(carac==tecla_s){
	    res_="sim"; 
	}
	if(carac==tecla_n){
	    res_="nao";
	}
	
	if ((val.indexOf(va)>(-1) && carac == tecla_s) || (val.indexOf(va)==(-1) && carac == tecla_n)) {
	    correcao[x]='certo';
	}
	else {
		correcao[x]='errado';
	}
	conta_tempo(0);
}

--> 
</script>

  

