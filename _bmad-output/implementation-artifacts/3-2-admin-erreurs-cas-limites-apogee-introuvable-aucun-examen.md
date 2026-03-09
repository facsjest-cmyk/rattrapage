# Story 3.2: Admin: erreurs & cas limites (Apogée introuvable / aucun examen)

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a administrateur,
I want obtenir des retours clairs quand la recherche ne retourne rien,
so that je ne perds pas de temps et je peux guider l’étudiant.

## Acceptance Criteria

1. **Given** je suis sur l’interface admin de recherche
   **When** je saisis un Apogée inexistant et je valide
   **Then** je vois un message clair indiquant qu’aucun étudiant n’a été trouvé
   **And** le formulaire conserve la valeur saisie pour corriger rapidement

2. **Given** je saisis un Apogée existant
   **When** l’étudiant n’a aucun examen de rattrapage
   **Then** je vois un message clair : “Aucun examen de rattrapage n’est disponible pour cet étudiant.”
   **And** les infos de l’étudiant restent visibles

## Tasks / Subtasks

- [x] Gestion erreur “étudiant introuvable” (AC: 1)
  - [x] Message dédié (pas une erreur générique)
  - [x] Conserver la saisie (old/query)

- [x] Empty state examens (AC: 2)
  - [x] Message clair
  - [x] Garder la card infos étudiant affichée

- [x] Tests
  - [x] Apogée introuvable
  - [x] Étudiant sans examens

## Dev Notes

- Même logique UX que côté étudiant: messages **spécifiques**.

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 3.2]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/3-2-admin-erreurs-cas-limites-apogee-introuvable-aucun-examen.md
- rattrapage/app/Http/Controllers/AdminController.php
- rattrapage/resources/views/admin/recherche.blade.php
- rattrapage/lang/fr/messages.php
- rattrapage/lang/ar/messages.php
- rattrapage/tests/Feature/AdminSearchTest.php

### Change Log

- 2026-03-02: Ajout tests feature admin pour les cas limites: apogée introuvable (message + saisie conservée) et étudiant sans examens (empty state + infos visibles).
- 2026-03-02: Review: ajout tests validation (champ requis) et trim de la saisie Apogée.
