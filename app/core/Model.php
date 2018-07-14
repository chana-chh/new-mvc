<?php

abstract class Model {
    /**
     * Baza podataka
     * @var Db PDO instanca
     */
    protected $db;

    /**
     * Naziv tabele u bazi podataka
     * @var string Naziv tabele u bazi podataka
     */
    protected $table;

    /**
     * Primarni kljuc tabele
     * @var string Primarni kljuc tabele
     */
    protected $pk = 'id';

    /**
     * Naziv modela
     * @var string Model klasa koja sadrzi podatke za jedan zapis iz baze podataka
     */
    protected $model;

    /**
     * Lista za eager loading
     * @var array
     */
    protected $eager = [];

    public function __construct() {
        $this->db = App::instance()->db;
        $this->model = get_class($this);
    }

    public function getTable() {
        return $this->table;
    }

    public function getPrimaryKey() {
        return $this->pk;
    }

    /**
     * Sirovi sql upit
     * @param string $sql SQL upit
     * @param array $params Niz parametara za PDO parametrizovani upit
     * @return array Niz Model-a
     */
    public function query($sql, $params = null) {
        return $this->db->sel($sql, $params, $this->model);
    }

    public function foundRows() {
        $count = $this->query("SELECT FOUND_ROWS() AS count;");
        return (int) $count[0]->count;
    }

    public function select($sql, $params = null) {
        
    }

    public function selectAll($sort_column = null, $sort = 'ASC') {
        $order_by = '';
        if ($sort_column) {
            $order_by = " ORDER BY `{$sort_column}` {$sort}";
        }
        $sql = "SELECT * FROM `{$this->table}`{$order_by};";
        return $this->db->sel($sql, null, $this->model);
    }

    public function selectId(int $id) {
        $sql = "SELECT * FROM `{$this->table}` WHERE `{$this->pk}` = :id;";
        $params = [':id' => $id];
        return $this->db->sel($sql, $params, $this->model)[0];
    }

    public function insert($data) {
        $cols = array_column($data, 0);
        $pars = array_map(function($col) {
            return ':' . $col;
        }, $cols);
        $vals = array_column($data, 1);
        $params = array_combine($pars, $vals);
        $c = '`' . implode('`, `', $cols) . '`';
        $v = implode(', ', $pars);
        $sql = "INSERT INTO `{$this->table}` ({$c}) VALUES ({$v});";
        return $this->db->qry($sql, $params);
    }

    // TODO DODATI PARAMS, a WHERE da bude string
    public function update($data, $where) {
        list($column, $operator, $value) = $where;
        $cols = array_column($data, 0);
        $pars = array_map(function($col) {
            return ':' . $col;
        }, $cols);
        $vals = array_column($data, 1);
        $cv = array_combine($cols, $pars);
        $params = array_combine($pars, $vals);
        $c = '';
        foreach ($cv as $key => $val) {
            $c .= ", `{$key}` = {$val}";
        }
        $c = ltrim($c, ', ');

        $sql = "UPDATE `{$this->table}` SET {$c} WHERE `{$column}` {$operator} :where_{$column};";
        $params[":where_{$column}"] = $value;
        return $this->db->qry($sql, $params);
    }

    // TODO DODATI PARAMS, a WHERE da bude string
    public function delete($where) {
        list($column, $operator, $value) = $where;
        $sql = "DELETE FROM `{$this->table}` WHERE `{$column}` {$operator} :where_{$column};";
        $params = [":where_{$column}" => $value];
        return $this->db->qry($sql, $params);
    }

    public function deleteId(int $id) {
        $sql = "DELETE FROM `{$this->table}` WHERE `{$this->pk}` = :id";
        $params = [':id' => $id];
        return $this->db->qry($sql, $params);
    }

    public function lastId() {
        return $this->db->lastId();
    }

    public function lastCount() {
        return $this->db->lastCount();
    }

    public function lastError() {
        return $this->db->lastError();
    }

    public function lastQuery() {
        return $this->db->lastQuery();
    }

