# # SYNOLIA

***

## Besoin numéro 1 
Utiliser en PHP les Web Services mis à disposition par Sugar

#### Prérequis
 - Un fichier ```.env``` avec les variables ```APP_USERNAME``` et ```APP_PASSWORD``` définient
 - PHP 7.4 ou plus
 - Composer pour installer Dotenv pour la gestion du fichier ```.env```

#### Installation

```sh
cd PHP
composer install
cd public
php -S localhost:8000
```
Décommenter les ```print_r``` pour afficher les données

### Fichiers
- index.php : point d'entrée
- tools.php : classe permettant le requêtage de l'API 

### Tâches accomplies
- Prise en main de la documentation de SugarCRM : ~1H
- Initialisation du projet et première requête à l'API : ~30MIN
- Authentification, récupération des cas et récupération de l'ID du premier contact: ~1H
- Création d'un cas lié au premier contact : ~1H
- Formattage du code, refactoring: ~30MIN

### Améliorations
- Un front pour afficher les données récupérées.
- Création d'un ticket unique (pb lors de la création d'un ticket, un doublon est crée également)  


***


## Besoin numéro 2
Utiliser en Javascript les Web services mis à disposition par l’API SIRENE

#### Prérequis
 - Un fichier ```.env``` avec les variables ```APP_USERNAME``` et ```APP_PASSWORD``` définient
 - PHP 7.4 ou plus
 - Composer pour installer Dotenv pour la gestion du fichier ```.env```

#### Installation

```sh
cd JS
```
Utilisation de l'extension 'Live Server' pour lancer un serveur local

### Fichiers
- index.html : point d'entrée et affichage des données
- script.js : Fonctions permettant  l'appel à l'API et la création d'éléments HTML ajouter au DOM 

### Tâches accomplies
- Rédaction de la doc, création d'un compte et récupération d'un token auprès de l'INSEE : ~30MIN
- Initialisation du projet et première requête à l'API : ~30MIN
- Traitement de la donnée et affichage : ~30MIN

### Améliorations
- Un front plus attraillant.
- Rendre la clef API non-accessible par l'utilisateur
