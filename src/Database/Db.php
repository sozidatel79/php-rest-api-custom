<?php
namespace App\Database;

use PDOException;
use PDO;
use App\Helpers\JsonHelper;

class Db
{
    private $database;

    private const DB_USERNAME = 'anton';
    private const DB_PASSWORD = '13151315';
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'todo';

    private static $instance;

    private $dsn;

    private function __construct(){
        $this->dsn = `mysql:host=${ self::DB_HOST };dbname=${ self::DB_NAME }`;
        $this->database = $this->connect( $this->dsn );
    }

    private function __clone(){}

    /**
     * @return \PDO|string
     */
    public function getDatabase(): PDO {
        return $this->database;
    }

    /**
     * @return static
     */
    public static function getInstance(): self {
        if( ! self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $dsn ;
     * @return \PDO|string
     */
    private function connect($dsn) {
        try {
            $conn = new \PDO($dsn,self::DB_USERNAME, self::DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            return $conn;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function store($data) {
        $insert_data = JsonHelper::jsonToArray($data);
        $sql = `INSERT INTO todos (title, complete) values(?,?,?)`;

        try {
            $query = $this->getDatabase()->prepare($sql);
            $query->execute([
                $insert_data['title'],
                $insert_data['complete']
            ]);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function getAll() {
        $sql = `SELECT * FROM todos`;
        try {
            $query = $this->getDatabase()->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function update($data) {
        $update_data = JsonHelper::jsonToArray($data);
        $sql = `UPDATE todos SET title = ?, complete = ? WHERE id = ?`;
        try {
            $query = $this->getDatabase()->prepare($sql);
            $query->execute([
                $update_data['title'],
                $update_data['complete'],
                $update_data['id']
            ]);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function delete ($data) {
        $delete_data = JsonHelper::jsonToArray($data);
        $sql = `DELETE FROM todos WHERE id = ?`;
        try {
            $query = $this->getDatabase()->prepare($sql);
            $query->execute([
                $delete_data['id']
            ]);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}