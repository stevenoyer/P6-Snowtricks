# P6-Snowtricks

## Installation 
Faire une copie de ce répertoire :
```
git clone https://github.com/stevenoyer/P6-Snowtricks.git
```

Après l'installation ouvrez le projet dans votre éditeur et dans le terminal tapez :
```
composer install
```

Pour démarrer le serveur symfony :
```
symfony serve
```

Pour consummer les mails avec symfony messenger :
```
php bin/console messenger:consume async -vv
```

## Env
Pour créer le fichier .env, vous pouvez simplement copier le fichier .env.dist et ensuite y configurer les variables d'environnement MAILER_DSN ainsi que l'accès à la base de données en modifiant la valeur de DATABASE_URL.

## Base de données
Dans ce projet, un fichier .sql est inclus pour vous fournir un ensemble de données. Si vous préférez ne pas importer la base de données directement, vous avez également la possibilité d'inclure manuellement les données en extrayant les instructions "INSERT INTO" de chaque table.
