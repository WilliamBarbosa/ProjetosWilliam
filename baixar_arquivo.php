 
 <?php 
 
 require_once('conexaobanco.php');
 
 $ArqBanco = abreBanco();
 
 
 $id = $_GET['id'];
 

 $qry = "SELECT arquivo, tipo, tamanho, nomearquivo FROM tarefas WHERE codtarefa=$id";
 $res = mysqli_query($ArqBanco, $qry);
 
 if($res === FALSE) { 
   die(mysqli_error($ArqBanco));
 }
 
 $linha = mysqli_fetch_assoc($res);
 
 $tipo = $linha['tipo'];
 $conteudo = $linha['arquivo'];
 $tamanho = $linha['tamanho'];
 $arquivo = $linha['nomearquivo'];
  
 
 header("Content-type: $tipo");
 header("Content-Disposition: attachment; filename=$arquivo");
 
 echo $conteudo;
 
 mysqli_close($ArqBanco);
 ?>