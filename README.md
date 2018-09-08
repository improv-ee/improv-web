# improv.ee v2


## Development

### Needs to be installed

- Docker (latest)
- Docker Compose (latest)

Run the setup script:

```bash
./setup.sh
```

[Generate](https://github.com/FiloSottile/mkcert) a self-signed certificate for `dev.improv.ee`
and place it into `docker/lb/certs/server.crt` (with CA chain, private key is in `server.key`).

Bring up services:

```bash
docker-compose build
docker-compose up
```