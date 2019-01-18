# Keep babbling and everyone survives - Webservices

API HTTP pour gérer les jeux Kbaes.

## Dépendances

- Serveur LAMP
- php 7.2, laravel framework
  - Modules php: mbstring, xml
- Redis 5.0.3
- laravel echo server (npm)

## Architecture générale

- Un controlleur par modèle qui renvoies à des view pour la partie administration de la BDD
- RaspberryInterface et WebInterface pour les routes relatives au gameplay. (Controlleurs)
- Utilistion intensive d'Eloquent pour tout ce qui est communication avec la base. 
- Certains Model exposent des manipulations de ressources supplémentaire (domain models)
- Utilisation des routes de Broadcast: une pour la board (private-board.{boardid}), une pour le site (private-game.{gameid})
- Utilisation des events: 2 pour la board (RequestNewGame et RequestGameHalt) et 2 pour le site (GameCreatedSuccess et GameUpdate)

### Modèle principal

Rule_Sets est le modèle central des jeux. C'est un ensemble de liaison qui crée les "questions" qui seront envoyées à la board et au site. C'est l'unité la plus importante pour la création des jeux, auxquels elles sont rattachées par une relation multiple (Many to Many). Le ruleset expose la combinaison de LED et renferme la solution aux "modules" joués sur la board. Les rulesets sont exposés au site web afin de fournir au joueur sur le "manuel" de trouver les réponses.

### Gameplay

Les webservices sont au coeur des logiques de gameplay du jeu. Les logiques sont partagées dans 3 fichiers: `App\Http\Controllers\WebInterface`, `App\Http\Controllers\RaspberryInterface` et `App\BO\GameCourseBO`.

WebInterface contient tous les endpoints utiles au site:

- POST /game/start qui lance le jeu avec les options données en body
- GET /game/{id} qui expose le status d'une partie (Les options, le score et l'état)
- GET /game/{id}/abort qui interrompt une partie
- GET /gameBoardModule/{gameid} qui expose la liste des rulesets potentiellement utilisés pour cette partie

