# CabeleLeila

**CabeleLeila** é um sistema de gerenciamento de agendamentos e serviços para um salão de cabeleireiro, com funcionalidades específicas para diferentes níveis de acesso, permitindo uma experiência personalizada para usuários com diferentes permissões.

## Níveis de Segurança e Acesso

O sistema possui dois principais níveis de acesso:

1. **Administrador (Adm)**:
   - Os administradores têm permissões para acessar todas as funcionalidades do sistema, incluindo visualização de agendamentos, edição de dados, exclusão e geração de relatórios.
   - ~Possuem a capacidade de gerenciar os usuários do sistema e visualizar todos os dados, com um nível de controle total.~

2. **Usuário Comum**:
   - Usuários comuns têm acesso limitado ao sistema, podendo apenas visualizar seus próprios agendamentos e informações, sem permissão para editar ou excluir dados críticos.
   - Sua interface é mais restrita, com foco nas funcionalidades de visualização e agendamento.

A lógica de permissões é implementada por meio de variáveis de sessão e verificações de nível de acesso nas páginas do sistema.

## Tecnologias Utilizadas

O sistema foi desenvolvido utilizando as seguintes tecnologias:

- **PHP**: Linguagem de programação utilizada para implementar a lógica de negócios e a interação com o banco de dados.
- **MySQL**: Banco de dados relacional utilizado para armazenar informações de agendamentos, usuários e serviços.
- **JavaScript**: Usado para melhorar a interatividade da interface do usuário, incluindo validações de formulários e carregamento dinâmico de dados.

## Funcionalidades

- **Cadastro de Agendamentos**: Os usuários podem agendar serviços, selecionar horários e visualizar os agendamentos realizados.
- **Visualização de Relatórios**: O sistema possui relatórios semanais, com filtro de datas e visualização de serviços agendados.
- **Sistema de Login**: O sistema possui uma tela de login que verifica as credenciais do usuário e garante que somente os usuários autorizados acessem as páginas restritas.
- **Gerenciamento de Serviços**: Os administradores podem adicionar, editar e remover serviços oferecidos pelo salão.

## Débito Técnico

- **Funcionalidade de Status de Agendamento**: Atualmente, o sistema possui um débito técnico em relação à funcionalidade de "status" dos agendamentos. A implementação do status de agendamento (como "pendente", "confirmado", "cancelado", etc.) ainda precisa ser finalizada para garantir a gestão completa e eficaz do ciclo de vida dos agendamentos. Este ajuste está previsto para ser feito em futuras versões.

## Como Iniciar

1. Clone este repositório.
2. Configure seu servidor local (exemplo: XAMPP, WAMP ou LAMP) com suporte a PHP e MySQL.
3. Importe o banco de dados utilizando o arquivo SQL presente no projeto.
4. Atualize as configurações de conexão com o banco de dados no arquivo PHP.
5. Acesse o sistema através de um navegador e faça login com um usuário de nível adequado.
