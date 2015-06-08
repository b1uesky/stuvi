# Stuvi

## Workflow

`git pull`

In your homestead VM (homestead ssh):

```bash
composer update
php artisan migrate --seed
```

After adding a database table seeder:

```bash
composer dump-autoload
php artisan db:seed
```

To fix database SQL error message when migrating, go to mysql shell:

```bash
mysql -u root -p
password: secret

drop database homestead;
create database homestead;
```

Go back (ctrl+d) to vagrant:

```bash
php artisan migrate --seed
```

## Administrator

url: `/admin`

If you cannot go to `/admin`, try:

```bash
mkdir config/administrator/settings
```
