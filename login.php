<!DOCTYPE html>
<html>
<head>
	<title>Formulario LOGIN</title>
</head>
<body>
<script>
var todoslogins = [];
var todassenhas = []; 

	function selecionatudoLogin(){
		
		var selecionados = document.getElementById('logins');
		
		for(i=0; i<=selecionados.length-1; i++){
		
			selecionados.options[i].selected = true;
		
		}
          var i, j, cur;
	    for (i = 0, j = selecionados.options.length; i < j; i++) {
		cur = selecionados.options[i];
		if (cur.selected) {
		    todoslogins.push(encodeURIComponent(cur.value));
		}
	    }

	
	
	}
	
	function selecionatudoSenha(){
		
		var selecionados = document.getElementById('senhas');
		
		for(i=0; i<=selecionados.length-1; i++){
		
			selecionados.options[i].selected = true;
		
		}
	  var i, j, cur;
	    for (i = 0, j = selecionados.options.length; i < j; i++) {
		cur = selecionados.options[i];
		if (cur.selected) {
		    todassenhas.push(encodeURIComponent(cur.value));
		}
	    }
	}

	function gravaLoginSenha(login, senha){
		
			var x = document.getElementById("logins");
			var option = document.createElement("option");
			option.value = login;
			x.add(option); 

			var y = document.getElementById("senhas");
			var option = document.createElement("option");
			option.value = senha;
			y.add(option); 
	}
	
	
function load() {
  var xhttp;
  if (document.getElementById("login").length == 0 || document.getElementById("senha").length == 0) { 
    return;
  }
  
  var logins = new Array();
  lb = document.getElementById("logins");
    for(var i=0; i < lb.length; i++) {
        if(lb[i].selected) {
            // Note the [] after the name
            logins.push(lb[i].value);
        }
  }

  var senhas = new Array();
  lb = document.getElementById("senhas");
    for(var i=0; i < lb.length; i++) {
        if(lb[i].selected) {
            // Note the [] after the name
            senhas.push(lb[i].value);
        }
  }



  xhttp = new XMLHttpRequest(); 
  //var params = "login=2&senha=2&situacao=0&novasenha=2";
  var params = "loginCad="+Encripta(document.getElementById("loginCad").value)+"&senhaCad="+
  Encripta(document.getElementById("senhaCad").value)+"&login="+Encripta(document.getElementById("login").value)+"&senha="+
  Encripta(document.getElementById("senha").value)+"&novasenha="+
  Encripta(document.getElementById("novasenha").value)+"&situacao="+document.getElementById("situacao").value+ "&logins="+JSON.stringify(logins) + "&senhas="+JSON.stringify(senhas);
  
  xhttp.open("POST", "logins.php", false);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send(params);

  var json = JSON.parse(xhttp.responseText);
  


  if(xhttp.responseText == 0)
	alert("A senha não é igual a sua confirmação");
  else if(xhttp.responseText == 1)
	alert("Bem vindo ao Sistema");
  else if(xhttp.responseText == 2)
	alert("Senha ou usuário incorreto!");
  else if(json[0].situacao == 0){
	gravaLoginSenha(json[0].login, json[0].senha);
        alert(json[0].mensagem);
	}
  
}
	
	



</script>
<style>
form {
    width: 80%;
    margin: 0 auto;
}

label, input {
    display: inline-block;
}

label {
    width: 30%;
    text-align: right;
}

label + input {
    width: 30%;
    margin: 0 30% 0 4%;
}

input + input {
    float: right;
}
input[type='button'] {
    background-color: lightgray;
}
input[type='reset'] {
    background-color: red;
}
</style>

<div style="width:100%; height:251px;  display:flex;">

<div style="width:49%; height:251px; display:inline-block; background:lightgreen; margin-right:1%;" align="middle">

<form>
<input type="value" name="situacao"  id="situacao"style="display:none" /> <br>

<span>CADASTRO</span><br><br>
<label>Login :</label> <input type="text" name="loginCad" id="loginCad"> <br><br>
<label>Senha :</label> <input type="password" name="senhaCad" id="senhaCad"> <br><br>
<label>Confirmar Senha :</label> <input type="password" name="novasenha" id="novasenha"> <br><br>


 <input type="button" value="Cadastrar" onclick="document.getElementById('situacao').value = 0;  load();"><br><br>
 <input type="reset" value="limpar"/><br><br>
</form>
</div>

<div style="width:49%; height:251px; display:inline-block; background:lightblue; " align="middle">

<form><br>
<span>LOGAR</span><br><br>
<label>Login : </label><input type="text" name="login" id="login"> <br><br>
<label>Senha : </label><input type="password" name="senha" id="senha"> <br><br>

    <select  style="display:none" id="logins" multiple="multiple">
    </select>

    <select style="display:none" id="senhas" multiple="multiple">
    </select>



 <input type="button" value="Entrar" onclick="document.getElementById('situacao').value = 1;  selecionatudoLogin();selecionatudoSenha();load();"><br><br>
 <input type="reset" value="limpar"/><br>
</form></div>
</div>

<div style="width:100%; height:auto;  display:flex;  background:lightyellow;">

<form><br>
<span>TAREFAS</span>
<label>Nome : </label><input type="text" name="nome" id="nome"> 
<label>Descrição : </label><input type="text" name="descricao" id="descricao"> 
<label>Descrição : </label><input type="text" name="descricao" id="descricao">
<label>
<input id="file" name="file" type="file" />
</label>

    <select  style="display:none" id="logins" multiple="multiple">
    </select>

    <select style="display:none" id="senhas" multiple="multiple">
    </select>



 <input type="button" value="Entrar" onclick="document.getElementById('situacao').value = 1;  selecionatudoLogin();selecionatudoSenha();load();"><br><br>
 <input type="reset" value="limpar"/><br>
</form>

<div>

</body>

<script language="javascript">
function Encripta(dados){
	var mensx="";
	var l;
	var i;
	var j=0;
	var ch;
	ch = "assbdFbdpdPdpfPdAAdpeoseslsQQEcDDldiVVkadiedkdkLLnm";	
	for (i=0;i<dados.length; i++){
		j++;
		l=(Asc(dados.substr(i,1))+(Asc(ch.substr(j,1))));
		if (j==50){
			j=1;
		}
		if (l>255){
			l-=256;
		}
		mensx+=(Chr(l));
	}
	return mensx;
}

function Asc(String){
	return String.charCodeAt(0);
}
 
function Chr(AsciiNum){
	return String.fromCharCode(AsciiNum)
}
</script>
</html>







