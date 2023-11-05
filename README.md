## correiosApi


#### 1) Executar o comando ```composer install```
#### 2) Atualizar o arquivo <b>.env</b> com as informações: 

```
    BASE_URL='https://apihom.correios.com.br/token/v1/'
    USER_LOGIN='LOGIN (FORMATO CNPJ SEM PONTOS)'
    USER_PASSWORD='TOKEN GERADO EM https://cwshom.correios.com.br/acesso-componentes'

    DATABASE_HOST=
    DATABASE_NAME=
    DATABASE_USER=
    DATABASE_PASSWORD=
```

#### 3) Crie a tabela <b>city</b>:

```sql
CREATE TABLE city (
	city_id INT(11) auto_increment NOT NULL PRIMARY KEY,
	city_country varchar(2) NOT NULL,
	city_name varchar(255) NULL,
	city_code varchar(20) NULL
)

```