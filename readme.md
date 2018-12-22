##Laravel Forum

## Getting started

Install the following packages prior to standing up your development environment:

- [Git](https://git-scm.com/)
- [docker](https://docs.docker.com/engine/installation/)
- [docker-compose](https://docs.docker.com/compose/install/)

Set your .env vars and then type:
```
git clone <this_repo>
docker-compose up -d
cp .env.example .env
docker-compose exec php-cli php artisan key:generate
docker-compose exec php-cli composer install
docker-compose exec node yarn install
docker-compose exec node yarn watch
```
## Usage

To start your containers you have only type next command:
```
make docker-up
