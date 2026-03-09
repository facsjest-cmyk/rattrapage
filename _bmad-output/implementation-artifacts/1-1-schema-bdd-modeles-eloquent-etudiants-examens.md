# Story 1.1: Schéma BDD + modèles Eloquent (Étudiants/Examens)

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a développeur (équipe produit),
I want créer le schéma BDD et les modèles (Etudiant, Examen) conformes à l’architecture,
so that le reste du parcours (auth + affichage examens + PDF + exports) peut fonctionner sur des données fiables.

## Acceptance Criteria

1. **Given** un projet Laravel initialisé et une base MySQL disponible
   **When** j’exécute les migrations
   **Then** les tables suivantes existent et respectent les conventions définies :
   - `etudiants` avec `cod_etu` (PK), `nom`, `prenom`, `date_naissance`, `filiere`
   - `examens` avec `id` (PK), `cod_etu` (FK), `module`, `professeur`, `semestre`, `groupe`, `date_examen`, `horaire`, `salle`, `site`

2. **And** la contrainte FK `examens.cod_etu` → `etudiants.cod_etu` est en place

3. **And** les modèles Eloquent existent :
   - `Etudiant` (PK = `cod_etu`, `incrementing=false`, `keyType=string`) avec relation `hasMany(Examen)`
   - `Examen` avec relation `belongsTo(Etudiant)` via `cod_etu`

4. **And** aucune table “future” non nécessaire n’est créée (uniquement ce qui est requis ici)

5. **And** la base est compatible avec :
   - la consultation étudiant (FR5–FR7)
   - les exports admin plus tard (Epic 4)
   - l’import SQL (Epic 5)

## Tasks / Subtasks

- [x] Créer les migrations (AC: 1,2)
  - [x] `create_etudiants_table` avec `cod_etu` en PK (string/varchar)
  - [x] `create_examens_table` avec FK vers `etudiants.cod_etu`
  - [x] Vérifier les types MySQL : `DATE` pour `date_naissance`/`date_examen`, `TIME` pour `horaire`

- [x] Créer les modèles Eloquent (AC: 3)
  - [x] `app/Models/Etudiant.php` (PK custom, relations)
  - [x] `app/Models/Examen.php` (relations)

- [x] Ajouter une validation minimale de cohérence (AC: 2)
  - [x] Vérifier que la FK est bien créée en base (migration) et pas “commentée”

- [x] Tests (AC: 1..5)
  - [x] Tests unitaires modèles (relations)
  - [x] Test de migration (au moins: migrations passent + relations fonctionnent sur données seedées)

## Dev Notes

- **Règle d’or**: respecter strictement le schéma défini dans l’architecture. Ne pas “améliorer” (pas de tables users/password, pas de sur-normalisation).

- **Conventions BDD**:
  - snake_case
  - `etudiants.cod_etu` = PK string (pas auto-increment)
  - `examens.cod_etu` = FK direct (pas `etudiant_id`)

- **Impact stories futures**:
  - Story 1.3 (auth) dépend de `etudiants` + `date_naissance`
  - Story 1.5 (convocation) dépend de la relation etudiant→examens
  - Epic 4 (listes ops) dépend d’une jointure fiable `examens`↔`etudiants`

- **Perf**:
  - Penser indexes utiles tôt (au minimum index sur `examens.cod_etu`, `examens.date_examen`, `examens.salle`), sans sur-optimiser.

### Project Structure Notes

- Migrations: `database/migrations/`
- Models: `app/Models/`

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 1.1]
- [Source: _bmad-output/planning-artifacts/architecture.md#Data Architecture]
- [Source: _bmad-output/planning-artifacts/architecture.md#Naming Patterns]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`
- `php artisan migrate`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/1-1-schema-bdd-modeles-eloquent-etudiants-examens.md
- rattrapage/app/Models/Etudiant.php
- rattrapage/app/Models/Examen.php
- rattrapage/database/migrations/2026_02_26_000003_create_etudiants_table.php
- rattrapage/database/migrations/2026_02_26_000004_create_examens_table.php
- rattrapage/tests/Unit/EtudiantExamenRelationTest.php

### Change Log

- 2026-02-26: Ajout des migrations `etudiants`/`examens` (FK + indexes), création des modèles Eloquent (PK custom sur `cod_etu`), et tests de relations.
- 2026-02-27: Code review fixes: cast `horaire` (TIME) corrigé, ajout de tests prouvant FK, cascade delete et structure des tables.

## Senior Developer Review (AI)

### Outcome

- Approve

### Findings & Fixes Applied

- [HIGH] Les tests ne prouvaient pas la FK / cascade delete → ajout tests `foreign key prevents orphan examen` et `cascade delete removes examens...`.
- [HIGH] Cast `horaire` incorrect (`datetime`) pour une colonne `TIME` → remplacé par cast `string`.
- [MED] Couverture structure de schéma insuffisante → ajout test `schema has expected columns`.
