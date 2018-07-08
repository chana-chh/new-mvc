
-- https://mariadb.com/kb/en/library/documentation/

SELECT
    -- DISTINCT i DISTINCTROW su alijasi, ALL je default
    [ALL | DISTINCT | DISTINCTROW]
    -- HIGH_PRIORITY daje prioritet upitu.
    -- Ako je tabela zakljucana prioritetni upit ce se izvrsiti odmah nakon otkljucavanja cak i ako drugi upiti cekaju izvrsenje
    [HIGH_PRIORITY]
    -- STRAIGHT_JOIN se koristi kod JOIN upita i forsira da se tabele moraju citati onim redom kako su navedene u upitu
    [STRAIGHT_JOIN]
    -- SQL_BUFFER_RESULT forsira koriscenje privremene tabele za obradu rezultata - otkljucava tabelu sto je pre moguce
    -- SQL_SMALL_RESULT i SQL_BIG_RESULT forsiraju da se rezultat smatra veoma velikim ili ne.
    -- GROUP BY i DISTINCT operacije cesto koriste privremene tabele, ako je rezultat veoma veliki koriscenje privremene tabele nije pozeljno
    -- Ovim se moze forsirati koriscenje [SQL_SMALL_RESULT] ili izbegavanje [SQL_BIG_RESULT] privremene tabele
    [SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]
    -- SQL_CALC_FOUND_ROWS is only applied when using the LIMIT clause. If this option is used, MariaDB will count how many rows would match the query, without the LIMIT clause. That number can be retrieved in the next query, using FOUND_ROWS().
    [SQL_CACHE | SQL_NO_CACHE] [SQL_CALC_FOUND_ROWS]
    -- Polja (kolone) u rezultatu upita
    select_expr [, select_expr ...]
    -- Tabele i JOIN tabele upita
    [ FROM table_references]
      [WHERE where_condition]
      [GROUP BY {col_name | expr | position} [ASC | DESC], ... [WITH ROLLUP]]
      [HAVING where_condition]
      [ORDER BY {col_name | expr | position} [ASC | DESC], ...]
      [LIMIT {[offset,] row_count | row_count OFFSET offset}]
