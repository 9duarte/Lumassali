# Lumassali

Aplicação PHP para apresentar a tabela de preços do café Lumassali, gerir os preços
através de uma área reservada e mostrar as próximas passagens de autocarro.

## Funcionalidades

- Tabela pública de preços organizada por secções.
- Login e área administrativa.
- Alteração manual de preços.
- Atualização de preços através de ficheiros Excel.
- Endpoint JSON com as próximas passagens na paragem Agrinha (Carreira).
- Cache temporária das respostas da API de transportes para reduzir pedidos
  externos.

## Requisitos

- PHP 7.4 ou superior.
- MySQL/MariaDB com as extensões `mysqli` e `mbstring`.
- Extensão PHP `curl` para o endpoint de autocarros.
- Composer.
- Servidor web (Apache, Nginx ou o servidor integrado do PHP).

## Instalação

1. Clone o repositório e entre na pasta do projeto:

   ```bash
   git clone <url-do-repositorio>
   cd Lumassali
   ```

2. Instale as dependências:

   ```bash
   composer install
   ```

3. Crie o ficheiro `.env` a partir do exemplo:

   ```bash
   cp .env.example .env
   ```

   No Windows PowerShell, pode usar:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Preencha o `.env` com os dados da base de dados:

   ```dotenv
   DATABASE_HOST=localhost
   DATABASE_USER=utilizador
   DATABASE_PASS=password
   DATABASE_NAME=lumassali
   ```

   O ficheiro `.env` não deve ser commitado. As variáveis são carregadas em
   `db/conexao.php` através do `phpdotenv`.

5. Configure a base de dados com as tabelas necessárias pela aplicação,
   incluindo:

   - `administrator`, usada na autenticação dos administradores;
   - `secoes_produtos`, usada para as secções e produtos apresentados na
     tabela de preços.

## Execução local

Com o servidor integrado do PHP:

```bash
php -S localhost:8000
```

Depois, abra [http://localhost:8000](http://localhost:8000).

A página pública é `index.php`. A área administrativa está disponível em
`login.php` e requer um utilizador existente na tabela `administrator`.

## Importação de preços por Excel

Na área administrativa é possível carregar ficheiros `.xlsx` ou `.xls`.
A importação usa a folha ativa e lê:

- coluna `A`: código do produto (`codigo`);
- coluna `F`: novo preço (`preco`).

Os dados são aplicados à tabela `secoes_produtos` através do
`importarExcel.php`. A primeira linha é tratada como cabeçalho e não é
importada.

## Endpoint de autocarros

O ficheiro `proximos_autocarros.php` consulta os endpoints públicos do Qmob e
devolve JSON. Pode ser usado diretamente:

```text
/proximos_autocarros.php
```

Existe um modo de teste sem pedidos externos:

```text
/proximos_autocarros.php?test=1
/proximos_autocarros.php?test=vazio
/proximos_autocarros.php?test=falha
```

O ficheiro `cacert.pem` é utilizado para validar os certificados TLS dos
pedidos cURL.

## Estrutura principal

| Ficheiro/pasta | Descrição |
| --- | --- |
| `index.php` | Tabela pública de preços |
| `login.php` | Formulário de autenticação |
| `loginVerification.php` | Validação do login |
| `admin.php` | Gestão manual e upload de preços |
| `adminInserir.php` | Gravação das alterações manuais |
| `importarExcel.php` | Importação de preços a partir de Excel |
| `proximos_autocarros.php` | Endpoint/cache das próximas passagens |
| `db/conexao.php` | Carregamento do `.env` e ligação à base de dados |
| `css/` | Folhas de estilo |
| `images/` | Imagens utilizadas pela aplicação |

## Segurança

- Nunca coloque credenciais diretamente no código ou no repositório.
- Mantenha o `.env` apenas no ambiente onde a aplicação é executada.
- Use HTTPS em produção.
- Garanta que os ficheiros de configuração e logs não ficam acessíveis
  publicamente pelo servidor web.
