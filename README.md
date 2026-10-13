# 🐘 Integração do PHP com Banco de Dados PostgreSQL

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap_5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white)
![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=xampp&logoColor=white)
![DBeaver](https://img.shields.io/badge/DBeaver-382923?style=for-the-badge&logo=dbeaver&logoColor=white)
![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)
![GitHub](https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white)
![Google Antigravity](https://img.shields.io/badge/Google_Antigravity-4285F4?style=for-the-badge&logo=google&logoColor=white)

---

## 🎓 Projeto Acadêmico

Este repositório consiste em um **projeto acadêmico** desenvolvido no âmbito dos estudos do curso superior na **[Universidade Estácio de Sá](https://estacio.br)**. 

O projeto tem fins educacionais para demonstrar a aplicação prática de conceitos de desenvolvimento web backend, manipulação de banco de dados relacional e arquitetura em camadas no ecossistema PHP.

---

## 🎯 Objetivo

O principal objetivo deste projeto é demonstrar de forma didática e funcional a **integração entre uma aplicação web desenvolvida em PHP e o Sistema Gerenciador de Banco de Dados PostgreSQL**.

A aplicação implementa um fluxo completo de cadastro e listagem de clientes, englobando:
- **Conexão segura com banco de dados** via **PDO** (*PHP Data Objects*), garantindo proteção contra SQL Injection com prepared statements.
- **Gerenciamento seguro de credenciais** e configurações sensíveis através de variáveis de ambiente com a biblioteca `vlucas/phpdotenv`.
- **Arquitetura modular em camadas** baseada no padrão MVC (separando Controllers, Models, Views e Configurações).
- **Interface moderna e responsiva** para interação do usuário, com feedback em tempo real de ações e validações.

---

## 🛠️ Tecnologias Utilizadas

Abaixo estão listadas as tecnologias, ferramentas e bibliotecas empregadas em todo o ciclo de desenvolvimento:

| Tecnologia | Descrição | Badge |
| :--- | :--- | :--- |
| **HTML5** | Estruturação semântica das páginas web | ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white) |
| **Bootstrap 5** | Framework CSS para componentes e grid responsivo | ![Bootstrap](https://img.shields.io/badge/Bootstrap_5-7952B3?style=flat-square&logo=bootstrap&logoColor=white) |
| **PHP** | Linguagem server-side para regras de negócio e manipulação de dados | ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white) |
| **XAMPP** | Ambiente de desenvolvimento local com servidor Apache | ![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=flat-square&logo=xampp&logoColor=white) |
| **Composer** | Gerenciador de dependências PHP (utilizado para gerenciar o `phpdotenv`) | ![Composer](https://img.shields.io/badge/Composer-885630?style=flat-square&logo=composer&logoColor=white) |
| **PostgreSQL** | SGBD relacional robusto utilizado para armazenamento e persistência | ![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=flat-square&logo=postgresql&logoColor=white) |
| **DBeaver** | Ferramenta universal de banco de dados para modelagem, execução de scripts e visualização das tabelas | ![DBeaver](https://img.shields.io/badge/DBeaver-382923?style=flat-square&logo=dbeaver&logoColor=white) |
| **Git** | Sistema de controle de versão distribuído | ![Git](https://img.shields.io/badge/Git-F05032?style=flat-square&logo=git&logoColor=white) |
| **GitHub** | Plataforma de hospedagem de código e controle de versão | ![GitHub](https://img.shields.io/badge/GitHub-181717?style=flat-square&logo=github&logoColor=white) |
| **Google Antigravity** | Assistência e geração da estilização moderna, tipografia, microinterações e acabamento visual | ![Google Antigravity](https://img.shields.io/badge/Google_Antigravity-4285F4?style=flat-square&logo=google&logoColor=white) |

---

## 🎨 Estilização e Design com Antigravity

> [!NOTE]
> **Aviso de Design e UI:** Toda a estilização avançada, harmonia de cores, microinterações e refinamento visual da interface foram desenvolvidos e aprimorados com o auxílio do **Google Antigravity**.

A interface do usuário foi planejada para superar o aspecto simples de um sistema básico, entregando um visual moderno e agradável:
- **Tipografia Moderna:** Integração com a fonte *Plus Jakarta Sans* via Google Fonts.
- **Glassmorphism e Sombreamento Suave:** Aplicação de efeitos de desfoque (`backdrop-filter`) em barras de navegação e cartões.
- **Paleta Harmoniosa:** Esquema de cores refinado com foco em usabilidade, contraste acessível e microanimações interativas em botões e tabelas.
- **Responsividade Completa:** Adaptação fluida para telas de smartphones, tablets e desktops.

---

## 📂 Estrutura do Projeto

```text
├── config/
│   └── conexao.php           # Configuração da conexão PDO com PostgreSQL via .env
├── controllers/
│   └── cliente_controller.php # Controle de requisições, validações e fluxo
├── models/
│   └── cliente_model.php      # Funções de persistência e consulta SQL no banco
├── views/
│   └── listar_clientes.php    # Visualização e listagem dos clientes cadastrados
├── SQL/
│   └── DDL.sql                # Script de criação da tabela 'cliente' no PostgreSQL
├── vendor/                    # Dependências instaladas via Composer (ignorado no git)
├── .env.example               # Exemplo de configuração das variáveis de ambiente
├── composer.json              # Configuração de dependências do projeto
├── index.html                 # Página inicial com formulário de cadastro
├── LICENSE                    # Licença de uso
└── README.md                  # Documentação do projeto
```

---

## 🚀 Como Executar o Projeto

### Pré-requisitos
- **PHP 8.x** instalado (com a extensão `pdo_pgsql` habilitada no `php.ini`)
- **PostgreSQL** instalado e ativo
- **Composer** instalado
- **XAMPP** (ou servidor Apache local configurado)
- **DBeaver** (recomendado para gerenciar e inspecionar o banco)

### Passo a Passo

1. **Clonar o Repositório:**
   ```bash
   git clone https://github.com/jdavi-sc/Integracao-do-PHP-com-banco-de-dados.git
   cd Integracao-do-PHP-com-banco-de-dados
   ```

2. **Instalar Dependências:**
   ```bash
   composer install
   ```

3. **Configurar o Banco de Dados:**
   - No **PostgreSQL** (via DBeaver ou psql), crie o banco de dados desejado.
   - Execute o script contido em `SQL/DDL.sql` para criar a tabela `cliente`.

4. **Configurar as Variáveis de Ambiente:**
   - Duplique o arquivo `.env.example` e renomeie-o para `.env`:
     ```bash
     cp .env.example .env
     ```
   - Preencha com as suas credenciais do banco:
     ```env
     DB_HOST=localhost
     DB_PORT=5432
     DB_NAME=seu_banco
     DB_USER=seu_usuario
     DB_PASSWORD=sua_senha
     ```

5. **Iniciar a Aplicação:**
   - Coloque o projeto no diretório `htdocs` do seu XAMPP e acesse via navegador:
     ```text
     http://localhost/Davi-server/php/Integracao-do-PHP-com-banco-de-dados/index.html
     ```
   - Ou utilize o servidor embutido do PHP:
     ```bash
     php -S localhost:8000
     ```

---

## 👨‍💻 Autor

Desenvolvido por **José Davi**:

- **GitHub:** [@jdavi-sc](https://github.com/jdavi-sc)
- **E-mail:** [josedscosta2005@gmail.com](mailto:josedscosta2005@gmail.com)

---

## 📄 Licença

Este projeto está sob a licença [MIT](LICENSE).