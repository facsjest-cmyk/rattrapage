---
stepsCompleted: [1, 2, 3, 4, 5, 6, 7, 8]
inputDocuments: ['planning-artifacts/prd.md', 'brainstorming/brainstorming-session-2026-02-25.md']
workflowType: 'architecture'
project_name: 'Rattrapage'
user_name: 'Hamza'
date: '2026-02-26'
lastStep: 8
status: 'complete'
completedAt: '2026-02-26'
---

# Architecture Decision Document

_This document builds collaboratively through step-by-step discovery. Sections are appended as we work through each architectural decision together._

## Project Context Analysis

### Requirements Overview

**Functional Requirements:**
19 FRs réparties en 6 catégories : Authentification (4), Consultation (3), PDF (3), Interface (3), Admin (3), Données (3). Le MVP se concentre sur le parcours étudiant (FR1-FR13), avec une interface admin minimale (FR14-FR16).

**Non-Functional Requirements:**
- **Performance** : TTFB <500ms, affichage examens <2s, génération PDF <3s, flow complet <20s
- **Scalabilité** : 10 000 utilisateurs simultanés, base ~50K enregistrements
- **Disponibilité** : 100% uptime pendant période rattrapages (2 semaines)
- **Sécurité** : Auth Apogée + DOB, sessions 30min, HTTPS obligatoire, protection Eloquent ORM

**Scale & Complexity:**
- Primary domain: Web Application (EdTech)
- Complexity level: Medium
- Estimated architectural components: 3-4 (Auth, Exam Display, PDF Generation, Admin Search)

### Technical Constraints & Dependencies

| Contrainte | Valeur |
|------------|--------|
| Framework | Laravel 10+ avec Blade templating |
| CSS | Tailwind CSS |
| Base de données | MySQL 8.0+ |
| PDF | barryvdh/laravel-dompdf |
| QR Code | simplesoftwareio/simple-qrcode (v1.1) |
| Architecture | MPA (Multi-Page Application) |
| Responsive | Desktop-first, mobile basique |

### Cross-Cutting Concerns Identified

1. **Scalabilité** — 10K utilisateurs simultanés impacte : connection pooling, optimisation queries, cache, dimensionnement serveur
2. **Disponibilité** — 100% uptime impacte : stratégie déploiement, monitoring, backups
3. **Sécurité** — Protection données étudiants impacte : validation inputs, sessions, HTTPS
4. **Performance PDF** — Génération <3s impacte : optimisation DomPDF, potentiel queue system

## Starter Template Evaluation

### Primary Technology Domain

Web Application (MPA) avec Laravel Blade — architecture server-rendered sans complexité SPA.

### Starter Options Considered

| Option | Évaluation |
|--------|------------|
| **Laravel Vanilla** | ✅ Recommandé — Structure propre, pas de code auth inutile |
| **Laravel Breeze** | ❌ Non adapté — Auth standard incompatible avec auth Apogée |
| **Laravel Jetstream** | ❌ Surdimensionné — Teams, 2FA non nécessaires |

### Selected Starter: Laravel Vanilla + Packages

**Rationale for Selection:**
L'authentification custom (Apogée + date de naissance) ne correspond pas aux starter kits Laravel standards. Un projet vanilla permet d'implémenter exactement ce qui est requis sans code superflu à supprimer.

**Initialization Command:**

```bash
# Création projet (DÉJÀ EXÉCUTÉ)
laravel new rattrapage  # Laravel 12.11.2 installé

# Installation dépendances à faire
cd rattrapage
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

# Packages Laravel
composer require barryvdh/laravel-dompdf
composer require simplesoftwareio/simple-qrcode
```

**Architectural Decisions Provided by Starter:**

| Aspect | Configuration |
|--------|---------------|
| **Language & Runtime** | PHP 8.2+ avec Laravel 12 |
| **Templating** | Blade engine |
| **Styling** | Tailwind CSS 4.x via npm |
| **Build Tooling** | Vite (inclus par défaut) |
| **Testing** | PHPUnit (inclus par défaut) |
| **Code Organization** | Structure MVC Laravel standard |

**Development Commands:**
- `php artisan serve` — Serveur local
- `npm run dev` — Vite/Tailwind hot reload
- `composer run dev` — Tout en un

## Core Architectural Decisions

### Decision Priority Analysis

