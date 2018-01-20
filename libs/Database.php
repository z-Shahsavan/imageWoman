<?php

class Database extends PDO {

    function __construct() {
        try {
            parent::__construct(DBTYPE . ':host=' . SERVERNAME . ';dbname=' . DBNAME, DBUSER, DBPASS);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->exec("SET NAMES 'utf8'");
        } catch (Exception $exc) {
            die('Connection Faild! Error message:' . $exc->getMessage());
        }
    }

    public function insert($table, $data) {

        $fieldkeys = implode(',', array_keys($data));
        $fieldvalues = ':' . implode(',:', array_keys($data));
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = "INSERT INTO $table ($fieldkeys) VALUES($fieldvalues)";
        $result = $this->prepare($query);
        $result->execute($data);
        return $this->lastInsertId();
    }

    public function update($table, $updata, $cond = null, $condata = array()) {
      
        $fieldkeyvalue = '';
        foreach ($updata as $key => $value) {
            $fieldkeyvalue .="$key=:$key,";
        }
        $fieldkeyvalue = rtrim($fieldkeyvalue, ',');
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        if (is_null($cond)) {
            $query = "UPDATE $table SET $fieldkeyvalue";
            $data = $updata;
        } else {
            $query = "UPDATE $table SET $fieldkeyvalue WHERE $cond";
            $data = array_merge($updata, $condata);
        }
        $result = $this->prepare($query);
        $result->execute($data);
    }

    public function select($table, $fields, $cond = null, $data = array()) {
        
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        if (is_null($cond)) {
            $query = "SELECT $fields FROM $table";
        } else {
            $query = "SELECT $fields FROM $table WHERE $cond";
        }
//        file_put_contents('config/x', $query, FILE_APPEND);
        try {
            $result = $this->prepare($query);
            $result->execute($data);
            $rownumber = 0;
            $rownumber = $result->rowCount();
            if ($rownumber > 0) {
                $result->setFetchMode(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public function delete($table, $cond = null, $data = array()) {
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        if (is_null($cond)) {
            $query = "DELETE FROM $table";
        } else {
            $query = "DELETE FROM $table WHERE $cond";
        }
        $result = $this->prepare($query);
        $result->execute($data);
    }

    public function selectarray($table, $fields, $condfield, $data = array()) {
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $cond = '';
        for ($i = 0; $i < count($data); $i++) {
            $cond.=$condfield . '=:' . $condfield . $i . ' OR ';
        }
        $cond = rtrim($cond, '=: OR ');
        $j = 0;
        foreach ($data as $datum) {
            $exdata[$condfield . $j] = $datum;
            $j++;
        }
        $query = "SELECT $fields FROM $table WHERE $cond";
        $result = $this->prepare($query);
        $result->execute($exdata);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        return $result;
    }

    public function batchinsert($table, $fields, $data) {
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $fieldkeys = explode(',', $fields);
        $fieldvalues = ':' . implode(',:', $fieldkeys);
        $query = "INSERT INTO $table ( " . implode(',', $fieldkeys) . " ) VALUES ($fieldvalues);";
        for ($k = 0; $k < sizeof($data); $k++) {
            $result = $this->prepare($query);
            $result->execute($data[$k]);
        }
    }

    public function bulkupdate($table, $data, $casecond) {
        if (sizeof($data)) {
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $query = "UPDATE $table SET $casecond";
            $result = $this->prepare($query);
            $result->execute($data);
        }
    }

}
