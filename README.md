# blog

Développez de A à Z le site communautaire SnowTricks

Contexte
Jimmy Sweat est un entrepreneur ambitieux passionné de snowboard. Son objectif est la création d'un site collaboratif pour faire connaître ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).

Il souhaite capitaliser sur du contenu apporté par les internautes afin de développer un contenu riche et suscitant l’intérêt des utilisateurs du site. Par la suite, Jimmy souhaite développer un business de mise en relation avec les marques de snowboard grâce au trafic que le contenu aura généré.

Pour ce projet, nous allons nous concentrer sur la création technique du site pour Jimmy.

Installation

1 - Clonez ou téléchargez le repository GitHub dans le dossier voulu :
git clone https://github.com/christophe13012/snowtricks-p6.git

2 - Configurez vos variables d'environnement en adaptant le fichier .env.

3 - Téléchargez et installez les dépendances back-end du projet avec Composer :
composer install

4 - Téléchargez et installez les dépendances front-end du projet avec Npm :
npm install

5 - Importer le fichier SQL dans votre base de donnée MySQL :
Récupérer snowtricks-p6.sql dans le dossier public/docs

6 - Lancer votre serveur et rendez-vous à l'adresse suivante : http://snowtricks.test/

7 - Lancer webpack : ./node_modules/.bin/encore dev-server --host 0.0.0.0 --disable-host-check

Accès :
Identifiez-vous sur le site avec les identifiants suivants
nom d'utilisateur : christophe13012
mot de passe : snowtrick13
