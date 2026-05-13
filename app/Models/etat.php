<?php

namespace Models;

use Config\Database;
final class etat {
     public static function findAll(): array
    {
        $pdo = Database::get();
        $st  = $pdo->query('SELECT id, libelle FROM etat');
        return $st->fetchAll(); // FETCH_ASSOC déjà par défaut via Database
    }
    public static function findById(int $id): ?array{
        $pdo = Database::get(); //connexion avec la base de données 
        $st  = $pdo->prepare('SELECT id, libelle FROM etat WHERE id = :id');
        $st ->execute(['id' => $id]); //execute est une fonction sql qui va executer la requete dans la base de donnée
        $row = $st->fetch(); //fetch permet de récupérer l'execution 
        return $row ?: null; 
    }
    
    public static function create(string $libelle): int
    {
        $pdo = Database::get(); //connexion avec la base de données
        $st  = $pdo->prepare('INSERT INTO etat (libelle) VALUES (?)');
        $st ->execute([$libelle]); //execute est une fonction sql qui va executer la requete dans la base de donnée
        return (int)$pdo->lastInsertId();
    }
      
    
    public static function exists(int $id): bool {
        try {
            $pdo = Database::get();
            $sql = "SELECT COUNT(*) FROM etat WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Erreur exists : " . $e->getMessage());
            return false;
        }
    }

    public static function update(int $id, string $libelle): bool
{
    $pdo = Database::get();
    $st  = $pdo->prepare('UPDATE etat SET libelle = ? WHERE id = ?');
    return $st->execute([$libelle, $id]);
}

public static function delete(int $id): bool
{
    $pdo = Database::get();
    $st  = $pdo->prepare('DELETE FROM etat WHERE id = ?');
    return $st->execute([$id]);
}


}

?>
