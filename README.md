# MakemyTripweb

Il 'agit d'une application web de gestion d'une agence de voyage réalisé avec Symfony .


Set environment variables in .env; you'll need a db, a mailer and recaptcha keys. Then run


$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate
