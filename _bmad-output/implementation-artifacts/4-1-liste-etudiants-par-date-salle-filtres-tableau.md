# Story 4.1: Liste étudiants par date/salle : filtres + tableau

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a administrateur (opérations),
I want consulter une liste des étudiants de rattrapage sous forme de tableau, filtrable/groupée par date et par salle/amphi,
so that je prépare les listes de présence et l’organisation du jour J.

## Acceptance Criteria

1. **Given** je suis sur la page “Liste étudiants” (interface opérations)
   **When** la page se charge
   **Then** je peux filtrer au minimum par :
   - date (jour)
   - salle/amphi

2. **And** le résultat s’affiche sous forme d’un tableau listant les étudiants correspondant au filtre

3. **And** le tableau est groupé (ou au minimum trié) par :
   - date puis salle/amphi

4. **And** pour chaque ligne étudiant, le tableau affiche au minimum :
   - identité (nom, prénom, code Apogée)
   - détails d’examen nécessaires (module, date, horaire, salle/amphi, site)

## Tasks / Subtasks

- [x] Route ops + Controller
  - [x] Créer une route dédiée (ex: `/ops/liste-etudiants` ou `/admin/liste-etudiants`) — décider un namespace
  - [x] Requête join `examens` + `etudiants`

- [x] Filtres
  - [x] Filtre date (jour) — via `date_examen`
  - [x] Filtre salle — via `salle`
  - [x] Paramètres via query string

- [x] Vue tableau
  - [x] Table avec colonnes opérationnelles
  - [x] Tri/grouping (au moins ORDER BY date_examen, salle, horaire)

- [x] Tests
  - [x] Filtre date
  - [x] Filtre salle

## Dev Notes

- **Perf**: requête join potentiellement volumineuse (50K). Ajouter indexes si nécessaire (date_examen, salle).

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 4.1]
- [Source: _bmad-output/planning-artifacts/architecture.md#Data Architecture]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/4-1-liste-etudiants-par-date-salle-filtres-tableau.md
- rattrapage/app/Http/Controllers/OpsController.php
- rattrapage/routes/web.php
- rattrapage/resources/views/ops/liste-etudiants.blade.php
- rattrapage/lang/fr/messages.php
- rattrapage/lang/ar/messages.php
- rattrapage/tests/Feature/OpsListeEtudiantsTest.php

### Change Log

- 2026-03-02: Ajout page ops liste étudiants (/ops/liste-etudiants) avec filtres date/salle (query string), tri par date/salle/horaire et tests feature.
