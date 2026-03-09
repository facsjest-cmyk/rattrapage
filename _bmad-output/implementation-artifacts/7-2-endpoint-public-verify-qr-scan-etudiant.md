# Story 7.2: Endpoint public `/verify` (scan étudiant)

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a étudiant,
I want scanner le QR code sur ma convocation PDF et ouvrir une page web,
so that je peux voir mes données et mes examens via un lien vérifiable.

## Acceptance Criteria

1. **Given** je scanne le QR depuis le PDF
   **When** j'ouvre l'URL `/verify?d=...&s=...`
   **Then** la signature est validée et j'obtiens une page affichant les infos étudiant + examens

2. **And** si la signature est invalide
   **Then** la page refuse l'accès (403)

3. **And** si le payload est invalide
   **Then** la page répond 404

## Tasks / Subtasks

- [x] Route web (AC: 1..3)
  - [x] Ajouter `GET /verify`

- [x] Contrôleur (AC: 1..3)
  - [x] Décoder `d` (base64url) + vérifier `s` (HMAC)
  - [x] Charger `Planing` (cod_etu) et la liste des examens

- [x] Vue (AC: 1)
  - [x] Créer `resources/views/verify.blade.php`

## Dev Agent Record

### Agent Model Used

Cascade

### File List

- rattrapage/routes/web.php
- rattrapage/app/Http/Controllers/ConvocationController.php
- rattrapage/resources/views/verify.blade.php
- _bmad-output/implementation-artifacts/7-2-endpoint-public-verify-qr-scan-etudiant.md

### Change Log

- 2026-03-06: Ajout endpoint public `/verify` + vue `verify`.
