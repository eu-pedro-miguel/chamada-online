<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chamada Online - Login do Professor</title>
        <style>
            h1, h4, p {
                display: flex;
                justify-content: center;
            }
        </style>
    </head>
    <body>
        <form action="valida_professor.php" method="post">
            <h1>Chamada Online - Login do Professor</h1>
            <p>
                <label for="matricula">Matrícula do professor:&nbsp;</label>
                <input type="text" name="matricula">
            </p>
            <p>
                <label for="senha">Senha do professor:&nbsp;</label>
                <input type="password" name="senha">
            </p>
            <input type="hidden" name="web" value="1" />
            <p><button>Login</button></p>
        </form>
        <h4><a href="index.php">Volte ao menu principal.</a></h4>
    </body>
</html>