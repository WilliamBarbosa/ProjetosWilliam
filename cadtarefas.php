<?php 

  require_once('conexaobanco.php');
  
  $ArqBanco = abreBanco();
  
  
  session_start();
  
  $idusuario = $_SESSION['idusuario'];
  

  $nometarefa = $_POST['nome'];
  $descricao = $_POST['descricao'];
  $idtarefa = $_POST['idtarefa'];
  
  
	if(isset($_FILES['file']))
	{    
         
		 
		 $arquivo = $_FILES["file"]["tmp_name"]; 
		 $tamanho = $_FILES["file"]["size"];
		 $tipo    = $_FILES["file"]["type"];
		 $nome  = $_FILES["file"]["name"];
		
		 if ( $arquivo != "none" )
		 {
			 //$fp = fopen($arquivo, "r");
			 //$conteudo = fread($fp, $tamanho);
			 //$conteudo = addslashes($conteudo);
			 $conteudo = addslashes(file_get_contents($arquivo));
			 //$conteudo = mysqli_real_escape_string($ArqBanco, $conteudo);
			 
			 //fclose($fp); 

		 }
	}
  
  if($idtarefa == 0){
	  $sql = "SELECT codtarefa FROM tarefas WHERE nometarefa = '$nometarefa' AND idusuario = '$idusuario'";
	  
	  $tb = mysqli_query($ArqBanco,$sql);
	  
	  
	  if(mysqli_num_rows($tb) <= 0){
		  
		  $sql = "INSERT INTO tarefas(nometarefa, descricao, arquivo, tipo, nomearquivo, tamanho, idusuario) VALUES('$nometarefa', '$descricao', '$conteudo', '$tipo', '$nome', '$tamanho', '$idusuario')";
		  
		 $res = mysqli_query($ArqBanco,$sql);
		  
		  if($res === FALSE) { 
			   die(mysqli_error($ArqBanco));
			}
		  
		  if(mysqli_affected_rows($ArqBanco) > 0)
			 echo "<script>alert('Cadastrado!')</script>";
		  else
			 echo "<script>alert('Erro ao Cadastrar!')</script>";
		 
		  header("Refresh:0; url= http://localhost/loginVoxus/tarefas.html", true, 303);
	  } else {
		  echo "<script>alert('Ja existe uma tarefa com este nome!')</script>";
	  }
  } else {
	  $sql = "UPDATE tarefas SET nometarefa =  '$nometarefa', descricao = '$descricao', arquivo = '$conteudo', tipo = '$tipo', nomearquivo = '$nome', tamanho = '$tamanho' WHERE idusuario = $idusuario AND codtarefa = $idtarefa";
			  
			 $res = mysqli_query($ArqBanco,$sql);
			 
			  if($res === FALSE) { 
			   die(mysqli_error($ArqBanco));
			}
			
			  if($res){
				  echo "<script>alert('Alterado!')</script>";
				  header("Refresh:0; url= http://localhost/loginVoxus/tarefas.html", true, 303);
				  
			  }
			  else{
				  echo "<script>alert('Erro ao Alterar!')</script>";
	              
			 }
  }		   
  mysqli_close($ArqBanco);
  

?>