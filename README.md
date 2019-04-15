# ldev - Local Web Development with Docker

A minimal framework for local development of web sites, using Docker Compose and Bash.

- Docker Compose defines a local hosting environment that can be started in a single command.
- Bash scripts automate workflow:
  - A build script to checkout and configure source code.
  - A pull script automates migrating data from production and staging environments.
  - An environment script configures the shell to interact with the hosting environment.

## Repository Structure

Base branches:

- `drupal-7`, `drupal-8` -- Host-agnostic Drupal.
- `pantheon-drupal-7`, `pantheon-drupal-8` -- [Pantheon](https://pantheon.io)-hosted Drupal.

Pick a base branch, and create a branch for your project.

You will need to make minor modifications to most files to suit your project.

You can merge base branch changes into your project branch. You can submit PRs on base branches.
