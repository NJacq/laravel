# Le marché du haut et très haut débit fixe (déploiements) en France

Vous trouverez ici un suivi des déploiements de la fibre optique jusqu'à l'abonné (Ftth). Les données sont issues de la collecte trimestrielle "Observatoire de gros HD/THD" de l'arcep (Autorité de régulation des communications électroniques et des postes) disponibles sous licence ouverte.

Vous pouvez obtenir directement des informations sur une région, un département ou une commune en saisissant son nom dans le champ correspondant.

**Technologies utilisées** 
- Laravel
- Laravel Mix
- Vue.js
- Axios
- Vue2Filters
- vSelect
- Bootstrap 4
- phpMyAdmin


**Procédure d'installation**

1. Lancer la commande ``` composer install ```
2. Lancer la commande ``` composer require box/spout ``` 
3. Lancer la commande ``` npm install ``` 
4. Créer une base de données
5. Modifier dans le fichier .env 
   - ``` DB_DATABASE=``` : le nom de la base de données précédemment créée
   - ``` DB_USERNAME=``` : l'identifiant pour se connecter à cette base
   - ``` DB_PASSWORD=``` : le mot de passeacq
   

**Importation des données**

Veuillez respecter l'ordre des commandes suuivantes : 

1. Lancer la commande ``` php artisan import:regions regions.csv ``` 
2. Lancer la commande ``` php artisan import:ajoutRegions ``` 
3. Lancer la commande ``` php artisan import:regions ftthRegions.csv ``` 
4. Lancer la commande ``` php artisan import:statregions ``` 
5. Lancer la commande ``` php artisan import:departements departements.csv ``` 
6. Lancer la commande ``` php artisan import:urlcartedepartements ``` 
7. Lancer la commande ``` php artisan import:ftthdepartements ftthDepartements.csv ``` 
8. Lancer la commande ``` php artisan import:statdepartements ```
9. Lancer la commande ``` php artisan import:epci epci. ``` 
10. Lancer la commande ``` php artisan import:ftthepci ftthEpci.csv ``` 
11. Lancer la commande ``` php artisan import:statepci ``` 
12. Lancer la commande ``` php artisan import:communes communes.csv ``` 
13. Lancer la commande ``` php artisan import:ftthcommunes ftthCommunes.csv ``` 
14. Lancer la commande ``` php artisan import:statcommunes ```
15. Lancer la commande ```  php artisan import:ajoutinfoepci ``` 
16. Lancer la commande ``` php artisan import:arrondissements arrondissements.csv ``` 
17. Lancer la commande ``` php artisan import:fttharrondissements ftthArrondissements.csv ``` 
18. Lancer la commande ``` php artisan import:statarrondissements ``` 
