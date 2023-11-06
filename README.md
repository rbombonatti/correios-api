## correiosApi


1) Executar o comando ```composer install```
2) Atualizar o arquivo <b>.env</b> com as informações: 

```
    BASE_URL='https://apihom.correios.com.br/token/v1/'
    USER_LOGIN='LOGIN (FORMATO CNPJ SEM PONTOS)'
    USER_PASSWORD='TOKEN GERADO EM https://cwshom.correios.com.br/acesso-componentes'

    DATABASE_HOST=
    DATABASE_NAME=
    DATABASE_USER=
    DATABASE_PASSWORD=
```

3) Crie a tabela <b>city</b>:

```sql
CREATE TABLE city (
	city_id INT(11) auto_increment NOT NULL PRIMARY KEY,
	city_country varchar(2) NOT NULL,
	city_name varchar(255) NULL,
	city_code varchar(20) NULL
)
```

<hr>

4) Crie a tabela <b>customer_order</b>:

```sql
CREATE TABLE customer_order (
	id INT(11) auto_increment NOT NULL PRIMARY KEY,
	order_id VARCHAR(20) NOT NULL,
	customer_id VARCHAR(11) NOT NULL,
	delivery_date DATE NULL,
	order_date DATE NOT NULL,
	order_value DECIMAL(11,2) NOT NULL,
	product_id INT(11) NOT NULL,
	quantity INT(11) NOT NULL,
	order_description LONG VARCHAR NULL
)
```

5) No arquivo <b>read_csv_file.php</b> inclua os dados: 

```
    $dbname = '';
    $usuario = '';
    $senha = '';
```

6) Para acessar a leitura de arquivo csv, no terminal, execute o comando ```php read_csv_file.php [nome_do_arquivo.csv]```

7) Para acessar a busca por países / cidades, ```http://localhost/```