    public function lastSql() {
        $length = (int) getStringBetween($this->db->lastQuery(), 'SQL: [', ']');
        $start = strlen('SQL: [' . $length . '] ');
        return substr($this->db->lastQuery(), $start, $length);
    }

    public function enumOrSetList($column) {
        $sql = "SELECT DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE `TABLE_NAME` = :table AND `COLUMN_NAME` = :column;";
        $params = [':table' => $this->table, ':column' => $column];
        $result = $this->db->sel($sql, $params);
        if ($result['DATA_TYPE'] === 'enum' || $result['DATA_TYPE'] === 'set') {
            $list = explode(",", str_replace("'", "", substr($result['COLUMN_TYPE'], 5, (strlen($result['COLUMN_TYPE']) - 6))));
            if (is_array($list) && !empty($list)) {
                return $list;
            }
        } else {
            return false;
        }
    }

    public function pagination($page, $perpage, $span, $sql, $params = null) {
        $data = $this->pageData($page, $perpage, $sql, $params);
        $links = $this->pageLinks($page, $perpage, $span);
        return ['data' => $data, 'links' => $links];
    }

    public function pageData($page, $perpage, $sql, $params = null) {
        $sql = str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $sql);
        $start = ($page - 1) * $perpage;
        $limit = $perpage;
        $offset = $start;
        $sql = rtrim($sql, ';');
        $sql .= " LIMIT {$limit} OFFSET {$offset};";
        $data = $this->query($sql, $params);
        return $data;
    }

    public function pageLinks($page, $perpage, $span) {
        $count = $this->foundRows();
        $url = App::instance()->router->getCurrentUriName();
        $pages = (int) ceil($count / $perpage);
        $prev = ($page > 2) ? $page - 1 : 1;
        $next = ($page < $pages) ? $page + 1 : $pages;
        $disabled_begin = ($page === 1) ? " disabled" : "";
        $disabled_end = ($page === $pages) ? " disabled" : "";
        $span_begin = $page - $span;
        $start = $span_begin <= 1 ? 1 : $span_begin;
        $span_end = $start + 2 * $span;
        if ($span_end >= $pages) {
            $end = $pages;
            $start = $end - 2 * $span;
            $start = $start <= 1 ? 1 : $start;
        } else {
            $end = $span_end;
        }
        $zapis_od = (($page - 1) * $perpage) + 1;
        $zapis_do = ($zapis_od + $perpage) - 1;
        $zapis_do = $zapis_do >= $count ? $count : $zapis_do;
        $links = '<a class="pagination-button" href="' . $url . '/1"' . $disabled_begin . '>&lt;&lt;</a>';
        $links .= '<a class="pagination-button" href="' . $url . '/' . $prev . '"' . $disabled_begin . '>&lt;</a>&nbsp;';
        for ($i = $start; $i <= $end; $i++) {
            $current = '';
            if ($page === $i) {
                $current = ' current-page';
            }
            $links .= '<a class="pagination-button' . $current . '" href="' . $url . '/' . $i . '">' . $i . '</a>';
        }
        $links .= '&nbsp;<a class="pagination-button" href="' . $url . '/' . $next . '"' . $disabled_end . '>&gt;</a>';
        $links .= '<a class="pagination-button" href="' . $url . '/' . $pages . '"' . $disabled_end . '>&gt;&gt;</a>';
        $links .= '<br><span class="pagination-info">Strana '
                . $page . ' od ' . $pages
                . ' | Prikazani su zapisi od ' . $zapis_od . ' do ' . $zapis_do
                . ' | Ukupan broj zapisa: ' . $count . '</span>';
        return $links;
    }

    /**
     * Jedan prema jedan (Jedan)
     * <strong>Primer</strong><br>
     * Korisnik moze da ima samo jedan DodatniPodatak.
     * U tabeli dodatni_podaci imamo `korisnik_id` FK koji povezuje ovu tabelu sa tabelom `korisnici`.
     * U modelu Korsnik imamo dodatni_podatak(){return hasOne('DodatniPodatak', 'korisnik_id');}
     * @param string $model_class Model klasa koja sadrzi povezane podatke
     * @param string $fk Strani kljuc koji povezuje tabelu povezanog modela sa tabelom trenutnog modela
     * @return Model
     */
    public function hasOne($model_class, $fk) {
        $m = new $model_class();
        $sql = "SELECT * FROM `{$m->getTable()}` WHERE `{$fk}` = :fk;";
        $pk = $this->getPrimaryKey();
        $params = [':fk' => $this->$pk];
        $result = $this->db->sel($sql, $params, $model_class);
        return $result[0];
    }

    /**
     * Jedan prema jedan (jedan)
     * <strong>Primer</strong><br>
     * DodatniPodatak pripada samo jednom Korisnik-u.
     * U tabeli dodatni_podaci imamo `korisnik_id` FK koji povezuje ovu tabelu sa tabelom `korisnici`.
     * U modelu DodatniPodatak imamo korisnik(){return belongsTo('Korisnik', 'korisnik_id');}
     * Jedan prema vise (jedan)
     * <strong>Primer</strong><br>
     * Korisnik moze da (pripada) ima samo jednu Uloga.
     * U tabeli `uloge` imamo 'korisnik_id' FK koji povezuje ovu tabelu sa tabelom korisnici
     * U modelu Korisnik imamo uloga(){return belongsTo('Uloga', 'korisnik_id');};
     * @param string $model_class Model klasa koja sadrzi povezane podatke
     * @param string $fk Strani kljuc koji povezuje tabelu trenutnog modela sa tabelom povezanog modela
     * @return Model
     */
    public function belongsTo($model_class, $fk) {
        $m = new $model_class();
        $sql = "SELECT * FROM `{$m->getTable()}` WHERE `{$m->getPrimaryKey()}` = :fk;";
        $params = [':fk' => $this->$fk];
        $result = $this->db->sel($sql, $params, $model_class);
        return $result[0];
    }

    /**
     * Jedan prema vise (vise)
     * <strong>Primer</strong><br>
     * Uloga moze da ima vise Korisnik-a.
     * U tabeli `uloge` imamo 'korisnik_id' FK koji povezuje ovu tabelu sa tabelom korisnici
     * U modelu Uloga imamo korisnici(){return hasMany('Uloga', 'korisnik_id');}
     * @param string $model_class Model klasa koja sadrzi povezane podatke
     * @param string $fk Strani kljuc koji povezuje tabelu povezanog modela sa tabelom trenutnog modela
     * @return array Niz Model-a
     */
    public function hasMany($model_class, $fk) {
        $m = new $model_class();
        $sql = "SELECT * FROM `{$m->getTable()}` WHERE `{$fk}` = :pk;";
        $pk = $this->getPrimaryKey();
        $params = [':pk' => $this->$pk];
        $result = $this->db->sel($sql, $params, $model_class);
        return $result;
    }

    /**
     * Vise prema vise
     * @param string $model_class Model klasa koja sadrzi povezane podatke
     * @param string $pivot_table Medjutabela koja povezuje tabelu ovog modela i tabelu povezanog modela
     * @param string $pt_this_table_fk FK na ovu tabelu u medjutabeli
     * @param string $pt_foreign_table_fk FK na povezanu tabelu u medjutabeli
     * @return array Niz Model-a
     */
    public function belongsToMany($model_class, $pivot_table, $pt_this_table_fk, $pt_foreign_table_fk) {
        $m = new $model_class();
        $tbl = $m->getTable();
        $pk = $this->getPrimaryKey();
        $params = [':pk' => $this->$pk];
        $sql = "SELECT `{$tbl}`.* FROM `{$tbl}` JOIN `{$pivot_table}` ON `{$tbl}`.`{$m->getPrimaryKey()}` = `{$pivot_table}`.`{$pt_foreign_table_fk}` WHERE `{$pivot_table}`.`{$pt_this_table_fk}` = :pk;";
        $result = $this->db->sel($sql, $params, $model_class);
        return $result;
    }

    public function with($relations) {

    }

}
