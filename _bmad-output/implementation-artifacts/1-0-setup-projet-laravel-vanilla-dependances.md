# Story 1.0: Setup projet (Laravel vanilla + dépendances)

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a développeur (équipe produit),
I want initialiser le projet depuis le starter Laravel vanilla et installer/configurer les dépendances nécessaires,
so that le reste des stories (auth, UI, PDF, exports) peut être implémenté rapidement et de manière reproductible.

## Acceptance Criteria

1. **Given** un repository propre pour le projet
   **When** je finalise le setup local
   **Then** l’application Laravel démarre en local

2. **And** les dépendances nécessaires au MVP sont en place :
   - Tailwind (via npm/Vite)
   - DomPDF (`barryvdh/laravel-dompdf`)

3. **And** la configuration de base respecte l’architecture :
   - MySQL configuré via `.env`
   - sessions configurées pour expiration 30 minutes (driver fichier)

4. **And** les commandes principales de dev (serve + build assets) sont documentées/connues pour l’équipe

## Tasks / Subtasks

- [x] Valider l’état du projet Laravel existant (AC: 1)
  - [x] Vérifier que `rattrapage/` contient `artisan`, `composer.json`, `package.json` et que `php artisan --version` fonctionne
  - [x] Vérifier le démarrage local via `php artisan serve` (ou `composer run dev` si déjà en place)

- [x] Installer/configurer Tailwind via Vite (AC: 2)
  - [x] Installer les dépendances npm requises (tailwindcss, postcss, autoprefixer)
  - [x] Initialiser la config Tailwind (`tailwind.config.js`, `postcss.config.js`) et activer les directives `@tailwind` dans `resources/css/app.css`
  - [x] Vérifier la compilation front via `npm run dev` et que les classes Tailwind s’appliquent sur une page Blade

- [x] Installer/configurer DomPDF (AC: 2)
  - [x] Ajouter `barryvdh/laravel-dompdf` via Composer
  - [x] Vérifier que la génération d’une vue PDF est possible (smoke check minimal, sans implémenter le PDF final)

- [x] Préparer le socle i18n/RTL (pré-requis Epic 1) (AC: 4)
  - [x] Créer `lang/fr/messages.php` et `lang/ar/messages.php` (minimum: placeholders, pas de contenu produit complet ici)
  - [x] Définir la locale par défaut `fr` et prévoir le stockage de la langue en session (la mécanique complète sera implémentée en Story 1.2)

- [x] Configurer la base MySQL et sessions (AC: 3)
  - [x] Vérifier `.env` (DB_HOST/DB_DATABASE/DB_USERNAME/DB_PASSWORD)
  - [x] S’assurer que `SESSION_DRIVER=file` et `SESSION_LIFETIME=30`
  - [x] Vérifier que `storage/framework/sessions` est accessible en écriture

- [x] Ajouter un guide de commandes dev (AC: 4)
  - [x] Identifier un emplacement unique (ex: `README.md` du projet Laravel) et y noter les commandes essentielles

- [x] Smoke tests (AC: 1,2,3)
  - [x] Lancer le runner de tests (`php artisan test`) pour confirmer que l’environnement est sain

## Dev Notes

- **Portée de cette story**: uniquement le **socle de projet** (outillage + dépendances + config). Ne pas implémenter l’auth custom ni les pages finales (ce sont les stories suivantes).

- **Stack imposée / versions**:
  - Laravel 10+ (projet actuel: Laravel 12)
  - Blade (MPA)
  - Tailwind via Vite
  - MySQL 8.0+
  - PDF: `barryvdh/laravel-dompdf`
  - QR: `simplesoftwareio/simple-qrcode` **post-MVP / v1.1** (ne pas le rendre bloquant ici)

- **Contraintes NFR** (à garder en tête dès le setup):
  - Performance: TTFB <500ms (normal), affichage examens <2s
  - PDF <3s (plus tard)
  - Sécurité: HTTPS en prod (plus tard), CSRF par défaut Laravel, protection SQL via Eloquent / requêtes préparées

- **Guardrails (anti-erreurs LLM/dev)**:
  - Ne pas installer Breeze/Jetstream (auth standard incompatible Apogée+DOB).
  - Ne pas ajouter de couches inutiles (Services/Repositories) au MVP: logique dans Controllers (décision architecture).
  - Tous les textes UI doivent passer par `lang/` et `__('...')` (préparer le terrain, même si l’UI arrive en 1.2+).
  - Respecter conventions de nommage (snake_case BDD, PascalCase classes, kebab-case views/routes).

- **Composants/fichiers à toucher (probables)**:
  - `composer.json`, `package.json`
  - `tailwind.config.js`, `postcss.config.js`, `vite.config.js`
  - `resources/css/app.css`, `resources/views/...`
  - `.env` / `.env.example`
  - `config/app.php`, `config/session.php`
  - `lang/fr/messages.php`, `lang/ar/messages.php`

