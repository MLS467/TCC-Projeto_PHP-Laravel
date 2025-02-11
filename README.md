<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


```markdown
# Documentação do Backend

## 1. Introdução

Este backend foi desenvolvido utilizando **Laravel**, com autenticação via **Token** (JWT) para proteger as rotas e permitir o controle de acesso. A API implementa todos os **CRUDs** necessários para gerenciar **atendentes**, **pacientes**, **enfermeiros** e **médicos**, com as devidas relações entre as tabelas.

O objetivo é garantir que os dados sejam acessados e manipulados de forma segura e eficiente, permitindo a integração com o frontend e o sistema de pronto-socorro.

---

## 2. Instalação e Configuração ⚙️

### **Pré-requisitos** 📌
Antes de começar, certifique-se de ter instalado em sua máquina:  
- [PHP](https://www.php.net/) (versão 8.0 ou superior)  
- [Composer](https://getcomposer.org/)  
- [MySQL](https://www.mysql.com/) ou outro banco de dados suportado  

### **Passo 1: Clonar o Repositório** ⬇️
Abra o terminal e execute:
```sh
git clone https://github.com/seu-usuario/seu-repositorio-backend.git
cd seu-repositorio-backend
```

### **Passo 2: Instalar Dependências** 📦  
Se estiver utilizando **Composer**, execute:
```sh
composer install
```

---

## 3. Configuração do Banco de Dados e Variáveis de Ambiente 🛠️

Após clonar o repositório e instalar as dependências, o próximo passo é configurar o ambiente.

### **Passo 1: Criar o Arquivo `.env`**  
Na raiz do projeto, crie um arquivo `.env` baseado no arquivo `.env.example`:
```sh
cp .env.example .env
```

### **Passo 2: Configurar as Variáveis no `.env`**  
Abra o arquivo `.env` e configure as variáveis conforme seu ambiente local. Certifique-se de que a configuração do banco de dados esteja correta:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

Além disso, configure a chave do JWT para autenticação:
```env
JWT_SECRET=base64:seu_token_aqui
```

### **Passo 3: Gerar a Chave do JWT**  
Execute o seguinte comando para gerar a chave secreta do JWT:
```sh
php artisan jwt:secret
```

---

## 4. Rodar o Projeto ▶️

### **Passo 1: Migrate as Tabelas do Banco de Dados**  
Execute o comando para rodar as migrations e criar as tabelas no banco de dados:
```sh
php artisan migrate
```

### **Passo 2: Rodar o Servidor Local**  
Para iniciar o servidor de desenvolvimento:
```sh
php artisan serve
```
O projeto estará disponível em `http://localhost:8000`.

---

## 5. Rodar o Seeder para Popular o Banco de Dados 🌱

Agora que o banco de dados está configurado, você pode rodar o seeder para popular as tabelas com dados iniciais.

### **Rodar o Seeder**  
Execute o seguinte comando para rodar o seeder e inserir dados nas tabelas:
```sh
php artisan db:seed
```

### **Importante**  
O seeder irá inserir múltiplos usuários para as tabelas de **atendentes**, **pacientes**, **enfermeiros** e **médicos**, para garantir que existam dados suficientes para testar as funcionalidades e relacionamentos entre as entidades.

Se precisar rodar seeder específico, utilize:
```sh
php artisan db:seed --class=NomeDoSeeder
```

---

## 6. Links Importantes 📎

### **Dump da Base de Dados**  
adicione a base de dados fazendo a importação da estrutura, incluindo as tabelas e relações entre as entidades:
[Dump da Base de Dados](https://drive.google.com/file/d/1w-fYFOho_4KfXCTLbIph9Vw9jKPWsd2_/view?usp=sharing)

### **Modelagem Inicial do Banco**  
Acesse a modelagem inicial do banco de dados, incluindo as tabelas e relações entre as entidades:
[Modelagem Inicial do Banco de Dados](https://drive.google.com/file/d/1Xs4xpENaoltKIa2G13g54Gv5vtmpRBGH/view?usp=sharing)

### **Diagrama de Classes**  
Confira o diagrama de classes que descreve as relações entre os modelos e as funcionalidades do sistema:
[Diagrama de Classes](https://drive.google.com/file/d/1wDwkcZDh9pAq-v4lge8P2W5Ws4xlrA38/view?usp=sharing)

---

Agora você está pronto para rodar e testar a API com autenticação via token, CRUDs completos e dados populados para os usuários e suas profissões! 🚀

