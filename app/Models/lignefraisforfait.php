<?php

namespace Models;

use Config\Database;

final class lignefraisforfait {

    public static function findAll(): array
    {
        $pdo = Database::get();
        $st  = $pdo->query('SELECT 
            lff.IDvisiteur,
            v.nom,
            lff.mois,
            lff.IDfraisforfait,
            ff.libelle AS libelleFraisForfait,
            lff.quantite
        FROM lignefraisforfait lff
        JOIN visiteur v ON lff.IDvisiteur = v.id
        JOIN fraisforfait ff ON lff.IDfraisforfait = ff.id');
        return $st->fetchAll();
    }

    public static function findById(int $idVisiteur, string $mois, int $idFraisForfait): ?array
    {
        $pdo = Database::get();
        $st  = $pdo->prepare('SELECT * FROM lignefraisforfait 
                               WHERE IDvisiteur = :idVisiteur 
                               AND mois = :mois 
                               AND IDfraisforfait = :idFraisForfait');
        $st->execute([
            'idVisiteur'     => $idVisiteur,
            'mois'           => $mois,
            'idFraisForfait' => $idFraisForfait,
        ]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public static function findByVisiteurMois(int $idVisiteur, string $mois): array
    {
        $pdo = Database::get();
        $st  = $pdo->prepare('SELECT 
            lff.IDvisiteur,
            lff.mois,
            lff.IDfraisforfait,
            ff.libelle AS libelleFraisForfait,
            lff.quantite
        FROM lignefraisforfait lff
        JOIN fraisforfait ff ON lff.IDfraisforfait = ff.id
        WHERE lff.IDvisiteur = :idVisiteur AND lff.mois = :mois');
        $st->execute([
            'idVisiteur' => $idVisiteur,
            'mois'       => $mois,
        ]);
        return $st->fetchAll();
    }

    public static function exists(int $idVisiteur, string $mois, int $idFraisForfait): bool
    {
        try {
            $pdo  = Database::get();
            $sql  = 'SELECT COUNT(*) FROM lignefraisforfait 
                     WHERE IDvisiteur = :idVisiteur 
                     AND mois = :mois 
                     AND IDfraisforfait = :idFraisForfait';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':idVisiteur'     => $idVisiteur,
                ':mois'           => $mois,
                ':idFraisForfait' => $idFraisForfait,
            ]);
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Erreur exists lignefraisforfait : " . $e->getMessage());
            return false;
        }
    }

    public static function create(int $idVisiteur, string $mois, int $idFraisForfait, int $quantite): bool
    {
        $pdo = Database::get();
        $sql = 'INSERT INTO lignefraisforfait (IDvisiteur, mois, IDfraisforfait, quantite) 
                VALUES (?, ?, ?, ?)';
        $st  = $pdo->prepare($sql);
        return $st->execute([$idVisiteur, $mois, $idFraisForfait, $quantite]);
    }

    public static function update(int $idVisiteur, string $mois, int $idFraisForfait, int $quantite): bool
    {
        $pdo = Database::get();
        $sql = 'UPDATE lignefraisforfait 
                SET quantite = :quantite 
                WHERE IDvisiteur = :idVisiteur 
                AND mois = :mois 
                AND IDfraisforfait = :idFraisForfait';
        $st  = $pdo->prepare($sql);
        return $st->execute([
            'quantite'       => $quantite,
            'idVisiteur'     => $idVisiteur,
            'mois'           => $mois,
            'idFraisForfait' => $idFraisForfait,
        ]);
    }

    public static function delete(int $idVisiteur, string $mois, int $idFraisForfait): bool
    {
        $pdo = Database::get();
        $st  = $pdo->prepare('DELETE FROM lignefraisforfait 
                               WHERE IDvisiteur = ? AND mois = ? AND IDfraisforfait = ?');
        return $st->execute([$idVisiteur, $mois, $idFraisForfait]);
    }
}