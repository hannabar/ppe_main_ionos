# PPE— Installation rapide

1. Copier le projet dans un dossier.
2. Renommer `.env.example` en `.env` et mettre tes identifiants DB.
3. Importer `migration.sql` dans MySQL :
   `mysql -u root -p < migration.sql` ou via un client MySQL.
4. Lancer le serveur PHP (depuis le dossier `public`):
   `php -S localhost:8000` (ou configure Apache/Nginx pour pointer sur `public/`).
5. Ouvrir http://localhost:8000

Compte admin créé : `alice.m` / `hash_pwd_1` 

Notes de sécurité supplémentaires:
- Utilise HTTPS en production et mets `SESSION_COOKIE_SECURE=1` dans `.env`.
- Active HSTS côté serveur web.
- Ajuste la politique CSP selon tes besoins.
