decoupled-backend
================

Starting point for a decoupled-backend with Symfony 2.8

##Getting Started

####Update your vendors via Composer

```
$ composer install
```

####Fix your permissions

 See [Setting up Permissions](http://symfony.com/doc/2.3/book/installation.html#checking-symfony-application-configuration-and-setup) in the Symfony book.
 
```
$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
```

####Install & dump assetic files

```
$ sh dev-setup.sh
```

####Setup Database

Make sure you have a valid MYSQL user set in parameters.yml first

```
$ app/console doctrine:database:create
$ app/console doctrine:schema:create
```

####JWT Setup

Generate the SSH keys for jwt (make sure to use the pass phrase in parameters.yml)

```
$ mkdir -p app/var/jwt
$ openssl genrsa -out app/var/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem
```

####Create OAuth Client

Run the command below to create an OAuth Client for your URL.  Use the public_id displayed as your client_id on the front end.

```
$ app/console caxy:oauth-server:client:create --redirect-uri='YOUR_URL' --grant-type='authorization_code'
```

##Other Tasks

####Running Tests

```
bin/behat
```
