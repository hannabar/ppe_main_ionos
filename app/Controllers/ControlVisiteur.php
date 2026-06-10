<?php

namespace Controllers;
use Core\Controller;
use Models\visiteur;
final class ControlVisiteur extends Controller{
    public function index(): void {
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');
    
    if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}
    
    try {
        $visiteur = visiteur::findAll();
    } catch(\Throwable $e) {
        $_SESSION['flash'] = 'Impossible de trouver des visiteurs';
        $visiteur = [];
    }
    
    $this->render('visiteur/index', [
        'title'   => "Liste des visiteurs",
        'visiteur' => $visiteur,
        'message' => $_SESSION['flash'] ?? '',
    ]);
    
    unset($_SESSION['flash']);
}
    public function show($id): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    if ($_SESSION['role'] !== 'comptable' && $_SESSION['uid'] !== $id) {
    $_SESSION['flash'] = 'Accès refusé.';
    $this->redirect('/index.php/dashboard');
}

    $id = (int)$id;

    try {
        $visiteur =visiteur::findById($id);
        if (!$visiteur) {
            //http_response_code(404);
            $_SESSION['flash'] = 'Visiteur introuvable.';
            $this->redirect('/index.php/visiteur');
        }
    } catch (\Throwable $e) {
        // error_log($e->getMessage()); // utile en debug
        $_SESSION['flash'] = 'Erreur lors du chargement des visiteurs.';
        $visiteur = null;
    }

    $this->render('visiteur/show', [
        'title' => 'Détail du visteur',
        'visiteur'  => $visiteur,
        'message' => $_SESSION['flash'] ?? '',
    ]);
    unset($_SESSION['flash']);
}
public function create(): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/');

    if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}


    $this->render('visiteur/create', [
        'title'   => 'Créer un visiteur',
        'message' => $_SESSION['flash'] ?? '',
        'old'     => $_SESSION['old'] ?? [
            'nom' => '',
            'prenom' => '',
            'adresse' => '',
            'ville' => '',
            'cp' => '',
            'date_embauche' => '',
            'login' => ''
        ],
        'errors'  => $_SESSION['errors'] ?? [],
    ]);

    unset($_SESSION['flash'], $_SESSION['old'], $_SESSION['errors']);
}

public function store(): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

    $nom           = trim($_POST['nom'] ?? '');
    $prenom        = trim($_POST['prenom'] ?? '');
    $adresse       = trim($_POST['adresse'] ?? '');
    $ville         = trim($_POST['ville'] ?? '');
    $cp            = trim($_POST['cp'] ?? '');
    $date_embauche = trim($_POST['date_embauche'] ?? '');
    $login         = trim($_POST['login'] ?? '');
    $mdp           = $_POST['mdp'] ?? '';
    $mdp_confirm   = $_POST['mdp_confirm'] ?? '';
    
    $errors = [];

    if ($nom === '') {
        $errors['nom'] = 'Le nom est obligatoire.';
    } elseif (mb_strlen($nom) > 100) {
        $errors['nom'] = 'Le nom ne doit pas dépasser 100 caractères.';
    }

    if ($prenom === '') {
        $errors['prenom'] = 'Le prénom est obligatoire.';
    } elseif (mb_strlen($prenom) > 100) {
        $errors['prenom'] = 'Le prénom ne doit pas dépasser 100 caractères.';
    }

    if ($adresse === '') {
        $errors['adresse'] = 'L\'adresse est obligatoire.';
    } elseif (mb_strlen($adresse) > 255) {
        $errors['adresse'] = 'L\'adresse ne doit pas dépasser 255 caractères.';
    }

    if ($ville === '') {
        $errors['ville'] = 'La ville est obligatoire.';
    } elseif (mb_strlen($ville) > 100) {
        $errors['ville'] = 'La ville ne doit pas dépasser 100 caractères.';
    }

    if ($cp === '') {
        $errors['cp'] = 'Le code postal est obligatoire.';
    } elseif (!preg_match('/^[0-9]{5}$/', $cp)) {
        $errors['cp'] = 'Le code postal doit contenir exactement 5 chiffres.';
    }

    if ($date_embauche === '') {
        $errors['date_embauche'] = 'La date d\'embauche est obligatoire.';
    } elseif (!strtotime($date_embauche)) {
        $errors['date_embauche'] = 'La date d\'embauche n\'est pas valide.';
    }

    if ($login === '') {
        $errors['login'] = 'Le login est obligatoire.';
    } elseif (mb_strlen($login) > 50) {
        $errors['login'] = 'Le login ne doit pas dépasser 50 caractères.';
    }
    
    if ($mdp === '') {
        $errors['mdp'] = 'Le mot de passe est obligatoire.';
    } elseif (mb_strlen($mdp) < 8) {
        $errors['mdp'] = 'Le mot de passe doit contenir au moins 8 caractères.';
    }

    if ($mdp_confirm === '') {
        $errors['mdp_confirm'] = 'La confirmation du mot de passe est obligatoire.';
    } elseif ($mdp !== $mdp_confirm) {
        $errors['mdp_confirm'] = 'Les mots de passe ne correspondent pas.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old']    = [
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'ville' => $ville,
            'cp' => $cp,
            'date_embauche' => $date_embauche,
            'login' => $login
        ];
        $_SESSION['flash']  = 'Merci de corriger les erreurs du formulaire.';
        $this->redirect('/index.php/visiteur/create');
    }
   
    try {
        $id = \Models\visiteur::create_visiteur(
            $nom,
            $prenom,
            $adresse,
            $ville,
            $cp,
            $date_embauche,
            $login,
            $mdp
        );
        $_SESSION['flash'] = 'Visiteur créé avec succès.';
        $this->redirect('/index.php/visiteur/' . $id);
    } catch (\Throwable $e) {
        error_log("CREATE VISITEUR ERROR: " . $e->getMessage());
        $_SESSION['flash'] = 'Impossible de créer le visiteur.';
        $this->redirect('/index.php/visiteur');
    }
}

