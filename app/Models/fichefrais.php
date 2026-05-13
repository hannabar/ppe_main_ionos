<?php

namespace Models;

use Config\Database;
final class fichefrais {
     public static function findAll(): array
    {
        $pdo = Database::get();
        $st  = $pdo->query('SELECT 
    fichefrais.idVisiteur,
    visiteur.nom ,
    fichefrais.mois ,
    fichefrais.nbrJustificatifs ,
    fichefrais.montantValide,
    fichefrais.dateModif,
    lignefraishorforfait.libelle AS LibelleHorForfait,
    Etat.libelle AS LibelleEtat
FROM 
    fichefrais
JOIN 
    visiteur ON fichefrais.idVisiteur = visiteur.id
JOIN 
    lignefraishorforfait ON fichefrais.idLigneFraisHorsForfait = lignefraishorforfait.id
JOIN 
    Etat ON fichefrais.idEtat = Etat.id');
        return $st->fetchAll(); // FETCH_ASSOC déjà par défaut via Database
    }
    public static function findById(int $idVisiteur, int $mois): ?array{
        $pdo = Database::get(); //connexion avec la base de données 
        $st  = $pdo->prepare('SELECT * FROM fichefrais WHERE idVisiteur = :idVisiteur AND mois = :mois');
        $st ->execute([
            'idVisiteur' => $idVisiteur,
            'mois' => $mois]); //execute est une fonction sql qui va executer la requete dans la base de donnée
        $row = $st->fetch(); //fetch permet de récupérer l'execution 
        return $row ?: null; 
    }
    
  public static function create(int $idVisiteur, int $mois, int $nbrJustificatifs, float $montantValide, int $idLigneFraisHorsForfait, int $idEtat): bool
    {
        $pdo = Database::get();
        $sql = 'INSERT INTO fichefrais (IDvisiteur, mois, nbrJustificatifs, montantValide, dateModif, idLigneFraisHorsForfait, idEtat) 
                VALUES (?, ?, ?, ?, curdate(), ? , ?)';
        
        $st = $pdo->prepare($sql);
        return $st->execute([
            $idVisiteur, 
            $mois, 
            $nbrJustificatifs, 
            $montantValide, 
            $idLigneFraisHorsForfait, 
            $idEtat
        ]);
    }
      
    
    public static function exists(int $idVisiteur, int $mois): bool {
        try {
            $pdo = Database::get();
            $sql = "SELECT COUNT(*) FROM fichefrais WHERE IDvisiteur = :IDvisiteur AND mois = :mois";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':IDvisiteur' => $idVisiteur,
                ':mois' => $mois]);
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Erreur exists : " . $e->getMessage());
            return false;
        }
    }
public static function update(int $idVisiteur, int $mois, int $nbrJustificatifs, float $montantValide, int $idEtat): bool
    {
        $pdo = Database::get();
        $sql = 'UPDATE fichefrais 
                SET nbrJustificatifs = :nbr, 
                    montantValide = :montant, 
                    idEtat = :etat, 
                    dateModif = NOW() 
                WHERE IDvisiteur = :idV AND mois = :mois';
        
        $st = $pdo->prepare($sql);
        return $st->execute([
            'nbr'     => $nbrJustificatifs,
            'montant' => $montantValide,
            'etat'    => $idEtat,
            'idV'     => $idVisiteur,
            'mois'    => $mois
        ]);
    }

public static function delete(int $idVisiteur, int $mois): bool
{
    $pdo = Database::get();
    $st  = $pdo->prepare('DELETE FROM fichefrais WHERE IDvisiteur = ? AND mois = ?');
    return $st->execute([$idVisiteur, $mois]);
}


}

?>
