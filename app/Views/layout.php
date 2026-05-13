<?php /** @var string $title */ ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'GSB', ENT_QUOTES) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --cyan:#00BFDF; --cyan-dark:#009AB8; --cyan-light:#E0F7FB;
      --navy:#0A2540; --navy-soft:#1C3A5C;
      --gray-bg:#F4F6F9; --gray-border:#DDE3EC; --gray-text:#6B7A90;
      --white:#FFFFFF; --red:#E53935;
      --font:'DM Sans',system-ui,sans-serif;
      --font-display:'DM Serif Display',serif;
    }
    html,body{height:100%;font-family:var(--font);background:var(--gray-bg);color:var(--navy);margin:0;}
    body.auth-page{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem 1rem;}
    body.auth-page::before{content:'';position:fixed;top:-180px;right:-180px;width:560px;height:560px;border-radius:50%;background:radial-gradient(circle,rgba(0,191,223,0.09) 0%,transparent 70%);pointer-events:none;}
    .auth-wrapper{width:100%;max-width:430px;animation:fadeUp 0.45s ease both;}
    @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
    .auth-logo{display:flex;align-items:center;gap:12px;margin-bottom:2.25rem;}
    .auth-logo-badge{width:50px;height:50px;border-radius:14px;background:var(--navy);border:2px solid var(--cyan);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .auth-logo-badge span{font-family:var(--font-display);font-size:19px;color:var(--cyan);}
    .auth-logo-info strong{display:block;font-size:14.5px;font-weight:600;color:var(--navy);}
    .auth-logo-info small{font-size:11.5px;color:var(--gray-text);}
    .auth-card{background:var(--white);border-radius:22px;border:1px solid var(--gray-border);box-shadow:0 6px 36px rgba(10,37,64,0.08);padding:2.25rem 2.25rem 2rem;}
    .auth-eyebrow{font-size:10.5px;font-weight:600;letter-spacing:1.6px;text-transform:uppercase;color:var(--cyan-dark);margin-bottom:6px;}
    .auth-title{font-family:var(--font-display);font-size:28px;color:var(--navy);line-height:1.15;margin-bottom:6px;}
    .auth-sub{font-size:13.5px;color:var(--gray-text);margin-bottom:1.75rem;}
    .auth-error{display:flex;align-items:center;gap:9px;background:#FFF0F0;border:1px solid #FFCDD2;border-radius:10px;padding:10px 14px;margin-bottom:1.25rem;font-size:13.5px;color:var(--red);}
    .form-group{margin-bottom:1.2rem;}
    .form-group label{display:block;font-size:13px;font-weight:500;color:var(--navy-soft);margin-bottom:7px;}
    .form-group input[type="text"],.form-group input[type="password"],.form-group input[type="email"],.form-group input[type="tel"]{width:100%;padding:11px 14px;border:1.5px solid var(--gray-border);border-radius:10px;font-family:var(--font);font-size:14px;color:var(--navy);background:var(--white);outline:none;transition:border-color 0.2s,box-shadow 0.2s;}
    .form-group input:focus{border-color:var(--cyan);box-shadow:0 0 0 3px rgba(0,191,223,0.13);}
    .form-group input::placeholder{color:#BCC8D4;}
    .btn-gsb{display:block;width:100%;padding:13px;background:var(--cyan);color:var(--white);border:none;border-radius:12px;font-family:var(--font);font-size:15px;font-weight:600;cursor:pointer;margin-top:1.5rem;box-shadow:0 4px 18px rgba(0,191,223,0.32);transition:background 0.2s,box-shadow 0.2s,transform 0.1s;text-align:center;text-decoration:none;letter-spacing:0.2px;}
    .btn-gsb:hover{background:var(--cyan-dark);box-shadow:0 6px 22px rgba(0,191,223,0.42);}
    .btn-gsb:active{transform:scale(0.99);}
    .auth-security{display:flex;align-items:center;gap:8px;margin-top:1.5rem;padding:10px 13px;background:var(--cyan-light);border-radius:10px;}
    .auth-security span{font-size:12px;color:var(--navy-soft);}
    .dash-nav{background:var(--white);border-bottom:1px solid var(--gray-border);padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between;height:60px;position:sticky;top:0;z-index:200;}
    .dash-nav-left{display:flex;align-items:center;gap:1.5rem;}
    .dash-nav-logo{display:flex;align-items:center;gap:9px;text-decoration:none;flex-shrink:0;}
    .dash-nav-logo-badge{width:36px;height:36px;border-radius:9px;background:var(--navy);border:2px solid var(--cyan);display:flex;align-items:center;justify-content:center;}
    .dash-nav-logo-badge span{font-family:var(--font-display);font-size:13px;color:var(--cyan);}
    .dash-nav-logo strong{font-size:13px;font-weight:600;color:var(--navy);white-space:nowrap;}
    .dash-nav-links{display:flex;align-items:center;gap:2px;}
    .dash-nav-links a{font-size:13px;font-weight:500;color:var(--gray-text);text-decoration:none;padding:6px 11px;border-radius:7px;transition:all 0.15s;white-space:nowrap;}
    .dash-nav-links a:hover{color:var(--navy);background:var(--gray-bg);}
    .dash-nav-links a.active{color:var(--cyan-dark);background:var(--cyan-light);}
    .nav-dropdown{position:relative;}
    .nav-dropdown-btn{display:flex;align-items:center;gap:5px;font-size:13px;font-weight:500;color:var(--gray-text);padding:6px 11px;border-radius:7px;cursor:pointer;border:none;background:transparent;font-family:var(--font);transition:all 0.15s;white-space:nowrap;}
    .nav-dropdown-btn:hover{color:var(--navy);background:var(--gray-bg);}
    .nav-dropdown-btn svg{transition:transform 0.2s;}
    .nav-dropdown-btn.open svg{transform:rotate(180deg);}
    .nav-dropdown-menu{display:none;position:absolute;top:calc(100% + 6px);left:0;background:var(--white);border:1px solid var(--gray-border);border-radius:12px;box-shadow:0 8px 24px rgba(10,37,64,0.1);padding:6px;min-width:180px;z-index:300;}
    .nav-dropdown-menu.open{display:block;}
    .nav-dropdown-menu a{display:block;font-size:13px;color:var(--gray-text);text-decoration:none;padding:7px 12px;border-radius:7px;transition:all 0.12s;white-space:nowrap;}
    .nav-dropdown-menu a:hover{color:var(--navy);background:var(--gray-bg);}
    .menu-divider{height:1px;background:var(--gray-border);margin:4px 6px;}
    .dash-nav-right{display:flex;align-items:center;gap:10px;flex-shrink:0;}
    .dash-nav-avatar{width:30px;height:30px;border-radius:50%;background:var(--navy);color:var(--cyan);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:12px;}
    .dash-nav-name{font-size:13px;font-weight:500;color:var(--navy);}
    .btn-logout{font-size:12.5px;color:var(--gray-text);text-decoration:none;padding:6px 12px;border:1px solid var(--gray-border);border-radius:7px;transition:all 0.15s;}
    .btn-logout:hover{color:var(--red);border-color:#FFCDD2;background:#FFF0F0;}
    .dash-main{max-width:1100px;margin:0 auto;padding:2.5rem 2rem;}
    .dash-hero{background:var(--navy);border-radius:16px;padding:2rem 2.5rem;margin-bottom:2rem;position:relative;overflow:hidden;}
    .dash-hero::before{content:'';position:absolute;top:-60px;right:-60px;width:260px;height:260px;border-radius:50%;background:rgba(0,191,223,0.07);}
    .dash-hero-eyebrow{font-size:11px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;color:var(--cyan);margin-bottom:8px;}
    .dash-hero h2{font-family:var(--font-display);font-size:26px;color:var(--white);margin-bottom:5px;}
    .dash-hero p{font-size:13.5px;color:rgba(255,255,255,0.5);}
    .dash-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;}
    .dash-card{background:var(--white);border-radius:14px;border:1px solid var(--gray-border);padding:1.5rem;text-decoration:none;transition:box-shadow 0.2s,transform 0.15s;display:block;}
    .dash-card:hover{box-shadow:0 4px 20px rgba(10,37,64,0.08);transform:translateY(-2px);}
    .dash-card-icon{width:38px;height:38px;border-radius:9px;background:var(--cyan-light);display:flex;align-items:center;justify-content:center;margin-bottom:1rem;}
    .dash-card-title{font-size:14px;font-weight:600;color:var(--navy);margin-bottom:4px;}
    .dash-card-desc{font-size:12.5px;color:var(--gray-text);line-height:1.5;}
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;}
    .page-header h2{font-family:var(--font-display);font-size:22px;color:var(--navy);margin-bottom:3px;}
    .page-header p{font-size:13px;color:var(--gray-text);}
    .btn-action{display:inline-block;padding:9px 18px;background:var(--cyan);color:var(--white);border:none;border-radius:10px;font-family:var(--font);font-size:13.5px;font-weight:600;cursor:pointer;text-decoration:none;box-shadow:0 4px 12px rgba(0,191,223,0.25);transition:background 0.15s;}
    .btn-action:hover{background:var(--cyan-dark);}
    .table-card{background:var(--white);border-radius:14px;border:1px solid var(--gray-border);overflow:hidden;}
    .table-wrap{overflow-x:auto;}
    table.gsb-table{width:100%;border-collapse:collapse;min-width:600px;}
    table.gsb-table thead tr{background:var(--navy);}
    table.gsb-table thead th{padding:12px 16px;text-align:left;font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255,255,255,0.6);}
    table.gsb-table tbody td{padding:12px 16px;font-size:13.5px;border-bottom:1px solid var(--gray-border);vertical-align:middle;}
    table.gsb-table tbody tr:last-child td{border-bottom:none;}
    table.gsb-table tbody tr:hover{background:var(--gray-bg);}
    .btn-sm{display:inline-block;padding:5px 10px;font-size:12px;font-weight:500;border-radius:6px;text-decoration:none;border:none;cursor:pointer;font-family:var(--font);}
    .btn-see{color:var(--cyan-dark);background:var(--cyan-light);}
    .btn-edit{color:var(--navy-soft);background:var(--gray-bg);border:1px solid var(--gray-border);}
    .btn-warn{color:#92610a;background:#FFF8E1;}
    .btn-del{color:#b91c1c;background:#FFF0F0;}
    .flash-error{display:flex;align-items:center;gap:9px;background:#FFF0F0;border:1px solid #FFCDD2;border-radius:10px;padding:10px 14px;margin-bottom:1rem;font-size:13.5px;color:var(--red);}
    .flash-success{background:#F0FFF4;border:1px solid #BBF7D0;border-radius:10px;padding:10px 14px;margin-bottom:1rem;font-size:13.5px;color:#166534;}
    .empty-state{padding:3rem;text-align:center;color:var(--gray-text);font-size:14px;}
    .form-card{background:var(--white);border-radius:16px;border:1px solid var(--gray-border);padding:2rem;max-width:600px;}
    .form-card .form-group{margin-bottom:1.2rem;}
    .form-card label{display:block;font-size:13px;font-weight:500;color:var(--navy-soft);margin-bottom:7px;}
    .form-card input,.form-card select,.form-card textarea{width:100%;padding:10px 13px;border:1.5px solid var(--gray-border);border-radius:9px;font-family:var(--font);font-size:14px;color:var(--navy);outline:none;transition:border-color 0.2s,box-shadow 0.2s;background:var(--white);}
    .form-card input:focus,.form-card select:focus,.form-card textarea:focus{border-color:var(--cyan);box-shadow:0 0 0 3px rgba(0,191,223,0.12);}
    .form-error{font-size:12px;color:var(--red);margin-top:4px;}
    .form-actions{display:flex;gap:10px;margin-top:1.5rem;}
  </style>
</head>
<body class="<?= ($authPage ?? false) ? 'auth-page' : '' ?>">

<?php if (!($authPage ?? false)):
  // Calcul automatique du préfixe (ex: /PPE-main - Copie/public)
  $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
  $base = ($scriptDir === '' || $scriptDir === '/') ? '' : $scriptDir;

  $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
  if ($base !== '' && str_starts_with($requestPath, $base)) {
      $requestPath = substr($requestPath, strlen($base)) ?: '/';
  }

  $isActive = fn(string $prefix) => str_starts_with($requestPath, $prefix) ? 'active' : '';
  $initial  = strtoupper(substr($_SESSION['name'] ?? 'U', 0, 1));
  $uname    = htmlspecialchars($_SESSION['name'] ?? '', ENT_QUOTES);
?>
<nav class="dash-nav">
  <div class="dash-nav-left">
    <a href="<?= $base ?>/dashboard" class="dash-nav-logo">
      <div class="dash-nav-logo-badge"><span>GSB</span></div>
    </a>
    <div class="dash-nav-links">
      <a href="<?= $base ?>/dashboard" class="<?= $requestPath === '/dashboard' ? 'active' : '' ?>">Accueil</a>
      <a href="<?= $base ?>/visiteur" class="<?= $isActive('/visiteur') ?>">Visiteurs</a>
      <a href="<?= $base ?>/etat" class="<?= $isActive('/etat') ?>">États</a>
      <a href="<?= $base ?>/fichefrais" class="<?= $isActive('/fichefrais') ?>">Fichefrais</a>
      <a href="<?= $base ?>/forfait" class="<?= $isActive('/forfait') ?>">Forfaits</a>
      <a href="<?= $base ?>/horforfait" class="<?= $isActive('/horforfait') ?>">Horforfait</a>
      <a href="<?= $base ?>/lignefraisforfait" class="<?= $isActive('/lignefraisforfait') ?>">Lignefraisforfait</a>
    </div>
  </div>
  <div class="dash-nav-right">
    <div class="dash-nav-avatar"><?= $initial ?></div>
    <span class="dash-nav-name"><?= $uname ?></span>
    <a href="<?= $base ?>/logout" class="btn-logout">Se déconnecter</a>
  </div>
</nav>
<?php endif; ?>

<main>
  <?php require $viewFile; ?>
</main>
<script>
document.querySelectorAll(".nav-dropdown-btn").forEach(btn => {
  btn.addEventListener("click", function(e) {
    e.stopPropagation();
    const menu = this.nextElementSibling;
    const isOpen = menu.classList.contains("open");
    document.querySelectorAll(".nav-dropdown-menu").forEach(m => m.classList.remove("open"));
    document.querySelectorAll(".nav-dropdown-btn").forEach(b => b.classList.remove("open"));
    if (!isOpen) { menu.classList.add("open"); this.classList.add("open"); }
  });
});
document.addEventListener("click", () => {
  document.querySelectorAll(".nav-dropdown-menu").forEach(m => m.classList.remove("open"));
  document.querySelectorAll(".nav-dropdown-btn").forEach(b => b.classList.remove("open"));
});
</script>
</body>
</html>