public function edit($id): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    if ($_SESSION['role'] !== 'comptable' && $_SESSION['uid'] !== $id) {
    $_SESSION['flash'] = 'Accès refusé.';
    $this->redirect('/index.php/dashboard');
}

    $id = (int)$id;

    try {
        $visiteur = \Models\visiteur::findById($id);
        if (!$visiteur) {
            $_SESSION['flash'] = "Visiteur introuvable.";
            $this->redirect('/index.php/visiteur');
        }
    } catch (\Throwable $e) {
        $_SESSION['flash'] = "Erreur lors du chargement du visiteur.";
        $this->redirect('/index.php/visiteur');
    }

    // remplissage auto
    $old = $_SESSION['old'] ?? [
    'adresse' => $visiteur['adresse'],
    'ville' => $visiteur['ville'],
    'cp' => $visiteur['cp'],
    'mdp' => $visiteur['mdp'],
];

    $this->render('visiteur/edit', [
        'title'   => 'Modifier un visiteur',
        'visiteur'    => $visiteur,
        'old'     => $old,
        'errors'  => $_SESSION['errors'] ?? [],
        'message' => $_SESSION['flash'] ?? ''
    ]);

    unset($_SESSION['old'], $_SESSION['errors'], $_SESSION['flash']);
}

public function update($id): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    if ($_SESSION['role'] !== 'comptable' && $_SESSION['uid'] !== $id) {
    $_SESSION['flash'] = 'Accès refusé.';
    $this->redirect('/index.php/dashboard');
}

    $id = (int)$id;
    $adresse = trim($_POST['adresse'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $cp= trim($_POST['cp'] ?? '');
    $mdp = trim($_POST['mdp'] ?? '');

    $errors = [];

    if ($adresse === '') {
        $errors['adresse'] = "L'adresse est obligatoire.";
    }

    if ($ville === '') {
        $errors['ville'] = 'Le nom de la ville est obligatoire.';
    }

    if ($cp === '') {
        $errors['cp'] = 'Le code postale est obligatoire.';
    }

    if ($mdp === '') {
        $errors['mdp'] = 'Le mot de passe est obligatoire.';
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = [
    'adresse' => $adresse,
    'ville' => $ville,
    'cp' => $cp,
    'mdp' => $mdp
];

        $_SESSION['flash'] = "Merci de corriger les erreurs.";
        $this->redirect("/index.php/visiteur/$id/edit");
    }

    try {
        \Models\visiteur::update($id, $adresse , $ville , $cp , $mdp);
        $_SESSION['flash'] = "Informations modifiées avec succès.";
        $this->redirect("/index.php/visiteur/$id");
    } catch (\Throwable $e) {
        $_SESSION['flash'] = "Erreur lors de la mise à jour.";
        $this->redirect("/index.php/visiteur");
        return;
    }
}

public function delete($id): void
{
    if (empty($_SESSION['uid'])) {
        $this->redirect('/index.php');
    }

    if ($_SESSION['role'] !== 'comptable' && $_SESSION['uid'] !== $id) {
    $_SESSION['flash'] = 'Accès refusé.';
    $this->redirect('/index.php/dashboard');
}

    $id = (int)$id;

    try {
        $ok = \Models\visiteur::delete($id);

        if ($ok) {
            $_SESSION['flash'] = "Visiteur supprimé avec succès.";
        } else {
            $_SESSION['flash'] = "Impossible de supprimer ce visiteur.";
        }
    } catch (\Throwable $e) {
        // error_log($e->getMessage());
        $_SESSION['flash'] = "Erreur lors de la suppression du visiteur.";
    }

    $this->redirect('/index.php/visiteur');
}

public function modifierMdp(int $id): void
{
    $visiteurModel = new \Models\visiteur(); 
    $visiteur = $visiteurModel->findById($id);
    
    if (!$visiteur) {
        die("Visiteur introuvable");
    }
    
    $message = '';
    $erreur = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nouveauMdp = $_POST['nouveau_mdp'] ?? '';
        $confirmation = $_POST['confirmation_mdp'] ?? '';
        
        if (empty($nouveauMdp) || empty($confirmation)) {
            $erreur = "Tous les champs sont obligatoires.";
        } elseif (strlen($nouveauMdp) < 6) {
            $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
        } elseif ($nouveauMdp !== $confirmation) {
            $erreur = "Les mots de passe ne correspondent pas.";
        } else {
            if ($visiteurModel->updatePassword($id, $nouveauMdp)) {
                $message = "Le mot de passe a été modifié avec succès !";
            } else {
                $erreur = "Erreur lors de la modification du mot de passe.";
            }
        }
    }
    
   // require __DIR__ . '/../views/visiteur/modifier_mdp.php';

    $this->render('visiteur/modifier_mdp', [
        'title'    => 'Modifier le mot de passe',
        'visiteur' => $visiteur,
        'errors'   => $errors,
        'message'  => $_SESSION['flash'] ?? ''
    ]);

    unset($_SESSION['flash']);
}



}