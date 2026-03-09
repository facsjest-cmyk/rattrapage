# Story 4.2: Export multi-PDF (1 PDF par date + horaire + salle/amphi)

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a administrateur (opérations),
I want générer des PDFs séparés par salle/amphi et par horaire (et par date),
so that j’imprime une liste de présence distincte pour chaque salle et chaque créneau.

## Acceptance Criteria

1. **Given** je suis sur la page “Liste étudiants” (avec ou sans filtre de date)
   **When** je clique sur “Exporter PDFs”
   **Then** le système génère un PDF par groupe unique (date, horaire, salle/amphi)

2. **And** chaque PDF contient :
   - un en-tête avec date, horaire, salle/amphi (et éventuellement site)
   - un tableau avec au minimum : nom, prénom, code Apogée, module

3. **And** si un groupe (date, horaire, salle) n’a aucun étudiant, aucun PDF n’est généré pour ce groupe

4. **And** le résultat est téléchargeable sous forme de plusieurs PDFs (téléchargement PDF par PDF via liste de liens)

## Tasks / Subtasks

- [x] Endpoint export
  - [x] Action “Exporter PDFs” depuis la page liste
  - [x] Générer les groupes (date_examen, horaire, salle)

- [x] Génération DomPDF par groupe
  - [x] Template PDF “liste présence”
  - [x] Générer plusieurs PDFs et retourner une page de liens (simple)

- [ ] Gestion volume
  - [ ] Éviter timeouts si beaucoup de groupes (potentiellement queue post-MVP)

- [x] Tests
  - [x] Génération de liens

## Dev Notes

- DomPDF est déjà requis; réutiliser le setup PDF.

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 4.2]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/4-2-export-multi-pdf-1-pdf-par-date-horaire-salle-amphi.md
- rattrapage/app/Http/Controllers/OpsController.php
- rattrapage/routes/web.php
- rattrapage/resources/views/ops/liste-etudiants.blade.php
- rattrapage/resources/views/ops/export-pdfs.blade.php
- rattrapage/resources/views/pdf/presence-list.blade.php
- rattrapage/lang/fr/messages.php
- rattrapage/lang/ar/messages.php
- rattrapage/tests/Feature/OpsExportPdfsTest.php

### Change Log

- 2026-03-02: Ajout export multi-PDF via page de liens (groupes date+horaire+salle) + génération DomPDF par groupe + tests.
