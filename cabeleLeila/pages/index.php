<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/principal.css"> <!-- css global -->
    <link rel="stylesheet" href="../styles/index.css"> <!-- css unico (da pagina) -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>

</head>

<body>
    <header>
        <?php
            session_start();
            if(!isset($_SESSION['idUsuario'])) {
                //header("Location: login.php");
            }
            include "../components/navbar.php";
        ?>
    </header>

    <main class="framePrincipal">
        <section id="sobre">
            <div class="textoSobre">
                <h2>Nosso salão</h2>
                <p>Com um ambiente sofisticado e aconchegante, o Salão Cabeleleila Leila se tornou referência em cuidados estéticos, sendo o destino perfeito para quem busca renovação e bem-estar. Aqui, cada cliente recebe um atendimento personalizado, garantindo que saia ainda mais confiante e radiante. Seja para uma transformação completa ou apenas um momento de autocuidado, a equipe do Salão Cabeleleila Leila está pronta para atender você com profissionalismo, carinho e inovação.</p>
            </div>
        </section>

        <section id="servicos">
            <h2>Alguns dos serviços</h2>

            <ul class="listaServicos">
                <li>
                    <i class="bx bx-check"></i> <span class="itemServico"><strong>Cabelos</strong> – Cortes modernos, coloração, hidratação, reconstrução capilar e alongamento com mega hair.</span>
                </li>
                <li>
                    <i class="bx bx-check"></i> <span class="itemServico"><strong>Maquiagem Profissional</strong> – Para eventos, noivas e dia a dia, realçando sua beleza natural.</span>
                </li>
                <li>
                    <i class="bx bx-check"></i> <span class="itemServico"><strong>Estética Facial</strong> – Limpeza de pele, peeling, tratamento para acne e rejuvenescimento.</span>
                </li>
                <li>
                    <i class="bx bx-check"></i> <span class="itemServico"><strong>Estética Corporal</strong> – Massagens relaxantes, drenagem linfática, criolipólise e modelagem corporal.</span>
                </li>
                <li>
                    <i class="bx bx-check"></i> <span class="itemServico"><strong>Design de Sobrancelhas</strong> – Henna, micropigmentação e correção de falhas</span>
                </li>
                <li>
                    <i class="bx bx-check"></i> <span class="itemServico"><strong>Manicure e Pedicure</strong> – Esmaltação tradicional e em gel, spa dos pés e unhas decoradas.</span>
                </li>
                <li>
                    <i class="bx bx-check"></i> <span class="itemServico"><strong>Depilação</strong> – Cera quente e laser para todos os tipos de pele.</span>
                </li>
                <li>
                    <i class="bx bx-check"></i> <span class="itemServico"><strong>Bronzeamento</strong> – Natural e artificial, para um brilho dourado o ano todo.</span>
                </li>
            </ul>
        </section>
    </main>
</body>

</html>