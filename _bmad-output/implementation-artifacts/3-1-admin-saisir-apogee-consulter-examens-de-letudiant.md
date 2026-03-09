# Story 3.1: Admin: saisir Apogée → consulter examens de l’étudiant

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a administrateur,
I want saisir le code Apogée d’un étudiant pour consulter ses examens de rattrapage,
so that je puisse aider rapidement un étudiant / vérifier ses informations.

## Acceptance Criteria

1. **Given** je suis sur l’interface admin de recherche
   **When** je saisis un code Apogée et je valide
   **Then** je vois les informations de l’étudiant :
   - nom
   - prénom
   - code Apogée
   - filière

2. **And** je vois la liste de ses examens avec au minimum :
   - module
   - date
   - horaire
   - salle/amphi
   - site

3. **And** l’interface admin est distincte du parcours étudiant (route/vues séparées)

## Tasks / Subtasks

- [x] Routes admin (AC: 3)
  - [x] Préfixe `/admin`
  - [x] GET `/admin/recherche` affiche formulaire
  - [x] POST `/admin/recherche` exécute recherche (ou GET avec query param)

- [x] Controller admin (AC: 1..3)
  - [x] `AdminController@search` (form + résultat)
  - [x] Lookup étudiant par `cod_etu`
  - [x] Charger examens (relation)

- [x] Vue admin (AC: 1..3)
  - [x] `resources/views/admin/recherche.blade.php`
  - [x] UI simple, efficace, sans impacter UX étudiant

- [x] i18n (optionnel)
  - [x] Au minimum: messages d’erreur et labels. (Admin peut rester FR-only si décidé, mais si i18n global est déjà là, utiliser `lang/`.)

- [x] Tests
  - [x] Recherche valide retourne infos + examens

## Dev Notes

- **Séparation stricte**: pas de réutilisation de routes étudiant, éviter confusion.
- **Sécurité**: selon périmètre, cette interface peut être interne (sans auth), mais noter que ça expose des données sensibles. Si possible, prévoir une protection minimale (IP allowlist / basic auth / middleware) en post-MVP.

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 3.1]
- [Source: _bmad-output/planning-artifacts/architecture.md#Routes Pattern]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/3-1-admin-saisir-apogee-consulter-examens-de-letudiant.md
- rattrapage/app/Http/Controllers/AdminController.php
- rattrapage/routes/web.php
- rattrapage/resources/views/admin/recherche.blade.php
- rattrapage/lang/fr/messages.php
- rattrapage/lang/ar/messages.php
- rattrapage/tests/Feature/AdminSearchTest.php

### Change Log

- 2026-03-02: Ajout interface admin de recherche Apogée (/admin/recherche) + affichage infos étudiant/examens et tests feature.
- 2026-03-02: Review: normalisation de la saisie Apogée (trim) + tests validation et trim.
