<form action="../actions/agendar.php" method="post">
    <div class="container">
        <div class="containerHorario">
            <label for="data">Para qual dia <?= ucfirst($_SESSION['nome']) ?>?</label> <!-- nome do cliente -->
            <input type="date" name="data" id="data" required>
        </div>
        <div class="containerHorario">
            <label for="data">Qual melhor horário?</label>
            <input type="time" name="hora" id="data" required>
        </div>
    </div>

    <fieldset>
        <legend>Qual serviço?</legend>

        <div class="checkboxContainer">
            <input type="checkbox" name="servicos[]" value="1">
            <label for="cabelo">Cabelos</label>
        </div>
        <div class="checkboxContainer">
            <input type="checkbox" name="servicos[]" value="2">
            <label for="maquiagem">Maquiagem</label>
        </div>
        <div class="checkboxContainer">
            <input type="checkbox" name="servicos[]" value="3">
            <label for="estetica">Estetica facial</label>
        </div>
        <div class="checkboxContainer">
            <input type="checkbox" name="servicos[]" value="4">
            <label for="sobrancelha">Sobrancelhas</label>
        </div>
        <div class="checkboxContainer">
            <input type="checkbox" name="servicos[]" value="5">
            <label for="manicurePedicure">Manicure e Pedicure</label>
        </div>
        <div class="checkboxContainer">
            <input type="checkbox" name="servicos[]" value="6">
            <label for="depilacao">Depilação</label>
        </div>
        <div class="checkboxContainer">
            <input type="checkbox" name="servicos[]" value="7">
            <label for="bronzeamento">Bronzeamento</label>
        </div>
    </fieldset>

    <button id="enviarBotao">Marcar</button>
</form>