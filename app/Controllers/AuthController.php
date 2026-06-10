<?php
namespace Controllers;
use Core\Controller;
use Models\User;

final class AuthController extends Controller {

    public function accueil(): void {
        $this->render('accueil', ['title' => 'Accueil' , 'authPage'=> true]);
    }

    public function login(): void {
        if (!empty($_SESSION['uid'])) { $this->redirect('/index.php/dashboard'); }
        $this->render('login', [
            'title' => 'Connexion',
            'csrf'  => $this->csrfToken(),
            'message' => $_SESSION['flash'] ?? '',
            'authPage' => true, 
        ]);
        unset($_SESSION['flash']);
    }

    public function doLogin(): void {
        if (!$this->checkCsrf($_POST['csrf'] ?? null)) { http_response_code(400); exit('CSRF'); }

        $username = trim((string)($_POST['username'] ?? ''));
        $password = (string)($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $_SESSION['flash'] = 'Identifiants requis';
            $this->redirect('/index.php/');
        }

        $user = User::findByUsername($username);
        if (!$user || !password_verify($password, $user['mdp'])) {
            $_SESSION['flash'] = 'Mauvais identifiant ou mot de passe';
            $this->redirect('/index.php/');
        }

        $_SESSION['uid']  = (int)$user['id'];
        $_SESSION['name'] = $user['login'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'comptable') {
        $this->redirect('/index.php/dashboard-comptable');
}       else {
        $this->redirect('/index.php/dashboard');
}
    }

    public function dashboard(): void {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php/');
        $this->render('dashboard', ['title'=>'Dashboard', 'username'=>$_SESSION['name'] ?? 'Utilisateur']);
    }

    public function logout(): void {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time()-42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
        $this->redirect('/index.php');
    }

    public function dashboardComptable(): void {
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');
    if ($_SESSION['role'] !== 'comptable') $this->redirect('/index.php/dashboard');
    
    $this->render('dashboard-comptable', [
        'title' => 'Dashboard Comptable',
        'username' => $_SESSION['name'] ?? 'Comptable',
        'authPage' => true,
    ]);
}

public function inscription(): void {
    if (!empty($_SESSION['uid'])) $this->redirect('/index.php/dashboard');
    $this->render('inscription', [
        'title'   => 'Inscription',
        'message' => $_SESSION['flash'] ?? '',
        'old'     => $_SESSION['old'] ?? [],
        'errors'  => $_SESSION['errors'] ?? [],
        'authPage' => true,   
    ]);
    unset($_SESSION['flash'], $_SESSION['old'], $_SESSION['errors']);
}

public function doInscription(): void {
    $nom        = trim($_POST['nom'] ?? '');
    $prenom     = trim($_POST['prenom'] ?? '');
    $adresse    = trim($_POST['adresse'] ?? '');
    $ville      = trim($_POST['ville'] ?? '');
    $cp         = trim($_POST['cp'] ?? '');
    $login      = trim($_POST['login'] ?? '');
    $mdp        = $_POST['mdp'] ?? '';
    $mdp_confirm = $_POST['mdp_confirm'] ?? '';

    $errors = [];
    if ($nom === '')     $errors['nom']     = 'Le nom est obligatoire.';
    if ($prenom === '')  $errors['prenom']  = 'Le prénom est obligatoire.';
    if ($adresse === '') $errors['adresse'] = "L'adresse est obligatoire.";
    if ($ville === '')   $errors['ville']   = 'La ville est obligatoire.';
    if (!preg_match('/^[0-9]{5}$/', $cp)) $errors['cp'] = 'Code postal invalide.';
    if ($login === '')   $errors['login']   = 'Le login est obligatoire.';
    if (strlen($mdp) < 8) $errors['mdp']   = '8 caractères minimum.';
    if ($mdp !== $mdp_confirm) $errors['mdp_confirm'] = 'Les mots de passe ne correspondent pas.';

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old']    = compact('nom','prenom','adresse','ville','cp','login');
        $_SESSION['flash']  = 'Merci de corriger les erreurs.';
        $this->redirect('/index.php/inscription');
    }

    try {
        \Models\visiteur::create_visiteur(
            $nom, $prenom, $adresse, $ville, $cp,
            date('Y-m-d'), // date_embauche = aujourd'hui par défaut
            $login, $mdp
            // role = 'visiteur' par défaut en BDD
        );
        $_SESSION['flash'] = 'Compte créé avec succès ! Connectez-vous.';
        $this->redirect('/index.php/login');
    } catch (\Throwable $e) {
        $_SESSION['flash'] = 'Erreur : login déjà utilisé ou problème serveur.';
        $this->redirect('/index.php/inscription');
    }
}

    

public function gestionRoles(): void {
    if (empty($_SESSION['uid'])) $this->redirect('/');
    if ($_SESSION['role'] !== 'comptable') $this->redirect('/index.php/dashboard');

    $this->render('gestion-roles', [
        'title'    => 'Gestion des rôles',
        'visiteurs' => \Models\visiteur::findAll(),
    ]);
}

public function changerRole(): void {
    if (empty($_SESSION['uid'])) $this->redirect('/index.php/');
    if ($_SESSION['role'] !== 'comptable') $this->redirect('/index.php/dashboard');

    $id      = (int)($_POST['id'] ?? 0);
    $role    = $_POST['role'] ?? 'visiteur';

    if (!in_array($role, ['visiteur', 'comptable'])) $this->redirect('/index.php/gestion-roles');

    \Models\visiteur::updateRole($id, $role);
    $_SESSION['flash'] = 'Rôle mis à jour avec succès.';
    $this->redirect('/index.php/gestion-roles');
}

public function validerFiches(): void {
    if (empty($_SESSION['uid'])) $this->redirect('/index.php/');
    if ($_SESSION['role'] !== 'comptable') $this->redirect('/index.php/dashboard');

    $fiches = \Models\fichefrais::findAll();
    $this->render('valider-fiches', [
        'title'  => 'Validation des fiches',
        'fiches' => $fiches,
        'message' => $_SESSION['flash'] ?? '',
    ]);
    unset($_SESSION['flash']);
}

public function doValiderFiche(): void {
    if (empty($_SESSION['uid'])) $this->redirect('/index.php/');
    if ($_SESSION['role'] !== 'comptable') $this->redirect('/index.php/dashboard');

    $idVisiteur = (int)($_POST['idVisiteur'] ?? 0);
    $mois       = trim($_POST['mois'] ?? '');
    $idEtat     = (int)($_POST['idEtat'] ?? 0);

    \Models\fichefrais::updateEtat($idVisiteur, $mois, $idEtat);
    $_SESSION['flash'] = 'Fiche mise à jour.';
    $this->redirect('/index.php/valider-fiches');
}

    

}

