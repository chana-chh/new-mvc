{@ DEFAULT @}

{{ CONTENT BEGIN }}
<h3>SELECT</h3>
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
<p>
    <code>[ALL | DISTINCT | DISTINCTROW]</code>
    ALL je default opcija. DISTINCT i DISTINCTROW su alijasi i sluze za selektovanje samo jedinstvenih zapisa iz baze.
</p>
<p>
    <code>[HIGH_PRIORITY]</code>
    daje prioritet upitu. Ako je tabela zakljucana prioritetni upit ce se izvrsiti odmah nakon otkljucavanja cak i ako drugi upiti cekaju izvrsenje.
</p>
<p>
    <code>[STRAIGHT_JOIN]</code>
    se koristi kod JOIN upita i forsira da se tabele moraju citati onim redom kako su navedene u upitu.
</p>
<p>
    <code>[SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]</code>
    SQL_BUFFER_RESULT forsira koriscenje privremene tabele za obradu rezultata - otkljucava tabelu sto je pre moguce. SQL_SMALL_RESULT i SQL_BIG_RESULT forsiraju da se rezultat smatra veoma velikim ili ne. GROUP BY i DISTINCT operacije cesto koriste privremene tabele, ako je rezultat veoma veliki koriscenje privremene tabele nije pozeljno pa se ovim se moze forsirati koriscenje [SQL_SMALL_RESULT] ili izbegavanje [SQL_BIG_RESULT] privremene tabele.
</p>
<p>
    <code>[SQL_CACHE | SQL_NO_CACHE] [SQL_CALC_FOUND_ROWS]</code>
    SQL_CALC_FOUND_ROWS se primenjuje samo uz koriscenje LIMIT-a. Ako se koristi ova opcija MariaDB se prebrojati koliko zapisa odgovara upitu bez LIMIT-a. Ovaj broj se moze preuzeti ako sledeci upit koristi FOUND_ROWS().
</p>
<p>
    <code>select_expr [, select_expr ...]</code>
    polja (kolone u upitu)
</p>
<p>
    <code>[ FROM table_references</code>
    tabele i JOIN tabele upita
</p>
<p>
    <code>[WHERE where_condition]</code>
    uslovi za filtriranje upita. Operatori koji mogu da se koriste su:
</p>
<ul>
    <li>column = value</li>
    <li>column &lt;&gt; value</li>
    <li>column &gt; value</li>
    <li>column &gt;= value</li>
    <li>column &lt; value</li>
    <li>column &lt;= value</li>
    <li>column BETWEEN value1 AND value2</li>
    <li>column IN (value1,value2,…)</li>
    <li>column NOT IN (value1,value2,…)</li>
    <li>column LIKE value</li>
    <li>column NOT LIKE value</li>
</ul>
<p>
    <code>[GROUP BY {col_name | expr | position} [ASC | DESC], ... [WITH ROLLUP]]</code>
    grupisanje rezultata upita.
</p>
{{ CONTENT END }}

{{ ASIDE BEGIN }}
{! ASIDE !}
{{ ASIDE END }}
