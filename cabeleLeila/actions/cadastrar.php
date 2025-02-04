<?php
    session_start();
    if (isset($_SESSION["idUsuario"])) {
        header("Location: ../pages/index.php");
    }

    function cadastrarCliente($dados) {
        include "../connect/conexao.php";

        try {
            // Verifica se o email existe
            $stmt = "SELECT email FROM usuario WHERE email = :email";
            $comando = $pdo->prepare($stmt);
    
            $email = htmlspecialchars($dados["email"]);
            $comando->bindParam(":email", $email);
            $comando->execute();
    
            if ($comando->rowCount() > 0) {
                throw new Exception("E-mail já cadastrado", 401); //usuario nao autorizado
            }
    
            //criar usuario
            $stmt = "INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)";
            $comando = $pdo->prepare($stmt);
    
            $nome = htmlspecialchars($dados["nome"]);
            $senha = md5(htmlspecialchars($dados["senha"]));
    
            $comando->bindParam(":nome", $nome);
            $comando->bindParam(":email", $email);
            $comando->bindParam(":senha", $senha);
            $comando->execute();
    
            // Verifica se a inserção foi bem-sucedida
            if ($comando->rowCount() > 0) {
                $retorno = ["success" => true, "redirect" => "login.php"];
                return json_encode($retorno);
            }
            else {
                throw new Exception("Erro ao cadastrar usuário", 500); // Erro interno do servidor
            }
        }
        catch (Exception $e) {
            // Tratar erro e retornar resposta JSON
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            $retorno = ["failed" => true, "status" => $e->getMessage()];
            return json_encode($retorno);
        }
    }
    
    // Recebe a requisição e chama a função de cadastro
    try {
        $recebeJSON = file_get_contents('php://input');
        $dados = json_decode($recebeJSON, true); // Decodifica o JSON em um array associativo
        echo cadastrarCliente($dados);
    }
    catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['Erro' => $e->getMessage()]);
    }
    ?>