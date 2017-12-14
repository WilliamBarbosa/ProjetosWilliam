<?php 

  require_once('conexaobanco.php');
  
  
  switch($_POST['funcao']){
	  case 'cadastrar':
	       cadastrar($_POST['loginCad'], $_POST['senhaCad'], $_POST['novasenha']);
		   break;
      
	  case 'logar':
	       logar($_POST['login'], $_POST['senha']);
		   break;
		   
	  case 'sair':
	       sair();
		   break;
		   
	  case 'cadtarefas':
	       cadtarefas($_POST['nome'], $_POST['descricao'], $_FILES["file"]["tmp_name"], $_POST['idtarefa']);
		   break;
	 
	  case 'listaTarefas':
	       listaTarefas();
		   break;
		   
	  case 'editar':
	       editar($_POST['codtarefa']);
		   break;
		   
	  case 'excluir':
	       excluir($_POST['codtarefa']);
		   break;
  }
  
  function cadastrar($loginCad, $senhaCad, $novasenha){
	  
	  $ArqBanco = abreBanco();
	  
	  if($senhaCad != $novasenha){
		  $out[] = ["st" => 1, "mensagem" => "As senhas estão diferentes!"];
		  
	  }
	  else{
		  
		  $sql = "SELECT idusuario FROM usuarios WHERE email = '$loginCad'";
		  
		  $tb = mysqli_query($ArqBanco,$sql);
		  
		  if(mysqli_num_rows($tb) > 0){
			  $out[] = ["mensagem" => "Ja existe este Email Cadastrado!", "st" => 1];
		  }
		  else{
			  $sql = "INSERT INTO usuarios(email, senha) VALUES('$loginCad', '$senhaCad')";
			  
			  if(mysqli_query($ArqBanco,$sql)){
				  $out[] = ["mensagem" => "Cadastrado com Sucesso!", "st" => 0];
				  
				  
			  }
			  else{
				  $out[] = ["mensagem" => "Erro ao Cadastrar!", "st" => 1];
				  
			  }
			  
		  }
		    
	  }
	  
	  echo json_encode($out);
	  mysqli_close($ArqBanco);
  }

  function logar($login, $senha){
	  
	    $ArqBanco = abreBanco();
		
		mysqli_set_charset($ArqBanco, "utf8");
	  
		$senhaAtual = str_replace("'", "''",$senha);
		
		$sql = "SELECT idusuario FROM usuarios WHERE email = '$login' AND senha = '$senhaAtual'";
		
		$tb = mysqli_query($ArqBanco,$sql);

	    $row = mysqli_num_rows($tb);
		
	    if($row > 0){
			session_start();
			
			$linha = mysqli_fetch_assoc($tb);
			
			$_SESSION['idusuario']= $linha['idusuario'];
			$_SESSION['Email']=$login;
			$_SESSION['senha']=$senhaAtual;
			
			$out[] = ["mensagem" => "Você foi autenticado com sucesso!", "st" => 0];
		}else{
			$out[] = ["mensagem" => "EMAIL OU SENHA INVÁLIDOS!", "st" => 1];
		}
		
		echo json_encode($out);
		mysqli_close($ArqBanco);
  }
  
  function sair(){
      session_destroy();
	  
	 
	  echo 0;
	  
	  
  }
  
  function cadtarefas($nome, $descricao, $file_tmp, $idtarefa){
	  
	  $ArqBanco = abreBanco();
	  
	  $conteudo = file_get_contents($file_tmp);
	  
	  $conteudo = mysqli_real_escape_string($ArqBanco, $conteudo);
	  
	  $idusuario = $_SESSION['idusuario'];
	  
	  if($idtarefa == 0){
		  
		  $sql = "SELECT codtarefa FROM usuarios WHERE nometarefa = '$nome' AND idusuario = ".$_SESSION['idusuario'];
		  
		  $tb = mysqli_query($ArqBanco,$sql);
		  
		  if(mysqli_num_rows($tb) > 0){
			  $out[] = ["mensagem" => "Ja existe uma tarefa com este nome!", "st" => 0];
		  }
		  else{
			  $sql = "INSERT INTO tarefas(nometarefa, descricao, arquivo, idusuario) VALUES('$nome', '$descricao', '$conteudo', '$idusuario')";
			  
			  if(mysqli_query($ArqBanco,$sql)){
				  $out[] = ["mensagem" => "Cadastrado com Sucesso!", "st" => 1];
				  
				  
			  }
			  else{
				  $out[] = ["mensagem" => "Erro ao Cadastrar!", "st" => 0];
				  
			  }
	      }  
      } else {
	   
	   $sql = "UPDATE tarefas SET nometarefa =  '$nome', descricao = '$descricao', arquivo = '$conteudo', idusuario) VALUES('$nome', '$descricao', '$conteudo', '$idusuario')";
			  
			  if(mysqli_query($ArqBanco,$sql)){
				  $out[] = ["mensagem" => "Alterado com Sucesso!", "st" => 1];
				  
				  
			  }
			  else{
				  $out[] = ["mensagem" => "Erro ao Alterar!", "st" => 0];
	   
			 }
	  }
		    
	  
	  
	  echo json_encode($out);
	  mysqli_close($ArqBanco);
  }

  
  function listaTarefas(){
	  
	  $ArqBanco = abreBanco();
	  
	  
	  
      session_start();
	  
	  $idusuario = $_SESSION['idusuario'];
	  
	  $sql = "SELECT codtarefa, nometarefa, descricao FROM tarefas WHERE idusuario = '$idusuario' ORDER BY codtarefa DESC";
	  $tb = mysqli_query($ArqBanco,$sql);

	  while($fila = mysqli_fetch_assoc($tb)){
		  $out[] = ["codtarefa" => $fila['codtarefa'], "nome" => $fila['nometarefa'], "descricao" => $fila['descricao']];
		  
	  }
	  
	 
	  echo json_encode($out);
	  
	  mysqli_close($ArqBanco);
	  
	  
  }
  
  function editar($codtarefa){
	  
	  $ArqBanco = abreBanco();
	  
	  
	  
      session_start();
	  
	  $idusuario = $_SESSION['idusuario'];
	  
	  $sql = "SELECT codtarefa, nometarefa, descricao FROM tarefas WHERE idusuario = '$idusuario' AND codtarefa = $codtarefa";
	  $tb = mysqli_query($ArqBanco,$sql);

	  while($fila = mysqli_fetch_assoc($tb)){
		  $out[] = ["codtarefa" => $fila['codtarefa'], "nome" => $fila['nometarefa'], "descricao" => $fila['descricao']];
		  
	  }
	  
	 
	  echo json_encode($out);
	  
	  mysqli_close($ArqBanco);
	  
	  
  }
  
  function excluir($codtarefa){
	  
	  $ArqBanco = abreBanco();
	  
	  
	  
      session_start();
	  
	  $idusuario = $_SESSION['idusuario'];
	  
	  $sql = "DELETE FROM tarefas WHERE idusuario = '$idusuario' AND codtarefa = $codtarefa";
	  $tb = mysqli_query($ArqBanco,$sql);

	  
	  $out[] = ["mensagem" => "Deletado com sucesso", "st" => 0];
		  
	  
	  
	 
	  echo json_encode($out);
	  
	  mysqli_close($ArqBanco);
	  
	  
  }
?>

