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

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chamada Online - MENU PROFESSOR</title>
        <link rel="stylesheet" href="/css/estilo.css">
    </head>
    <body>
        <h1>Chamada Online - MENU PROFESSOR</h1>
        <h2><a href="lista_presenca.php">&nbsp;&nbsp;Lista Presença dos Alunos&nbsp;&nbsp;</a></h2>
        <h2><a href="limpa_presenca.php">&nbsp;&nbsp;Limpa Presença dos Alunos&nbsp;&nbsp;</a></h2>
        <h2><a href="sair.php">&nbsp;&nbsp;Sair&nbsp;&nbsp;</a></h2>
        <h3>Clique em um dos links acima</h3>
    </body>
</html>

<?php

    }

?>