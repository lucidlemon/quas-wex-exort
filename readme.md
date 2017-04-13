## Useful Links

[dota 2 cdn paths](http://dev.dota2.com/showthread.php?t=58317)

[vuejs fetch](https://github.com/pagekit/vue-resource)


# Installation

Basic Requirements for running the php installation
* install valet or virtualbox
* install composer
* `composer install`
* `yarn` or `npm install`

now to make it working in your demo application:
* `cp .env.example .env`
* set up mysql settings in .env
* `php artisan key:generate`
* `php artisan passport:install` // may take some time
* `php artisan migrate --seed`
