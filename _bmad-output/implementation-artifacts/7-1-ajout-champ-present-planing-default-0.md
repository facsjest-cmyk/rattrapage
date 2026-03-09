# Story 7.1: Ajout du champ `present` sur planing (default 0)

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a admin/ops,
I want une colonne `present` dans la table `planing` avec valeur par défaut `0`,
so that on peut suivre la présence d'un étudiant à un examen.

## Acceptance Criteria

1. **Given** la base contient déjà des lignes dans `planing`
   **When** je lance la migration
   **Then** la colonne `present` existe et toutes les lignes existantes ont `present=0`

2. **And** le modèle Eloquent caste `present` en boolean

## Tasks / Subtasks

- [x] Migration BDD (AC: 1)
  - [x] Ajouter colonne `present` bool default false
  - [x] Migration réversible (down)

- [x] Modèle (AC: 2)
  - [x] Ajouter `present` à `$fillable`
  - [x] Ajouter `present` à `$casts` en `boolean`

## Dev Agent Record

### Agent Model Used

Cascade

### File List

- rattrapage/database/migrations/2026_03_06_000007_add_present_to_planing_table.php
- rattrapage/app/Models/Planing.php
- _bmad-output/implementation-artifacts/7-1-ajout-champ-present-planing-default-0.md

### Change Log

- 2026-03-06: Ajout colonne `present` (default 0) et casts boolean.
