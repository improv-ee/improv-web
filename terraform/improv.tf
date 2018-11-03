# Configure the DigitalOcean Provider
provider "digitalocean" {

}

resource "digitalocean_tag" "tag-web" {
  name = "server:web"
}

resource "digitalocean_tag" "tag-mariadb" {
  name = "server:mariadb"
}

resource "digitalocean_tag" "tag-redis" {
  name = "server:redis"
}

resource "digitalocean_tag" "tag-improv" {
  name = "owner:improv"
}

resource "digitalocean_volume" "improv-mariadb" {
  region = "fra1"
  name = "improv-database"
  size = 3
  initial_filesystem_type = "ext4"
  description = "improv.ee MariaDB database"
}

resource "digitalocean_volume" "improv-storage" {
  region = "fra1"
  name = "improv-storage"
  size = 2
  initial_filesystem_type = "ext4"
  description = "improv.ee application blob storage"
}


resource "digitalocean_droplet" "improv-webserver" {
  image = "ubuntu-18-04-x64"
  name = "public-1.improv.ee"
  region = "fra1"
  size = "s-1vcpu-1gb"
  backups = false
  monitoring = false
  ipv6 = false
  private_networking = true
  ssh_keys = [
    "aa:a8:b6:d6:fb:87:ce:ba:f4:bc:c6:86:9a:73:05:95",
    "6d:b3:e4:f2:ba:68:f7:a2:19:52:3e:84:58:2d:97:dc"
  ]
  tags = [
    "${digitalocean_tag.tag-improv.id}",
    "${digitalocean_tag.tag-mariadb.id}",
    "${digitalocean_tag.tag-redis.id}",
    "${digitalocean_tag.tag-web.id}",
  ]
}


resource "digitalocean_volume_attachment" "improv-droplet-volumes" {
  droplet_id = "${digitalocean_droplet.improv-webserver.id}"
  volume_id = "${digitalocean_volume.improv-mariadb.id}"
}


resource "digitalocean_floating_ip" "improv-public-ip" {
  droplet_id = "${digitalocean_droplet.improv-webserver.id}"
  region = "${digitalocean_droplet.improv-webserver.region}"
}

resource "digitalocean_firewall" "improv-firewall" {
  name = "improv-firewall"

  droplet_ids = [
    "${digitalocean_droplet.improv-webserver.id}"]

  inbound_rule = [
    {
      protocol = "tcp"
      port_range = "22"
      source_addresses = [
        "0.0.0.0/0"]
    },
    {
      protocol = "tcp"
      port_range = "80"
      source_addresses = [
        "0.0.0.0/0",
        "::/0"]
    },
    {
      protocol = "tcp"
      port_range = "443"
      source_addresses = [
        "0.0.0.0/0",
        "::/0"]
    },
    {
      protocol = "icmp"
      source_addresses = [
        "0.0.0.0/0",
        "::/0"]
    },
  ]

  outbound_rule = [
    {
      protocol = "udp"
      port_range = "1-65535"
      destination_addresses = [
        "0.0.0.0/0",
        "::/0"]
    },
    {
      protocol = "tcp"
      port_range = "1-65535"
      destination_addresses = [
        "0.0.0.0/0",
        "::/0"]
    },
  ]
}