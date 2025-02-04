<?php
    echo '<form action="../pages/agendamento.php" method="GET">
    <div class="container">
        <div class="containerData">
            <label for="data">Data Inicio:</label> <!-- data inicio -->
            <input type="date" name="dataInicio" id="data" required>
        </div>
        <div class="containerData">
            <label for="data">Data Final:</label>
            <input type="date" name="dataFim" id="data" required>
        </div>
    </div>

    <button id="enviarBotao">Filtrar</button>
    <button id="limpar">Limpar</button>
</form>';

?>