- **Standards de test**:
  - PHPUnit via `php artisan test`
  - À ce stade: tests “smoke” (boot app, config OK). Les tests fonctionnels Login/Convocation arrivent avec les stories correspondantes.

### Project Structure Notes

- **Structure attendue (référence)**:
  - Controllers: `app/Http/Controllers/`
  - Middleware: `app/Http/Middleware/`
  - Views: `resources/views/` (incl. `pdf/` plus tard)
  - i18n: `lang/fr/`, `lang/ar/`
  - Routes: `routes/web.php`

- **Écart à éviter**:
  - Ne pas créer de structure alternative (ex: `src/`, dossiers non-Laravel) pour le MVP.

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 1.0] — AC et objectifs story setup
- [Source: _bmad-output/planning-artifacts/architecture.md#Starter Template Evaluation] — Laravel vanilla recommandé + commandes + packages
- [Source: _bmad-output/planning-artifacts/architecture.md#Technical Constraints & Dependencies] — Stack imposée
- [Source: _bmad-output/planning-artifacts/architecture.md#Internationalization Patterns] — FR/AR + RTL + stockage locale en session
- [Source: _bmad-output/planning-artifacts/architecture.md#Project Structure & Boundaries] — Arborescence cible
- [Source: _bmad-output/planning-artifacts/prd.md#Implementation Considerations] — packages (DomPDF/QR), stack
- [Source: _bmad-output/planning-artifacts/ux-design-specification.md#Design System Foundation] — tokens/components Blade (à implémenter progressivement)

## Dev Agent Record

### Agent Model Used

Cascade

### Completion Notes List

- Setup story context généré en mode YOLO (create-story)
- Objectif: rendre les stories suivantes “mécaniques” (install ok, conventions fixées)

### Debug Log References

- `php -v`
- `php artisan --version`
- `composer --version`
- `composer validate --no-interaction`
- `php artisan test`
- `npm install`
- `npm i -D autoprefixer postcss @tailwindcss/postcss`
- `npm run build`
- `composer require barryvdh/laravel-dompdf`
- `php -r "echo (is_dir('storage/framework/sessions') ? 'sessions_dir=ok' : 'sessions_dir=missing') . PHP_EOL; echo (is_writable('storage/framework/sessions') ? 'sessions_writable=yes' : 'sessions_writable=no') . PHP_EOL;"`
- `php artisan serve --host=127.0.0.1 --port=8000`

### Implementation Plan

- Aligner la configuration (locale/sessions/.env.example) sur les AC.
- Ajouter les placeholders i18n FR/AR.
- Préparer les fichiers de config Tailwind demandés par la story.
- Faire valider via exécution locale: `php artisan --version`, `php artisan serve` ou `composer run dev`, `npm run dev`, `php artisan test`.
- Installer DomPDF via Composer et smoke-check de génération PDF.

### File List

- _bmad-output/implementation-artifacts/1-0-setup-projet-laravel-vanilla-dependances.md
- rattrapage/composer.json
- rattrapage/composer.lock
- rattrapage/package-lock.json
- rattrapage/package.json
- rattrapage/.env.example
- rattrapage/config/app.php
- rattrapage/config/session.php
- rattrapage/lang/ar/messages.php
- rattrapage/lang/fr/messages.php
- rattrapage/postcss.config.js
- rattrapage/README.md
- rattrapage/resources/views/pdf/smoke.blade.php
- rattrapage/routes/web.php
- rattrapage/tailwind.config.js
- rattrapage/tests/Feature/PdfSmokeTest.php

### Change Log

- 2026-02-26: Alignement config (locale FR, sessions file 30min, exemple MySQL), ajout placeholders i18n FR/AR, ajout configs Tailwind/PostCSS, ajout commandes dev dans README.
- 2026-02-26: Installation deps front (postcss/autoprefixer + plugin Tailwind v4 PostCSS), build Vite OK, installation DomPDF + smoke endpoint + test.
- 2026-02-26: Code review fixes: `CACHE_STORE=file` par défaut, endpoint smoke PDF protégé (local/testing), README cross-OS, i18n pour smoke PDF.

## Senior Developer Review (AI)

### Outcome

- Approve

### Findings & Fixes Applied

- [HIGH] `CACHE_STORE=database` dans `.env.example` pouvait casser `php artisan cache:clear` sans table cache → fixé (`CACHE_STORE=file`).
- [MED] Endpoint smoke PDF exposé partout → limité à `local/testing`.
- [MED] README: ajout commandes Windows + Mac/Linux pour la copie `.env.example`.
- [MED] Texte smoke PDF hardcodé → basculé vers traductions.
