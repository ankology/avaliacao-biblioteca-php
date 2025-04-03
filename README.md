# Avaliação Back-End (PHP/Laravel)

## Objetivo

Esta avaliação tem como objetivo avaliar a capacidade técnica em tecnologias utilizadas para desenvolvimento back-end
usando PHP e o framework Laravel consumindo dados de um banco de dados MySQL para criação de uma API (REST).

## Projeto/Repositório (GitHub)

- O link para clone do repositório base está disponível no link [GitHub](https://github.com/ankology/avaliacao-biblioteca-php).
- É necessário ter o Docker instalado
- O projeto está configurado no Docker com os seguintes aspectos:
    - [PHP](https://www.php.net/downloads.php) 8.3.4
    - [Laravel](https://laravel.com/docs/11.x) 11
    - MySQL 8.0
    - Nginx (alpine)
- Para executar o projeto com o docker, execute o comando: `docker compose up -d` dentro da pasta do projeto clonado
- Ao executar o comando, todas as dependências para rodar o projeto já irão ser instaladas e configuradas, basta criar apenas o vínculo do server_name do nginx rodando através do Docker com sua rede local.
  - No Windows, acesse o arquivo hosts (C:\Windows\System32\drivers\etc\hosts) e adicione a linha no final: `127.0.0.1 biblioteca.api`
  - Para testar se o serviço está ativo, basta usar o Postman, Insomnia ou curl para enviar uma requisição para `http://biblioteca.api`
- Com o serviço ativo, crie um arquivo `.env` copiando o conteúdo do `.env.example` que já vai estar com as credenciais e configurações prontas para o teste

## Problemática

O `Cliente` possui uma biblioteca física e deseja informatizar seu negócio criando uma plataforma para armazenar
informações sobre livros, autores, editoras e permitir que usuários frequentadores avaliem livros. <br/>
Foi decidido pela criação de uma API feita em PHP para permitir o consumo dos dados no front-end, ela deve expor rotas
pré-determinadas com uma série de funcionalidades especificadas abaixo. <br/>

## Entidades

| Nome       | Atributos                                                    | 
|------------|--------------------------------------------------------------|
| Livro      | id, editora_id, titulo, data_publicacao, sinopse (opcional)  |
| Editora    | id, nome, descricao (opcional)                               |
| Autor      | id, nome, data_nascimento (opcional), biografia (opcional)   |
| Usuario    | id, nome, email, senha                                       |
| LivroAutor | id, livro_id, autor_id                                       |
| Avaliacao  | id, usuario_id, livro_id, nota (1 a 5), descricao (opcional) |

## Banco de dados

Cabe ao desenvolvedor criar a estrutura de banco de dados que satisfaça os critérios de consumo da API, levando em
conta:

- Nome do banco de dados deve ser `biblioteca` com colação `utf8mb4_general_ci`
- Utilizar nomes de tabelas e colunas em Português
- As tabelas devem seguir o padrão snake_case em suas nomenclaturas, bem como nomes no singular
- As colunas das tabelas devem seguir o padrão snake_case igual os Atributos descritos nas Entidades
- Os tipos de dados para as colunas ficam de livre escolha do desenvolvedor
- É obrigatória a criação de chaves estangeiras (Foreign Keys) para relações entre tabelas
- **Todas** as tabelas devem ter as colunas `criado_em` e `atualizado_em` seguindo o padrão do Laravel 
- **Não** é permitido utilizar exclusão lógica (SoftDelete) nas tabelas
- É permitido usar a ferramenta de `migrations` do Laravel, ou criar a estrutura manualmente

## API (Back-End)

Cabe ao desenvolvedor criar toda a estrutura de pastas, classes para representar Controllers, Services, Modelos e quaisquer outros
elementos necessários para a criação do consumo das rotas, respeitando o padrão REST estabelecido e levando em conta:

- O Modelo de arquitetura usado deve ser `Controller <=> Service <=> Model`
- Todas as rotas devem responder com dados no formato `JSON` e receber dados no formato `JSON`
- Todos os parâmetros de rotas devem ser validados de acordo com o tipo/estrutura de dado esperado
- Todos os dados recebidos das requisições (body) devem ser validados de acordo com os campos informados na sua respectiva `Entidade`,
onde regras implícitas (não informadas) devem ser desenvolvidas de forma livre (Ex: Campo `senha` do `Usuario` ter entre 6 e 20 caracteres, Campo `nome` do `Livro` ter no mínimo um caracter, etc)
- Para simular um processo simples de **autenticação** deverá ser criado um controle de acesso a API, onde apenas as
  requisições que enviarem um header `Authorization` com valor igual á `Bearer token-123` estarão aptas a serem processadas, caso contrário, deverá ser retornado uma resposta de erro com status code `401`
- Espera-se o bom uso das ferramentas incluídas no Laravel

## Rotas
- Toda resposta bem sucedida deverá retornar o status code `200`
- Todas as listagens de `Entidades` devem ser paginadas possibilitando a navegação entre páginas e limite de itens por página através da query string `?page={int}&per_page={int}`, onde por padrão `page=1` e `per_page=15`

## Livro

#### `GET` `/livros`
- Retornar os registros de forma paginada
- Deve retornar nos dados as relações vinculadas de `Editora` e `Autores`
- Ordenar os dados pelo atributo `titulo` de forma `crescente`
- Permitir busca por texto através da query string `?search={string}`

#### `GET` `/livros/{id}`
- Obter um registro por `id`, caso não exista no banco de dados, retornar status code `404`
- Deve retornar nos dados as relações vinculadas de `Editora` e `Autores`

#### `POST` `/livros/{id?}`
- Permitir criar ou editar (caso possua id) um registro
- Permitir opcionalmente vincular autores no ato de criação/edição do livro `{"titulo": "Meu Livro", "autores": [1, 2, 3], ...}` seguindo critérios de atomicidade (transações) na manipulação dos dados no banco de dados
- Validar os dados de acordo com os atributos informados na entidade `Livro` e em caso de erro de validação, retornar status code `422`
- Retornar o registro na resposta juntamente com o id (novo ou existente)

#### `DELETE` `/livros/{id}`
- Permitir deletar um registro, deverá retornar uma resposta com o total de registros deletados
 
#### `POST` `/livros/{id}/autores`
- Permitir vincular autores em lote a um determinado livro
- Caso algum autor já esteja vinculado a esse livro, lançar um erro
- Deve usar o modelo de dados para envio: `{"autores": [int, ...]}`
 
#### `DELETE` `/livros/{id}/autores`
- Permitir desvincular autores em lote de um determinado livro
- Deve usar o modelo de dados para envio: `{"autores": [int, ...]}`

## Editora

#### `GET` `/editoras`
- Retornar os registros de forma paginada
- Ordenar os dados pelo atributo `nome` de forma `crescente`
- Permitir busca por texto através da query string `?search={string}`

#### `GET` `/editoras/{id}`
- Obter um registro por `id`, caso não exista no banco de dados, retornar status code `404`

#### `POST` `/editoras/{id?}`
- Permitir criar ou editar (caso possua id) um registro
- Validar os dados de acordo com os atributos informados na entidade `Editora` e em caso de erro de validação, retornar status code `422`
- Retornar o registro na resposta juntamente com o id (novo ou existente)

#### `DELETE` `/editoras/{id}`
- Permitir deletar um registro, deverá retornar uma resposta com o total de registros deletados

## Autor

#### `GET` `/autores`
- Retornar os registros de forma paginada
- Ordenar os dados pelo atributo `nome` de forma `crescente`
- Permitir busca por texto através da query string `?search={string}`

#### `GET` `/autores/{id}`
- Obter um autor por `id`, caso não exista no banco de dados, retornar status code `404`

#### `POST` `/autores/{id?}`
- Permitir criar ou editar (caso possua id) um registro
- Validar os dados de acordo com os atributos informados na entidade `Autor` e em caso de erro de validação, retornar status code `422`
- Retornar o registro na resposta juntamente com o id (novo ou existente)

#### `DELETE` `/autores/{id}`
- Permitir deletar um registro, deverá retornar uma resposta com o total de registros deletados

## Usuario

#### `GET` `/usuarios`
- Retornar os registros de forma paginada
- Ordenar os dados pelo atributo `nome` de forma `crescente`
- Permitir busca por texto através da query string `?search={string}`
- Não deve expor o campo senha

#### `GET` `/usuarios/{id}`
- Obter um registro por `id`, caso não exista no banco de dados, retornar status code `404`
- Não deve expor o campo senha

#### `POST` `/usuarios/{id?}`
- Permitir criar ou editar (caso possua id) um registro
- Validar os dados de acordo com os atributos informados na entidade `Usuario` e em caso de erro de validação, retornar status code `422`
- Retornar o registro na resposta juntamente com o id (novo ou existente)
- A senha enviada não precisa ser armazenada no formato de hash criptografado

#### `DELETE` `/usuarios/{id}`
- Permitir deletar um registro, deverá retornar uma resposta com o total de registros deletados

## Avaliação

#### `GET` `/avaliacoes`
- Retornar os registros de forma paginada
- Deve retornar nos dados as relações vinculadas de `Usuario` e `Livro`
- Ordenar os dados pelo atributo `criado_em` de forma `decrescente`
- Permitir filtrar de forma opcional avaliações de um determinado `Usuario` através da query string `?usuario_id={int}`
- Permitir filtrar de forma opcional avaliações de um determinado `Livro` através da query string `?livro_id={int}`
- Permitir filtrar de forma opcional avaliações com uma determinada nota `?nota={int}`

#### `GET` `/avaliacoes/{id}`
- Obter um registro por `id`, caso não exista no banco de dados, retornar status code `404`
- Deve retornar nos dados as relações vinculadas de `Usuario` e `Livro`

#### `POST` `/avaliacoes/{id?}`
- Permitir criar ou editar (caso possua id) um registro
- Validar os dados de acordo com os atributos informados na entidade `Avaliacao` e em caso de erro de validação, retornar status code `422`
- Retornar o registro na resposta juntamente com o id (novo ou existente)

#### `DELETE` `/avaliacoes/{id}`
- Permitir deletar um registro, deverá retornar uma resposta com o total de registros deletados

## Considerações finais

- Caso não tenha utilizado a ferramenta de `migrations` do Laravel, gerar dump da estrutura do banco de dados MySQL ao final do teste e anexar o arquivo .sql no próprio projeto
- Tudo o que não tenha sido informado **explicitamente** no requisito poderá ser desenvolvido de forma livre pelo candidato, para justamente dar liberdade e avaliar sua
  criatividade e conhecimento técnico.
- O resultado da avaliação vai levar em conta os seguintes critérios gerais:
    - Estrutura/Organização do Projeto
        - Nomenclatura e estruturação de arquivos/pastas 
        - Consistência e padrões na estrutura/código
    - Conhecimento específico em Laravel
      - Utilização correta de funcionalidades do framework
    - Conhecimento em PHP
        - Utilização de métodos e funcionalidades da linguagem
        - Manipulação de objetos e arrays
        - Estruturação de código
        - Indentação de código
        - Tipagem de código 
- Enviar o link do repositório clonado com o teste finalizado
- **Não** é permitido o uso de consultas em ferramentas de IA, a ideia do teste é avaliar o conhecimento do candidato
