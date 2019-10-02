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
