<?php
$e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($base === '/') $base = '';
?>
<div class="dash-main">
  <div class="dash-hero">
    <p class="dash-hero-eyebrow">Espace collaborateur</p>
    <h2>Bonjour, <?= $e($username) ?> </h2>
    <p>Bienvenue sur votre espace de gestion des frais professionnels.</p>
  </div>
  <div class="dash-cards">
    <a href="<?= $base ?>/index.php/fichefrais/create" class="dash-card">
      <div class="dash-card-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#009AB8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg></div>
      <p class="dash-card-title">Saisir des frais</p>
      <p class="dash-card-desc">Déposer une nouvelle fiche de frais forfaitaires ou hors forfait.</p>
    </a>
    <a href="<?= $base ?>/index.php/fichefrais" class="dash-card">
      <div class="dash-card-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#009AB8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg></div>
      <p class="dash-card-title">Consulter des frais</p>
      <p class="dash-card-desc">Voir l'historique et le statut de vos fiches de frais.</p>
    </a>
    <a href="<?= $base ?>/index.php/horforfait" class="dash-card">
      <div class="dash-card-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#009AB8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></div>
      <p class="dash-card-title">Frais hors forfait</p>
      <p class="dash-card-desc">Saisir et consulter les dépenses exceptionnelles.</p>
    </a>
    <a href="<?= $base ?>/index.php/visiteur" class="dash-card">
      <div class="dash-card-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#009AB8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
      <p class="dash-card-title">Visiteurs</p>
      <p class="dash-card-desc">Gérer les comptes et informations des visiteurs médicaux.</p>
    </a>
  </div>
</div>
