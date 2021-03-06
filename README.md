# A minimal project written in Symfony 2.8 just for educational purposes.

It demonstrates Entities, Controllers, Views, Validation using annotations, CRUD generator, Form Validation,
Unit & Functional testing with fixtures.

## Set up
1. `git clone git@github.com:geobas/minimal-symfony.git`
2. Run `composer update`
3. Run `app/console doctrine:database:create && app/console doctrine:schema:create && app/console doctrine:fixtures:load` from application's root folder.

## Set up unit & functional testing
1. Run `app/console doctrine:database:create --env=test && app/console doctrine:schema:create --env=test && app/console doctrine:fixtures:load --env=test` from application's root folder.

## Run tests
1. Install [entr](http://entrproject.org) to automatically run tests when something changes
2. Execute `find src/ | entr -c phpunit -c app/ src/Lynda/MagazineBundle/Tests` from application's root folder.

## Generate code coverage report after unit tests have run
Execute `phpunit -c app/ --coverage-html cov/`