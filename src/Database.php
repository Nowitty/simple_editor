<?php
namespace App;

class Database
{
    public function __construct()
    {
        $opt = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION);
        $this->pdo = new \PDO('pgsql:host=localhost;dbname=ruslankuga', null, null, $opt);
    }
    public function insert($data)
    {
        $sql = "INSERT INTO articles VALUES ({$this->pdo->quote($data)});";
        $this->pdo->exec($sql);
    }
    public function select()
    {
        $article = $this->pdo->query("SELECT * FROM articles")->fetchAll(\PDO::FETCH_ASSOC);
        return $article[0]['body'];
    }

    public function update($data)
    {
        
        $sql = "UPDATE articles SET body =?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data]);
    }
}