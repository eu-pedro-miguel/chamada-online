<?php

  // Insere variáveis padrão.
  require_once('incs/configs/config.php');

  // Verificando se as variáveis matricula e senha foram enviadas para este script com valores atribuídos.
  if ( isset($_POST['matricula']) and isset($_POST['senha']) and $_POST['matricula'] != "" and $_POST['senha'] != "" ) {

    $matricula =$_POST['matricula'];
    $senha =$_POST['senha'];

  // Se nenhum valor para matrícula e senha foram enviados, nenhuma presença poderá ser registrada. 
  } else {

    if ( ! isset($_POST['web']) or $_POST['web'] != 1 ) {
      echo "0";
      exit();
    } else {

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chamada Online</title>
        <link rel="stylesheet" href="/css/estilo.css">
    </head>
    <body>
        <h1>Chamada Online</h1>
        <h2>Nenhum parâmetro foi passado a este script!</h2>
        <h2><a href="index.php">&nbsp;&nbsp;Volte ao menu principal&nbsp;&nbsp;</a></h2>
    </body>
</html>

<?php

      exit();

    }

  }

  // Instanciação da variável de banco de dados pela classe PDO.
  $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . BANCO_DE_DADOS, USUARIO_DB, SENHA_DB);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Tentando manipular o BD.
  try {
  
    // Consulta se a matricula e a senha enviadas estão no BD.
    $sql1 = 'SELECT count(*) as OK FROM alunos WHERE matricula = :matricula and senha = :senha';
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

    if ( ! isset($_POST['web']) or $_POST['web'] != 1 ) {
      echo "0";
      exit();
    } else {
      $resposta="Error: " . $e->getMessage();
    }

  }
 
  // Se matrícula e senha corresponderem, busca registrar a presença.
  if ( $qtdeOK == 1 ) {

    $data_aula = date('Y-m-d');

    // Tenta registrar a presença.
    try {

      $sql2 = "INSERT IGNORE INTO presencas (data_aula, matricula, presenca) VALUES (:data_aula, :matricula, '1')";
      $stmt2 = $pdo->prepare($sql2);
      $dados2 = [
        ':data_aula' => $data_aula,
        ':matricula' => $matricula
      ];
      $stmt2->execute($dados2);
  
      $qtdeOK = $stmt2->rowCount();
      
    // Algum erro na manipulação do BD.
    } catch(PDOException $f) {

      // Destroi a variável $pdo instanciada anteriormente no script.
      unset($pdo);

      if ( ! isset($_POST['web']) or $_POST['web'] != 1 ) {
        echo "0";
        exit();
      } else {
        $resposta="Error: " . $f->getMessage();
      }

    }

    // O aluno registrou sua presença com sucesso.
    if ( $qtdeOK == 1 ) {

      // Destroi a variável $pdo instanciada anteriormente no script.
      unset($pdo);

      if ( ! isset($_POST['web']) or $_POST['web'] != 1 ) {
        echo "1";
        exit();
      } else {
        $resposta="Sua presença foi registrada!";
      }

    // Se o aluno já registrou previamente a presença e está tentando registrá-la novamente.
    } else {
  
      // Destroi a variável $pdo instanciada anteriormente no script.
      unset($pdo);

      if ( ! isset($_POST['web']) or $_POST['web'] != 1 ) {
        echo "3";
        exit();
      } else {
        $resposta="Sua presença já tinha sido registrada anteriormente!";
      }

    }

  // Matrícula e/ou senha não correspondem a um usuário do BD.
  } else {

    // Destroi a variável $pdo instanciada anteriormente no script.
    unset($pdo);

    if ( ! isset($_POST['web']) or $_POST['web'] != 1 ) {
      echo "2";
      exit();
    } else {
      $resposta="Matrícula e/ou senha não correspondem.";
    }

  }

  if ( isset($_POST['web']) and $_POST['web'] == 1 ) {

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chamada Online</title>
        <link rel="stylesheet" href="/css/estilo.css">
    </head>
    <body>
        <h1>Chamada Online</h1>
        <h2><?php echo $resposta; ?></h2>
        <h2><a href="index.php">&nbsp;&nbsp;Volte ao menu principal&nbsp;&nbsp;</a></h2>
        <h3>Clique em um dos links acima</h3>
    </body>
</html>

<?php

  }

?>