<?php
    session_start();
    if (isset($_SESSION["idUsuario"])) {
        header("Location: ../pages/index.php");
    }
    
    file_get_contents('php://input');
    
    function buscarCliente($dados) {

        try {
            include "../connect/conexao.php";

            $stmt = "SELECT idUsuario, nome, nivelAcesso FROM usuario WHERE email LIKE :email AND senha LIKE :senha";
            //prepare statement
            $comando = $pdo->prepare($stmt);

            $email = htmlspecialchars($dados["email"]);
            $senha = md5(htmlspecialchars($dados["senha"]));

            $comando->bindParam(":email", $email);
            $comando->bindParam(":senha", $senha);
            $comando->execute();

            $dadosRetornar = $comando->fetchAll(PDO::FETCH_ASSOC); //armzenar em array associativo
            $qtdResult = $comando->rowCount();

            if ($qtdResult == 0) {
                throw new Exception("Usuario ou senha invalido", 401); //codigo de usuario nao autorizado
            }
            else {
                //echo var_dump($dadosRetornar);
                $_SESSION['idUsuario'] = $dadosRetornar[0]['idUsuario'];
                $_SESSION['nome'] = $dadosRetornar[0]['nome'];
                $_SESSION['nivelAcesso'] = $dadosRetornar[0]['nivelAcesso'];

                $retorno = (["success" => true, "redirect" => "index.php"]); //retorno dos dados
                return json_encode($retorno);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);

        } catch (Exception $e) {

            header('Content-Type: application/json');
            http_response_code(401);

            $retorno = (["failed" => true, "Status" => "Usuario ou senha invalido"]);

            return json_encode($retorno);
        }
    }

    try {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            // Captura o corpo da requisição que contém o JSON
            $recebeJSON = file_get_contents('php://input');
    
            // Decodifica o JSON em um array associativo
            $dados = json_decode($recebeJSON, true); //array de objetos
            echo buscarCliente($dados);
        }

        else if ($_SERVER['REQUEST_METHOD'] != "POST") {
            throw new Exception("Metodo invalido!");
        }
    }
    catch(Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['Erro' => $e->getMessage()]);
    }

