# Story 2.3 (post-MVP v1.1): QR code sur la convocation PDF

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a étudiant,
I want voir un QR code de vérification sur ma convocation PDF,
so that le document peut être vérifié rapidement.

## Acceptance Criteria

1. **Given** je génère mon PDF de convocation
   **When** la fonctionnalité v1.1 est activée
   **Then** le PDF contient un QR code visible et scannable

2. **And** le QR code encode une donnée/URL de vérification (à définir)

3. **And** le rendu reste compatible FR/AR (et RTL en AR)

4. **And** la présence du QR code ne dégrade pas la perf PDF au-delà de l’objectif (<3s) dans des conditions normales

## Tasks / Subtasks

- [x] Définir le payload QR (AC: 2)
  - [x] Choisir une URL de vérification (ex: route `/verify/{token}`) ou un code
  - [x] Définir format stable (versionné si besoin)

- [x] Générer le QR code (AC: 1..3)
  - [x] Utiliser `simplesoftwareio/simple-qrcode`
  - [x] Insérer le QR dans le template PDF

- [ ] Vérification côté serveur (optionnel, mais recommandé)
  - [ ] Endpoint de vérification simple (read-only)

- [x] Tests (AC: 1..4)
  - [x] Génération PDF inclut une image QR (assertion basique)

## Dev Notes

- **Post-MVP**: ne pas bloquer le MVP.
- **Sécurité**: éviter d’encoder des données sensibles en clair dans le QR.
- **Activation**: feature flag `CONVOCATION_QR_ENABLED=true`.

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 2.3]
- [Source: _bmad-output/planning-artifacts/architecture.md#Selected Starter: Laravel Vanilla + Packages]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/2-3-post-mvp-v1-1-qr-code-sur-la-convocation-pdf.md
- rattrapage/composer.json
- rattrapage/composer.lock
- rattrapage/app/Http/Controllers/ConvocationController.php
- rattrapage/config/convocation.php
- rattrapage/resources/views/pdf/convocation.blade.php
- rattrapage/tests/Feature/ConvocationQrCodeTest.php

### Change Log

- 2026-03-02: Ajout QR code sur le PDF convocation via `simple-qrcode` (SVG, sans Imagick) avec payload signé et test feature.
- 2026-03-02: Review: ajout feature flag `CONVOCATION_QR_ENABLED` pour activer/désactiver le QR.
- 2026-03-02: Review: ajout test feature pour vérifier le toggle (QR désactivé/activé).
