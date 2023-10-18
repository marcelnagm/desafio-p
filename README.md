desafio-backend-pigz
Desafio para a vaga de desenvolvedor back-end na Pigz.

Regras básicas
Você deverá subir este desafio em um repositório público no seu github pessoal.
Caso não consiga concluir todos os passos, não se preocupe, nos envie mesmo assim o que você fez para que possamos avaliar.
Deverá ser usado preferencialmente o framework Symfony PHP - documentação e outros detalhes sobre este framework você encontra na página Symfony
Desejável que todo o ambiente de desevolvimento seja montado em docker
O Desafio
Durante uma planning com o product owner e stackholders foram definidas as tasks de uma sprint, seguindo a metodologia adotada, cada membro da equipe escolheu suas tasks para realizar. Agora é a sua vez de escolher! Abaixo seguem duas tasks importantes para empresa, defina qual delas irá desenvolver e envie até o prazo estipulado.

Desafio 1
Foi falado durante essa sprint que um cliente entrou em contato solicitando um programa para melhorar a organização de afazeres da propria empresa (to do list), pensando nessa demanda foi enviada um analista de requisitos para verificar o que o cliente queria, chegando lá foi levantado que os usuarios dessa aplicação deverão ter as opções de:

Criar uma lista
Compartilhar uma lista
Deletar uma lista
Adicionar tarefas na lista
Concluir tarefas na lista
Remover uma tarefa
Somente pessoas autorizadas poderão cadastrar outros usuarios
Tipo de arquitetura e comunicação API REST;
DESEJÁVEL: Sistema montado com o padrão de arquitetura API RESTful.
Desafio 2
Foi falado também na mesma sprint, que um cliente de uma concessionária de veículos entrou em contato para criar um sistema com o objetivo de coletar diversas informações sobre veículos. Basicamente seria um sistema em que iria conter anúncios de compra e venda de veículos além da comparação de preços e histórico da tabela FIPE.
Em resumo, seria uma plataforma de negociação de veículos (veículos contendo o máximo de informações possíveis para compra e venda) e pesquisa de preços e histórico da Tabela FIPE. O primeiro passo do projeto, seria construir uma estrutura simples com as seguintes opções:

CRUD para informações do veículo;
CRUD para informações relacionadas a tabela FIPE;
Somente pessoas autorizadas (adminstrador) poderão cadastrar informações do veículo e tabela FIPE (Definir niveís de usuários);
Listagem dos veículos que estão disponíveis para vender;
Comparação do veículo selecionado com a tabela FIPE
DESEJÁVEL: Na listagem de veículos, enviar campo com o cálculo da comparação entre o veículo a venda e tabela FIPE.
Ferramentas e Tecnologias utilizadas/desejáveis:
PHP;
Framework Symfony;
Nginx/Apache;
MySQL/PostgreSQL;
Tipo de arquitetura e comunicação API REST;
DESEJÁVEL: Sistema montado com o padrão de arquitetura API RESTful.
E você foi o encarregado de fazer o backend de uma das aplicações, escolha a que achar melhor Caso a aplicação seja montado em docker, assim que rodamos o comando docker-compose up -d temos que ter a aplicação rodando na porta 8080 do localhost Divirta-se!!
