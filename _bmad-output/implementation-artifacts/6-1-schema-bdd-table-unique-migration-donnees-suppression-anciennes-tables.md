# Story 6.1: Schéma BDD table unique + migration de données + suppression des anciennes tables

Status: in-progress

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a développeur (équipe produit),
I want introduire une table unique contenant les données étudiant + examen (1 ligne = 1 examen) et migrer les données existantes,
So that l’application fonctionne avec un modèle “flat” et les anciennes tables peuvent être supprimées.

## Acceptance Criteria

1. **Given** une base contenant `etudiants` et `examens`
   **When** j’exécute les migrations
   **Then** une nouvelle table unique `planing` existe et contient au minimum les colonnes suivantes :
   - `id` (PK auto-increment)
   - `cod_etu`
   - `lib_nom_pat_ind`
   - `date_nai_ind`
   - `lib_pr1_ind`
   - `cod_elp`
   - `filiere`
   - `cod_tre`
   - `cod_ext_gpe`
   - `mod_groupe`
   - `prof`
   - `module`
   - `salle`
   - `site`
   - `date`
   - `horaire`

2. **And** des index existent au minimum sur :
   - `cod_etu`
   - `date`
   - `salle`

3. **And** une contrainte unique (anti-doublon) existe sur :
   - `cod_etu` + `mod_groupe` + `cod_tre`

4. **And** les données existantes (si présentes) sont migrées de `etudiants`/`examens` vers la table unique

5. **And** les tables `examens` et `etudiants` sont supprimées (dans cet ordre)

## Tasks / Subtasks

- [ ] Créer une migration pour créer la nouvelle table unique
- [ ] Ajouter les index nécessaires
- [ ] Migrer les données depuis `etudiants` + `examens`
- [ ] Supprimer les tables `examens` puis `etudiants`

## Dev Notes

- 1 ligne = 1 examen; les champs étudiant seront dupliqués si l’étudiant a plusieurs examens.

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Epic 6]

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List

### Change Log
