# Local Web Development with Docker

A minimal framework for local development of web sites, using [Docker Compose](https://docs.docker.com/compose/).

- Defines a local hosting environment using Docker Compose that can be started in a single command.
- Bash scripts automate workflow:
  - A build script checks out and configures source code.
  - A pull script automates migrating data from production and staging environments.
  - An environment script configures the shell to interact with the hosting environment.

Features:

- Aliases to commands running inside containers, e.g. `mysql` instead of `docker-compose exec db mysql --user="$user" --password="$pass" "$db"`.
- [Xdebug](http://www.xdebug.org/) -- PHP debugging, with a command to toggle on/off.
- [Webgrind](https://github.com/jokkedk/webgrind) -- visualize Xdebug profiles.
- [Mailhog](https://github.com/mailhog/MailHog) -- capture outgoing mail.
- [traefik](https://traefik.io) -- reverse proxy and ssl termination.

Similar projects:

- [DDEV](https://www.drud.com)
- [Docksal](https://docksal.io)
- [Drupal VM](https://www.drupalvm.com)
- [Expresso PHP](https://github.com/expresso-php/expresso-php)
- [Lando](https://github.com/lando/lando)
- [docker4drupal](https://github.com/Wodby/docker4drupal)

## Repository Structure

Base branches:

- `drupal-7`, `drupal-8` -- Host-agnostic Drupal.
- `pantheon-drupal-7`, `pantheon-drupal-8` -- [Pantheon](https://pantheon.io)-hosted Drupal.
- `acquia-drupal-7`, `acquia-drupal-8` -- [Acquia](https://www.acquia.com/)-hosted Drupal.
- `platformsh-drupal-7`, `platformsh-drupal-8` -- [platform.sh](https://platform.sh/)

Pick a base branch, and create a branch for your project.

You will need to make minor modifications to most files to suit your project.

You can merge base branch changes into your project branch. You can submit PRs on base branches.
