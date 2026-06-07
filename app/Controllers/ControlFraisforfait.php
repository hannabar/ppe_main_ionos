<?php

namespace Controllers;
use Core\Controller;
use Models\fraisforfait;

final class ControlFraisforfait extends Controller {

    public function index(): void {
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    try {
        $forfait = fraisforfait::findAll();
    } catch(\Throwable $e) {
        $_SESSION['flash'] = 'Impossible de charger des frais';
        $forfait = [];
    }

    $this->render('forfait/index', [
        'title'   => "Liste des frais de forfait",
        'forfait' => $forfait,
        'message' => $_SESSION['flash'] ?? '',
    ]);
    unset($_SESSION['flash']);
}

public function show($id): void {
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    $id = (int)$id;

    try {
        $forfait = fraisforfait::findById($id);
        if (!$forfait) {
            $_SESSION['flash'] = 'Forfait introuvable.';
            $this->redirect('/index.php/forfait');
        }
    } catch (\Throwable $e) {
        $_SESSION['flash'] = 'Erreur lors du chargement du forfait.';
        $forfait = null;
    }

    $this->render('forfait/show', [
        'title'   => 'Détail du forfait',
        'forfait' => $forfait,
        'message' => $_SESSION['flash'] ?? '',
    ]);
    unset($_SESSION['flash']);
}

    public function create(): void {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php');
        if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $this->render('forfait/create', [
            'title'   => 'Créer un forfait',
            'message' => $_SESSION['flash'] ?? '',
            'old'     => $_SESSION['old'] ?? ['libelle' => ''],
            'errors'  => $_SESSION['errors'] ?? [],
        ]);

        unset($_SESSION['flash'], $_SESSION['old'], $_SESSION['errors']);
    }

    public function store(): void {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php');
        if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $libelle = trim($_POST['libelle'] ?? '');
        $montant = $_POST['montant'] ?? '';
        $errors  = [];

        if ($libelle === '') {
            $errors['libelle'] = 'Le libellé est obligatoire.';
        } elseif (mb_strlen($libelle) > 100) {
            $errors['libelle'] = 'Le libellé ne doit pas dépasser 100 caractères.';
        }

        if ($montant === '') {
            $errors['montant'] = 'Le montant est obligatoire.';
        } elseif ($montant <= 0) {
            $errors['montant'] = 'Le montant ne doit pas être négatif.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old']    = ['libelle' => $libelle, 'montant' => $montant];
            $_SESSION['flash']  = 'Merci de corriger les erreurs du formulaire.';
            $this->redirect('/index.php/forfait/create');
        }

        try {
            $id = \Models\fraisforfait::create_forfait($libelle, $montant);
            $_SESSION['flash'] = 'Forfait créé avec succès.';
            $this->redirect('/index.php/forfait/' . $id);
        } catch (\Throwable $e) {
            $_SESSION['flash'] = 'Impossible de créer le forfait.';
            $this->redirect('/index.php/forfait');
        }
    }

    public function edit($id): void {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php');
        if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $id = (int)$id;

        try {
            $forfait = \Models\fraisforfait::findById($id);
            if (!$forfait) {
                $_SESSION['flash'] = "Forfait introuvable.";
                $this->redirect('/index.php/forfait');
            }
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors du chargement du forfait.";
            $this->redirect('/index.php/forfait');
        }

        $old = $_SESSION['old'] ?? [
            'libelle' => $forfait['libelle'],
            'montant' => $forfait['montant'],
        ];

        $this->render('forfait/edit', [
            'title'   => 'Modifier un forfait',
            'forfait' => $forfait,
            'old'     => $old,
            'errors'  => $_SESSION['errors'] ?? [],
            'message' => $_SESSION['flash'] ?? ''
        ]);

        unset($_SESSION['old'], $_SESSION['errors'], $_SESSION['flash']);
    }

    public function update($id): void {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php');
        if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $id      = (int)$id;
        $libelle = trim($_POST['libelle'] ?? '');
        $montant = trim($_POST['montant'] ?? '');
        $errors  = [];

        if ($libelle === '') $errors['libelle'] = 'Le libellé est obligatoire.';
        if ($montant === '') $errors['montant'] = 'Le montant est obligatoire.';

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old']    = ['libelle' => $libelle, 'montant' => $montant];
            $_SESSION['flash']  = "Merci de corriger les erreurs.";
            $this->redirect("/index.php/forfait/$id/edit");
        }

        try {
            \Models\fraisforfait::update($id, $libelle, $montant);
            $_SESSION['flash'] = "Forfait modifié avec succès.";
            $this->redirect("/index.php/forfait/$id");
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors de la mise à jour.";
            $this->redirect("/index.php/forfait");
        }
    }

    public function delete($id): void {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php');
        if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $id = (int)$id;

        try {
            $ok = \Models\fraisforfait::delete($id);
            $_SESSION['flash'] = $ok ? "Forfait supprimé avec succès." : "Impossible de supprimer ce forfait.";
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors de la suppression du forfait.";
        }

        $this->redirect('/index.php/forfait');
    }
}