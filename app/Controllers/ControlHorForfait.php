<?php

namespace Controllers;
use Core\Controller;
use Models\horforfait;
final class ControlHorForfait extends Controller{
    public function index():void{
        if (empty($_SESSION['uid'])){
            $this->redirect('/index.php');

        }
        try {
            $horforfait = horforfait::findAll();
        }catch(\Throwable $e){
            $_SESSION['flash']='Impossible de charger les frais horforfait';
            $horforfait=[];
        }
        $this->render('horforfait/index',
        ['title'=>"Liste des frais horforfait",
        "horforfait"=>$horforfait,
        "message"=>$_SESSION['flash']??'',
    ]);
        unset($_SESSION['flash']);


}
    public function show($id): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    $id = (int)$id;

    try {
        $horforfait =horforfait::findById($id);
        if (!$horforfait) {
            http_response_code(404);
            $_SESSION['flash'] = 'HorForfait introuvable.';
            $this->redirect('/index.php/horforfait');
        }
    } catch (\Throwable $e) {
        // error_log($e->getMessage()); // utile en debug
        $_SESSION['flash'] = 'Erreur lors du chargement du horforfait.';
        $horforfait = null;
    }

    $this->render('horforfait/show', [
        'title' => 'Détail du horforfait',
        'horforfait'  => $horforfait,
        'message' => $_SESSION['flash'] ?? '',
    ]);
    unset($_SESSION['flash']);
}

public function create(): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/index.php');

        $this->render('horforfait/create', [
            'title'   => 'Créer un horforfait',
            'message' => $_SESSION['flash'] ?? '',
            'old'     => $_SESSION['old'] ?? ['libelle' => ''],
            'errors'  => $_SESSION['errors'] ?? [],
        ]);

        unset($_SESSION['flash'], $_SESSION['old'], $_SESSION['errors']);
    }

    
public function store(): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    $dateStr = $_POST['date'] ?? '';
    $montant = $_POST['montant'] ?? '';
    $libelle = trim($_POST['libelle'] ?? '');
    $errors = [];

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

    try {
    $dateObj = new \DateTime($dateStr);
    $date = $dateObj->format('Y-m-d'); // <-- ici on récupère la date sous forme string
} catch (\Exception $e) {
    $errors['date'] = 'Date invalide.';
}

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = [
            'date' => $dateStr,
            'montant' => $montant,
            'libelle' => $libelle
        ];
        $_SESSION['flash'] = 'Merci de corriger les erreurs du formulaire.';
        $this->redirect('/index.php/horforfait/create');
    }

    try {
        $id = \Models\horforfait::create_horforfait($date, $montant, $libelle);
        $_SESSION['flash'] = 'HorForfait créé avec succès.';
        $this->redirect('/index.php/horforfait/' . $id);
    } catch (\Throwable $e) {
        $_SESSION['flash'] = 'Impossible de créer le horforfait.';
        $this->redirect('/index.php/horforfait');
    }
}

public function edit($id): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

   if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

    $id = (int)$id;

    try {
        $horforfait = \Models\horforfait::findById($id);
        if (!$horforfait) {
            $_SESSION['flash'] = "HorForfait introuvable.";
            $this->redirect('/index.php/horforfait');
        }
    } catch (\Throwable $e) {
        $_SESSION['flash'] = "Erreur lors du chargement du horforfait.";
        $this->redirect('/index.php/horforfait');
    }

    $old = $_SESSION['old'] ?? [
    'date' => $horforfait['date'],
    'montant' => $horforfait['montant'],
    'libelle' => $horforfait['libelle'],
];

    $this->render('horforfait/edit', [
        'title'   => 'Modifier un horforfait',
        'horforfait'    => $horforfait,
        'old'     => $old,
        'errors'  => $_SESSION['errors'] ?? [],
        'message' => $_SESSION['flash'] ?? ''
    ]);

    unset($_SESSION['old'], $_SESSION['errors'], $_SESSION['flash']);
}


public function update($id): void
{
    if (empty($_SESSION['uid'])) $this->redirect('/index.php');

    if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

    $id = (int)$id;
    $date = trim($_POST['date'] ?? '');
    $montant = trim($_POST['montant'] ?? '');
    $libelle = trim($_POST['libelle'] ?? '');

    $errors = [];

        if ($date === '') {
        $errors['date'] = 'La date est obligatoire.';

        }

    if ($montant === '') {
        $errors['montant'] = 'Le montant est obligatoire.';

    }


    if ($libelle === '') {
        $errors['libelle'] = 'Le libellé est obligatoire.';
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = [
    'date'=> $date,
    'montant' => $montant,
    'libelle' => $libelle
];

        $_SESSION['flash'] = "Merci de corriger les erreurs.";
        $this->redirect("/index.php/horforfait/$id/edit");
    }

    try {
        \Models\horforfait::update($id,$date, $montant,$libelle);
        $_SESSION['flash'] = "HorForfait modifié avec succès.";
        $this->redirect("/index.php/horforfait/$id");
    } catch (\Throwable $e) {
        $_SESSION['flash'] = "Erreur lors de la mise à jour.";
        $this->redirect("/index.php/horforfait");
    }
}

public function delete($id): void
{
    if (empty($_SESSION['uid'])) {
        $this->redirect('/index.php');
    }

    if ($_SESSION['role'] !== 'comptable') {
    $_SESSION['flash_error'] = 'Cette section est réservée au comptable.';
    $this->redirect('/index.php/dashboard');
}

    $id = (int)$id;

    try {
        $ok = \Models\horforfait::delete($id);

        if ($ok) {
            $_SESSION['flash'] = "HorForfait supprimé avec succès.";
        } else {
            $_SESSION['flash'] = "Impossible de supprimer ce HorForfait.";
        }
    } catch (\Throwable $e) {
        $_SESSION['flash'] = "Erreur lors de la suppression du Horforfait.";
    }

    $this->redirect('/index.php/horforfait');
}


}