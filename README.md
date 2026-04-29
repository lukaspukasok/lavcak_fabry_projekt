# lavcak_fabry_projekt

Jednoducha webova TODO aplikacia v PHP + MySQL.

Projekt obsahuje:
- registraciu a prihlasenie pouzivatela,
- reset hesla podla username,
- CRUD operacie nad ulohami,
- oddelenie uloh podla prihlaseneho pouzivatela cez user_id.

## Technologie

- PHP (mysqli)
- MySQL
- HTML + Bootstrap 5
- vlastne CSS v subore [style.css](style.css)

## Struktura suborov

- [index.php](index.php): landing stranka s odkazom na login/register
- [register.php](register.php): registracia pouzivatela
- [login.php](login.php): prihlasenie a odhlasenie
- [reset_password.php](reset_password.php): zmena hesla podla username
- [tasks.php](tasks.php): hlavna stranka taskov po prihlaseni
- [add.php](add.php): pridanie tasku
- [edit.php](edit.php): uprava tasku
- [delete.php](delete.php): zmazanie tasku
- [config.php](config.php): DB pripojenie a kontrola schema tabuliek
- [database.sql](database.sql): manualny SQL dump schema
- [style.css](style.css): UI styly

## Databaza (manualny setup)

Projekt je nastaveny na manualny setup databazy.

1. Vytvor databazu todo_app.
2. Importuj [database.sql](database.sql) do databazy todo_app.
3. Uprav prihlasovacie udaje v [config.php](config.php), ak sa lisia od lokalneho prostredia.

Default hodnoty v [config.php](config.php):
- host: localhost
- user: root
- password: root
- port: 3306
- database: todo_app

Ak databaza alebo tabulky neexistuju, aplikacia vypise chybu a poziada o import [database.sql](database.sql).

## SQL schema

Tabulka users:
- id (PK)
- username (UNIQUE)
- password (hash)
- created_at

Tabulka tasks:
- id (PK)
- user_id (FK na users.id)
- title
- description
- status (pending/done)
- created_at

## Aplikacny flow

1. Pouzivatel sa zaregistruje cez [register.php](register.php).
2. Po registracii sa nastavi session + cookie a redirect na [tasks.php](tasks.php).
3. Prihlasenie v [login.php](login.php) overi heslo cez password_verify.
4. [tasks.php](tasks.php) nacita len tasky konkretneho user_id.
5. CRUD operacie [add.php](add.php), [edit.php](edit.php), [delete.php](delete.php) su viazane na user_id v session.

## Bezpecnostne poznamky

- Hesla su hashovane cez password_hash.
- Pri task operaciach je filtrovanie cez user_id, aby pouzivatel nevidel alebo nemenil cudzie tasky.

## Zname obmedzenia

- Reset hesla v [reset_password.php](reset_password.php) overuje iba username (bez email tokenu).
- Chybove hlasky su orientovane na lokalny development (display_errors je zapnute).

## Rychly test po nasadeni

1. Otvor [register.php](register.php) a vytvor novy ucet.
2. Over, ze redirect ide na [tasks.php](tasks.php).
3. Pridaj task cez [add.php](add.php), uprav ho cez [edit.php](edit.php), zmaz cez [delete.php](delete.php).
4. Odhlas sa a prihlas znova cez [login.php](login.php).
5. Over, ze po prihlaseni vidis iba vlastne tasky.