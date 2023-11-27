
# SnowTricks_Projet6_OpenClassrooms

Création d'un site communautaire de partage de figures de snowboard via le framework Symfony.



## Environnement utilisé durant le développement

- Symfony 6.1
- Composer 2.5.8
- XAMPPServer: ->control panel:3.33.0    ->Apache: 2.4.5        ->Mysql: 5.2.1 
->PHP: 8.1.5
- Css Framework + Icon toolkit bootstrap : 5.1.3 font-awesome 4



## Installation

1. Clonez ou téléchargez le repository GitHub dans le dossier voulu :

```bash
git clone https://github.com/Ammar-Khaoula/SnowTricks_Projet6_OpenClassrooms.git

```
2. Editez le fichier situé à la racine intitulé `.env.local` qui devra être crée à la racine du projet en réalisant une copie du fichier `.env` afin de remplacer les valeurs de paramétrage de la base de données ou votre serveur SMTP ou adresse mail :

```bash
//Exemple : mysql://root:@127.0.0.1:3306/site_communautaire_SnowTricks
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
MAILER_DSN=smtp://url@sandbox.smtp.mailtrap.io:2525

```

3. Installez les dépendances back-end du projet avec Composer :
```bash
 composer install

```
4. Installez les dépendances front-end du projet avec Npm :
```bash
 npm install

```
5. Créer un build d'assets (grâce à Webpack Encore):
```bash
 npm run build

```
6. Créez la base de données, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
```bash
 symfony console doctrine:database:create

```
7. Créez les différentes tables de la base de données en appliquant les migrations :
```bash
 symfony console doctrine:migrations:migrate

```
8. Après avoir créer votre base de données, vous pouvez également injecter un jeu de données en effectuant la commande suivante :
```bash
 symfony console doctrine:fixtures:load

```
9. Félications le projet est installé correctement, vous pouvez désormais commencer à l'utiliser. 
Pour lancer le server de symfony, effectuez un:
```bash
 symfony serve:start

```
