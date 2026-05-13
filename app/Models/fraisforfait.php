<?php

namespace Models;

use Config\Database;
final class fraisforfait {
     public static function findAll(): array
    {
        $pdo = Database::get();
        $st  = $pdo->query('SELECT id, libelle,montant FROM fraisforfait');
        return $st->fetchAll(); // FETCH_ASSOC déjà par défaut via Database
    }
    public static function findById(int $id): ?array{
        $pdo = Database::get();
        $st  = $pdo->prepare('SELECT id, libelle,montant FROM fraisforfait WHERE id = :id');
        $st ->execute(['id' => $id]); //execute est une fonction sql qui va executer la requete dans la base de donnée
        $row = $st->fetch(); //fetch permet de récupérer l'execution 
        return $row ?: null; 
    }
    // //public static function Insert(string $libelle):bool{
    //     $pdo = Database::get();
    //     $st  = $pdo->query('INSERT  libelle FROM etat);
    //     $st ->execute(['id'=>$id]); //execute est une fonction sql qui va executer la requete dans la base de donnée
    //     $row = $st->fetch(); //fetch permet de récupérer l'execution 
    //     return $row ?:null ;
    // }

    public static function create_forfait(string $libelle , float $montant): int
    {
        $pdo = Database::get(); //connexion avec la base de données
        $st  = $pdo->prepare('INSERT INTO fraisforfait (libelle, montant ) VALUES (? , ?)');
        $st ->execute([$libelle , $montant]); //execute est une fonction sql qui va executer la requete dans la base de donnée
        return (int)$pdo->lastInsertId();
    }




     public static function update(int $id, string $libelle, string $montant): bool
    {
        $pdo = Database::get();
        $st  = $pdo->prepare('UPDATE fraisforfait SET libelle = ?, montant=? WHERE id = ?');
        return $st->execute([$libelle , $montant, $id]);
    }

     public static function delete(int $id): bool
{
    $pdo = Database::get();
    $st  = $pdo->prepare('DELETE FROM fraisforfait WHERE id = ?');
    return $st->execute([$id]);
}














































      

}
   


?>