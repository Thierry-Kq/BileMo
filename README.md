# BileMo

### Projet pour le P7 du parcours Developpeur PHP/Symfony avec Openclassrooms

___

### - Comment installer le projet :

```
git clone https://github.com/Thierry-Kq/BileMo.git
cd BileMo
composer install
symfony serve -d
```

Vous devrez configurer un accès à une database locale ou distante dans un fichier .env à la racine du projet (voir format du .env). Vous pouvez ensuite créer la database et lancer les fixtures avec les commande :

```
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
symfony console doctrine:fixtures:load
```

Pour essayer l'application, tout les comptes sont de type : login client-0 (0 à 9) et password azerty.

La documentation de l'Api se trouve sur /v1.

Comme indiqué dans la doc, pour avoir un token il faut envoyer login et password en json sur le endpoint /login. Tout les endpoints nécessitent un token valide, sauf /v1 et /login. 

___

### - Lancer les tests

Pour lancer les tests, vous devez au préalable créer une base de donnée de test (voir la config dans le fichier .env.test.local) :

```
symfony console doctrine:database:create --env=test
symfony console doctrine:migrations:migrate --env=test
symfony console doctrine:fixtures:load --env=test
bin/phpunit
```

___

### - Lien Codacy

Toutes les issues de Codacy proviennent des composants de Symfony ou des librairies externes.

<https://app.codacy.com/gh/Thierry-Kq/BileMo/dashboard?branch=master>


