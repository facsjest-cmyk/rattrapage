# Story 2.2: Bouton “Ouvrir/Télécharger PDF” depuis `/convocation` + parcours 1 clic

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a étudiant,
I want accéder au PDF depuis la page convocation via un bouton clair,
so that je peux ouvrir/télécharger/imprimer ma convocation en 1 clic.

## Acceptance Criteria

1. **Given** je suis authentifié et je suis sur `/convocation`
   **When** je vois la page
   **Then** je vois un bouton/CTA explicite (FR/AR) du type “Ouvrir la convocation PDF” / “Télécharger PDF”

2. **Given** je clique sur ce bouton
   **When** la requête est envoyée
   **Then** le PDF est renvoyé au navigateur de façon exploitable (ouverture/preview ou téléchargement)

3. **And** le nom du fichier est explicite (ex: `convocation_rattrapage_<apogee>.pdf`)

4. **And** l’action fonctionne en FR/AR (le PDF suit la langue active)

5. **And** si la génération échoue, un message d’erreur clair est affiché (FR/AR)

## Tasks / Subtasks

- [x] CTA dans la page convocation (AC: 1)
  - [x] Ajouter une barre d’actions (PdfActionsBar) au-dessus/à côté du tableau
  - [x] Libellés i18n

- [x] Réponse HTTP PDF (AC: 2..4)
  - [x] Décider: inline (preview) vs attachment (download) selon UX
  - [x] Fixer `Content-Disposition` + filename
  - [x] S’assurer que la langue active est passée au rendu PDF

- [x] Gestion erreur (AC: 5)
  - [x] Try/catch + message flash i18n + retour sur `/convocation`

- [x] Tests (AC: 1..5)
  - [x] Présence du CTA sur la page
  - [x] Click → réponse PDF + filename
  - [x] Cas erreur simulée → flash message

## Dev Notes

- **UX**: le CTA doit être visible sans scroll.
- **Pas d’étapes intermédiaires**: 1 clic.

### Project Structure Notes

- View: `resources/views/convocation.blade.php`
- Route: `/convocation/pdf`

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 2.2]
- [Source: _bmad-output/planning-artifacts/ux-design-specification.md#PdfActionsBar]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/2-2-bouton-ouvrir-telecharger-pdf-depuis-convocation-parcours-1-clic.md
- rattrapage/app/Http/Controllers/ConvocationController.php
- rattrapage/resources/views/convocation.blade.php
- rattrapage/lang/fr/messages.php
- rattrapage/lang/ar/messages.php
- rattrapage/tests/Feature/ConvocationPageTest.php
- rattrapage/tests/Feature/ConvocationPdfTest.php

### Change Log

- 2026-03-02: Ajout barre d’actions PDF sur /convocation (ouvrir + télécharger), support inline/attachment via `download=1`, filename explicite, gestion d’erreur i18n, et tests.
- 2026-03-02: Review: élargissement try/catch pour couvrir toute la génération PDF + test cas d'erreur (flash `pdf_error`).
