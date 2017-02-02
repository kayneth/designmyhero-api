DESIGNMYHERO - Student Project
=======

A Symfony project created on February 2, 2017, 12:26 am.
 
* Le Framework Back-end est Symfony configuré comme une API REST
* Le projet est écrit en ES6 et transpilé en ES5
* Le Framework Front-end est Angular 1
* Le Framework WebGL est Three.js

# Préparer le projet en dev

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