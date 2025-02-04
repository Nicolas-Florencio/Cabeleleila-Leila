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
        if (!isset($_SESSION["idUsuario"])) {
            header("Location: ../pages/login.php");
        }
        include "../components/navbar.php";
        include "../connect/conexao.php";

        // informacoes do agendamento

        $idAgendamento = $_GET["idAgendamento"];

        $stmt = "SELECT dataAgendada FROM agendamento WHERE idAgendamento = :idAgendamento";

        $comando = $pdo->prepare($stmt); //prepare statement

        $comando->bindParam(":idAgendamento", $idAgendamento);
        $comando->execute();

        $dadosRetornar = $comando->fetch(PDO::FETCH_ASSOC); //armzenar em array associativo

        if (empty($dadosRetornar)) {
            echo "nenhum agendamento encontrado";
        }

        //servico relacionados ao agendamento
        $stmtServicos = "SELECT servicos_idservicos FROM agendamento_servicos WHERE agendamento_idAgendamento = :idAgendamento";
        $comandoServicos = $pdo->prepare($stmtServicos);
        $comandoServicos->bindParam(":idAgendamento", $idAgendamento);
        $comandoServicos->execute();
        $servicosSelecionados = $comandoServicos->fetchAll(PDO::FETCH_COLUMN); //armazena em uma coluna de dados


        //nome do usuario
        $stmt = "SELECT usuario.nome
                FROM agendamento 
                JOIN usuario ON agendamento.usuario_idUsuario = usuario.idUsuario
                WHERE agendamento.idAgendamento = :idAgendamento";
                
        $comando = $pdo->prepare($stmt);
        $comando->bindParam(":idAgendamento", $idAgendamento);
        $comando->execute();
        $nomeUsuario = $comando->fetch(PDO::FETCH_ASSOC);

        $nomeSessao = $_SESSION["nome"];
        $nomeBanco = $nomeUsuario["nome"];

        //variaveis de texto dinamico (incio)
        $exibeDataEmCima = $_SESSION["nivelAcesso"] == 0 ? "" : date("d/m/Y", strtotime($dadosRetornar["dataAgendada"]));
        $exibeHoraEmCima = $_SESSION["nivelAcesso"] == 0 ? "Seu horário:" : "Para ás:";

        $ativaCampo = function ($diffData, $tempoParaRemarcar) {
            if (($_SESSION["nivelAcesso"] == 0) && ($diffData >= $tempoParaRemarcar)) {
                return "";
            }
            else if($_SESSION["nivelAcesso"] == 0) {
                return "disabled";
            }
            return "";
        };
        $contatoTelefone = "<p>Alterações <b>não</b> permitadas 02 (dois) dias antes do agendado, entre em contato através do telefone: <a href='tel:+551499999999'>14 9999-9999</a></p>";
        //variaveis de texto dinamico (fim)
        
        if (($nomeSessao != $nomeBanco) && ($_SESSION["nivelAcesso"] == 0)) {
            echo "<div class='container'>";
            echo "<p>Voce não tem permissão para acessar este agendamento</p>";
            echo "<a href='../pages/agendamento.php'>Voltar</a>";
            echo "</div>";
            die(); //para o codigo
        }
        
        $dataHoje = date("Y-m-d"); //formato de data padrao do mysql
        $diffData = strtotime($dadosRetornar["dataAgendada"]) - strtotime($dataHoje); //valor retornado em segundos
        $diffData = $diffData / (60 * 60 * 24); //diferenca de dias (tive que pesquisar)
        $tempoParaRemarcar = 2; //dias
        ?>
    </header>

    <main>
        <section class="criarAgendamento">
            <h2>Consulta de horario, <?= ucfirst($nomeUsuario["nome"]) ?></h2>

            <form action="../actions/atualizarAgendamento.php" method="POST">
                <input type="hidden" name="idAgendamento" value="<?= $idAgendamento ?>">

                <div class="container">
                    <div class="containerHorario">
                        <label for="data"><?= ucfirst($nomeUsuario["nome"]) ?>, marcou no dia:</label> <!-- nome e data do cliente -->
                        <input type="date" name="data" id="data" value="<?= date("Y-m-d", strtotime($dadosRetornar["dataAgendada"])) ?>" <?= $ativaCampo($diffData, $tempoParaRemarcar) ?>>
                    </div>

                    <div class="containerHorario">
                        <label for="data"><?= $exibeHoraEmCima ?></label>
                        <input type="time" name="hora" id="hora" value="<?= date("H:i", strtotime($dadosRetornar["dataAgendada"])) ?>" <?= $ativaCampo($diffData, $tempoParaRemarcar) ?>>
                    </div>
                </div>

                <fieldset>
                    <legend>Para os serviços</legend>

                    <?php //problema onde se adicionar novos servicos no banco, o codigo precisa dessa manutencao (LEMBRAR de realizar consulta no banco para pegar os servicos)
                    $servicos = [
                        1 => "Cabelos",
                        2 => "Maquiagem",
                        3 => "Estética Facial",
                        4 => "Sobrancelhas",
                        5 => "Manicure e Pedicure",
                        6 => "Depilação",
                        7 => "Bronzeamento"
                    ];

                    foreach ($servicos as $id => $nome) {
                        $checked = in_array($id, $servicosSelecionados) ? "checked" : "";
                        echo '
                        <div class="checkboxContainer">
                            <input type="checkbox" name="servicos[]" value="' . $id . '" ' . $checked . ' ' . $ativaCampo($diffData, $tempoParaRemarcar) . '>
                            <label for="servico' . $id . '">' . $nome . '</label>
                        </div>';
                    }
                    ?>
                </fieldset>
                <button id="voltarBotao">Voltar</button>

                <?php
                    $botaoAtualizar = '<button id="atualizarBotao" type="submit" name="atualizar" value="' . $idAgendamento . '">Atualizar</button>';
                    if ($_SESSION['nivelAcesso'] == 1) {
                        echo $botaoAtualizar;
                        echo '<button id="excluirBotao" type="submit" name="excluir" value="' . $idAgendamento . '">Excluir</button>';
                    }
                    if ($_SESSION["nivelAcesso"] == 0){
                        //o bloco de codigo que afeta esta linha, está na linha 79
                        echo $diffData >= $tempoParaRemarcar ? $botaoAtualizar : $contatoTelefone;
                    }
                    
                ?>
            </form>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById("voltarBotao").addEventListener("click", (e) => {
                e.preventDefault();
                window.location.href = "../pages/agendamento.php";
            });
            document.getElementById("excluirBotao").addEventListener("click", (e) => {
                e.preventDefault();
                
                let confirmacao = confirm("Deseja excluir este agendamento?");

                if(confirmacao) {
                    let params = new URLSearchParams(document.location.search); //Objeto da url
                    let busca = params.get("idAgendamento"); //parametro da url 

                    window.location.href = "../actions/excluirAgendamento.php?idAgendamento=" + busca;
                }
                else {
                    alert("Operação cancelada");
                }
            });
            document.getElementById("atualizarBotao").addEventListener("click", (e) => {
                e.preventDefault();
                
                let confirmacao = confirm("Deseja atualizar este agendamento?");

                if(confirmacao) {
                    document.querySelector("form").submit();
                }
                else {
                    alert("Operação cancelada");
                }
            });
        });
    </script>
</body>

</html>