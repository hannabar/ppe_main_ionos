<?php

namespace Controllers;
use Core\Controller;
use Models\lignefraisforfait;

final class ControlLigneFraisForfait extends Controller{
    
    public function index(): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');
        
        try {
            $lignefraisforfait = lignefraisforfait::findAll();
        } catch(\Throwable $e){
            $_SESSION['flash'] = 'Impossible de charger les lignes de frais forfait';
            $lignefraisforfait = [];
        }
        
        $this->render('lignefraisforfait/index', [
            'title'            => "Liste des lignes de frais forfait",
            'lignefraisforfait' => $lignefraisforfait,
            'message'          => $_SESSION['flash'] ?? '',
        ]);
        
        unset($_SESSION['flash']);
    }

    public function show($idVisiteur, $mois, $idFraisForfait): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        try {
            $ligne = lignefraisforfait::findById($idVisiteur, $mois, $idFraisForfait);
            if (!$ligne) {
                http_response_code(404);
                $_SESSION['flash'] = 'Ligne de frais forfait introuvable.';
                $this->redirect('/lignefraisforfait');
            }
        } catch (\Throwable $e) {
            $_SESSION['flash'] = 'Erreur lors du chargement de la ligne de frais forfait.';
            $this->redirect('/lignefraisforfait');
        }

        $this->render('lignefraisforfait/show', [
            'title'            => 'Détail de la ligne de frais forfait',
            'lignefraisforfait' => $ligne,
            'message'          => $_SESSION['flash'] ?? '',
        ]);
        
        unset($_SESSION['flash']);
    }

    public function create(): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/');

    try {
        $visiteurs    = \Models\visiteur::findAll();
        $fraisforfait = \Models\fraisforfait::findAll();
    } catch (\Throwable $e) {
        $visiteurs    = [];
        $fraisforfait = [];
    }

    $this->render('lignefraisforfait/create', [
        'title'        => 'Créer une ligne de frais forfait',
        'message'      => $_SESSION['flash'] ?? '',
        'old'          => $_SESSION['old'] ?? [],
        'errors'       => $_SESSION['errors'] ?? [],
        'visiteurs'    => $visiteurs,
        'fraisforfait' => $fraisforfait,
    ]);

    unset($_SESSION['flash'], $_SESSION['old'], $_SESSION['errors']);
}

    public function store(): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        $idVisiteur       = trim($_POST['idVisiteur'] ?? '');
        $mois             = trim($_POST['mois_annee'] ?? '') . trim($_POST['mois_mois'] ?? '');
        $idFraisForfait   = (int)($_POST['idFraisForfait'] ?? 0);
        $quantite         = (int)($_POST['quantite'] ?? 0);

        $errors = [];

        if ($idVisiteur === '') {
            $errors['idVisiteur'] = "L'identifiant visiteur est obligatoire.";
        }

        if ($mois === '') {
            $errors['mois'] = 'Le mois est obligatoire.';
        }

        if ($idFraisForfait <= 0) {
            $errors['idFraisForfait'] = 'Le type de frais forfait est obligatoire.';
        }

        if ($quantite < 0) {
            $errors['quantite'] = 'La quantité ne peut pas être négative.';
        }

        // Clé composite : (IDvisiteur, mois, IDfraisforfait)
        if (empty($errors) && lignefraisforfait::exists($idVisiteur, $mois, $idFraisForfait)) {
            $errors['general'] = 'Une ligne de frais forfait existe déjà pour ce visiteur, ce mois et ce type de frais.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = [
                'idVisiteur'     => $idVisiteur,
                'mois_annee'     => trim($_POST['mois_annee'] ?? ''),
                'mois_mois'      => trim($_POST['mois_mois'] ?? ''),
                'idFraisForfait' => $idFraisForfait,
                'quantite'       => $quantite,
            ];
            $_SESSION['flash'] = 'Merci de corriger les erreurs du formulaire.';
            $this->redirect('/lignefraisforfait/create');
        }


        try {
            lignefraisforfait::create($idVisiteur, $mois, $idFraisForfait, $quantite);
            $_SESSION['flash'] = 'Ligne de frais forfait créée avec succès.';
            $this->redirect('/lignefraisforfait/' . $idVisiteur . '/' . $mois);
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }

    public function edit($idVisiteur, $mois, $idFraisForfait): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        try {
            $ligne = lignefraisforfait::findById($idVisiteur, $mois, $idFraisForfait);
            if (!$ligne) {
                $_SESSION['flash'] = "Ligne de frais forfait introuvable.";
                $this->redirect('/lignefraisforfait');
            }
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors du chargement de la ligne de frais forfait.";
            $this->redirect('/lignefraisforfait');
        }

        $old = $_SESSION['old'] ?? [
            'IDvisiteur'     => $ligne['IDvisiteur'],
            'mois'           => $ligne['mois'],
            'IDfraisforfait' => $ligne['IDfraisforfait'],
            'quantite'       => $ligne['quantite'],
        ];

        $this->render('lignefraisforfait/edit', [
            'title'            => 'Modifier une ligne de frais forfait',
            'lignefraisforfait' => $ligne,
            'old'              => $old,
            'errors'           => $_SESSION['errors'] ?? [],
            'message'          => $_SESSION['flash'] ?? '',
        ]);

        unset($_SESSION['old'], $_SESSION['errors'], $_SESSION['flash']);
    }

    public function update($idVisiteur, $mois, $idFraisForfait): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        $quantite = (int)($_POST['quantite'] ?? 0);

        $errors = [];

        if ($quantite < 0) {
            $errors['quantite'] = 'La quantité ne peut pas être négative.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old']    = ['quantite' => $quantite];
            $_SESSION['flash']  = "Merci de corriger les erreurs.";
            $this->redirect("/lignefraisforfait/$idVisiteur/$mois/$idFraisForfait/edit");
        }

        try {
            lignefraisforfait::update($idVisiteur, $mois, $idFraisForfait, $quantite);
            $_SESSION['flash'] = "Ligne de frais forfait modifiée avec succès.";
            $this->redirect("/lignefraisforfait/$idVisiteur/$mois");
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors de la mise à jour.";
            $this->redirect("/lignefraisforfait");
        }
    }

    public function delete($idVisiteur, $mois, $idFraisForfait): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        try {
            $ok = lignefraisforfait::delete($idVisiteur, $mois, $idFraisForfait);

            $_SESSION['flash'] = $ok
                ? "Ligne de frais forfait supprimée avec succès."
                : "Impossible de supprimer cette ligne de frais forfait.";
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors de la suppression.";
        }

        $this->redirect("/lignefraisforfait/$idVisiteur/$mois");
    }
}