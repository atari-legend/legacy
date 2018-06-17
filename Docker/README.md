# Docker environment for Atari Legend

This environment can be used for local development. It is totally optional, you
can use your preferred tools instead.

Pre-requisites:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

This environment will:
- Setup a MySQL image to run the database
- Setup a PHP image to serve the site, on port 80
- Setup a phpMySql image for database administration, on port 8080

## Running the project

Run `docker-compose up --build` in this folder. This will build all the
required images and start them.

## Database setup

Once the project is running, you need to import the database dump. To do so,
you will run Docker commands to connect to the running MySQL instance in order
to create the database and import the dump. The MySQL instance link name is
`db` as per `docker-compose.yml`.

To connect to the running MySQL instance, you must first identify the virtual
network Docker has setup for it. To do so:

```bash
$ docker network ls

NETWORK ID          NAME                         DRIVER              SCOPE
b5efac899792        atarilegend_default          bridge              local
41e5bd2cef66        bridge                       bridge              local
7424e715f520        docker_default               bridge              local
f03f259428c3        host                         host                local
e188d93a5ba1        none                         null                local
```

The network we want is `atarilegend_default`. You also need to identify the
name of the running MySQL instance:

```bash
$ docker ps

CONTAINER ID        IMAGE                   COMMAND                  CREATED              STATUS              PORTS                  NAMES
d11c59db047e        docker_php              "docker-php-entryp..."   About a minute ago   Up About a minute   0.0.0.0:80->80/tcp     docker_php_1
f6fb94013c05        phpmyadmin/phpmyadmin   "/run.sh phpmyadmin"     14 hours ago         Up About a minute   0.0.0.0:8080->80/tcp   docker_phpmyadmin_1
b9dfeb9e2a87        mysql:5                 "docker-entrypoint..."   14 hours ago         Up About a minute   3306/tcp               docker_db_1
```

In this case: `docker_db_1`

As a result, the Docker commands to interact with the MySQL instance will need
the `--net atarilegend_default` to access the virtual network, and the `--link
docker_db_1:db` to link the command with the running container.

To create the database:

```bash
docker run -it --link docker_db_1:db --net atarilegend_default --rm mysql:5 sh -c 'mysqladmin -hdb -uroot -patari create 'atari-legend''
```

To import the dump:

```bash
docker run -it --link docker_db_1:db --net atarilegend_default -v /path/to/your/dump.sql:/tmp/dump.sql --rm mysql:5 sh -c 'mysql -hdb -uroot -patari atari-legend < /tmp/dump.sql'
```
