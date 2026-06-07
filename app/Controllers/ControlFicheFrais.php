<?php

namespace Controllers;
use Core\Controller;
use Models\fichefrais;
use Models\visiteur;
use Models\horforfait;
use Models\etat;


final class ControlFicheFrais extends Controller{
    
    public function index():void{
        if (empty($_SESSION['uid'])){
            $this->redirect('/index.php');
        }
        
        try {
            if ($_SESSION['role'] === 'comptable') {
                $fichefrais = fichefrais::findAll();
            } else {
                $fichefrais = fichefrais::findByVisiteur((int)$_SESSION['uid']);
            }
            } catch(\Throwable $e){
            $_SESSION['flash'] = 'Impossible de charger les fiches de frais';
            $fichefrais = [];
            }
        
        $this->render('fichefrais/index', [
            'title' => "Liste des fiches de frais",
            'fichefrais' => $fichefrais,
            'message' => $_SESSION['flash'] ?? '',
        ]);
        
        unset($_SESSION['flash']);
    }

    public function show($idVisiteur, $mois): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    $fichefrais = fichefrais::findById($idVisiteur, $mois);
    if (!$fichefrais) {
        http_response_code(404);
        $_SESSION['flash'] = 'Fiche frais introuvable.';
        $this->redirect('/index.php/fichefrais');
    }

    $lignesForfait = \Models\lignefraisforfait::findByVisiteurMois((int)$idVisiteur, (string)$mois);

    $this->render('fichefrais/show', [
        'title'         => 'Détail de la fiche frais',
        'fichefrais'    => $fichefrais,
        'lignesForfait' => $lignesForfait,
        'message'       => $_SESSION['flash'] ?? '',
    ]);

