# pizza-monorepo

* Laravel as backend
* Nuxt as frontend

## Up
```sh
./up.sh
```

# URL
http://localhost:3000/

# Credentials
`admin@example.org`:`admin`

## Down
```sh
./down.sh
```

## Requirements

* Docker-compose https://docs.docker.com/compose/install/

## Outside localhost

Laravel .env file must contain `SANCTUM_STATEFUL_DOMAINS` record equals to `hostname:port,hostname2:port2` of public domains, from which requests to `/api/` are being made
