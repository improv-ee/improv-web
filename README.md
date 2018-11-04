# improv.ee v2

This is the source code for https://improv.ee, a website dedicated to listing information and events about improvised theatre.

**It is very much in development stages.**


## Development

### Needs to be installed

- Docker (latest)
- Docker Compose (latest)

### Setup

Add `dev.improv.ee` to `/etc/hosts` as `127.0.0.1`.

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

## Deployment to a DigitalOcean Droplet

```bash
$ export DIGITALOCEAN_TOKEN=xxxx
$ cd terraform
$ terraform init
$ terraform apply

# Check that all resources created OK in DO
# Map domain name to floating IP

$ cd ../ansible

# Save vault token
$ nano .vault 
$ ansible-playbook -i hosts playbooks/all.yml
```



## Contributing

Want to help? Great - submit a pull request or an issue.

## License

Licensed under Apache-2.0 license.