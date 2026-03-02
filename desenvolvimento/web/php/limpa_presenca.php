<?php

    if ( session_status() === PHP_SESSION_NONE ) {
      session_start();
    }

    if ( ! isset($_SESSION['matricula']) or ! isset($_SESSION['nome']) ) {
      session_destroy();

    ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Você não está logado como professor. Volte ao login.</title>
        <link rel="stylesheet" href="/css/estilo.css">
    </head>
    <body>
        <h1>Você não está logado como professor. Volte ao login.</h1>
        <h2><a href="login_professor.php">&nbsp;&nbsp;Login do professor&nbsp;&nbsp;</a></h2>
    </body>
</html>

<?php

      exit();

    } else {

      require_once('incs/configs/config.php');

      $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . BANCO_DE_DADOS, USUARIO_DB, SENHA_DB);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Tenta limpar todos os registros de presença.
      try {

          $sql2 = "DELETE FROM presencas";
          $stmt2 = $pdo->prepare($sql2);
          $dados2 = [];
          $stmt2->execute($dados2);
      
          $qtdeOK = $stmt2->rowCount();
          
        // Algum erro na manipulação do BD.
      } catch(PDOException $f) {
          // Destroi a variável $pdo instanciada anteriormente no script.
          unset($pdo);
          echo 'Error: ' . $f->getMessage() . '<br>';
          exit();
      }

      // Os registros de presença foram removidos com sucesso.
      if ( $qtdeOK > 0 ) {

        // Destroi a variável $pdo instanciada anteriormente no script.
        unset($pdo);
        $resposta="Os registros de presença foram removidos!";

      // Nenhum registro de presença foi removido.
      } else {
      
        // Destroi a variável $pdo instanciada anteriormente no script.
        unset($pdo);
        $resposta="Nenhum registro de presença foi removido!";

      }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $resposta; ?></title>
        <link rel="stylesheet" href="/css/estilo.css">
    </head>
    <body>
        <h1><?php echo $resposta; ?></h1>
        <h4><a href="menu_professor.php">Volte ao menu do professor.</a></h4>
    </body>
</html>
