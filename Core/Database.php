<?php

namespace Core;

class Database
{
    public static function create($query, $params = [])
    {
        global $db;
        try {
            $stmt = $db->prepare($query);
            $stmt->execute($params);
            return true;
        } catch (\PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }
    public static function read($query, $params = [])
    {
        global $db;
        try {
            $stmt = $db->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }
    // read one
    public static function readOne($query, $params)
    {
        global $db;
        try {
            $stmt = $db->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }
    public function update($query, $params)
    {
        global $db;
        try {
            $stmt = $db->prepare($query);
            $stmt->execute($params);
            return true;
        } catch (\PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }
    public function delete($query, $params)
    {
        global $db;
        try {
            $stmt = $db->prepare($query);
            $stmt->execute($params);
            return true;
        } catch (\PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }
}
