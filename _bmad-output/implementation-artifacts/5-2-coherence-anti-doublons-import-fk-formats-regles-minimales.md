# Story 5.2: Cohérence & anti-doublons import (FK, formats, règles minimales)

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a administrateur / ops,
I want détecter et éviter les incohérences/doublons lors des imports,
so that les listes (étudiant + PDF admin) restent fiables et exploitables.

## Acceptance Criteria

1. **Given** un import d’examens est exécuté
   **When** une ligne d’examen viole une règle de cohérence (cod_etu manquant/inexistant, date/heure invalides)
   **Then** l’import signale clairement les lignes problématiques (log exploitable)
   **And** les données invalides ne sont pas insérées

2. **And** l’import empêche les doublons “évidents” selon une règle minimale :
   - même `cod_etu` + `module` + `date_examen` + `horaire` + `salle` ⇒ un seul enregistrement

## Tasks / Subtasks

- [x] Mettre en place une contrainte anti-doublon
  - [x] Unique index composite sur (`cod_etu`, `module`, `date_examen`, `horaire`, `salle`)

- [x] Process de validation avant import
  - [x] Requêtes SQL de détection d’anomalies
  - [x] Log / rapport simple (fichier texte)

- [x] Tests
  - [x] Insérer doublon → doit échouer

## Dev Notes

- Cette story touche le schéma (index). La compatibilité avec les requêtes (convocation + exports) doit être gardée.

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 5.2]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/5-2-coherence-anti-doublons-import-fk-formats-regles-minimales.md
- rattrapage/database/migrations/2026_03_02_000005_add_unique_index_to_examens_table.php
- rattrapage/routes/console.php
- rattrapage/tests/Feature/OpsImportSqlCommandTest.php

### Change Log

- 2026-03-02: Ajout index unique composite anti-doublon sur examens + validations import en transaction avec rapport texte (rollback si anomalies) + tests (doublon, cod_etu vide).
