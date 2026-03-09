# Story 1.3: Auth serveur Apogée + DOB + erreurs spécifiques (FR/AR) + rate limit

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a étudiant,
I want m’authentifier avec mon Apogée + ma date de naissance,
so that je puisse accéder à mes examens et à ma convocation.

## Acceptance Criteria

1. **Given** je suis sur le formulaire login
   **When** je soumets un Apogée existant + une date de naissance correcte
   **Then** je suis authentifié (session créée)
   **And** je suis redirigé vers la page résultats/convocation

2. **Given** je soumets un Apogée inexistant
   **When** je valide le formulaire
   **Then** je vois une erreur spécifique (FR/AR) : “Aucun étudiant trouvé avec ce code Apogée.”
   **And** je reste sur le formulaire avec mes valeurs conservées

3. **Given** je soumets un Apogée existant mais une date de naissance incorrecte
   **When** je valide le formulaire
   **Then** je vois une erreur spécifique (FR/AR) : “Date de naissance incorrecte pour ce code Apogée.”
   **And** je reste sur le formulaire avec mes valeurs conservées

4. **Given** je fais trop de tentatives de login depuis la même IP
   **When** je dépasse 5 tentatives par minute
   **Then** je reçois une réponse/erreur de limitation (FR/AR) indiquant de réessayer plus tard
   **And** l’application ne bloque pas définitivement l’utilisateur

## Tasks / Subtasks

- [x] Routes & Controller (AC: 1..3)
  - [x] `LoginController@showForm` (GET `/`)
  - [x] `LoginController@authenticate` (POST `/login`)
  - [x] Redirection succès vers `/convocation`

- [x] Validation serveur & parsing date (AC: 1..3)
  - [x] Accepter plusieurs formats de date (tolérance) mais normaliser en `Y-m-d` pour comparaison DB
  - [x] En cas de format invalide: erreur dédiée (clé i18n)

- [x] Lookup étudiant (AC: 1..3)
  - [x] Si `cod_etu` introuvable → message spécifique
  - [x] Si `cod_etu` existe mais DOB mismatch → message spécifique

- [x] Session “auth custom” (AC: 1)
  - [x] Stocker un identifiant minimal en session (ex: `cod_etu`)
  - [x] Ne pas utiliser le système Auth Laravel standard (users/password)

- [x] Rate limiting (AC: 4)
  - [x] Middleware dédié `ThrottleLogin` (5/min/IP) appliqué à POST `/login`
  - [x] Erreur i18n claire (pas un 429 brut)

- [x] Tests (AC: 1..4)
  - [x] Happy path: étudiant existe + DOB ok → session set + redirect
  - [x] Apogée introuvable → erreur spécifique
  - [x] DOB incorrecte → erreur spécifique
  - [x] Throttle: 6 tentatives → rate limit

## Dev Notes

- **Sécurité**: ne pas leak d’infos sensibles au-delà de ce qui est demandé. Les AC exigent 2 messages distincts (introuvable vs DOB incorrecte) → c’est un choix produit.
- **UX**: conserver les valeurs saisies + focus champ en erreur.
- **i18n**: tous les messages via `lang/`.
- **Tolérance formats date**: important UX (PRD/UX). Mais la validation serveur doit rester stricte sur ce qu’on accepte.

### Project Structure Notes

- Controller: `app/Http/Controllers/LoginController.php`
- Middleware throttle: `app/Http/Middleware/ThrottleLogin.php`
- Routes: `routes/web.php`

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 1.3]
- [Source: _bmad-output/planning-artifacts/prd.md#Authentification Étudiant]
- [Source: _bmad-output/planning-artifacts/architecture.md#Authentication & Security]
- [Source: _bmad-output/planning-artifacts/ux-design-specification.md#Error (spécifique et actionnable)]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- `php artisan test`

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/1-3-auth-serveur-apogee-dob-erreurs-specifiques-fr-ar-rate-limit.md
- rattrapage/app/Http/Controllers/LoginController.php
- rattrapage/app/Http/Middleware/ThrottleLogin.php
- rattrapage/bootstrap/app.php
- rattrapage/lang/fr/messages.php
- rattrapage/lang/ar/messages.php
- rattrapage/resources/views/convocation.blade.php
- rattrapage/routes/web.php
- rattrapage/tests/Feature/LoginAuthTest.php
- rattrapage/tests/Feature/LoginLocaleTest.php

### Change Log

- 2026-02-27: Implémentation auth Apogée + DOB (session `cod_etu` + redirect `/convocation`), erreurs spécifiques i18n (FR/AR), rate limiting (5/min/IP) et tests feature.