**Critical Decisions (Bloquent l'implémentation):**
- Structure BDD : 2 tables plates (etudiants, examens)
- Auth custom : Apogée + date naissance (pas de password)
- Sessions : File storage avec expiration 30 min

**Important Decisions (Façonnent l'architecture):**
- Rate limiting : 5 tentatives/minute par IP
- Serveur : Apache
- CSRF : Activé (défaut Laravel)

**Deferred Decisions (Post-MVP):**
- Cache (Redis/query cache) si performance insuffisante
- Staging environment
- Monitoring avancé (Sentry)

### Data Architecture

| Décision | Choix | Rationale |
|----------|-------|-----------|
| **Structure BDD** | 2 tables plates | Simplicité, import SQL direct, pas de jointures |
| **Tables** | `etudiants`, `examens` | Mapping direct depuis Excel source |
| **Cache** | Aucun (MVP) | Simplicité, données toujours fraîches |
| **Migrations** | Laravel migrations | Versionning schema standard |

**Schema:**
```sql
-- Table etudiants
CREATE TABLE etudiants (
    cod_etu VARCHAR(20) PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    filiere VARCHAR(100)
);

-- Table examens
CREATE TABLE examens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cod_etu VARCHAR(20) NOT NULL,
    module VARCHAR(150) NOT NULL,
    professeur VARCHAR(100),
    semestre VARCHAR(20),
    groupe VARCHAR(50),
    date_examen DATE NOT NULL,
    horaire TIME NOT NULL,
    salle VARCHAR(50) NOT NULL,
    site VARCHAR(100),
    FOREIGN KEY (cod_etu) REFERENCES etudiants(cod_etu)
);
```

### Authentication & Security

| Décision | Choix | Rationale |
|----------|-------|-----------|
| **Méthode auth** | Apogée + date naissance | Pas de password, vérification côté serveur |
| **Sessions** | File storage | Simple, suffisant serveur unique |
| **Expiration** | 30 minutes inactivité | Conformité PRD |
| **CSRF** | Activé | Protection par défaut Laravel |
| **Rate limiting** | 5 req/min par IP | Protection brute force légère |
| **HTTPS** | Obligatoire en prod | Conformité PRD |

### Infrastructure & Deployment

| Décision | Choix | Rationale |
|----------|-------|-----------|
| **Serveur web** | Apache | Pré-installé université, .htaccess |
| **Environnements** | Local + Production | Minimum viable, pas de staging |
| **Backup** | Export manuel avant update | Contrôle manuel des données |
| **Monitoring** | Logs Laravel + serveur | Simple, suffisant MVP |
| **Base de données** | MySQL 8.0+ | Conformité PRD |

### Decision Impact Analysis

**Séquence d'implémentation:**
1. Migrations BDD (tables etudiants, examens)
2. Middleware auth custom (Apogée + DOB)
3. Rate limiting middleware
4. Controllers (Login, Convocation, PDF)
5. Views Blade + Tailwind
6. Configuration Apache prod

## Implementation Patterns & Consistency Rules

### Naming Patterns

**Database Naming:**

| Élément | Convention | Exemple |
|---------|------------|--------|
| Tables | snake_case, pluriel | `etudiants`, `examens` |
| Colonnes | snake_case | `date_naissance`, `cod_etu` |
| Clé primaire | custom autorisé | `cod_etu` (etudiants), `id` (examens) |
| Clé étrangère | nom direct | `cod_etu` (pas `etudiant_cod_etu`) |

**Code Naming (Laravel Standard):**

| Élément | Convention | Exemple |
|---------|------------|--------|
| Controllers | PascalCase, singulier | `LoginController`, `ConvocationController` |
| Models | PascalCase, singulier | `Etudiant`, `Examen` |
| Routes | kebab-case | `convocation.show`, `convocation.pdf` |
| Views | kebab-case | `login.blade.php`, `convocation.blade.php` |

### Structure Patterns

**Architecture MVP Simple:**
- Logique métier directement dans les Controllers
- Pas de Services/Repositories pour le MVP
- Validation dans les Controllers (pas de FormRequest)

**Organisation fichiers:**
```
app/
├── Http/Controllers/
│   ├── LoginController.php
│   ├── ConvocationController.php
│   └── AdminController.php
├── Models/
│   ├── Etudiant.php
│   └── Examen.php
resources/
├── views/
│   ├── layouts/app.blade.php
│   ├── login.blade.php
│   ├── convocation.blade.php
│   └── pdf/convocation.blade.php
├── lang/
│   ├── fr/
│   │   └── messages.php
│   └── ar/
│       └── messages.php
```

### Internationalization Patterns

**Langues supportées:** Français (fr), Arabe (ar)

**Gestion langue:**
- Stockage : Session Laravel (`session('locale')`)
- Middleware : Applique la langue à chaque requête
- Défaut : Français (fr)
- Switch : Bouton/select sur l'interface

**Fichiers traduction:**
- `lang/fr/messages.php` — Messages français
- `lang/ar/messages.php` — Messages arabes
- Utiliser `__('messages.key')` dans les views

**RTL Support (Arabe):**
- Attribut `dir="rtl"` conditionnel sur `<html>`
- Classes Tailwind RTL si nécessaire

### Routes Pattern

**Structure routes:**
```php
// Routes publiques
Route::get('/', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
Route::post('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

// Routes authentifiées
Route::middleware('auth.etudiant')->group(function () {
    Route::get('/convocation', [ConvocationController::class, 'show'])->name('convocation.show');
    Route::get('/convocation/pdf', [ConvocationController::class, 'pdf'])->name('convocation.pdf');
});

// Routes admin
Route::prefix('admin')->group(function () {
    Route::get('/recherche', [AdminController::class, 'search'])->name('admin.search');
});
```

### Error Handling Patterns

**Messages d'erreur:**
- Toujours via fichiers `lang/` (jamais hardcodés)
- Flash messages pour feedback utilisateur
- Redirect back avec erreurs de validation

**Exemple messages.php:**
```php
// lang/fr/messages.php
return [
    'auth_failed' => 'Code Apogée ou date de naissance incorrect.',
    'student_not_found' => 'Aucun étudiant trouvé avec ce code Apogée.',
    'invalid_date' => 'Format de date invalide. Utilisez JJ/MM/AAAA.',
];
```

### Enforcement Guidelines

**Tous les agents AI DOIVENT:**
1. Utiliser les conventions de nommage Laravel (snake_case BDD, PascalCase classes)
2. Mettre TOUS les textes utilisateur dans les fichiers `lang/`
3. Utiliser `__('key')` pour tous les messages affichés
4. Respecter la structure de fichiers définie
5. Nommer les routes avec la convention `resource.action`

## Project Structure & Boundaries

### Complete Project Directory Structure

```
rattrapage/
├── .env
├── .env.example
├── .gitignore
├── .htaccess
├── artisan
├── composer.json
├── package.json
├── tailwind.config.js
├── postcss.config.js
├── vite.config.js
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── LoginController.php          # Auth Apogée + DOB
│   │   │   ├── ConvocationController.php    # Affichage + PDF
│   │   │   ├── AdminController.php          # Recherche admin
│   │   │   └── LocaleController.php         # Switch langue FR/AR
│   │   │
│   │   └── Middleware/
│   │       ├── AuthEtudiant.php             # Vérifie session étudiant
│   │       ├── SetLocale.php                # Applique langue session
│   │       └── ThrottleLogin.php            # Rate limiting 5/min
│   │
│   └── Models/
│       ├── Etudiant.php                     # Model cod_etu PK
│       └── Examen.php                       # Model avec FK cod_etu
│
├── config/
│   ├── app.php                              # Locale FR par défaut
│   └── session.php                          # File driver, 30 min
│
├── database/
│   ├── migrations/
│   │   ├── xxxx_xx_xx_create_etudiants_table.php
│   │   └── xxxx_xx_xx_create_examens_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
│
├── lang/
│   ├── fr/
│   │   ├── messages.php                     # Messages app FR
│   │   └── validation.php                   # Erreurs validation FR
│   └── ar/
│       ├── messages.php                     # Messages app AR
│       └── validation.php                   # Erreurs validation AR
│
├── public/
│   ├── index.php
│   ├── .htaccess                            # Config Apache
│   └── build/                               # Assets compilés Vite
│
├── resources/
│   ├── css/
│   │   └── app.css                          # @tailwind directives
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                # Master layout RTL-ready
│       ├── login.blade.php                  # Formulaire 2 champs
│       ├── convocation.blade.php            # Liste examens + bouton PDF
│       ├── pdf/
│       │   └── convocation.blade.php        # Template PDF DomPDF
│       └── admin/
│           └── recherche.blade.php          # Recherche par Apogée
│
├── routes/
│   └── web.php                              # Toutes les routes
│
├── storage/
│   ├── framework/
│   │   ├── sessions/                        # Sessions file
│   │   └── views/
│   └── logs/
│       └── laravel.log
│
└── tests/
    ├── Feature/
    │   ├── LoginTest.php
    │   └── ConvocationTest.php
    └── Unit/
        └── EtudiantTest.php
```

### Requirements to Structure Mapping

| FR | Fichiers Concernés |
|----|-------------------|
| **FR1-FR4 (Auth)** | `LoginController.php`, `AuthEtudiant.php`, `ThrottleLogin.php`, `login.blade.php` |
| **FR5-FR7 (Consultation)** | `ConvocationController.php`, `convocation.blade.php`, `Etudiant.php`, `Examen.php` |
| **FR8-FR10 (PDF)** | `ConvocationController@pdf`, `pdf/convocation.blade.php` |
| **FR11-FR13 (Interface)** | `layouts/app.blade.php`, `app.css`, Tailwind |
| **FR14-FR16 (Admin)** | `AdminController.php`, `admin/recherche.blade.php` |
| **Multilingue** | `LocaleController.php`, `SetLocale.php`, `lang/fr/`, `lang/ar/` |

### Architectural Boundaries

**Middleware Stack:**
1. `SetLocale` — Toutes les requêtes (applique langue session)
2. `ThrottleLogin` — POST /login uniquement (5 req/min)
3. `AuthEtudiant` — Routes /convocation/* (vérifie session)

**Data Flow:**
```
Request → Middleware → Controller → Model (Eloquent) → MySQL
                                  ↓
                            View (Blade) → Response
```

**Model Relations:**
- `Etudiant` hasMany `Examen` (via cod_etu)
- `Examen` belongsTo `Etudiant` (via cod_etu)

## Architecture Validation Results

### Coherence Validation ✅

**Decision Compatibility:** Toutes les technologies (Laravel 12, Blade, Tailwind 4, MySQL 8, DomPDF) sont compatibles et bien intégrées.

**Pattern Consistency:** Conventions Laravel standard appliquées uniformément (snake_case BDD, PascalCase classes).

**Structure Alignment:** Arborescence projet conforme aux décisions MPA simple.

### Requirements Coverage ✅

**Functional Requirements:** 19/19 FRs couvertes (100%)
- Auth (FR1-4): ✅ LoginController + middleware
- Consultation (FR5-7): ✅ ConvocationController + Models
- PDF (FR8-10): ✅ DomPDF + template dédié
- Interface (FR11-13): ✅ Blade + Tailwind
- Admin (FR14-16): ✅ AdminController
- Données (FR17-19): ✅ Migrations Laravel

**Non-Functional Requirements:**
- Performance: ✅ Architecture simple optimisée
- Scalabilité: ⚠️ File sessions suffisant MVP, surveiller en prod
- Sécurité: ✅ CSRF, rate limiting, sessions, HTTPS
- Disponibilité: ✅ Architecture simple = robuste

### Implementation Readiness ✅

**AI Agent Guidelines:**
- Suivre les conventions Laravel documentées
- Utiliser `__('key')` pour TOUS les textes
- Respecter la structure de fichiers exacte
- Consulter ce document pour toute question

### Architecture Completeness Checklist

- [x] Contexte projet analysé
- [x] Stack technique spécifiée avec versions
- [x] Décisions critiques documentées
- [x] Patterns d'implémentation définis
- [x] Structure projet complète
- [x] Mapping FR → fichiers établi
- [x] Multilingue FR/AR prévu
- [x] Boundaries et flux documentés

### Architecture Readiness Assessment

**Statut Global:** ✅ PRÊT POUR L'IMPLÉMENTATION

**Niveau de Confiance:** ÉLEVÉ

**Points Forts:**
- Architecture simple et maintenable
- Stack Laravel éprouvée
- Patterns clairs pour les agents AI
- Multilingue intégré dès le départ

**Améliorations Futures (Post-MVP):**
- Cache Redis si performance insuffisante
- Staging environment
- QR Code sur convocations
- Monitoring avancé
