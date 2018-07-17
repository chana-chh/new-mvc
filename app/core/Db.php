<?php

class Db extends PDO {

    // Cuva poslednju PDO gresku
    private $error;
    // Cuva broj redova poslednjeg upita
    private $count;
    // Poslednji upit
    private $lastQuery;

    public function __construct($dsn = DSN, $user = DB_USER, $pwd = DB_PASS, $attrib = null) {
        if (!$attrib) {
            $attrib = unserialize(PDO_OPCIJE);
        }
        try {
            parent::__construct($dsn, $user, $pwd, $attrib);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            greska('Db - PDOException: Nije uspelo povezivanje sa bazom', $e->getMessage());
        }
    }

    public function qry($sql, $params = null) {
        try {
            $stmt = $this->prepare($sql);
            if ($params) {
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, $this->pdoType($value));
                }
            }
            $stmt->execute();
            $this->count = $stmt->rowCount();

            ob_start();
            $stmt->debugDumpParams();
            $this->lastQuery = ob_get_contents();
            ob_end_clean();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            greska('Db - PDOException: Nije uspeo upit u bazu', $e->getMessage());
        }

        return $stmt;
    }

    public function sel($sql, $params = null, $model = null) {
        try {
            $stmt = $this->qry($sql, $params);
            if ($model) {
                $data = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
            } else {
                $data = $stmt->fetchAll();
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            greska('Db - PDOException: Nije uspelo preuzimanje podataka iz baze', $e->getMessage());
        }
        return $data;
    }

    protected function pdoType($param) {
        switch (gettype($param)) {
            case 'NULL':
                return PDO::PARAM_NULL;
            case 'boolean':
                return PDO::PARAM_BOOL;
            case 'integer':
                return PDO::PARAM_INT;
            default:
                return PDO::PARAM_STR;
        }
    }

    public function lastId() {
        return $this->lastInsertId();
    }

    public function lastCount() {
        return $this->count;
    }

    public function lastError() {
        return $this->error;
    }

    public function lastQuery() {
        return $this->lastQuery;
    }

}
