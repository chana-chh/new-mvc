{@ DEFAULT @}

{{ CONTENT BEGIN }}
<h3>SELECT</h3>
<a href="https://mariadb.com/kb/en/library/select/" target="_blank">MariaDB SELECT</a> |
<a href="http://www.mysqltutorial.org/mysql-select-statement-query-data.aspx" target="_blank">MySQL Tutorial SELECT</a>
<pre><code>SELECT
    [ALL | DISTINCT | DISTINCTROW]
    [HIGH_PRIORITY]
    [STRAIGHT_JOIN]
    [SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]
    [SQL_CACHE | SQL_NO_CACHE] [SQL_CALC_FOUND_ROWS]
    select_expr [, select_expr ...]
    [ FROM table_references
      [WHERE where_condition]
      [GROUP BY {col_name | expr | position} [ASC | DESC], ... [WITH ROLLUP]]
      [HAVING where_condition]
      [ORDER BY {col_name | expr | position} [ASC | DESC], ...]
      [LIMIT {[offset,] row_count | row_count OFFSET offset}]
      [PROCEDURE procedure_name(argument_list)]
      [INTO OUTFILE 'file_name' [CHARACTER SET charset_name] [export_options]


INTO DUMPFILE 'file_name'	INTO var_name [, var_name] ]

      [[FOR UPDATE | LOCK IN SHARE MODE] [WAIT n | NOWAIT] ] ]


export_options:
    [{FIELDS | COLUMNS}
        [TERMINATED BY 'string']
        [[OPTIONALLY] ENCLOSED BY 'char']
        [ESCAPED BY 'char']
    ]
    [LINES
        [STARTING BY 'string']
        [TERMINATED BY 'string']
    ]</code></pre>
<pre><code>-- Osnovni SELECT upit
-- vraca sve korisnike
SELECT * FROM korisnici;</code></pre>
<p>
    <code>[ALL | DISTINCT | DISTINCTROW]</code><br>
    ALL je default opcija. DISTINCT i DISTINCTROW su alijasi i sluze za selektovanje samo jedinstvenih redova iz tabele.
</p>
<pre><code>-- DISTINCT upit
-- vraca jedinstvena prezimenima korisnika
SELECT DISTINCT prezime FROM korisnici;

-- COUNT DISTINCT upit
-- vraca broj jedinstvenih prezimena korisnika
SELECT COUNT(DISTINCT (prezime)) FROM korisnici;</code></pre>
<p>
    <code>[HIGH_PRIORITY]</code><br>
    daje prioritet upitu. Ako je tabela zakljucana prioritetni upit ce se izvrsiti odmah nakon otkljucavanja cak i ako drugi upiti cekaju izvrsenje.
</p>
<p>
    <code>[STRAIGHT_JOIN]</code><br>
    se koristi kod JOIN upita i forsira da se tabele moraju citati onim redom kako su navedene u upitu.
</p>
<p>
    <code>[SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]</code><br>
    SQL_BUFFER_RESULT forsira koriscenje privremene tabele za obradu rezultata - otkljucava tabelu sto je pre moguce. SQL_SMALL_RESULT i SQL_BIG_RESULT forsiraju da se rezultat smatra veoma velikim ili ne. GROUP BY i DISTINCT operacije cesto koriste privremene tabele, ako je rezultat veoma veliki koriscenje privremene tabele nije pozeljno pa se ovim se moze forsirati koriscenje [SQL_SMALL_RESULT] ili izbegavanje [SQL_BIG_RESULT] privremene tabele.
</p>
<p>
    <code>[SQL_CACHE | SQL_NO_CACHE] [SQL_CALC_FOUND_ROWS]</code><br>
    SQL_CALC_FOUND_ROWS se primenjuje samo uz koriscenje LIMIT-a. Ako se koristi ova opcija MariaDB se prebrojati koliko zapisa odgovara upitu bez LIMIT-a. Ovaj broj se moze preuzeti ako sledeci upit koristi FOUND_ROWS().
</p>
<pre><code>-- SQL_CALC_FOUND_ROWS upit
-- vraca prvih 10 korisnika u tabeli korisnici
SELECT * FROM korisnici LIMIT 10;

-- vraca ukupan broj korisnika u tabeli korisnici
SELECT FOUND_ROWS() AS broj_korisnika;</code></pre>
<p>
    <code>select_expr [, select_expr ...]</code><br>
    kolone (polja) u upitu.
