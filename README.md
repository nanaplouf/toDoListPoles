# Projet PHP POO + MongoDB + Nginx (Docker)
## Architecture du projet
```
projetNosql/
│
├── config/
│   ├── Database.php
│   └── Router.php
│
├── public/
│   ├── assets/
│   │   ├── css/style.css
│   │   └── img/
│   └── index.php
│
├── src/
│   ├── Controllers/
│   ├── Models/
│   ├── Utils/
│   └── Views/
│       └── partials/
│
├── composer.json
├── docker-compose.yml
├── Dockerfile
└── nginx.conf
```
## Détails des dossiers
| Dossier/Fichier    |                                                 Description                                                 |
|:-------------------|:-----------------------------------------------------------------------------------------------------------:|
| src/               |                             Contient tout le code applicatif (le cœur du MVC).                              |
| src/Controllers/   |Les classes contrôleurs. Chaque fichier représente une page ou un module du site (ex :  UserController.php). |
| src/Models/        |                       Les modèles : ils gèrent les interactions avec la base MongoDB.                       |
| src/Views/         |                          Les fichiers de vue (HTML/PHP) qui affichent les données.                          |
| config/            |                 Les classes système : routeur, base controller, gestionnaire MongoDB, etc.                  |
| public/            |               Contient les fichiers accessibles depuis le navigateur (index.php, assets/ …).                |
| public/index.php   |            Point d’entrée du site. Il appelle le routeur et charge le contrôleur correspondant.             |
| nginx.conf |                 Configuration du serveur Nginx (route / redirigée vers /public/index.php).                  |
| composer.json      |              Fichier de configuration Composer (autoloader PSR-4, dépendances MongoDB, etc.).               |
| Dockerfile         |                        Image personnalisée PHP + installation de MongoDB + Composer.                        |
| docker-compose.yml |                             Orchestration des conteneurs PHP, Nginx et MongoDB.                             |

## Description des fichiers Docker

- **FROM php:8.2-fpm** → base officielle PHP avec FastCGI.
- **pecl install mongodb** → installe l’extension MongoDB côté PHP.
- **COPY --from=composer** → récupère Composer sans le réinstaller.
- **composer install** → télécharge les dépendances du projet.
- **CMD** → au démarrage, vérifie que vendor/ existe, sinon le crée.

## docker-compose.yml

- **php** : exécute le code PHP + Composer.
- **nginx** : sert les pages web, redirige tout vers /public/index.php.
- **mongo** : base de données NoSQL persistée avec un volume mongo_data.

## nginx.conf

- **root /var/www/html/public** → dossier public du site.
- **try_files** → permet la réécriture d’URL (/user/1 → index.php?url=user/1).
- **fastcgi_pass php:9000** → communique avec le conteneur PHP.

## Fonctionnement général

- Nginx reçoit une requête HTTP.
- Il la redirige vers index.php (grâce au try_files).
- index.php appelle le routeur (souvent dans src/Core/Router.php).
- Le routeur détermine quel contrôleur appeler selon l’URL.
- Le contrôleur appelle le modèle pour interagir avec MongoDB.
- Les données sont passées à la vue, qui s’affiche dans le navigateur.

## Installation et lancement

- Cloner le projet
- Lancer Docker :
```
docker-compose up --build
```
- Executer :
```
docker exec -it php_app composer dump-autoload
```
- Accéder au site
http://localhost:8080