<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/principal.css"> <!-- css global -->
    <link rel="stylesheet" href="../styles/visaoAdm.css"> <!-- css único (da página) -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Agendamentos</title>
</head>

<body>
<header>
    <?php
        session_start();
        include "../components/navbar.php";
        if ((!isset($_SESSION["idUsuario"])) || ($_SESSION["nivelAcesso"] == 0)) {
            echo "<script>
                    alert('Você não tem permissão para acessar esta página!');
                    window.location.href = 'login.php';
                </script>";
            die();
        }

        include "../connect/conexao.php";

        $dataInicio = isset($_GET['dataInicio']) ? $_GET['dataInicio'] : null;
        $dataFim = isset($_GET['dataFim']) ? $_GET['dataFim'] : null;

    ?>
</header>

<main class="framePrincipal">
    <h2>Relatório de Agendamentos e Serviços</h2>

    <form action="visaoAdm.php" method="GET">
        <div class="filtrarDatas">
            <div class="containerData">
                <label for="dataInicio">Data Início:</label>
                <input type="date" name="dataInicio" id="dataInicio" value="<?= $dataInicio ?>" required>
            </div>
            <div class="containerData">
                <label for="dataFim">Data Final:</label>
                <input type="date" name="dataFim" id="dataFim" value="<?= $dataFim ?>" required>
            </div>
        </div>
        <button type="submit" id="enviarBotao">Filtrar</button>
        <button type="reset" id="limpar">Limpar</button>
    </form>

    <?php
        if ($dataInicio && $dataFim) {
            //consultar o total de agendamentos no intervalo de datas
            $stmtAgendamentos = $pdo->prepare("SELECT COUNT(*) as total_agendamentos 
                                               FROM agendamento 
                                               WHERE dataAgendada BETWEEN :dataInicio AND :dataFim");
            $stmtAgendamentos->bindParam(':dataInicio', $dataInicio);
            $stmtAgendamentos->bindParam(':dataFim', $dataFim);
            $stmtAgendamentos->execute();
            $totalAgendamentos = $stmtAgendamentos->fetch(PDO::FETCH_ASSOC)['total_agendamentos'];

            //consultar o total de serviços prestados no intervalo de datas
            $stmtServicos = $pdo->prepare("SELECT COUNT(agendamento_servicos.agendamento_idAgendamento) as total_servicos 
                                           FROM agendamento_servicos
                                           JOIN agendamento ON agendamento_servicos.agendamento_idAgendamento = agendamento.idAgendamento
                                           WHERE agendamento.dataAgendada BETWEEN :dataInicio AND :dataFim");
            $stmtServicos->bindParam(':dataInicio', $dataInicio);
            $stmtServicos->bindParam(':dataFim', $dataFim);
            $stmtServicos->execute();
            $totalServicos = $stmtServicos->fetch(PDO::FETCH_ASSOC)['total_servicos'];

            echo "<div class='container'>
                    <p>Total de agendamentos: $totalAgendamentos</p>
                    <p>Total de serviços prestados: $totalServicos</p>
                  </div>";
        }
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('limpar').addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = '../pages/visaoAdm.php';
            });
        });
    </script>
</main>

</body>

</html>
