<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/principal.css"> <!-- css global -->
    <link rel="stylesheet" href="../styles/login.css"> <!-- css unico (da pagina) -->
    <title>Cadastro</title>
</head>
<header>
    <?php
    session_start();
    if (isset($_SESSION['idUsuario'])) {
        header("Location: index.php");
    }
    include "../components/navbar.php";
    ?>
</header>

<body>
    <main class="container">
        <h2>Cadastro</h2>
        <form name="cadastroForm" action="../actions/cadastrar.php" method="POST">
            <div class="inputs">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="inputs">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="inputs">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <button id="enviarBotao">Cadastrar</button>
        </form>

        <div class="cadastrar">
            <p>Já tem uma conta?</p>
            <a href="../pages/login.php">Faça login</a>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelector("form").addEventListener("submit", (e) => {
                e.preventDefault(); // evita que o formulario seja enviado

                const dados = {
                    nome: document.querySelector("#nome").value,
                    email: document.querySelector("#email").value,
                    senha: document.querySelector("#senha").value
                };

                fetch("../actions/cadastrar.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json" // cabecalho para JSON
                        },
                        body: JSON.stringify(dados) // dados convertidos para JSON
                    })
                    .then(response => response.json())
                    .then(retorno => {
                        if (retorno.success) {
                            alert("Cadastro realizado com sucesso!");
                            window.location.href = "login.php";
                        }
                        else {
                            if (!document.querySelector('span')) {
                                const span = document.createElement("span");
                                span.textContent = "E-mail ja cadastrado";
                                span.style.color = "red";
                                document.querySelector("form").appendChild(span);
                            }
                        }
                    })
                    .catch(error => {
                        console.log(error.message)
                    });
            });
        });
    </script>
</body>

</html>