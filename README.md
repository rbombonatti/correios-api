## correiosApi


#### 1) Executar o comando composer install
#### 2) Atualizar o arquivo <b>.env</b> com as informações: 

```
    BASE_URL='https://apihom.correios.com.br/token/v1/'
    USER_LOGIN='LOGIN (FORMATO CNPJ SEM PONTOS)'
    USER_PASSWORD='TOKEN GERADO EM https://cwshom.correios.com.br/acesso-componentes'
```

#### 3) Instalar MariaDB:

```
    docker pull mariadb
    docker run -d --name [CONTAINER_NAME] -e MYSQL_ROOT_PASSWORD=[DATABASE_PASSWORD] mariadb
    docker exec -it [CONTAINER_NAME] mysql -u root -p
```