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

- POST /game/start qui lance le jeu avec les options données en body __broadcast__ evrs la board
- GET /game/{id} qui expose le status d'une partie (Les options, le score et l'état)
- GET /game/{id}/abort qui interrompt une partie
- GET /gameBoardModule/{gameid} qui expose la liste des rulesets potentiellement utilisés pour cette partie

RaspberryInterface ceux utiles à la board (et à la course du jeu):

- POST /game/{id}/confirm Confirme la bonne réception d'une demande de jeu. Donne l'acceptation sous forme de 'OK' ou 'KO' __broadcast__ vers le site
- POST /game/{gameid}/answer/{rsid} Donne la réponse au couple jeu/ruleset auquel la board vient de répondre, renvoie le résultat de la réponse ainsi que la suite de la partie (has_next et next_ruleset si besoin) __broadcast__ vers le site
- GET /game/{id}/current /unused/
- POST /game/{id}/timesup Reçoit une notification de temps écoulé, __broadcast__ vers le site

Le GameCourseBO contient les logiques hors transferts HTTP pour alléger les controlleurs, notemment l'attribution des rulesets à un jeu lors de sa création et la comparaison des réponses reçues et des réponses attendues.

### Déroulé d'une partie

- __website__ > /api/game/start (w/ options, res: game id)
- __API__ > Broadcast Raspberry\RequestNewGame (w/ options)
- __Board__ > /api/game/x/confirm (res: next ruleset)
- __Api__ > Broadcast Website\GameCreatedSuccess
- __Website__ > /api/gameBoardModule/x (res: Liste des rulesets potentiels)
- __Board__ > /api/game/x/answer/y (w/ answer, res: next ruleset)
- __Api__ > broadcast Website\GameUpdate (w/ results)
- Répéter les deux dernières étapes jusqu'à la fin de la partie
- ? __Board__ > /api/game/x/timesup
- ? __Api__ > broadcast Website\GameUpdate

