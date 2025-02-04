<?php
    session_start();

    if (!isset($_SESSION["idUsuario"])) {
        header("Location: ../pages/login.php");
        die();
    }

    try {
        include "../connect/conexao.php";
    
        $idAgendamento = $_POST['idAgendamento'];
        $data = $_POST['data'];
        $hora = $_POST['hora'];
        $dataAgendada = $data . " " . $hora;

        //vamos atualizar a data e hora do agendamento
        $stmt = "UPDATE agendamento SET dataAgendada = :dataAgendada WHERE idAgendamento = :idAgendamento";
        $comando = $pdo->prepare($stmt);
        $comando->bindParam(":idAgendamento", $idAgendamento);
        $comando->bindParam(":dataAgendada", $dataAgendada);
        $comando->execute();

        //excluindo os servicos atrelados anteriormente
        $stmt = "DELETE FROM agendamento_servicos WHERE agendamento_idAgendamento = :idAgendamento";
        $comando = $pdo->prepare($stmt);
        $comando->bindParam(":idAgendamento", $idAgendamento);
        $comando->execute();

        //adicionando novos servicos
        $stmt = "INSERT INTO agendamento_servicos (agendamento_idAgendamento, servicos_idservicos) VALUES (:idAgendamento, :idServico)";
        $comando = $pdo->prepare($stmt);
        $comando->bindParam(":idAgendamento", $idAgendamento);

        foreach ($_POST["servicos"] as $servicoId) {
            $comando->bindParam(":idServico", $servicoId);
            $comando->execute();
        }
    }
    catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
        die();
    }
?>
<script>
    alert("Agendamento atualizado com sucesso");
    window.location.href = "../actions/visualizar.php?idAgendamento=<?= $idAgendamento ?>";
</script>