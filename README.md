DESIGNMYHERO - Student Project
=======

A Symfony project created on February 2, 2017, 12:26 am.
 
* Le Framework Back-end est Symfony configuré comme une API REST
* Le projet est écrit en ES6 et transpilé en ES5 (merci Babel)
* Le Framework Front-end est Angular 1
* Le Framework WebGL est Three.js

# Préparer le projet en dev

* `composer install` - préparation de symfony
* `php bin/console doctrine:database:create` - créé la DB
* `npm install` - pour installer les dépendances de dev (utilisé pour gulp)
* `bower install` - pour installer les dépendances front
* `gulp vendor` - à chaque fois qu'on rajoute un bower component
* `gulp` - pour la tâches par défaut qui met un watch sur les fichiers html, scss et js

A l'aide de ces commandes, vous pourrez travailler efficacement ! :)

# Travailler avec Git

Nous utiliserons le GitFlow (un peu modifié) suivant

http://danielkummer.github.io/git-flow-cheatsheet/index.fr_FR.html

* La branche master ne doit pas être touché en dehors de `Merge Request`
* Pour tout nouvel ajout créer une branche `feature/ma-feature`
* Pour tout debug créer une branche `fix/mon-fix`
* une fois que la `feature` ou le `fix` est prêt, on fait une `Merge Request` sur `staging`
* On essaye le code sur staging avec un `git checkout staging` et si tout est bon, on fait de nouveau un `Merge Request` sur Master
* Le code doit être relu par une autre personne
* On repart toujours de master pour créer une branche
    * Créer une branche avec `git checkout -b ma-branche`
    
# Nos outils

## Back-end

* Symfony 3.2
* FOSRestBundle
* JMSSerializer
* FOSJsRouting

## Front-end

### Gulp

* Ajouter Wiredep ??? 

### Angular

* https://github.com/mgonto/restangular - Restangular
* https://github.com/marmelab/ng-admin - ng-admin


### TO DO
https://www.developpez.net/forums/d1159168/php/bibliotheques-frameworks/symfony/upload-fichier-zip-decompresser/
http://stackoverflow.com/questions/29890729/symfony-2-unzip-a-zip-file-upload-folder-permissions
https://www.theodo.fr/blog/2015/07/manage-multiple-files-upload-in-symfony/
https://gist.github.com/beberlei/978346
