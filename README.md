# Example7 Docker

## Requirements

- [Docker Compose](https://github.com/docker/compose)
- [platformsh-cli](https://github.com/platformsh/platformsh-cli)
- [Pipe Viewer](http://www.ivarch.com/programs/pv.shtml)
- [jq](https://stedolan.github.io/jq/)
- Ports 80 and 443 on your host system.

On a mac:

```bash
curl -O https://download.docker.com/mac/stable/Docker.dmg
curl -sS https://platform.sh/cli/installer | php
brew install pv jq
```

## Getting Started

1. Shell aliases to run common commands like `drush` and `mysql` inside the correct containers. Open the script to see exactly what commands it sets up.

  ```bash
  source scripts/env
  ```

2. Build -- checks out code and configures it for this local hosting environment.

  ```bash
  build
  ```

3. DNS -- You need to set up your system to resolve the domain names this environment expects to localhost. An easy way to do this is to edit `/etc/hosts` and append:

  ```
  127.0.0.1 example7.localhost search.example7.localhost mail.localhost webgrind.localhost
  ```

4. Start up

  ```
  docker-compose up -d
  ```

  View the status of the environment, port mappings

  ```
  docker-compose ps
  ```

  All set!

  ```
  drush -y si
  drush uli 1 admin/reports/status
  ```

## Usage

### Pulling Content

The pull script [`scripts/pull`](scripts/pull) copies the database, files, and alters the site configuration to run in this local environment.

```bash
# help
pull -h
# pull from test, run database updates, configure for local dev:
pull -cud
```

### Customize

Edit [`.env`](.env) with your own settings.

### Environment Life Cycle

After running `build`, to start up you can init the shell and start up

```bash
source scripts/env && docker-compose up -d
```

Shut down

```bash
docker-compose down

# also removes volumes (drupal files, database files)
docker-compose down -v
```

Clean up -- deletes all code and docker artifacts

```bash
build -c
```

### URLs

- [https://example7.localhost](https://example7.localhost/)
- [http://search.example7.localhost](http://search.example7.localhost/) -- solr
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
