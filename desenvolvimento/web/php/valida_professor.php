<?php

  

  // Insere variáveis padrão.
  require_once('incs/configs/config.php');

  // Verificando se as variáveis matricula e senha foram enviadas para este script com valores atribuídos.
  if ( isset($_POST['matricula']) and isset($_POST['senha']) and $_POST['matricula'] != "" and $_POST['senha'] != "" ) {

    $matricula =$_POST['matricula'];
    $senha =$_POST['senha'];

  // Se nenhum valor para matrícula e senha foram enviados, nenhuma presença poderá ser registrada. 
  } else {

    echo "Nenhum parâmetro foi passado a este script!";
    exit();

  }

  if ( session_status() === PHP_SESSION_NONE ) {
    session_start();
  }

  // Instanciação da variável de banco de dados pela classe PDO.
  $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . BANCO_DE_DADOS, USUARIO_DB, SENHA_DB);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Tentando manipular o BD.
  try {
  
    // Consulta se a matricula e a senha enviadas estão no BD.
    $sql1 = 'SELECT count(*) as OK FROM professores WHERE matricula = :matricula and senha = :senha';
    $stmt1 = $pdo->prepare($sql1);
    $dados1 = [
      ':matricula' => $matricula,
      ':senha' => md5($senha)
    ];
    $stmt1->execute($dados1);

    foreach ($stmt1 as $row1) {
      $qtdeOK = $row1['OK'];
    }

  // Algum erro na manipulação do BD.
  } catch(PDOException $e) {
    // Destroi a variável $pdo instanciada anteriormente no script.
    unset($pdo);
    echo 'Error: ' . $e->getMessage();
    exit();
  }
 
  // Se matrícula e senha corresponderem, estabelece sessão.
  if ( $qtdeOK == 1 ) {

    // Tentando manipular o BD.
    try {
  
      // Consulta se a matricula e a senha enviadas estão no BD.
      $sql2 = 'SELECT nome_professor as nome FROM professores WHERE matricula = :matricula';
      $stmt2 = $pdo->prepare($sql2);
      $dados2 = [
        ':matricula' => $matricula
      ];
      $stmt2->execute($dados2);

      foreach ($stmt2 as $row2) {
        $nome = $row2['nome'];
      }

      $_SESSION['matricula'] = $matricula;
      $_SESSION['nome'] = $nome;

      header("Location: menu_professor.php");

    // Algum erro na manipulação do BD.
    } catch(PDOException $f) {
      // Destroi a variável $pdo instanciada anteriormente no script.
      unset($pdo);
      echo 'Error: ' . $f->getMessage();
      exit();
    }

  // Matrícula e/ou senha não correspondem a um professor do BD.
  } else {

    // Destroi a variável $pdo instanciada anteriormente no script.
    unset($pdo);
    echo "Matrícula e/ou senha não correspondem.<br><br>";
    echo "<a href='login_professor.php'>Volte ao login</a>";
    exit();

  }

?>