# Story 1.5: Page convocation (infos perso + tableau examens “critical info first”) FR/AR

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a étudiant,
I want voir mes informations personnelles et la liste de mes examens de rattrapage sur une page claire,
so that je sache immédiatement quand et où je dois me présenter.

## Acceptance Criteria

1. **Given** je suis authentifié
   **When** j’accède à `/convocation`
   **Then** je vois mes informations personnelles :
   - nom
   - prénom
   - code Apogée
   - filière

2. **And** je vois un tableau (ou liste) de mes examens contenant au minimum :
   - module
   - professeur
   - semestre
   - groupe
   - date
   - horaire
   - salle/amphi
   - site

3. **And** la hiérarchie visuelle met en avant date + heure + salle (lecture rapide sous stress)

4. **And** l’UI est disponible en FR/AR, et en AR elle s’affiche en RTL

5. **And** si l’étudiant n’a aucun examen, un message clair s’affiche (FR/AR) : “Aucun examen de rattrapage n’est disponible pour le moment.”

## Tasks / Subtasks

- [x] Route + Controller (AC: 1..5)
  - [x] `ConvocationController@show` pour GET `/convocation`
  - [x] Charger l’étudiant depuis la session (cod_etu)
  - [x] Charger les examens via relation Eloquent

- [x] Vue Blade (AC: 1..5)
  - [x] `resources/views/convocation.blade.php`
  - [x] Layout direction D2 (cards, surface douce, institutionnel)
  - [x] Hiérarchie forte sur colonnes critiques (date/heure/salle)
  - [x] Empty state explicite si 0 examens

- [x] i18n/RTL (AC: 4..5)
  - [x] Tous les labels via `lang/`
  - [x] RTL activé quand locale = `ar`

- [ ] Performance perçue (NFR/UX)
  - [ ] Si requête lente: prévoir skeleton discret (sans spinner plein écran)

- [x] Tests (AC: 1..5)
  - [x] Accès sans session → redirect (Story 1.4)
  - [x] Accès avec session → affiche infos étudiant + examens
  - [x] Cas 0 examens → message empty state

## Dev Notes

- **Critical info first**: l’utilisateur est potentiellement stressé → date/heure/salle doivent être immédiatement repérables.
- **Pas de navigation**: UX “zéro friction” (pas de menus inutiles).
- **Tous textes** via `lang/`.

### Project Structure Notes

- Controller: `app/Http/Controllers/ConvocationController.php`
- View: `resources/views/convocation.blade.php`

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 1.5]
- [Source: _bmad-output/planning-artifacts/architecture.md#Routes Pattern]
- [Source: _bmad-output/planning-artifacts/ux-design-specification.md#Design Direction Decision]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/1-5-page-convocation-infos-perso-tableau-examens-critical-info-first-fr-ar.md
- rattrapage/app/Http/Controllers/ConvocationController.php
- rattrapage/resources/views/convocation.blade.php
- rattrapage/routes/web.php
- rattrapage/lang/fr/messages.php
- rattrapage/lang/ar/messages.php
- rattrapage/tests/Feature/ConvocationPageTest.php
- rattrapage/tests/Feature/AuthEtudiantMiddlewareTest.php

### Change Log

- 2026-03-02: Ajout page convocation avec infos perso + liste examens (critical info first), i18n FR/AR + RTL, empty state, controller dédié et tests feature.
