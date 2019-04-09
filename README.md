# Example7 Docker

## Setup

1. Install
  -   [Docker](https://www.docker.com/community-edition)
  -   [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

  The pull script requires a few common utilities. On a mac:

  ```bash
  brew install pv jq
  ```

  -   [pv](http://www.ivarch.com/programs/pv.shtml)
  -   [jq](https://stedolan.github.io/jq/)

2. Build -- checks out code and configures it for this local hosting environment:

  ```bash
  ./scripts/build
  ```

3. Optionally edit `.env` with your own settings.

4. DNS -- You need to set up your system to resolve the domain names this environment expects to localhost. An easy way to do this is to edit `/etc/hosts` and append:

  ```
  127.0.0.1 example7.localhost search.example7.localhost mail.localhost webgrind.localhost netdata.localhost
  ```

  Note in `.env` you can configure different domain names.

## Start up

1. Start up docker containers:

  ```bash
  docker-compose up -d
  ```

  Note this will try to claim ports 80 and 443 on your host system. If you're already running a web server, this step will fail.

2. Shell aliases to run common commands like `drush` and `mysql` inside the correct containers. Open the script to see exactly what commands it sets up.

  ```bash
  source scripts/env
  ```

3. Pull content.

  The pull script [`scripts/pull`](scripts/pull) copies the database, files, and alters the site configuration to run in this local environment.

  ```bash
  # help
  pull -h
  # pull from test, run database updates, configure for local dev:
  pull -cud
  ```

## Usage

### URLs

-   [https://example7.localhost](https://example7.localhost/)
-   [http://search.example7.localhost](http://search.example7.localhost/) -- solr
-   [http://mail.localhost](http://mail.localhost/) -- mailhog
-   [http://localhost:8080](http://localhost:8080/) -- traefik
-   [http://webgrind.localhost](http://webgrind.localhost/) -- webgrind*
-   [http://netdata.localhost](http://netdata.localhost/) -- netdata*

\* if enabled via `.env`

### Search

To use search, populate solr index

```bash
# speed up by disabling stage file proxy
drush -y dis stage_file_proxy
drush sapi-c && drush sapi-i 0 0 25
drush -y en stage_file_proxy
```

### Single-Sign-On

If you got to [https://nahlink.localhost](https://nahlink.localhost) as an anonomous user, you get redirected to `http://idp.nahlink.localhost/simplesaml/module.php/core/loginuserpass.php?AuthState...`. This identity provider (IdP) is a simple mock NAH authentication service -- you can view/edit the users you can log in as in [conf/idp/authsources.php](conf/idp/authsources.php).

### Debugging

#### Xdebug

[`scripts/env`](scripts/env) defines a function to enable/disable xdebug:

```bash
# enable
xdebug en
# disable
xdebug dis
```

-   web -- use an xdebug browser plugin, or add parameter to url
    -   debug: `XDEBUG_SESSION_START=A`
    -   profile: `XDEBUG_PROFILE=1`
-   cli
    -   Make sure your IDE supports multiple simultaneous connections -- in PhpStorm search for setting "Max. simultaneous connections" and set to at least 2.
    -   [`scripts/env-nahlink`](scripts/env-nahlink) / [`scripts/env-nahealth`](scripts/env-nahealth) defines aliases:
        -   debug: `drush-debug`
        -   profile: `drush-profile`

This is [remote debugging](https://xdebug.org/docs/remote), so you will need to configure your IDE to map server paths to local paths:

-   `/var/www/web` -> `[path_to_this_repo]/code/example7`
-   `/var/www/drush` -> `[path_to_this_repo]/code/drush`


#### Profile with Webgrind

To use [webgrind](https://github.com/jokkedk/webgrind) to profile php, uncomment the line in your [`.env`](env_example).

```bash
COMPOSE_FILE=docker-compose.yml:docker-compose.debug.yml
```

and run up again to rebuild containers

```bash
docker-compose up -d
```

### Logging

```bash
# all logs
docker-compose logs
# follow (stream log to stdout)
docker-compose logs -f
```

### Clean up

Delete containers. `-v` will also delete volumes (database, files).

```bash
docker-compose down -v
```