    unset($_SESSION['flash']);
}

    public function create(): void {
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    $visiteurs  = visiteur::findAll();
    $horforfait = horforfait::findAll();
    $etat       = etat::findAll();
    $forfaits   = \Models\fraisforfait::findAll();

    $this->render('fichefrais/create', [
        'title'      => 'Créer une fiche frais',
        'message'    => $_SESSION['flash'] ?? '',
        'old'        => $_SESSION['old'] ?? [],
        'errors'     => $_SESSION['errors'] ?? [],
        'visiteurs'  => $visiteurs,
        'horforfait' => $horforfait,
        'etat'       => $etat,
        'forfaits'   => $forfaits, 
    ]);

    unset($_SESSION['flash'], $_SESSION['old'], $_SESSION['errors']);
}

    public function store(): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    $idVisiteur              = trim($_POST['idVisiteur'] ?? '');
    $mois                    = trim($_POST['mois_annee'] ?? '') . trim($_POST['mois_mois'] ?? '');
    $nbrJustificatifs        = (int)($_POST['nbrJustificatifs'] ?? 0);
    $montantValide           = (float)($_POST['montantValide'] ?? 0);
    $idLigneFraisHorsForfait = !empty($_POST['idLigneFraisHorsForfait']) ? (int)$_POST['idLigneFraisHorsForfait'] : null;
    $idEtat                  = (int)($_POST['idEtat'] ?? 0);

    $errors = [];

    if ($idVisiteur === '')    $errors['idVisiteur'] = "L'identifiant visiteur est obligatoire.";
    if ($mois === '')          $errors['mois'] = 'Le mois est obligatoire.';
    if ($nbrJustificatifs < 0) $errors['nbrJustificatifs'] = 'Le nombre de justificatifs ne peut pas être négatif.';
    if ($montantValide < 0)    $errors['montantValide'] = 'Le montant ne peut pas être négatif.';

    if (empty($errors) && fichefrais::exists($idVisiteur, $mois)) {
        $errors['general'] = 'Une fiche de frais existe déjà pour ce visiteur et ce mois.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old']    = [
            'idVisiteur'              => $idVisiteur,
            'mois_annee'              => trim($_POST['mois_annee'] ?? ''),
            'mois_mois'               => trim($_POST['mois_mois'] ?? ''),
            'nbrJustificatifs'        => $nbrJustificatifs,
            'montantValide'           => $montantValide,
            'idLigneFraisHorsForfait' => $idLigneFraisHorsForfait,
            'idEtat'                  => $idEtat,
        ];
        $_SESSION['flash'] = 'Merci de corriger les erreurs du formulaire.';
        $this->redirect('/index.php/fichefrais/create');
    }

    try {
    
        if (!empty($idLigneFraisHorsForfait)) {
            fichefrais::create($idVisiteur, $mois, $nbrJustificatifs, $montantValide, $idLigneFraisHorsForfait, $idEtat);
        } else {
            fichefrais::createSansHorForfait($idVisiteur, $mois, $nbrJustificatifs, $montantValide, $idEtat);
        }

        // Créer les lignes forfaitaires
        $quantites = $_POST['quantites'] ?? [];
        foreach ($quantites as $idForfait => $quantite) {
            $quantite = (int)$quantite;
            if ($quantite > 0) {
                \Models\lignefraisforfait::create((int)$idVisiteur, $mois, (int)$idForfait, $quantite);
            }
        }

        $_SESSION['flash'] = 'Fiche de frais créée avec succès.';
        $this->redirect('/index.php/fichefrais/' . $idVisiteur . '/' . $mois);

    } catch (\Throwable $e) {
        $_SESSION['flash'] = 'Impossible de créer la fiche de frais.';
        $this->redirect('/index.php/fichefrais');
    }
}

    public function edit($idVisiteur, $mois): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php');

        $etat = etat::findAll();

        try {
            $fichefrais = fichefrais::findById($idVisiteur, $mois);
            if (!$fichefrais) {
                $_SESSION['flash'] = "Fiche de frais introuvable.";
                $this->redirect('/index.php/fichefrais');
            }
            if ($fichefrais['idEtat'] != 1) {
            $_SESSION['flash'] = "Cette fiche ne peut plus être modifiée.";
            $this->redirect("/index.php/fichefrais/$idVisiteur/$mois");
            }
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors du chargement de la fiche de frais.";
            $this->redirect('/index.php/fichefrais');
        }

        $old = $_SESSION['old'] ?? [
            'IDvisiteur' => $fichefrais['IDvisiteur'],
            'mois' => $fichefrais['mois'],
            'nbrJustificatifs' => $fichefrais['nbrJustificatifs'],
            'montantValide' => $fichefrais['montantValide'],
            'idEtat' => $fichefrais['idEtat']
        ];

        $this->render('fichefrais/edit', [
            'title' => 'Modifier une fiche frais',
            'fichefrais' => $fichefrais,
            'old' => $old,
            'errors' => $_SESSION['errors'] ?? [],
            'message' => $_SESSION['flash'] ?? '',
            'etat' => $etat,

        ]);

        unset($_SESSION['old'], $_SESSION['errors'], $_SESSION['flash']);
    }

    public function update($idVisiteur, $mois): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    $fichefrais = fichefrais::findById($idVisiteur, $mois);
    if (!$fichefrais || $fichefrais['idEtat'] != 1) {
        $_SESSION['flash'] = 'Cette fiche ne peut plus être modifiée.';
        $this->redirect("/index.php/fichefrais/$idVisiteur/$mois");
    } 

    $nbrJustificatifs = (int)($_POST['nbrJustificatifs'] ?? 0);
    $montantValide    = (float)($_POST['montantValide'] ?? 0);
    $idEtat           = (int)($_POST['idEtat'] ?? 0);

    $errors = [];
    if ($nbrJustificatifs < 0) $errors['nbrJustificatifs'] = 'Le nombre de justificatifs ne peut pas être négatif.';
    if ($montantValide < 0)    $errors['montantValide'] = 'Le montant ne peut pas être négatif.';

    if ($errors) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old']    = ['nbrJustificatifs' => $nbrJustificatifs, 'montantValide' => $montantValide, 'idEtat' => $idEtat];
        $_SESSION['flash']  = "Merci de corriger les erreurs.";
        $this->redirect("/index.php/fichefrais/$idVisiteur/$mois/edit");
    }

    try {
        fichefrais::update($idVisiteur, $mois, $nbrJustificatifs, $montantValide, $idEtat);
        $_SESSION['flash'] = "Fiche de frais modifiée avec succès.";
        $this->redirect("/index.php/fichefrais/$idVisiteur/$mois");
    } catch (\Throwable $e) {
        $_SESSION['flash'] = "Erreur lors de la mise à jour.";
        $this->redirect("/index.php/fichefrais");
    }
}

public function delete($idVisiteur, $mois): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    $fichefrais = fichefrais::findById($idVisiteur, $mois);
    if (!$fichefrais || $fichefrais['idEtat'] != 1) {
        $_SESSION['flash'] = 'Cette fiche ne peut plus être supprimée.';
        $this->redirect('/index.php/fichefrais');
    } 

    try {
        $ok = fichefrais::delete($idVisiteur, $mois);
        $_SESSION['flash'] = $ok ? "Fiche de frais supprimée avec succès." : "Impossible de supprimer cette fiche de frais.";
    } catch (\Throwable $e) {
        $_SESSION['flash'] = "Erreur lors de la suppression de la fiche de frais.";
    }

    $this->redirect('/index.php/fichefrais');
}
}