<?php
    session_start();

    if ((!isset($_SESSION["idUsuario"])) || ($_SESSION["nivelAcesso"] == 0)) {
        echo "<p>Você não tem permissão</p>";
        
        die();
    }

    try {
        include "../connect/conexao.php";
        $idAgendamento = $_GET['idAgendamento'];

        //excluindo os servicos daquele agendamento
        $stmt = "DELETE FROM agendamento_servicos WHERE agendamento_idAgendamento = :idAgendamento";
        $comando = $pdo->prepare($stmt);
        $comando->bindpAram(":idAgendamento", $idAgendamento);
        $comando->execute();


        //exlcuindo o agendamento
        $stmt = "DELETE FROM agendamento WHERE idAgendamento = :idAgendamento";
        $comando = $pdo->prepare($stmt);

        $comando->bindParam(":idAgendamento", $idAgendamento);
        $comando->execute();

    }
    catch(Exception $e) {
        echo "Erro: ". $e->getMessage();
    }

?>

<script>
    alert("Agendamento excluido com sucesso!");
    window.location.href = "../pages/agendamento.php";
</script>