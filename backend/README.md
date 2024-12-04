# API Symfony

## Description

Ce projet backend est une API développée avec **Symfony** pour gérer les produits et les catégories dans le cadre de l'application. Elle offre des points de terminaison pour la gestion des produits et des catégories, permettant la création, la modification, la suppression et la récupération des données via des requêtes HTTP.

## Prérequis

Avant d'installer et d'exécuter l'API, vous devez avoir les outils suivants installés sur votre machine :

- **PHP** version 8.1 ou supérieure
- **Composer** (outil de gestion de dépendances PHP)
- **MySQL** ou **MariaDB** pour la base de données
- **Node.js** (si vous utilisez Webpack encore ou un autre outil frontend)

## Installation

### 1. Cloner le projet

Clonez le repository depuis GitHub.

### 2. Installation des dépendances PHP
Une fois que vous avez cloné le repository, naviguez dans le dossier du projet et installez les dépendances avec Composer :

```bash
cd backend
composer install
``` 

### 3. Configuration de la base de données
Dans le fichier .env, configurez les paramètres de votre base de données :

```bash
DATABASE_URL="mysql://root:password@127.0.0.1:3306/votre_base_de_donnees"
``` 

### 4. Création de la base de données et des tables
Exécutez les commandes suivantes pour créer la base de données et exécuter les migrations :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Serveur Symfony
Pour démarrer le serveur Symfony, utilisez la commande suivante :

```bash
symfony server:start
```
Cela démarrera un serveur local à l'adresse http://127.0.0.1:8000.


## Choix Techniques

### Symfony
Symfony a été choisi pour sa robustesse, sa flexibilité et son large écosystème de bundles. Il permet de construire des API rapidement tout en maintenant une architecture claire et modulaire.

### Architecture RESTful
L'API suit une architecture RESTful, ce qui permet d'utiliser les requêtes HTTP standards pour interagir avec les données :

- GET pour lire les données (produits, catégories)
- POST pour créer de nouvelles données
- PUT pour mettre à jour des données existantes
- DELETE pour supprimer des données

### Base de données
La base de données utilisée est MySQL, et elle est configurée dans le fichier .env avec la variable DATABASE_URL. Les entités Product et Category sont stockées dans des tables liées entre elles.

Les migrations sont gérées par Doctrine ORM, ce qui permet de maintenir les schémas de base de données synchronisés avec le code source.

### Points de terminaison
1. Produits
- GET /api/products : Récupérer la liste de tous les produits.
- GET /api/products/{id} : Récupérer un produit spécifique par ID.
- POST /api/products : Créer un nouveau produit.
- PUT /api/products/{id} : Mettre à jour un produit existant par ID.
- DELETE /api/products/{id} : Supprimer un produit par ID.
2. Catégories
- GET /api/categories : Récupérer la liste de toutes les catégories.
- GET /api/categories/{id} : Récupérer une catégorie spécifique par ID.
- POST /api/categories : Créer une nouvelle catégorie.
- PUT /api/categories/{id} : Mettre à jour une catégorie existante par ID.
- DELETE /api/categories/{id} : Supprimer une catégorie par ID.



