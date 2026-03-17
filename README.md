# Zoo ARCADIA 
## **[https://zoo-arcadia-production.up.railway.app/home/pages/index](https://zoo-arcadia-production.up.railway.app/home/pages/index)**
Système de gestion de zoo en **PHP** avec une architecture par domaines (**Screaming Architecture**) et du **MVC** à l’intérieur de chaque domaine.

- **Front Controller**: `public/index.php`
- **Routeur central**: `App/router.php`
- **Assets**: Gulp (SCSS/JS) → `public/build/`
- **BDD**: MariaDB/MySQL (local ou Docker)

## C’est quoi ce projet (en 20 secondes)

Zoo Arcadia est un site web pour un zoo fictif : les visiteurs peuvent consulter **les animaux**, **les habitats** et **les services**, et le back-office permet de gérer le contenu et les opérations internes avec des permissions par rôle.

## Contexte (ECF Studi / RNCP DWWM)

Ce dépôt a été réalisé dans le cadre du **projet ECF** de la formation **Développeur Web et Web Mobile (STUDI)**, avec un objectif “jury” : livrer une application **fonctionnelle**, **responsive**, et **justifiable techniquement** (architecture, sécurité, déploiement).

Exigences fonctionnelles (résumé) :

- **Espaces back-office** : administrateur (gestion complète), vétérinaire (suivi santé/rapports), employé (actions limitées).
- **Fonctionnalités front** : pages de présentation + filtres (animaux/habitats), formulaire de contact, témoignages.
- **Traçabilité** : Git + suivi Jira.

## Screenshots

| Home | Animals |
| --- | --- |
| ![Home](asssets-readme/Captura%20de%20pantalla%202026-01-15%20170235.png) | ![Animals](asssets-readme/Captura%20de%20pantalla%202026-01-15%20170258.png) |

| Back-office (admin) | Back-office (véto) |
| --- | --- |
| ![Back-Office 1](asssets-readme/Captura%20de%20pantalla%202026-01-15%20171210.png) | ![Back-Office 2](asssets-readme/Captura%20de%20pantalla%202026-01-15%20171227.png) |


## Démarrage rapide (le minimum pour lancer)

### Option A — Docker (recommandé)

```bash
git clone https://github.com/dumitrusf/zoo-Arcadia.git
cd zoo-ARCADIA

.\switch-to-docker.bat
docker-compose up -d --build
```

- App: `http://localhost:8080`
- Voir l’état: `docker-compose ps`
- Logs: `docker-compose logs -f web`
- Arrêter: `docker-compose down`

Note : si nous modifions `composer.json`, `package.json` ou les fichiers dans `src/`, nous relançons simplement :

```bash
docker-compose up -d --build
```

### Option B — Local (sans Docker, avec le serveur intégré PHP)

```bash
git clone https://github.com/dumitrusf/zoo-Arcadia.git
cd zoo-ARCADIA

composer install
npm install

.\switch-to-local.bat
.\deploy_database.bat

npx gulp buildCss && npx gulp buildJs
php -S localhost:3001 -t public public/index.php
```

- App: `http://localhost:3001`

## Prérequis (résumé)

- **PHP** 7.4+ (recommandé 8.x)
- **Composer**
- **Node.js + npm** (inclut `npx`)
- **MySQL/MariaDB**
- **Docker Desktop** (optionnel)

## Variables d’environnement (`.env`)

Le projet lit la configuration depuis `.env`. Les scripts :
- `switch-to-local.bat`
- `switch-to-docker.bat`

mettent ce fichier à jour automatiquement.

Exemple (local) :

```ini
DB_HOST=localhost
DB_NAME=zoo_arcadia
DB_USER=root
DB_PASS=root
```

## Base de données

- **Local**: `.\deploy_database.bat` (⚠️ recrée la BDD)
- **Docker**:
  - recréer de zéro (supprime les données): `docker-compose down -v && docker-compose up -d`
  - appliquer un `.sql` précis (conserve les données) :

```bash
docker exec -i zoo-arcadia-db mariadb -uzoo_user -pzoo_password zoo_arcadia < database/03_constraints.sql
```

## Assets (Gulp)

```bash
# build (pour prod / sans watchers)
npx gulp buildCss && npx gulp buildJs

# mode dev (watch + BrowserSync si configuré)
npx gulp
```

## Dépannage

### SSL Composer sous Windows (`curl error 60`)

Si `composer install` échoue à cause du SSL, ce projet l’a résolu en configurant `cacert.pem` dans le `php.ini` actif :

```bash
php --ini
```

```ini
[curl]
curl.cainfo = "C:\php\cacert.pem"

[openssl]
openssl.cafile = "C:\php\cacert.pem"
```

Ensuite : nous rouvrons le terminal (et nous redémarrons Apache si nécessaire), puis nous relançons `composer install`.

## Structure du projet (haut niveau)

```
zoo-ARCADIA/
├── App/                 # Domaines (MVC par domaine)
├── public/              # Front Controller + assets compilés
├── src/                 # Sources SCSS/JS
├── database/            # SQL versionné
├── includes/            # helpers partagés (CSRF, fonctions, layouts...)
├── docker-compose.yml
├── gulpfile.js
└── GUIA_DEFENSA_JURADO.md
```

## Documentation du projet

- Dossier: `docs/DOSSIER_PROJET_ZOO_ARCADIA.md`
