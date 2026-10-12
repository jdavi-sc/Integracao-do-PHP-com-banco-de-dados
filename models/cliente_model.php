<?php
    function salvarCliente($pdo, $nome, $cpf, $email, $dataNasc) {
        $sql = "INSERT INTO cliente (nome_cliente, cpf_cliente, email_cliente, data_nascimento_cliente) VALUES (:nome, :cpf, :email, :data_nasc)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $nome,
            ':cpf' => $cpf,
            ':email' => $email,
            ':data_nasc' => $dataNasc,
        ]);
    }

    function buscarClientes($pdo) {
        $sql = "SELECT id_cliente, nome_cliente, cpf_cliente, email_cliente, data_nascimento_cliente FROM cliente ORDER BY id_cliente DESC";
        $stmt = $pdo->query($sql);

        return $stmt->FetchAll(PDO::FETCH_ASSOC);
    }
?>