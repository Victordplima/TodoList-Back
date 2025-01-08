<h1 align="center">TodoList Back-End</h1>

---
<p align="center">
    <a href="#sobre">Sobre</a> •
    <a href="#documentacao">Documentação</a> •
    <a href="#tecnologias">Tecnologias</a> •
    <a href="#bd">Modelo Entidade-Relacionamento</a> •
    <a href="#instalacao">Instalação</a> •
    <a href="#autor">Autor</a>
</p>

<h2 id="sobre">✨ Sobre</h2>

Um sistema de gerenciamento de tarefas com suporte a subtarefas e categorias. Desenvolvido utilizando Laravel como back-end. Este projeto fornece uma API para gerenciar tarefas. Cada tarefa pode ter subtarefas, categorias associadas e status como "pendente", "em andamento" ou "concluída".

<h2 id="documentacao">📝 Documentação</h2>

[Documentação no Postman](https://documenter.getpostman.com/view/29442674/2sAYJAdxLV)


<h2 id="tecnologias">🛠 Tecnologias</h2>

+ Linguagem: PHP 8+
+ Framework: Laravel 11+
+ Banco de Dados: PostgreSQL
+ Gerenciador de Dependências: Composer
+ Testes de API e Documentação: Postman


<h2 id="bd">🎲 Modelo Entidade-Relacionamento</h2>
<p align="center">
  <img src="Modelo Entidade-Relacionamento.png" alt="Tela de perfil">
</p>

[Query de criação do Banco de Dados](https://drive.google.com/file/d/174kaqyPL4CED_z4x92O1zrp7K4nC3IMw/view?usp=sharing)


<h2 id="instalacao">🚀 Como executar o projeto</h2>
Siga os passos abaixo para executar o projeto em seu ambiente local:

1. **Clone o repositório**
   ```bash
   https://github.com/Victordplima/TodoList-Back.git
   ```
   
2. **Navegue até os arquivos**
   ```bash
   cd TodoList-Back
   ```

3. **Instalação de Dependências**
   ```bash
   composer install
   ```
   
4. **Copie o arquivo de exemplo de configuração e ajuste-o:**
   ```bash
   cp .env.example .env
   ```
5. **Gere a chave da aplicação:**
   ```bash
   php artisan key:generate
   ```
6. **Configure o banco de dados no arquivo .env:**
   ```env
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=nome_do_banco
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha
   ```

7. **Execute as migrações e os seeders:**
   ```env
    php artisan migrate --seed
   ```

8. **Inicie o servidor:**
   ```bash
   php artisan serve
   ```

<h2 id="autor">👨‍💻 Autor</h2>
https://github.com/Victordplima
