# lavcak_fabry_projekt

## Spustenie projektu

1. Skopiruj projekt do web root (napr. `C:/MAMP/htdocs/lavcak_fabry_projekt`).
2. Zapni Apache a MySQL v MAMP.
3. V phpMyAdmin (alebo MySQL klientovi) vytvor databazu `todo_app`.
4. Importuj subor [database.sql](database.sql) do databazy `todo_app`.
5. Otvor v prehliadaci:
	`http://localhost/lavcak_fabry_projekt/`

## Ako sa vytvori databaza

Databaza sa vytvara manualne:

1. vytvor databazu `todo_app`,
2. importuj [database.sql](database.sql).

Aplikacia uz databazu ani tabulky automaticky nevytvara.

## DB pristup pre noveho pouzivatela

V [config.php](config.php) su momentalne hodnoty:

- host: `localhost`
- user: `root`
- password: `root`
- port: `3306`

Ak to ma niekto ine (napr. ine heslo alebo port), treba tieto hodnoty upravit v [config.php](config.php).

## Ked sa DB nevytvori

Skontroluj, ci:

1. existuje DB `todo_app`,
2. je importovany [database.sql](database.sql),
3. sedia prihlasovacie udaje v [config.php](config.php).