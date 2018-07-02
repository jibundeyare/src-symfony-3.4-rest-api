# Symfony rest api

## Install

    git clone https://github.com/jibundeyare/src-symfony-rest-api.git
    cd src-symfony-rest-api
    composer install

- `database_host` : l'adresse ip du serveur de BDD (`127.0.0.1` si vous installez sur votre poste de dev)
- `database_port` : `3306` en général mais il faut vérifier si vous utilisez MAMP
- `database_name` : le nom de la BDD (utilisez le nom du projet, `src_symfony_rest_api` dans notre cas)
- `database_user` : le nom de l'utilisateur qui a accès à la BDD
- `database_password` : le mot de passe de l'utilisateur qui a accès à la BDD

La partie mailer n'est pas importante

## Créer la BDD

    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create
