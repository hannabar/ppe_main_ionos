<?php

namespace Models;

use Config\Database;
final class visiteur {
     public static function findAll(): array
    {
        $pdo = Database::get();
        $st  = $pdo->query('SELECT id,nom,prenom,adresse,ville,cp,date_embauche,login,mdp FROM visiteur');
        return $st->fetchAll(); // FETCH_ASSOC déjà par défaut via Database
    }
    public static function findById(int $id): ?array{
        $pdo = Database::get();
        $st  = $pdo->prepare('SELECT id,nom,prenom,adresse,ville,cp,date_embauche,login,mdp FROM visiteur WHERE id = :id');
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
    public static function create_visiteur(
    string $nom,
    string $prenom,
    string $adresse,
    string $ville,
    string $cp,
    string $date_embauche,
    string $login,
    string $mdp
): int
{
    $pdo = Database::get(); // Connexion avec la base de données
    
    // Hachage du mot de passe pour la sécurité
    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
    
    $st = $pdo->prepare(
        'INSERT INTO visiteur (nom, prenom, adresse, ville, cp, date_embauche, login, mdp) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );
    

    $st->execute([
         $nom,
         $prenom,
         $adresse,
         $ville,
         $cp,
         $date_embauche,
         $login,
         $mdp_hash
     ]); // Execute est une fonction SQL qui va exécuter la requête dans la base de données
    
    return (int)$pdo->lastInsertId();
}

public static function update(int $id, string $adresse, string $ville, string $cp, string $mdp): bool
{
    $pdo = Database::get();

    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

    $st = $pdo->prepare(
        'UPDATE visiteur 
         SET adresse = ?, ville = ?, cp = ?, mdp = ?
         WHERE id = ?'
    );

    return $st->execute([$adresse, $ville, $cp, $mdp_hash, $id]);
}

public static function delete(int $id): bool
{
    $pdo = Database::get();
    $st  = $pdo->prepare('DELETE FROM visiteur WHERE id = ?');
    return $st->execute([$id]);
}

public static function updatePassword(int $id, string $nouveauMdp): bool
{
    $pdo = Database::get();

    $hash = password_hash($nouveauMdp, PASSWORD_DEFAULT);

    $sql = "UPDATE visiteur SET mdp = :hash WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'hash' => $hash,
        'id'   => $id
    ]);
}
}

?>
