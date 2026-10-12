<?php
require_once __DIR__ . '/../config/Conexao.php';
require_once __DIR__ . '/../models/cliente_model.php';

$clientes = buscarClientes($pdo);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Clientes Cadastrados</h2>

    <table class="table table-striped table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>E-mail</th>
                <th>Data de Nascimento</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($clientes)): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= htmlspecialchars($cliente['id_cliente']) ?></td>
                        <td><?= htmlspecialchars($cliente['nome_cliente']) ?></td>
                        <td>
                            <?= preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", htmlspecialchars($cliente['cpf_cliente'])) ?>
                        </td>
                        <td><?= htmlspecialchars($cliente['email_cliente']) ?></td>
                        <td>
                            <?= date('d/m/Y', strtotime($cliente['data_nascimento_cliente'])) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Nenhum cliente cadastrado ainda.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>