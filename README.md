# improv-web

[![](https://img.shields.io/travis/improv-ee/improv-web.svg)](https://travis-ci.org/improv-ee/improv-web)
[![Maintainability](https://api.codeclimate.com/v1/badges/54f0ebd5a83319def11a/maintainability)](https://codeclimate.com/github/improv-ee/improv-web/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/54f0ebd5a83319def11a/test_coverage)](https://codeclimate.com/github/improv-ee/improv-web/test_coverage)
[![](https://img.shields.io/docker/pulls/improv/improv-web.svg)](https://cloud.docker.com/u/improv/repository/registry-1.docker.io/improv/improv-web)

This is the source code for https://improv.ee, a website dedicated to listing information and events about improvised theatre.


## Development

Configuration instructions are provided for a Linux (Ubuntu) based development environment.

### Needs to be installed

- [Docker][] (latest)
- [Docker Compose][] (latest)
- `openssl` (`apt-get install openssl`)
- [Composer][]
- [npm][]

### Setup

Install vendor packages:

```bash
cd src
composer install
npm install
```

Run the setup script:

```bash
./setup.sh
```

This will generate a new self-signed CA and certificates for local development. You need to
install your new Certificate Authority into your web browser. [Here is how](https://wiki.wmtransfer.com/projects/webmoney/wiki/Installing_root_certificate_in_Mozilla_Firefox)
to do it for Firefox (`Settings -> Certificate Authorities -> Add`). The CA file for importing
is `docker/lb/certs/ca.crt`. If done correctly, this will make `https://` "green" for our dev domains:

`web.local.improv.ee` will be the frontend webserver
`api.local.improv.ee` will be the API

DNS entries are already configured in global DNS to point to `127.0.0.1`.

Review settings in `src/.env` - this will be your local conf.

Bring up services:

```bash
docker-compose up
```

You need to bootstrap the database (once) and set up Laravel.

```bash
docker-compose run webserver bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan passport:install
```

If all goes well you should have Docker containers running, database bootstrapped and webpages
(with green HTTPS) opening on `web.local.improv.ee` and `api.local.improv.ee`.


## API documentation

API documentation is generated from API source code using [apidoc-generator](https://github.com/mpociot/laravel-apidoc-generator).
To change it, change PHP code comments on API controllers (`src/app/Http/Controllers/Api/`).

### Regenerate documentation

Run:

```bash
$ php artisan apidoc:generate
```

Open `public/doc/index.html` with a local webbrowser.

## External services in use

### AWS S3

S3 buckets are used for data storage (ex: uploaded images). See `config/filesystems.php` for more.

### Google Cloud

Google Translate is used for translating text and fetching Places information - see `config/googletranslate.php` for more


## Contributing

Want to help? Great - submit a pull request or an issue.

## License

Licensed under Apache-2.0 license.

[Docker]: https://docs.docker.com/install/linux/docker-ce/ubuntu/
[Docker Compose]: https://docs.docker.com/compose/install/
[Composer]: https://getcomposer.org/download/
[npm]: https://www.npmjs.com/get-npm