</p>
<p>
    <code>[ FROM table_references</code><br>
    tabele i JOIN tabele upita.
</p>
<p>
    <code>[WHERE where_condition]</code><br>
    uslovi koje red mora da ispunjava da bi bio izabran. U WHERE izrazu mogu da se koriste sve funkcije i operatori koji su podrzani, osim agregatnih (sumarnih) funkcija.
</p>
<pre><code>-- SELECT WHERE upit
-- vraca korisnicka imena korisnika sa ulogom admin
SELECT korisnicko_ime FROM korisnici WHERE `uloga` = 'admin';

-- Slozeni SELECT WHERE upit
-- vraca korisnike koji rade u odeljenju za IKT i imaju staz 5 ili vise godina
-- ili imaju ulogu admin/administrator
SELECT *
FROM korisnici
WHERE (`odeljenje` = 'IKT' AND `staz` >= 5) OR `uloga` LIKE 'admin%';
</code></pre>
<p>
    <code>[GROUP BY {col_name | expr | position} [ASC | DESC], ... [WITH ROLLUP]]</code><br>
    koristi se za grupisanje redova koji imaju istu vrednost jedne ili vise kolona ili istu vrednost izracunatu pomocu funkcija i operatora. Kada se koristi GROUP BY dobije se po jedan red za svaku grupu redova koji imaju iste vrednosti izraza u GROUP BY. Moze se koristiti vise izraza odvojenih zarezom. Redovi se grupisu ako odgovaraju svim navedenim izrazima.
</p>
<p>
    WHERE se izvrsava pre GROUP BY i filtrira neagregatne redove pre grupisanja. Da bi se filtrirali grupisani redovi na osnovu zbirnih vrednosti koristi se HAVING. HAVING svaki izraz i ocenjuje ga kao true ili false (isto kao i WHERE). Mogu da se koriste i agregatne funkcije
</p>
<p>
    Ako se koristi GROUP BY redovi ce biti sortirani prema izrazima koriscenim u GROUP BY. Mogu da se koriste i ASC ili DESC na krajevima koriscenih izraza kao u ORDER BY. Ako se zeli sortiranje po nekom drugom polju moze se dodati i ORDER BY. Ako se traze nesortirani rezultati dodaje se ORDER BY NULL.
</p>
<p>WITH ROLLUP dodaje ekstra red u rezultate koji predstavlja super-agregatne zbirove.</p>
<pre><code>-- GROUP BY upiti
-- vraca koliko ima timova sa odredjenim brojem pobeda (4 pobede ima 5 timova)
SELECT pobede, COUNT(*) FROM utakmice GROUP BY pobede;

-- vraca koliko ima timova sa odredjenim procentom pobeda (23% pobeda ima 2 tima)
SELECT (pobede * 100 / odigrane) AS procenat_pobeda, COUNT(*)
FROM utakmice
GROUP BY procenat_pobeda;

-- vraca koliko je prosecno odigranih utakmica za odredjeni procenat pobeda
-- (za 23% pobeda prosecno je odigrano 28 utakmica)
SELECT (pobede * 100 / odigrane) AS procenat_pobeda, AVG(odigrane)
FROM utakmice
GROUP BY procenat_pobeda;

-- vraca koliki je procenat pobeda ako je prosecno odigrano vise od 20 utakmica
-- (za 23% pobeda prosecno je odigrano 28 utakmica)
-- ne vraca (za 50% pobeda prosecno je odigrano 17 utakmica)
SELECT (pobede * 100 / odigrane) AS procenat_pobeda, AVG(odigrane)
FROM utakmice
GROUP BY procenat_pobeda
HAVING AVG(odigrane) > 20;

-- SELECT GROUP BY WITH ROLLUP upiti
-- vraca ukupnu prodaju po godinama i jos jedan red sa ukupnom prodajom za sve godine
-- 2016 | 20650
-- 2017 | 11200
-- NULL | 31850
SELECT godina, SUM(prodato) FROM prodaja_knjiga GROUP BY godina WITH ROLLUP;

-- vraca ukupnu prodaju po zemljama, godinama i zanru s tim da se posle svake grupe
-- dodaje red sa medjuzbirovima
SELECT zemlja, godina, zanr, SUM(prodato)
FROM prodaja_knjiga GROUP BY zemlja, godina, zanr WITH ROLLUP;

-- vraca ukupnu prodaju po zemljama, godinama i zanru sortirano po opadajucoj godini
-- s tim da se posle svake grupe dodaje red sa medjuzbirovima
SELECT zemlja, godina, zanr, SUM(prodato)
FROM prodaja_knjiga GROUP BY zemlja, godina DESC, zanr WITH ROLLUP;
</code></pre>
<p>
    <code>[HAVING where_condition]</code><br>
    koristi se za filtriranje sumarnih informacija. HAVING se pokrece posle GROUP BY i omogucava filtriranje sumarnih podataka koji nisu dostupni WHERE izrazu.
</p>
{{ CONTENT END }}

{{ ASIDE BEGIN }}
{! ASIDE !}
{{ ASIDE END }}
