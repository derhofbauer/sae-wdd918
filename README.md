# PHP Basics - WDD918

## `docker-compose`

Wer gerne Docker/Docker Compose nutzen möchte, findet ein entsprechendes File im Repository.

### Web
+ Apache: [localhost:8080](localhost:8080)
+ PhpMyAdmin: [localhost:8081](localhost:8081)

### Database
+ MariaDB: [localhost:3306](localhost:3306)

## Nützliche Informationen & Links

+ PHP Docs: https://www.php.net/
+ MySQL Docs: https://dev.mysql.com/doc/
+ GIT Flow: https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow
+ https://learngitbranching.js.org/

### Cheatsheets

+ Markdown: https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet
+ GIT: https://www.atlassian.com/git/tutorials/atlassian-git-cheatsheet
+ https://devhints.io/
+ http://cheat.sh/

### Alternative Datenbanksysteme

+ PostgreSQL (bspw. Volltextsuche): https://www.postgresql.org/

### Snippets

```php

/**
 * $link holds the DB connection object created by mysqli_connect()
 */
$result = mysqli_query($link, "SELECT ...");

while ($row = mysqli_fetch_assoc($result)) {
    // do something with the current $row
}
```

```php
/**
 * Die extract Funktion macht im Hintergrund folgendes:
 *
 * $id = $row['id'];
 * $title = $row['title'];
 * usw.
 */
extract($row);
```

### Misc

+ some directories in this repository contain files named `.gitkeep`. Git does not check in empty folders, so people use to create `.gitkeep` files in order to make Git check-in "empty" folders (they are not actually empty anymore, when they hold those files, though).
