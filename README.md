# Prática Extensionista III: Sistema de Gestão Coloratto Tintas

Este repositório contém a entrega final do projeto da disciplina de **Prática Extensionista III** do curso de Análise e Desenvolvimento de Sistemas da **Universidade do Oeste de Santa Catarina (Unoesc - Chapecó)**.

## Sobre o Projeto Coloratto Tintas

O Projeto Coloratto Tintas consiste na criação de uma **aplicação web completa utilizando PHP e banco de dados MySQL**. O objetivo principal é fornecer uma plataforma para um site de comércio eletrônico (ou gestão de serviços/orçamentos de uma loja de tintas), otimizando processos e centralizando informações.

A aplicação foi desenvolvida com foco em:
* Gestão de Serviços (Catálogo de Produtos/Serviços de Tintas)
* Gestão de Orçamentos com controle de status
* Sistema de Autenticação para diferentes perfis de usuário (Administrador)
* Interface intuitiva e responsiva para facilitar o uso.

![Captura de Tela do Sistema Coloratto Tintas](https://github.com/user-attachments/assets/5137977f-ec81-4ac2-ab5f-4d217640c4c3)

## Funcionalidades Principais

* **Páginas Institucionais:** Início, Sobre Nós, Serviços, Clientes, Contato.
* **Autenticação:** Login e Registro de usuários.
* **Painel Administrativo:**
    * Gerenciamento de Serviços (Adicionar, Editar, Excluir, Listar).
    * Gerenciamento de Clientes (Adicionar, Editar, Excluir, Listar).
    * Gerenciamento de Orçamentos (Listar, Visualizar Detalhes, Atualizar Status).
* **Solicitação de Orçamento:** Funcionalidade para visitantes/clientes solicitarem orçamentos.

## Contribuição

Este projeto foi desenvolvido com a contribuição de:

* **Jorge Nascimento**

## Tecnologias Utilizadas

O projeto foi construído utilizando as seguintes tecnologias e frameworks:

* **Linguagem de Programação:** PHP (puro)
* **Banco de Dados:** MySQL
* **Frontend:**
    * HTML5
    * CSS3
    * JavaScript
    * Bootstrap 5 (Framework CSS/JS)

## Como Rodar o Projeto (Instalação Local)

Para rodar este projeto em seu ambiente local, siga os passos abaixo:

1.  **Pré-requisitos:**
    * Servidor web com suporte a PHP e MySQL (ex: XAMPP).

2.  **Clone o Repositório:**
    ```bash
    git clone [https://github.com/SEU_USUARIO/SEU_REPOSITORIO.git](https://github.com/SEU_USUARIO/SEU_REPOSITORIO.git)
    cd SEU_REPOSITORIO
    ```
    *(Substitua `SEU_USUARIO` e `SEU_REPOSITORIO` pelos dados corretos do seu GitHub)*

3.  **Configurar o Banco de Dados:**
    * Crie um banco de dados MySQL com o nome `coloratto_db`.
    * Importe o script SQL `import.sql` para criar as tabelas e dados iniciais.
    * Ajuste as credenciais do banco de dados no arquivo `config.php`.

4.  **Configurar `BASE_URL`:**
    * No arquivo `config.php`, defina a constante `BASE_URL` para o caminho base do seu projeto no servidor local. Exemplo:
        ```php
        define('BASE_URL', '/coloratto/');
        ```

5.  **Acessar a Aplicação:**
    * Abra seu navegador e acesse: `http://localhost/coloratto/index.php` (ou o caminho configurado no seu servidor).
