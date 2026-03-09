# Story 2.1: Génération PDF convocation (DomPDF + template officiel) FR/AR

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a étudiant,
I want générer une convocation PDF officielle contenant mes informations et mes examens,
so that je puisse l’enregistrer et l’imprimer facilement.

## Acceptance Criteria

1. **Given** je suis authentifié et j’ai accès à ma page `/convocation`
   **When** je demande la génération du PDF (route dédiée)
   **Then** un PDF est généré via DomPDF

2. **And** le PDF contient :
   - mes informations personnelles (nom, prénom, code Apogée, filière)
   - la liste de mes examens (au minimum : module, date, horaire, salle/amphi, site)

3. **And** le PDF existe en FR/AR

4. **And** en AR, le contenu est rendu en RTL (lecture correcte)

5. **And** la génération du PDF respecte une contrainte de performance : < 3 secondes dans des conditions normales

## Tasks / Subtasks

- [x] Route PDF (AC: 1)
  - [x] Ajouter `GET /convocation/pdf` (protégée)
  - [x] `ConvocationController@pdf`

- [x] Template PDF (AC: 2..4)
  - [x] `resources/views/pdf/convocation.blade.php`
  - [x] Design “officiel” (header institutionnel + typographie claire)
  - [x] RTL en arabe

- [x] DomPDF config (AC: 1..5)
  - [x] Utiliser DomPDF pour rendre la vue Blade en PDF
  - [x] S’assurer des polices compatibles AR (point critique)

- [x] Perf (AC: 5)
  - [x] Éviter requêtes N+1 (charger examens efficacement)
  - [x] Éviter CSS complexe/large images dans PDF

- [x] Tests (AC: 1..5)
  - [x] Feature: endpoint PDF renvoie `application/pdf`
  - [x] Vérifier présence de contenu minimal (ex: header + nom étudiant) via assertions simples

## Dev Notes

- **Risque principal**: rendu AR/RTL en PDF (police + direction). Anticiper et tester tôt.
- **Ne pas implémenter QR code ici** (story 2.3 post-MVP).

### Project Structure Notes

- View PDF: `resources/views/pdf/convocation.blade.php`
- Controller: `app/Http/Controllers/ConvocationController.php`

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 2.1]
- [Source: _bmad-output/planning-artifacts/architecture.md#PDF]
- [Source: _bmad-output/planning-artifacts/ux-design-specification.md#Convocation PDF officielle]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/2-1-generation-pdf-convocation-dompdf-template-officiel-fr-ar.md
- rattrapage/app/Http/Controllers/ConvocationController.php
- rattrapage/resources/views/pdf/convocation.blade.php
- rattrapage/routes/web.php
- rattrapage/tests/Feature/ConvocationPdfTest.php

### Change Log

- 2026-03-02: Ajout endpoint PDF convocation protégé, rendu DomPDF FR/AR (RTL), template PDF officiel et tests feature.
- 2026-03-02: Review: ajout test de protection du endpoint PDF.
