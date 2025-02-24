<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

class DB
{
    protected static $PDO;

    protected static function connect()
    {
        try {
            defined('DB_NAME') or die('Required database information');
            self::$PDO = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USER, DB_PASS);
            self::$PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$PDO->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            self::$PDO->exec('SET NAMES utf8mb4');
            register_shutdown_function(function () {
                self::$PDO = null;
            });
        } catch (\PDOException $e) {
            die('Database connection failed');
        }
    }

    public static function select($tableName, $columnSelect = '*', $columnWhere = [], $extraSql = null, $logic = 'AND')
    {
        try {
            $sql = "SELECT $columnSelect FROM $tableName";
            if ($columnWhere) {
                $val = "";
                foreach ($columnWhere as $x => $y) {
                    $val .= "$x=:$x $logic ";
                }
                $sql .= " WHERE " . rtrim($val, " $logic ");
            }
            $sql .= " $extraSql;";
            if (!self::$PDO) {
                self::connect();
            }
            $stmt = self::$PDO->prepare($sql);
            foreach ($columnWhere as $x => $y) {
                $stmt->bindValue(":$x", $y, self::valueType($y));
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            self::error($e);
        }
    }

    public static function selectIn($tableName, $columnSelect = '*', $columnWhere = [], $extraSql = null, $logic = 'AND')
    {
        try {
            $sql = "SELECT $columnSelect FROM $tableName";
            if ($columnWhere) {
                $val = "";
                foreach ($columnWhere as $x => $y) {
                    if (is_array($y)) {
                        $val .= $x . ' IN ("' . implode('","', $y) . '") ' . $logic . ' ';
                    } else {
                        $val .= " $x=:$x $logic ";
                    }
                }
                $sql .= " WHERE " . rtrim($val, " $logic ");
            }
            $sql .= " $extraSql;";
            if (!self::$PDO) {
                self::connect();
            }
            $stmt = self::$PDO->prepare($sql);
            foreach ($columnWhere as $x => $y) {
                if (!is_array($y)) {
                    $stmt->bindValue(":$x", $y, self::valueType($y));
                }
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            self::error($e);
        }
    }

    public static function insert($tableName, $columnValue)
    {
        try {
            $sql = "INSERT INTO $tableName";
            $val = '';
            $qus = '';
            foreach ($columnValue as $x => $y) {
                $val .= $x . ', ';
                $qus .= ':' . $x . ', ';
            }
            $sql .= '(' . rtrim($val, ', ') . ') VALUES (' . rtrim($qus, ', ') . ');';
            self::connect();
            $stmt = self::$PDO->prepare($sql);
            foreach ($columnValue as $x => $y) {
                $stmt->bindValue(":$x", $y, self::valueType($y));
            }
            $stmt->execute();
            $lastInsertId = self::$PDO->lastInsertId();
            self::$PDO = null;
            return $lastInsertId;
        } catch (\PDOException $e) {
            self::error($e);
        }
    }

    public static function update($tableName, $columnValue, $columnWhere = [], $extraSql = null, $logic = 'AND')
    {
        try {
            $sql = "UPDATE $tableName";
            $set = '';
            foreach ($columnValue as $x => $y) {
                $set .= $x . ' = :' . $x . ', ';
            }
            $sql .= ' SET ' . rtrim($set, ', ');
            if ($columnWhere) {
                $val = "";
                foreach ($columnWhere as $x => $y) {
                    $val .= "$x = :$x $logic ";
                }
                $sql .= " WHERE " . rtrim($val, " $logic ");
            }
            $sql .= " $extraSql;";
            self::connect();
            $stmt = self::$PDO->prepare($sql);
            foreach ($columnValue as $x => $y) {
                $stmt->bindValue(":$x", $y, self::valueType($y));
            }
            foreach ($columnWhere as $x => $y) {
                $stmt->bindValue(":$x", $y, self::valueType($y));
            }
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            self::error($e);
        }
    }

    public static function delete($tableName, $columnWhere = [], $extraSql = null, $logic = 'AND')
    {
        try {
            $sql = "DELETE FROM $tableName";
            if ($columnWhere) {
                $val = "";
                foreach ($columnWhere as $x => $y) {
                    $val .= "$x = :$x $logic ";
                }
                $sql .= " WHERE " . rtrim($val, " $logic ");
            }
            $sql .= " $extraSql;";
            if (!self::$PDO) {
                self::connect();
            }
            $stmt = self::$PDO->prepare($sql);
            foreach ($columnWhere as $x => $y) {
                $stmt->bindValue(":$x", $y, self::valueType($y));
            }
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            self::error($e);
        }
    }

    public static function count($tableName, $columnWhere = [], $extraSql = null, $logic = 'AND')
    {
        try {
            $sql = "SELECT COUNT(*) FROM $tableName";
            if ($columnWhere) {
                $val = "";
                foreach ($columnWhere as $x => $y) {
                    $val .= "$x=:$x $logic ";
                }
                $sql .= " WHERE " . rtrim($val, " $logic ");
            }
            $sql .= " $extraSql;";
            if (!self::$PDO) {
                self::connect();
            }
            $stmt = self::$PDO->prepare($sql);
            $stmt->execute($columnWhere);
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            self::error($e);
        }
    }

    public static function search($searchQuery, $tableName, $columnSelect = '*', $columnWhere = [], $extraSql = null, $logic = 'AND')
    {
        try {
            $sql = "SELECT $columnSelect FROM $tableName";
            if ($columnWhere) {
                $val = "";
                foreach ($columnWhere as $x => $y) {
                    $val .= "$x = :$x $logic ";
                }
                $sql .= " WHERE " . rtrim($val, " $logic ");
            }
            $Where = empty($columnWhere) ? ' WHERE ' : ' AND ';
            $val = '(';
            foreach ($searchQuery as $x => $y) {
                $val .= $x . ' REGEXP "(' . preg_replace('/[\\/\\\"\'`~^*$:,;?&|.=@({<%>})\[\]]+/', '', $y) . ')" OR ';
            }
            $sql .= $Where . rtrim($val, ' OR ') . ')';
            $sql .= " $extraSql;";
            if (!self::$PDO) {
                self::connect();
            }
            $stmt = self::$PDO->prepare($sql);
            foreach ($columnWhere as $x => $y) {
                if (!is_array($y)) $stmt->bindValue(":$x", $y, self::valueType($y));
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            self::error($e);
        }
    }

    public static function query($sql, $fetch = true)
    {
        if (!self::$PDO) {
            self::connect();
        }
        try {
            $stmt = self::$PDO->query($sql);
            return $fetch ? $stmt->fetchAll() : $stmt;
        } catch (\PDOException $e) {
            self::error($e);
        }
    }

    public static function import($sql)
    {
        if (!self::$PDO) {
            self::connect();
        }
        try {
            self::$PDO->exec($sql);
            return true;
        } catch (\PDOException $e) {
            self::error($e);
        }
    }

    public static function escape($data)
    {
        if (!self::$PDO) {
            self::connect();
        }
        return self::$PDO->quote($data);
    }

    protected static function valueType($item)
    {
        switch ($item) {
            case is_int($item):
                $type = \PDO::PARAM_INT;
                break;
            case is_bool($item):
                $type = \PDO::PARAM_BOOL;
                break;
            case is_null($item):
                $type = \PDO::PARAM_NULL;
                break;
            default:
                $type = \PDO::PARAM_STR;
        }
        return $type;
    }

    protected static function error($e)
    {
        error_log($e->getMessage());
    }
}
