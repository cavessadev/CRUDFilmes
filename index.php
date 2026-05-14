<?php
session_start();

// aqui cria o banco de dados
if (!isset($_SESSION['filmes'])) {
    $_SESSION['filmes'] = [];
}

//aqui a gente adiciona
if (isset($_POST['acao']) && $_POST['acao'] == 'adicionar') {
    $filme = [
        'titulo' => $_POST['titulo'],
        'genero' => $_POST['genero'],
        'ano' => $_POST['ano']
    ];

    $_SESSION['filmes'][] = $filme;

    header("Location: index.php");
    exit;
}


if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];

    unset($_SESSION['filmes'][$id]);

    $_SESSION['filmes'] = array_values($_SESSION['filmes']);

    header("Location: index.php");
    exit;
}


if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    $id = $_POST['id'];

    $_SESSION['filmes'][$id] = [
        'titulo' => $_POST['titulo'],
        'genero' => $_POST['genero'],
        'ano' => $_POST['ano_filme']
    ];

    header("Location: index.php");
    exit;
}

//aqui conseguimos editar
$filmeEditar = null;

if (isset($_GET['editar'])) {
    $idEditar = $_GET['editar'];
    $filmeEditar = $_SESSION['filmes'][$idEditar];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CRUD de Filmes</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h1>CRUD de Filmes</h1>

        <?php if ($filmeEditar): ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $idEditar ?>">

            <input type="text" name="titulo" placeholder="Título" value="<?= $filmeEditar['titulo'] ?>" required>

            <input type="text" name="genero" placeholder="Gênero" value="<?= $filmeEditar['genero'] ?>" required>

            <input type="number" name="ano" placeholder="Ano" value="<?= $filmeEditar['ano'] ?>" required>

            <button type="submit" name="acao" value="editar">
                Atualizar
            </button>
        </form>

        <?php else: ?>

        <form method="POST">
            <input type="text" name="titulo" placeholder="Título" required>

            <input type="text" name="genero" placeholder="Gênero" required>

            <input type="number" name="ano" placeholder="Ano" required>

            <button type="submit" name="acao" value="adicionar">
                Adicionar
            </button>
        </form>

        <?php endif; ?>

        <table>
            <tr>
                <th>Título</th>
                <th>Gênero</th>
                <th>Ano</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($_SESSION['filmes'] as $id => $filme): ?>

            <tr>
                <td><?= $filme['titulo'] ?></td>
                <td><?= $filme['genero'] ?></td>
                <td><?= $filme['ano'] ?></td>

                <td>
                    <a href="?editar=<?= $id ?>">Editar</a>

                    <a href="?deletar=<?= $id ?>" onclick="return confirm('Deseja excluir?')">
                        Excluir
                    </a>
                </td>
            </tr>

            <?php endforeach; ?>

        </table>
    </div>

</body>

</html>