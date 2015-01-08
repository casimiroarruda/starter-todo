# starter-todo

> Projeto auto contido para uso didádico - Um simples To-Do

### Instalação

##### 1. Obtenha o [Composer](http://getcomposer.org) e instale as dependências do projeto

```
php composer.phar install
```

##### 2. Copie a base de dados

```
cp fixture/empty.sqlite data/db.sqlite
```

##### 3. Copie o arquivo de parâmetros e edite-o para suas necessidades

```
cp application/settings/parameters.yml.sample application/settings/parameters.yml
```

##### 4. Execute com o servidor web do PHP

```
php -S localhost:8080 -t web/ web/index.php
```
