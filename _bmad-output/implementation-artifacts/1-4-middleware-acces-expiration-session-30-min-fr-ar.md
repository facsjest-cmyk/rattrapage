# Story 1.4: Middleware d’accès + expiration session 30 min (FR/AR)

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a étudiant,
I want que l’accès à la page convocation soit protégé par une session,
so that mes informations ne soient pas accessibles sans authentification et que ma session expire après inactivité.

## Acceptance Criteria

1. **Given** je ne suis pas authentifié (aucune session valide)
   **When** j’essaie d’accéder à `/convocation` (ou toute route protégée)
   **Then** je suis redirigé vers la page login
   **And** je vois un message (FR/AR) indiquant que je dois me connecter

2. **Given** je suis authentifié avec une session valide
   **When** j’accède à `/convocation`
   **Then** la page s’affiche normalement

3. **Given** je suis authentifié
   **When** je reste inactif pendant 30 minutes
   **Then** la session expire
   **And** au prochain accès à une page protégée, je suis redirigé vers login avec un message (FR/AR) “Votre session a expiré. Veuillez vous reconnecter.”

## Tasks / Subtasks

- [x] Middleware `AuthEtudiant` (AC: 1..3)
  - [x] Définir la condition “auth” sur la présence de `cod_etu` (ou équivalent) en session
  - [x] Si absent → redirect login + flash message i18n

- [x] Routes protégées (AC: 1..2)
  - [x] Grouper `/convocation` et `/convocation/pdf` derrière `auth.etudiant`

- [x] Expiration session 30 minutes (AC: 3)
  - [x] Configurer `SESSION_LIFETIME=30` (minutes)
  - [x] Vérifier `expire_on_close=false` (par défaut) et comportement “inactivité”
  - [x] Définir un mécanisme fiable pour afficher le message “session expirée” (ex: flag flash quand middleware détecte absence session après une navigation)

- [x] Tests (AC: 1..3)
  - [x] Accès convocation sans session → redirect + message
  - [x] Accès avec session → OK
  - [x] Test expiration: simuler temps (ou au minimum tester que config session lifetime est bien 30)

## Dev Notes

- **Point d’attention**: “inactivité 30 min” = comportement Laravel standard via `SESSION_LIFETIME` (refresh session à chaque requête). Tester rapidement pour éviter surprise.
- **UX**: le message session expirée est important pour éviter l’impression de bug.
- **i18n**: messages via `lang/fr/messages.php` et `lang/ar/messages.php`.

### Project Structure Notes

- Middleware: `app/Http/Middleware/AuthEtudiant.php`
- Config: `config/session.php`
- Routes: `routes/web.php`

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 1.4]
- [Source: _bmad-output/planning-artifacts/architecture.md#Authentication & Security]
- [Source: _bmad-output/planning-artifacts/ux-design-specification.md#Session/expira]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/1-4-middleware-acces-expiration-session-30-min-fr-ar.md
- rattrapage/app/Http/Middleware/AuthEtudiant.php
- rattrapage/bootstrap/app.php
- rattrapage/lang/fr/messages.php
- rattrapage/lang/ar/messages.php
- rattrapage/resources/views/login.blade.php
- rattrapage/routes/web.php
- rattrapage/tests/Feature/AuthEtudiantMiddlewareTest.php

### Change Log

- 2026-02-27: Ajout middleware `AuthEtudiant` (session `cod_etu`) + messages i18n (FR/AR) pour accès requis/expiration, protection routes convocation, et tests feature.
