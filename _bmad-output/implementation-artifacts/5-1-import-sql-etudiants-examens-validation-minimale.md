# Story 5.1: Import SQL (étudiants + examens) + validation minimale

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a administrateur / ops,
I want importer les données étudiants et examens via injection SQL contrôlée,
so that l’application soit alimentée rapidement sans interface admin lourde.

## Acceptance Criteria

1. **Given** un fichier SQL d’import pour `etudiants` et un fichier SQL d’import pour `examens`
   **When** j’exécute l’import sur la base MySQL
   **Then** les données sont insérées dans les tables correspondantes sans erreur

2. **And** l’import respecte les contraintes minimales suivantes :
   - pour chaque `examens.cod_etu`, un `etudiants.cod_etu` correspondant existe (cohérence FK)
   - les formats de `date_examen` (DATE) et `horaire` (TIME) sont valides
   - la colonne `cod_etu` n’est jamais vide dans `examens`

3. **And** si l’import échoue, la cause est identifiable (erreur SQL exploitable / log)

## Tasks / Subtasks

- [x] Définir le format des fichiers d’import
  - [x] 1 fichier SQL pour `etudiants`
  - [x] 1 fichier SQL pour `examens`
  - [x] Convention de nommage + emplacement (ex: dossier `database/imports/` ou `docs/ops/`)

- [x] Exécuter l’import en environnement local
  - [x] Procédure reproductible (commandes exactes)

- [x] Validations minimales
  - [x] FK en base (bloque insertion incohérente)
  - [x] Requête de vérification post-import (counts, rows invalides)

- [x] Logging
  - [x] Capturer l’erreur SQL et la documenter

## Dev Notes

- Cette story est orientée **ops**: l’objectif est un process fiable et reproductible, pas une UI.

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 5.1]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/5-1-import-sql-etudiants-examens-validation-minimale.md
- rattrapage/routes/console.php
- rattrapage/tests/Feature/OpsImportSqlCommandTest.php

### Change Log

- 2026-03-02: Ajout commande ops:import-sql (2 fichiers SQL) avec transaction, log d'erreur SQL, validations minimales post-import et tests.
