# Story 4.3: Qualité du PDF “liste présence” (mise en page opérationnelle + pagination + signature)

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a administrateur (opérations),
I want des PDFs lisibles et prêts à imprimer pour chaque (date, horaire, salle),
so that je peux les utiliser directement comme listes de présence.

## Acceptance Criteria

1. **Given** un PDF généré pour un groupe (date, horaire, salle/amphi)
   **When** je l’ouvre
   **Then** le PDF affiche clairement en en-tête :
   - date
   - horaire
   - salle/amphi
   - (optionnel) site

2. **And** le tableau est optimisé pour l’impression :
   - colonnes stables (nom, prénom, Apogée, module)
   - une colonne “Signature” (ou zone d’émargement) vide pour chaque étudiant
   - lignes lisibles (espacement suffisant)
   - pagination si la liste dépasse 1 page

## Tasks / Subtasks

- [x] Design template PDF
  - [x] En-tête répété (si possible)
  - [x] Table print-friendly + colonne signature

- [x] Pagination
  - [x] CSS print DomPDF (simple)

- [x] Tests visuels
  - [x] Générer un PDF avec > 1 page (data de test)

## Dev Notes

- Priorité: lisibilité opérationnelle, pas esthétique.

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 4.3]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/4-3-qualite-du-pdf-liste-presence-mise-en-page-operationnelle-pagination-signature.md
- rattrapage/resources/views/pdf/presence-list.blade.php
- rattrapage/tests/Feature/OpsExportPdfsTest.php

### Change Log

- 2026-03-02: Amélioration du PDF liste présence: en-tête fixe, table print-friendly (thead répété), pagination (numéros de page), colonne signature + test avec multi-pages.
