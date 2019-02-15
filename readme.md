# GAME log parser

## Task 

Construa um parser para o arquivo de log game.log.

O arquivo game.log é gerado pelo servidor de um GAME PVP(Player vs Player). Ele registra todas as informações dos jogos, quando um jogo começa, quando termina, quem matou quem, quem morreu pq caiu no vazio, quem morreu machucado, entre outros.

O parser deve ser capaz de ler o arquivo(game.log), agrupar os dados de cada jogo, e em cada jogo deve coletar as informações de morte.

### Exemplo

  	21:42 Kill: 1022 2 22: <world> killed novato by MOD_TRIGGER_HURT
  
  O player "novato" morreu pois estava ferido e caiu de uma altura que o matou.

  	2:22 Kill: 3 2 10: novato killed player_um by MOD_RAILGUN
  
  O player "novato" matou o player_um usando a arma Railgun.
  
Para cada rodada do jogo o parser deve gerar algo como:

    game_1: {
	    total_kills: 45;
	    players: ["player_um", "novato", "ZeMoleZa"]
	    kills: {
	      "player_um": 5,
	      "novato": 18,
	      "ZeMoleZa": 20
	    }
	  }

### Observações
1. O arquivo está no repositório https://github.com/jfsc/gameparser
2. Quando o `<world>` mata o player ele perde -1 kill.
3. `<world>` não é um player e não deve aparecer na lista de players e nem no dicionário de kills.
4. `total_kills` são os kills dos games, isso inclui mortes do `<world>`.

## Task 2
Modele uma tabela em um banco de dados relacional como o MySQL e utilize o parser (Task 1) para popular a sua tabela.

Adicione o arquivo para criação da estrutura desse banco de dados na solução.

## Task 3
Após construir o parser construa um ranking geral de kills por jogador com campo de busca por nome do usuário. Os dados deverão ser consultados da tabela gerada na Task 2. **Atenção essa aplicação deve ser um SPA**.

# Requisitos

1. Use a linguagem que você tem mais habilidade.
2. Faça testes unitários, suite de testes bem organizados.
3. Use git e tente fazer commits pequenos e bem descritos.
4. Faça pelo menos um README explicando como fazer o setup, uma explicação da solução proposta, o mínimo de documentação para outro desenvolvedor entender seu código.
5. Siga o que considera boas práticas de programação, coisas que um bom desenvolvedor olhe no seu código e não ache "feio" ou "ruim".

##Informações sobre o desenvolvimento

Escolhi o framework Laravel 5.7 para o desenvolvimento desta aplicação. O Laravel utiliza a linguagem de programação PHP. Já o banco de dados escolhido foi o MySQL.

## Passos para Rodar a Aplicação

1. Baixe ou clone este repositório
2. Edite o arquivo "httpd-vhosts.conf" presente na pasta do Apache (Se usa XAMPP ele está em C:/xampp/apache/conf/extras) e adicione as seguintes configurações:

		<VirtualHost desafio.accenture:80>
				DocumentRoot "C:/xampp/htdocs/desafio-accenture/public/"
				ServerName desafio.accenture
		</VirtualHost>
3. Em seguida edite com permissões de administrador o arquivo "host" do Windows e adicione a seguinte linha:

	<IP DO SERVIDOR>		desafio.accenture

	obs: Substitua <IP DO SERVIDOR> pelo IP do Apache. Por exemplo:

	127.0.0.1		desafio.accenture

4. Utilizando o Composer, abra o CMD e navegue até a pasta raiz do projeto e digite os seguintes comandos:

	composer install

	php artisan key:generate

5. abra o arquivo ".env" e preencha com as configurações do seu banco de dados

6. No CMD ainda dentro da pasta raiz, rode o comando:

	php artisan migrate

7. Pronto! o projeto está configurado. 

## Executando os exercícios

# Task 1

Para executar o task 1, basta digitar em seu navegador desafio.accenture/task1

# Task 2

Para executar o task 1, basta digitar em seu navegador desafio.accenture/task2

# Task 3

Para executar o task 1, basta digitar em seu navegador desafio.accenture/task3



Qualquer dúvida, só comunicar: douglastorr@gmail.com


