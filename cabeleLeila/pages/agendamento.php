<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/principal.css"> <!-- css global -->
    <link rel="stylesheet" href="../styles/agendamento.css"> <!-- css unico (da pagina) -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>

</head>

<body>
    <header>
        <?php
            session_start();
            if (!isset($_SESSION['idUsuario'])) {
                header("Location: login.php");
            }
            include "../components/navbar.php";

            $tituloUsuarioNormal = '<h2>Vamos marcar um horário!</h2>';
            $tituloUsuarioAdm = '<h2>Consulta e alteração de agendamentos!</h2>';

        ?>
    </header>

    <main>
        <section class="criarAgendamento">
            <?php
            if ($_SESSION['nivelAcesso'] == 1) {
                echo $tituloUsuarioAdm; //titulo para adm
                include "../components/formFiltrarAgendamento.php";
            } else {
                echo $tituloUsuarioNormal; //titulo para usuario normal
                include "../components/formCriarAgendamento.php";
                //formulario para criar agendamento
            }
            ?>
        </section>

        <section class="listaAgendamentos">
            <h3>Histórico</h3>
            <div class="frameAgendamentos">
                <!-- listagem dos agendamentos -->
                <?php
                    include '../connect/conexao.php';
                    $idUsuario = $_SESSION['idUsuario'];

                    if ($_SESSION['nivelAcesso'] == 1) {
                        $stmt = 'SELECT agendamento.idAgendamento, agendamento.dataAgendada, usuario.nome
                                 FROM agendamento 
                                 JOIN usuario ON agendamento.usuario_idUsuario = usuario.idUsuario
                                 WHERE 1=1'; //macete para podermos concatenar o restante da query la em baixo
                    } else {
                        $stmt = 'SELECT idAgendamento, dataAgendada FROM agendamento WHERE usuario_idusuario = :idUsuario';
                    }
                    
                    //adiciona filtros de data se existirem
                    if (!empty($_GET['dataInicio']) && !empty($_GET['dataFim'])) {
                        $stmt .= ' AND dataAgendada BETWEEN :dataInicio AND :dataFim';
                    }
                    
                    $stmt .= " ORDER BY dataAgendada DESC";
                    
                    //prepara a query
                    $comando = $pdo->prepare($stmt);
                    
                    //bind de parâmetros
                    if ($_SESSION['nivelAcesso'] != 1) {
                        $comando->bindParam(':idUsuario', $idUsuario);
                    }
                    if (!empty($_GET['dataInicio']) && !empty($_GET['dataFim'])) {
                        $comando->bindParam(':dataInicio', $_GET['dataInicio']);
                        $comando->bindParam(':dataFim', $_GET['dataFim']);
                    }
                    
                    $comando->execute();
                    $dadosRetornar = $comando->fetchAll(PDO::FETCH_ASSOC);

                    if ($dadosRetornar) {

                        if($_SESSION['nivelAcesso'] == 1) {
                            foreach ($dadosRetornar as $agendamento) {
                                echo '<div class="agendamento">
                                            <p><b>'.ucfirst($agendamento['nome']).'</b> tem agendamento para o dia <strong>' . date('d/m/Y', strtotime($agendamento['dataAgendada'])) . ' às ' . date('H:i', strtotime($agendamento['dataAgendada'])) . '</strong></p>
                                            <a href="../actions/visualizar.php?idAgendamento=' . $agendamento['idAgendamento'] . '">Alterar</a>
                                        </div>';
                            }
                        }
                        else {
                            foreach ($dadosRetornar as $agendamento) {
                                echo '<div class="agendamento">
                                            <p>Agendamento para o dia <strong>' . date('d/m/Y', strtotime($agendamento['dataAgendada'])) . ' às ' . date('H:i', strtotime($agendamento['dataAgendada'])) . '</strong></p>
                                            <a href="../actions/visualizar.php?idAgendamento=' . $agendamento['idAgendamento'] . '">Visualizar</a>
                                        </div>';
                            }
                        }
                    } else {
                        echo '<p>Nenhum agendamento encontrado.</p>';
                    }
                ?>
            </div>
        </section>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('limpar').addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = '../pages/agendamento.php';
            });
        });
    </script>
</body>
</html>