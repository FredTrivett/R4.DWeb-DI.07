<?php 

// create a methode getAllLegos that gets the legoes from the database (on the port 8088) and returns them

namespace App\Service;

use PDO;


class DatabaseInterface
{
    public function getAllLegos(): array
    {
        $db = new PDO('mysql:host=tp-symfony-mysql;dbname=lego_store', 'root', 'root');
        $query = $db->query('SELECT * FROM lego');
        $legos = $query->fetchAll(PDO::FETCH_ASSOC);
        return $legos;
    }

    public function getLegosByCollection(string $collection): array
    {
        $db = new PDO('mysql:host=tp-symfony-mysql;dbname=lego_store', 'root', 'root');
        $query = $db->prepare('SELECT * FROM lego WHERE collection = :collection');
        $query->execute(['collection' => $collection]);
        $legos = $query->fetchAll(PDO::FETCH_ASSOC);
        return $legos;
    }
}