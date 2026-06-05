<?php
namespace Controllers;

use Core\Controller;
use Models\etat;

final class ControlEtat extends Controller
{
    public function index(): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php');
        if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        try {
            $etats = etat::findAll();
        } catch (\Throwable $e) {
            $_SESSION['flash'] = 'Impossible de charger les états.';
            $etats = [];
        }

        $this->render('etat/index', [
            'title'   => 'Liste des États',
            'etats'   => $etats,
            'message' => $_SESSION['flash'] ?? '',
        ]);
        unset($_SESSION['flash']);
    }

    public function show($id): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php');
        if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $id = (int)$id;

        try {
            $etat = \Models\etat::findById($id);
            if (!$etat) {
                $_SESSION['flash'] = 'État introuvable.';
                $this->redirect('/index.php/etat');
            }
        } catch (\Throwable $e) {
            $_SESSION['flash'] = 'Erreur lors du chargement de l\'état.';
            $etat = null;
        }

        $this->render('etat/show', [
            'title'   => 'Détail de l\'état',
            'etat'    => $etat,
            'message' => $_SESSION['flash'] ?? '',
        ]);
        unset($_SESSION['flash']);
    }

    public function create(): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php');
        if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $this->render('etat/create', [
            'title'   => 'Créer un état',
            'message' => $_SESSION['flash'] ?? '',
            'old'     => $_SESSION['old'] ?? ['libelle' => ''],
            'errors'  => $_SESSION['errors'] ?? [],
        ]);

        unset($_SESSION['flash'], $_SESSION['old'], $_SESSION['errors']);
    }

    public function store(): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');
      if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $libelle = trim($_POST['libelle'] ?? '');
        $errors = [];

        if ($libelle === '') {
            $errors['libelle'] = 'Le libellé est obligatoire.';
        } elseif (mb_strlen($libelle) > 100) {
            $errors['libelle'] = 'Le libellé ne doit pas dépasser 100 caractères.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old']    = ['libelle' => $libelle];
            $_SESSION['flash']  = 'Merci de corriger les erreurs du formulaire.';
            $this->redirect('/index.php/etat/create');
        }

        try {
            $id = \Models\etat::create($libelle);
            $_SESSION['flash'] = 'État créé avec succès.';
            $this->redirect('/index.php/etat/' . $id);
        } catch (\Throwable $e) {
            $_SESSION['flash'] = 'Impossible de créer l\'état.';
            $this->redirect('/index.php/etat');
        }
    }

    public function edit($id): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');
       if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $id = (int)$id;

        try {
            $etat = \Models\etat::findById($id);
            if (!$etat) {
                $_SESSION['flash'] = "État introuvable.";
                $this->redirect('/index.php/etat');
            }
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors du chargement de l'état.";
            $this->redirect('/index.php/etat');
        }

        $old = $_SESSION['old'] ?? ['libelle' => $etat['libelle']];

        $this->render('etat/edit', [
            'title'   => 'Modifier un état',
            'etat'    => $etat,
            'old'     => $old,
            'errors'  => $_SESSION['errors'] ?? [],
            'message' => $_SESSION['flash'] ?? ''
        ]);

        unset($_SESSION['old'], $_SESSION['errors'], $_SESSION['flash']);
    }

    public function update($id): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');
        if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $id = (int)$id;
        $libelle = trim($_POST['libelle'] ?? '');
        $errors = [];

        if ($libelle === '') {
            $errors['libelle'] = 'Le libellé est obligatoire.';
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old']    = ['libelle' => $libelle];
            $_SESSION['flash']  = "Merci de corriger les erreurs.";
            $this->redirect("/index.php/etat/$id/edit");
        }

        try {
            \Models\etat::update($id, $libelle);
            $_SESSION['flash'] = "État modifié avec succès.";
            $this->redirect("/index.php/etat/$id");
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors de la mise à jour.";
            $this->redirect("/index.php/etat");
        }
    }

    public function delete($id): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');
        if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

        $id = (int)$id;

        try {
            $ok = \Models\etat::delete($id);
            if ($ok) {
                $_SESSION['flash'] = "État supprimé avec succès.";
            } else {
                $_SESSION['flash'] = "Impossible de supprimer cet état.";
            }
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors de la suppression de l'état.";
        }

        $this->redirect('/index.php/etat');
    }
}