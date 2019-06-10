# Example8 Docker

## Requirements

- [Docker Compose](https://github.com/docker/compose)
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- [Terminus](https://github.com/pantheon-systems/terminus)
- [Pipe Viewer](http://www.ivarch.com/programs/pv.shtml)
- [jq](https://stedolan.github.io/jq/)

On a mac:

```bash
curl -O https://download.docker.com/mac/stable/Docker.dmg
brew install pv jq
```

## Setup

1. Build -- checks out code and configures it for this local hosting environment:

  ```bash
  ./scripts/build
  ```

2. Optionally edit `.env` with your own settings.

3. DNS -- You need to set up your system to resolve the domain names this environment expects to localhost. An easy way to do this is to edit `/etc/hosts` and append:

  ```
  127.0.0.1 example8.localhost search.example8.localhost mail.localhost webgrind.localhost
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

- [https://example8.localhost](https://example8.localhost/)
- [http://search.example8.localhost](http://search.example8.localhost/) -- solr
- [http://mail.localhost](http://mail.localhost/) -- mailhog
- [http://localhost:8080](http://localhost:8080/) -- traefik
- [http://webgrind.localhost](http://webgrind.localhost/) -- webgrind*
- [http://netdata.localhost](http://netdata.localhost/) -- netdata*

\* if enabled via `.env`

### Debugging

#### Xdebug

[`scripts/env`](scripts/env) defines a function to enable/disable xdebug:

```bash
# enable
xdebug en
# disable
xdebug dis
```

- web -- use an xdebug browser plugin, or add parameter to url
  - debug: `XDEBUG_SESSION_START=A`
  - profile: `XDEBUG_PROFILE=1`
- cli
  - Make sure your IDE supports multiple simultaneous connections -- in PhpStorm search for setting "Max. simultaneous connections" and set to at least 2.
  - [`scripts/env`](scripts/env) defines aliases:
    - debug: `drush-debug`
    - profile: `drush-profile`

This is [remote debugging](https://xdebug.org/docs/remote), so you will need to configure your IDE to map server paths to local paths. Look in the `docker-compose*.yml` files, the php containers declare the mappings as `volumes`.

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
