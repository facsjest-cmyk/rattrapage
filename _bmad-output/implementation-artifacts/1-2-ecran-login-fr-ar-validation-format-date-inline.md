# Story 1.2: Écran Login (FR/AR) + validation format date (inline)

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a étudiant,
I want voir un formulaire de connexion simple (Apogée + date de naissance) en FR/AR, avec validation immédiate du format de date,
so that je peux saisir correctement mes informations sans stress et sans erreurs bloquantes.

## Acceptance Criteria

1. **Given** je suis sur la page d’accueil (non authentifié)
   **When** je consulte l’écran
   **Then** je vois un formulaire avec 2 champs :
   - Code Apogée
   - Date de naissance
   et un bouton principal pour soumettre

2. **And** un switch de langue permet de basculer FR/AR

3. **And** en langue AR, l’UI est en RTL (layout `dir="rtl"` ou équivalent)

4. **Given** je saisis une date de naissance
   **When** le format est invalide (format attendu : JJ/MM/AAAA)
   **Then** un message d’erreur inline, spécifique et actionnable s’affiche (FR/AR)

5. **And** le bouton de soumission reste utilisable après correction (pas de blocage permanent)

6. **And** lors d’une erreur, les champs gardent leurs valeurs saisies (pas d’effacement)

7. **And** le focus est placé sur le champ en erreur (au moins côté accessibilité clavier)

## Tasks / Subtasks

- [x] Construire la vue login (AC: 1)
  - [x] `resources/views/login.blade.php` conforme design direction D2 (sobre, institutionnel)
  - [x] Champs label+help (format date), bouton primary

- [x] Mettre en place le switch langue (AC: 2,3)
  - [x] Route `POST /locale/{locale}` + `LocaleController@switch`
  - [x] Stocker `locale` en session
  - [x] Middleware `SetLocale` appliqué à toutes les requêtes
  - [x] Appliquer `dir="rtl"` lorsque locale = `ar`

- [x] Validation inline format date côté UI (AC: 4..7)
  - [x] Sans JS lourd: validation côté serveur + affichage erreurs sous champ
  - [x] Optionnel léger: validation HTML/JS minimale (ne remplace pas validation serveur)
  - [x] Focus sur premier champ en erreur (autofocus conditionnel)
  - [x] Conserver les valeurs (old())

- [x] i18n messages (AC: 2..4)
  - [x] Ajouter clés dans `lang/fr/messages.php` et `lang/ar/messages.php`
  - [x] Ne pas hardcoder de texte

- [x] Tests (AC: 1..7)
  - [x] Feature test: GET `/` retourne le formulaire
  - [x] Feature test: switch locale change session + RTL côté rendu (au moins attribut `dir`)
  - [x] Feature test: date invalide → erreur inline

## Dev Notes

- **UX critique**: l’utilisateur est stressé. Les erreurs doivent être **spécifiques** et **actionnables**.
- **Pas de spinner plein écran**: préférer skeleton discret si besoin (UX spec).
- **Accessibilité**: navigation clavier complète, `:focus-visible` visible.
- **Ne pas implémenter l’auth ici** (c’est Story 1.3). Ici = écran + i18n + validation format.

### Project Structure Notes

- View: `resources/views/login.blade.php`
- Locale: `app/Http/Controllers/LocaleController.php`, `app/Http/Middleware/SetLocale.php`
- Routes: `routes/web.php`
- Lang: `lang/fr/`, `lang/ar/`

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 1.2]
- [Source: _bmad-output/planning-artifacts/architecture.md#Internationalization Patterns]
- [Source: _bmad-output/planning-artifacts/ux-design-specification.md#Form Patterns]
- [Source: _bmad-output/planning-artifacts/ux-design-specification.md#Accessibility Strategy]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/1-2-ecran-login-fr-ar-validation-format-date-inline.md
- rattrapage/app/Http/Controllers/LocaleController.php
- rattrapage/app/Http/Controllers/LoginController.php
- rattrapage/app/Http/Middleware/SetLocale.php
- rattrapage/bootstrap/app.php
- rattrapage/lang/fr/messages.php
- rattrapage/lang/ar/messages.php
- rattrapage/resources/views/login.blade.php
- rattrapage/routes/web.php
- rattrapage/tests/Feature/LoginLocaleTest.php

### Change Log

- 2026-02-26: Ajout écran login (FR/AR), switch locale en session + RTL, validation serveur format date (JJ/MM/AAAA) avec erreurs inline + focus, et tests feature.
- 2026-02-27: Code review fixes: middleware `SetLocale` ajouté au groupe `web` (ordre session), validation date renforcée (date réelle), améliorations accessibilité (aria-describedby + dir=ltr) et test autofocus.

## Senior Developer Review (AI)

### Outcome

- Approve

### Findings & Fixes Applied

- [HIGH] Exécution de `SetLocale` non garantie après la session → `SetLocale` ajouté au groupe `web` dans `bootstrap/app.php` et retiré du middleware de route.
- [HIGH] Validation date uniquement regex (dates impossibles acceptées) → validation via `DateTime::createFromFormat('d/m/Y')` + vérification stricte.
- [MED] Accessibilité: erreurs non reliées aux champs → ajout `aria-describedby` + ids d'erreur; champ date forcé `dir="ltr"`.
- [MED] AC7 non prouvée par tests → ajout assertion `autofocus` dans `LoginLocaleTest`.
