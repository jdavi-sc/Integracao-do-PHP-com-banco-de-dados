<?php
    require_once __DIR__ . '/../config/conexao.php';
    require_once __DIR__ . '/../models/cliente_model.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = filter_input(INPUT_POST, 'nomeCliente', FILTER_SANITIZE_SPECIAL_CHARS);
        $cpf = filter_input(INPUT_POST, 'cpfCliente', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'emailCliente', FILTER_VALIDATE_EMAIL);
        $dataNasc = $_POST['dataNascCliente'] ?? null;

        if ($nome && $cpf && $email && $dataNasc) {
            $sucesso = salvarCliente($pdo, trim($nome), trim($cpf), $email, $dataNasc);

            if ($sucesso) {
                echo "Cliente cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar cliente no banco de dados.";
            }
        } else {
            echo "Por favor, preencha todos os campos corretamente.";
        }
    }

?>