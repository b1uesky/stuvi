# Stuvi

Read and contribute to [Stuvi Wiki](https://github.com/B1ueSky/stuvi/wiki)!

## Workflow

Pull the latest code.

`git pull`

In your homestead VM (homestead ssh):

```bash
composer update
php artisan migrate --seed
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

After adding a database table seeder:

```bash
composer dump-autoload
php artisan db:seed
```

## Routes

- Admin: `/admin`
- Express: `/express`
