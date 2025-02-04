<?php
@session_start(); //o @ suprime o erro de sessao caso ja exista
//barra de navegacao de usuario normal
if (isset($_SESSION['idUsuario']) && $_SESSION['nivelAcesso'] == 0) {
    echo '<nav class="navbar">
        <a href="../pages/index.php"><h1>Cabelos e Leilas</h1></a>
            <ul class="navbarItems">
                <li>
                    <a href="../pages/index.php">Principal</a>
                </li>
                <li>
                    <a href="#servicos">Serviços</a>
                </li>
                <li>
                    <a href="../pages/agendamento.php">Agendar!</a>
                </li>
                <li>
                    <a href="../actions/logoff.php">Sair</a>
                </li>
            </ul>
        </nav>';
}
//barra de navegacao de usuario adm
else if (isset($_SESSION['idUsuario']) && $_SESSION['nivelAcesso'] == 1) {
    echo '<nav class="navbar">
        <a href="../pages/index.php"><h1>Cabelos e Leilas</h1></a>
            <ul class="navbarItems">
                <li>
                    <a href="../pages/index.php">Principal</a>
                </li>
                <li>
                    <a href="#servicos">Serviços</a>
                </li>
                <li>
                    <a id="adm" href="../pages/visaoAdm.php">ADM</a>
                </li>
                <li>
                    <a href="../pages/agendamento.php">Agendamentos</a>
                </li>
                <li>
                    <a href="../actions/logoff.php">Sair</a>
                </li>
            </ul>
        </nav>';
}
//barra de navegacao para usuario nao logado
else {
    echo '<nav class="navbar">
        <a href="../pages/index.php"><h1>Cabelos e Leilas</h1></a>
            <ul class="navbarItems">
                <li>
                    <a href="../pages/index.php">Principal</a>
                </li>
                <li>
                    <a href="../pages/login.php">Login</a>
                </li>
                <li>
                    <a href="../pages/cadastro.php">Cadastrar-se</a>
                </li>
            </ul>
        </nav>';
}
