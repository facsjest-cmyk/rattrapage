# Story 6.3: Import SQL vers table unique + validations + mise à jour des tests

Status: ready-for-dev

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a administrateur / ops,
I want importer les données via SQL vers la table unique (flat) avec validations et reporting,
So that l’import reste reproductible et les fonctionnalités restent fiables.

## Acceptance Criteria

1. **Given** un fichier SQL d’import pour la table unique `planing`
   **When** j’exécute la commande d’import
   **Then** les données sont importées dans la table unique

2. **And** si l’import échoue, la cause est identifiable (erreur SQL exploitable / rapport)

3. **And** les tests automatisés sont mis à jour et passent (import, convocation, ops exports)

## Tasks / Subtasks

- [ ] Adapter `ops:import-sql` pour importer dans la table unique
- [ ] Adapter validations (colonnes obligatoires, cohérence minimale)
- [ ] Mettre à jour les tests `OpsImportSqlCommandTest` et tests liés au schéma

## Dev Notes

- L’import doit rester safe (transaction + report).
- Le schéma cible utilise `date` + `horaire` (et non `heure`).

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Epic 6]

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List

### Change Log
