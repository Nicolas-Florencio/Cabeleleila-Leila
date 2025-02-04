<?php
    session_start();
    if (!isset($_SESSION["idUsuario"])) {
        header("Location: ../pages/login.php");
    }
    try {
        include '../connect/conexao.php';
        // Dados do agendamento
        $idUsuario = $_SESSION['idUsuario'];
        $dataAgendada = $_POST['data']; //remove caractes invalidos
        $horaAgendada = $_POST['hora'];
        $dataAgendada = $dataAgendada . ' ' . $horaAgendada;
        $servicoSelecionado = $_POST['servicos'];

        // Inserção do agendamento no banco de dados
        $stmt = 'INSERT INTO agendamento (usuario_idUsuario, dataAgendada) VALUES (:usuario_idUsuario, :dataAgendada)';
        $comando = $pdo->prepare($stmt);

        $comando->bindParam(':usuario_idUsuario', $idUsuario);
        $comando->bindParam(':dataAgendada', $dataAgendada);
        $comando->execute();

        $idAgendamento = $pdo->lastInsertId(); //tomar cuidado com load alto do banco

        //vamos inserir os servcios
        $stmt = 'INSERT INTO agendamento_servicos (servicos_idservicos, agendamento_idAgendamento) VALUES (:idServico, :idAgendamento)';
        $comando = $pdo->prepare($stmt);

        foreach($servicoSelecionado as $servico) {
            $comando->bindParam(':idServico', $servico);
            $comando->bindParam(':idAgendamento', $idAgendamento);
            $comando->execute();
        }

        header('Location: ../pages/agendamento.php');
    }
    catch(PDOException $e) {
        echo "Erro " . $e;
    }
?>