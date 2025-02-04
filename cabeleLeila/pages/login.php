<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/principal.css"> <!-- css global -->
    <link rel="stylesheet" href="../styles/login.css"> <!-- css unico (da pagina) -->
    <title>Login</title>

</head>

<body>
    <header>
        <?php
        session_start();
        if(isset($_SESSION['idUsuario'])) {
            header("Location: index.php");
        }
        include "../components/navbar.php";
        ?>
    </header>

    <main class="container">
        <h2>Login</h2>
        <form name="loginForm" action="logar.php" method="POST">
            <div class="inputs">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="inputs">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <button id="enviarBotao">Entrar</button>
        </form>

        <div class="cadastrar">
            <p>Não tem uma conta?</p>
            <a href="../pages/cadastro.php">Cadastre-se</a>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelector("form").addEventListener("submit", (e) => {
                e.preventDefault(); // evita que o formulario seja enviado

                const dados = {
                    email: document.querySelector("#email").value,
                    senha: document.querySelector("#senha").value
                };

                fetch("../actions/logar.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json" // cabecalho para JSON
                        },
                        body: JSON.stringify(dados) // dados dos inputs
                    })
                    .then(response => {
                        if (response.ok === false) {
                            throw new Error("Usuário ou senha inválidos");
                        }
                        else {
                            return response.json();
                        }
                    })
                    .then(retorno => {
                        console.log("Retorno:", retorno);
                        if (retorno.success) {
                            window.location.href = "../pages/index.php"; // redireciona se sucesso
                        }
                        else {
                            console.log("Erro no retorno:", retorno);
                        }
                    })
                    .catch((error) => {
                        if(!document.querySelector('span')) {
                            const span = document.createElement("span");
                            span.textContent = error.message;
                            span.style.color = "red";
                            document.querySelector("form").appendChild(span);
                        } 
                    });
            });
        });
    </script>
</body>

</html>