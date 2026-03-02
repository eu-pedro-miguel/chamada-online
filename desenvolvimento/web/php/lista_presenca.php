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

    } else {

      require_once('incs/configs/config.php');

      $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . BANCO_DE_DADOS, USUARIO_DB, SENHA_DB);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      try {

        $data_aula = date('Y-m-d');
    
        $sql = 'SELECT a.matricula, a.nome_aluno, p.data_aula, IF(p.presenca IS NULL, 0, p.presenca) AS presenca FROM alunos AS a LEFT JOIN presencas AS p ON a.matricula = p.matricula AND (p.data_aula IS NULL OR p.data_aula = :data_aula) ORDER BY
  a.nome_aluno';

        $stmt = $pdo->prepare($sql);

        $dados = [
          ':data_aula' => $data_aula
        ];

        $stmt->execute($dados);

        $i = 0;
        while ($linha = $stmt->fetch()) {
          $matricula[$i] = $linha['matricula'];
          $nome_aluno[$i] = $linha['nome_aluno'];
          $presenca[$i] = $linha['presenca'];
          $i++;
        }
      
      } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
      }
    
      unset($pdo);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Presença</title>
  <link rel="stylesheet" href="/css/estilo.css">
  <meta http-equiv="Refresh" content="10">
</head>
<body>
  <h1>Lista de Presença</h1>
  <h2>Data: <?php echo date('d/m/Y'); ?></h2>
  <table>
    <tr><th>Nr</th><th>MATRÍCULA</th><th>ALUNO(A)</th><th>PRESENÇA</th></tr>
    <?php
      $presenca_ok = 0;
      for ($b=0;$b<$i;$b++) {
        if ( $presenca[$b] == 0 ) { 
          $img = 'nok.png';
        } else {
          $img = 'ok.png';
          $presenca_ok++;
        }
        echo "\r\n\t<tr><td class='nr'>" . ($b+1) . "</td><td class='matricula'>". $matricula[$b] . "<td class='aluno'>" . $nome_aluno[$b] . "</td><td class='presenca'><img src='imagens/" . $img . "'></td></tr>";
        }
    ?>   
    </table>
    <h3>
    <?php 
        if ( $presenca_ok == 1 ) {
          echo $presenca_ok . " aluno(a) está presente.";
        } else if ( $presenca_ok > 1 ) {
          echo $presenca_ok . " aluno(s) estão presentes.";
        } else {
          echo "Nenhum aluno(a) está presente.";
        }
    ?>
    </h3>
    <h4><a href="menu_professor.php">Volte ao menu do professor.</a></h4>
</body>
</html>

<?php

    }

?>
