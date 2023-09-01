# P6-Snowtricks

## Installation 
Faire une copie de ce répertoire :
```
git clone
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
Pour le fichier .env il suffit de duppliquer le fichier .env.dist et d'y configurer le MAILER_DSN et l'accès à la base de données DATABASE_URL

## Base de données
Un fichier .sql est joint dans ce projet afin que vous puissiez avoir un jeu de données. Si vous ne voulez pas importer directement cette base de données, vous pouvez inclure manuellement les données en récupérant les "INSERT INTO" de chaque table.
