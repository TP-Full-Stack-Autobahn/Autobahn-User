# Autobahn-User
API Made fromscratch

## Configuration 

- Complete env file

## Install 

```bash
composer install
```

### Run migrations 

```bash
php bin/console doctrine:migrations:migrate || symfony doctrine:migrations:migrate
```

### Run fixtures 

```bash
php bin/console doctrine:fixtures:load || symfony doctrine:fixtures:load
```

### Build and deploy in local

```bash
php bin/console symfony server:start -d || sympfony server:start -d
```