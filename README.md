# 🚀 Onboard - Sistema de Gerenciamento de Viagens

Sistema completo para gerenciamento de solicitações de viagens corporativas, desenvolvido com Laravel (back-end) e Vue.js (front-end).

## 📋 Índice

- [Tecnologias Utilizadas](#-tecnologias-utilizadas)
- [Pré-requisitos](#-pré-requisitos)
- [Instalação e Configuração](#-instalação-e-configuração)
- [Como Executar](#-como-executar)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Testes](#-testes)
- [Funcionalidades](#-funcionalidades)
- [Troubleshooting](#-troubleshooting)

## 🛠 Tecnologias Utilizadas

### Back-end
- **Laravel 12.x** - Framework PHP
- **MySQL 8.0** - Banco de dados
- **PEST** - Testes

### Front-end
- **Vue.js 3** - Framework JavaScript
- **Vue Router** - Gerenciamento de rotas
- **Axios** - Requisições HTTP
- **Vite** - Build tool

### DevOps
- **Docker** - Containerização
- **Docker Compose** - Orquestração de containers
- **Nginx** - Servidor web

## 📦 Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/) (v20.10+)
- [Docker Compose](https://docs.docker.com/compose/install/) (v2.0+)
- Git

## ⚙️ Instalação e Configuração

### 1. Clone o Repositório

```bash
git clone https://github.com/seu-usuario/OnBoard.git
cd OnBoard
```

### 2. Configure as Variáveis de Ambiente

#### Back-end (Laravel)

Copie o arquivo `.env.example` e configure:

```bash
cd backend
cp .env.example .env
```

Edite o arquivo `.env` com as seguintes configurações:

```env
APP_NAME=Onboard
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=username
DB_PASSWORD=userpass
```

#### Front-end (Vue.js)

```bash
cd frontend
cp .env.example .env
```

Configuração do `.env` do front-end:

```env
VITE_API_BASE_URL=http://localhost:8080
```

### 3. Suba os Containers

Na raiz do projeto:

```bash
docker-compose up -d
```

### 4. Instale as Dependências e Configure o Laravel

```bash
# Acesse o container do Laravel
docker exec -it laravel-backend bash

# Instale as dependências
composer install

# Gere a chave da aplicação
php artisan key:generate

# Execute as migrations
php artisan migrate

# (Opcional) Execute os seeders para popular o banco
php artisan db:seed

# Saia do container
exit
```

### 5. Instale as Dependências do Vue.js

```bash
# Acesse o container do Vue
docker exec -it vue-frontend sh

# Instale as dependências
npm install

# Saia do container
exit
```

## 🚀 Como Executar

Os containers já estarão rodando após o `docker-compose up -d`. Acesse:

- **Front-end (Vue.js)**: http://localhost:5173/login
- **Back-end API (Laravel)**: http://localhost:8080/api
- **PHPMyAdmin**: http://localhost:8989
  - Servidor: `db`
  - Usuário: `username` (ou `root`)
  - Senha: `userpass` (ou `root`)

### Comandos Úteis

```bash
# Ver logs dos containers
docker-compose logs -f

# Parar os containers
docker-compose down

# Reiniciar os containers
docker-compose restart

# Acessar o container do Laravel
docker exec -it laravel-backend bash

# Acessar o container do Vue
docker exec -it vue-frontend sh

# Limpar cache do Laravel
docker exec laravel-backend php artisan cache:clear
docker exec laravel-backend php artisan config:clear
docker exec laravel-backend php artisan route:clear
```

## 📁 Estrutura do Projeto

```
onboard/
├── backend/                 # Aplicação Laravel
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   └── Resources/
│   │   ├── Models/
│   │   ├── Services/
│   │   ├── Enums/
│   │   └── Exceptions/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── routes/
│   │   └── api.php
│   └── tests/
├── frontend/                # Aplicação Vue.js
│   ├── src/
│   │   ├── components/
│   │   ├── composables/
│   │   ├── views/
│   │   ├── router/
│   │   └── utils/
│   └── package.json
├── docker/
│   └── nginx/
│       └── default.conf
└── docker-compose.yml
```

## 🧪 Testes

### Testes do Back-end (Laravel)

```bash
# Acessar o container
docker exec -it laravel-backend bash

# Rodar todos os testes
php artisan test

# Rodar testes específicos
php artisan test --filter=NomeDoTeste
```

## ✨ Funcionalidades

### Back-end (API REST)

- ✅ Autenticação JWT/Sanctum
- ✅ CRUD de Viagens
- ✅ Sistema de Aprovação/Cancelamento
- ✅ Controle de Permissões (Policies)
- ✅ Service Layer Pattern
- ✅ API Resources para serialização
- ✅ Validação de Requests
- ✅ Notificações por e-mail
- ✅ Cache com Redis

### Front-end (SPA)

- ✅ Autenticação de Usuários
- ✅ Dashboard com Estatísticas
- ✅ Listagem e Filtros de Viagens
- ✅ Criação/Edição de Solicitações
- ✅ Busca por ID
- ✅ Filtros por Status, Destino e Data
- ✅ Notificações Toast
- ✅ Responsive Design

## 🐛 Troubleshooting

### Problema: Permissões de arquivo

```bash
# No container do Laravel
docker exec -it laravel-backend bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Problema: Containers não sobem

```bash
# Limpe os containers e volumes
docker-compose down -v
docker-compose up -d --build
```

### Problema: Erro de conexão com o banco

- Verifique se o container `db` está rodando: `docker ps`
- Aguarde ~30 segundos após o `docker-compose up` para o MySQL inicializar
- Verifique as credenciais no `.env`

### Problema: CORS no front-end

Adicione no `backend/config/cors.php`:

```php
'allowed_origins' => ['http://localhost:5173'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### Problema: Vue não conecta na API

Verifique se o `VITE_API_BASE_URL` no `.env` do front-end está correto:

```env
VITE_API_BASE_URL=http://localhost:8080
```

## 📝 Seeders Disponíveis

```bash
# Popular cargos de usuarios
php artisan db:seed --class=RoleSeeder

# Popular usuários de exemplo
php artisan db:seed --class=UserSeeder

# Popular status de viagem
php artisan db:seed --class=StatusSeeder

# Popular destinos
php artisan db:seed --class=DestinationSeeder

# Popular tudo
php artisan db:seed
```

## 🔐 Credenciais Padrão (Após Seeders)

- **Admin**: admin@onboard.com / password
- **User**: user@onboard.com / password

