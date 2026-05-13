<?php

namespace Models;

use Config\Database;
final class horforfait {
     public static function findAll(): array
    {
        $pdo = Database::get();
        $st  = $pdo->query('SELECT id,date,montant,libelle FROM lignefraishorforfait');
        return $st->fetchAll(); // FETCH_ASSOC déjà par défaut via Database
    }
    public static function findById(int $id): ?array{
        $pdo = Database::get();
        $st  = $pdo->prepare('SELECT id,date,montant,libelle  FROM lignefraishorforfait WHERE id = :id');
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

    public static function create_horforfait(string $date ,float $montant, string $libelle ): int
    {
        $pdo = Database::get(); //connexion avec la base de données
        $st  = $pdo->prepare('INSERT INTO lignefraishorforfait (date,montant, libelle ) VALUES (? , ?, ?)');
        $st ->execute([$date,$montant,$libelle]); //execute est une fonction sql qui va executer la requete dans la base de donnée
        return (int)$pdo->lastInsertId();
    }




     public static function update(int $id, string $date, float $montant ,string $libelle): bool
    {
        $pdo = Database::get();
        $st  = $pdo->prepare('UPDATE lignefraishorforfait SET  date= ? , montant=?, libelle = ? WHERE id = ?');
        return $st->execute([$date,$montant,$libelle,$id]);
    }

     public static function delete(int $id): bool
{
    $pdo = Database::get();
    $st  = $pdo->prepare('DELETE FROM lignefraishorforfait WHERE id = ?');
    return $st->execute([$id]);
}














































      

}
   


?>