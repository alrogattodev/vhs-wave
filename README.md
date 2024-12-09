# Sistema de Locadora VHS Wave - API RESTful

O **Sistema de Locadora** é uma API RESTful desenvolvida em Laravel para gerenciar clientes, mídias (como filmes, séries ou jogos) e suas respectivas locações. O sistema é projetado para ser simples, eficiente e escalável, permitindo integração com outras aplicações por meio de respostas estruturadas em JSON.

---

## 🚀 **Descrição do Projeto**

O sistema permite:
- Gerenciar clientes e mídias por meio de operações CRUD.
- Registrar locações e devoluções de mídias.
- Incrementar automaticamente os preços das mídias a cada 3 minutos usando cron jobs.
- Processar locações de forma assíncrona utilizando filas (Redis ou MySQL).
- Integrar com sistemas externos via webhooks.

Ideal para locadoras ou empresas que desejam modernizar e automatizar sua gestão de locações.

---

## Detalhes
- Para melhorar a organização, leitura do código, manutenção e melhor separação das responsabilidades utilizei Requests e Resources 
- Os textos, mensagens, variáveis e validações foram escritos em inglês para: 1- facilitação de manutenção por times de outsourcing | 2- facilitar o uso de convenções do Laravel para criação de models, controllers, routes, etc.
- Apesar do desempenho do REDIS ser melhor, utilizei o MySQL para gerenciar as filas por ser mais rápido para configurar em ambiente "caseiro" e ainda assim pode ser adequado para sistemas de baixa escala.
- Foi criado um webhook que pode ser consumido para obter respostas sobre o sucesso ou falha do job de fila.

---

## Backlog (o que pensei em implementar mas não deu tempo)
- Sistema de autenticação e Autorização utilizando Sanctum
- Front-end simples utilizando Bootstrap para propósito de testes
- Maior gama de mensagens de erro e validações, facilitando a identificação de problemas e como consequência sua resolução
- Tipo de mídia no model Medias para expansão da "empresa" permitindo catalogar outros tipos de mídia como games, VHS, cassetes, Blu Rays, etc.
- Configurar Retries e Falhas para os jobs
- Dockerizar o sistema
- Pipeline para deploy
---

## 🛠️ **Tecnologias Utilizadas**

- **Laravel 11**
- **MySQL** (banco de dados)
- **Redis** (para filas)
- **Postman / Insomnia** (para testes de API)

---

## 📋 **Requisitos**

- PHP >= 8.1
- Composer
- MySQL
- Redis (opcional, para filas)
- Extensões PHP:
  - `pdo`
  - `mbstring`
  - `openssl`
  - `redis` (se usado)

---

## 🗂️ **Instalação**

1. Clone o repositório:
   ```bash
   git clone https://github.com/alrogattodev/vhs-wave.git
   ```

2. Entre no diretório do projeto:
   ```bash
   cd rental-system
   ```

3. Instale as dependências:
   ```bash
   composer install
   ```

4. Configure o arquivo `.env`:
   - Configure as credenciais do banco de dados:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=meudatabase
     DB_USERNAME=root
     DB_PASSWORD=sua_senha
     ```
   - Configure o repositório ("banco de dados" das filas) (se necessário):
     ```env
     QUEUE_CONNECTION=redis #(para Redis)
     OU
     QUEUE_CONNECTION=database #(para MySQL, no caso utilizei MySQL por isso existe a migration da tabela jobs)
     ```

5. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

6. Rode as migrações:
   ```bash
   php artisan migrate
   ```

7. Inicie o servidor de desenvolvimento:
   ```bash
   php artisan serve 
   ```
   Ou outro de sua preferência (para o desenvolvimento e fins de informação para compatibilidade, utilizei XAMPP 3.3.0, Apache 2.4.58 e MariaDB 10.4.32)

8. Para processar os Jobs da fila: 
    ```bash
    php artisan queue:work
    ```
9. Testar o Agendamento de incremento de preço:
    ```bash
    php artisan media:increase-price
    ```
    Se tudo estiver funcionando, você verá a mensagem:
    ```bash
    Prices increased by 1 cent for all media.
    ```
10. Para adicionar o agendamento no sistema (no Linux): 
    1. Abra o editor de cron
    ```bash
    crontab -e
    ```
    2. Adicione a seguinte linha:
    ```bash
    * * * * * cd /raiz_do_projeto/ && php artisan schedule:run >> /dev/null 2>&1
    ```


---

## 🛠️ **Funcionalidades Principais**

### **Gerenciar Clientes**
- **Listar Clientes:** `GET /clients`
- **Criar Cliente:** `POST /clients`
- **Atualizar Cliente:** `PUT /clients/{id}`
- **Deletar Cliente:** `DELETE /clients/{id}`

### **Gerenciar Mídias**
- **Listar Mídias:** `GET /medias`
- **Criar Mídia:** `POST /medias`
- **Atualizar Mídia:** `PUT /medias/{id}`
- **Deletar Mídia:** `DELETE /medias/{id}`

### **Gerenciar Locações**
- **Registrar Locações:** `POST /rentals/rent`
- **Registrar Devoluções:** `POST /rentals/{id}/return`

### **Tarefas Automáticas**
- **Incrementar Preços:** Cron job que aumenta o preço das mídias em 1 centavo a cada 3 minutos.

---

## 🔧 **Testando a API**

### Usando Postman ou Insomnia:
1. Configure a URL base:
   ```plaintext
   http://localhost:8000/api/ (supondo que esteja utilizando seu computador e o webserver Apache/nGinx na porta 8000, caso contrário basta alterar)
   ```

2. Adicione as rotas disponíveis:
   - **Clientes:** `/clients`
   - **Mídias:** `/medias`
   - **Locações:** `/rentals`

3. Envie requisições usando os métodos adequados (`GET`, `POST`, `PUT`, `DELETE`).

---

## 📞 **Contato**

- Desenvolvedor: Alberto Rogatto
- Email: [alrogattodev@gmail.com]
- GitHub: [https://github.com/alrogattodev](https://github.com/alrogattodev)

