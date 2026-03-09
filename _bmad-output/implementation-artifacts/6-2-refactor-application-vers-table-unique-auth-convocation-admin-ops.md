# Story 6.2: Refactor application vers table unique (auth, convocation, admin, ops)

Status: in-progress

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a développeur (équipe produit),
I want adapter les requêtes Eloquent/DB pour lire depuis la table unique `planing`,
So that le login, la convocation (page + PDF), la recherche admin et les exports ops continuent de fonctionner.

## Acceptance Criteria

1. **Given** l’application déployée avec la table unique
   **When** un étudiant se connecte (Apogée + DOB)
   **Then** l’authentification fonctionne en se basant sur la table unique

2. **And** la page convocation et le PDF affichent la liste des examens de l’étudiant (triée par date/horaire)

3. **And** la recherche admin par Apogée fonctionne

4. **And** les pages ops (liste étudiants, export PDFs, présence PDF) fonctionnent sur les mêmes filtres (date/salle/horaire)

## Tasks / Subtasks

- [ ] Adapter l’auth (LoginController) pour lire dans la table unique
- [ ] Adapter convocation page + PDF
- [ ] Adapter recherche admin
- [ ] Adapter ops (liste, export PDFs, présence)
- [ ] Mettre à jour / créer les modèles nécessaires

## Dev Notes

- Conserver le comportement fonctionnel existant (seul le stockage change).

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Epic 6]

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List

### Change Log
