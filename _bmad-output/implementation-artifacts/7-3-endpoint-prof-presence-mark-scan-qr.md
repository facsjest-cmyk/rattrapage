# Story 7.3: Endpoint prof `/presence/mark` (scan QR + marquage présence)

Status: review

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a professeur,
I want scanner le QR de l'étudiant et marquer sa présence automatiquement,
so that l'appel de présence est rapide et fiable.

## Acceptance Criteria

1. **Security**
   - **Given** j'appelle `POST /presence/mark`
     **When** le header `X-Prof-Key` est absent ou invalide
     **Then** l'API répond `401`

2. **QR validation**
   - **Given** je fournis `d` et `s`
     **When** la signature HMAC est invalide
     **Then** l'API répond `403`

3. **Matching temporel**
   - **Given** l'étudiant a un examen aujourd'hui
     **When** l'heure actuelle est entre `examAt - 10min` et `examAt + 40min`
     **Then** l'API marque `present=1` sur la ligne correspondante et répond `200`

4. **Multi-match**
   - **Given** plusieurs examens matchent la fenêtre
     **When** aucun `planing_id` n'est fourni
     **Then** l'API répond `409` avec `matches[]`

   - **And**
     **When** `planing_id` est fourni et fait partie des `matches[]`
     **Then** l'API marque `present=1` pour cet examen et répond `200`

5. **CSRF**
   - **Given** l'appel vient d'une app mobile (pas de session)
     **Then** il ne doit pas échouer en 419 (CSRF)

## Tasks / Subtasks

- [x] Configuration
  - [x] Ajouter `CONVOCATION_PROF_API_KEY` (config `convocation.prof_api_key`)

- [x] Route
  - [x] Ajouter `POST /presence/mark`

- [x] Contrôleur
  - [x] Auth header `X-Prof-Key`
  - [x] Validation signature QR
  - [x] Matching "aujourd'hui" + fenêtre [-10min; +40min]
  - [x] Multi-match -> `409` + liste
  - [x] Choix via `planing_id`

- [x] CSRF
  - [x] Exclure `presence/mark` de la validation CSRF

## Dev Notes

- Payload attendu:
  - `d`: string (base64url)
  - `s`: string (hex sha256)
  - `planing_id`: int (optionnel, requis si multi-match)

- Header requis:
  - `X-Prof-Key: <CONVOCATION_PROF_API_KEY>`

## Dev Agent Record

### Agent Model Used

Cascade

### File List

- rattrapage/config/convocation.php
- rattrapage/routes/web.php
- rattrapage/bootstrap/app.php
- rattrapage/app/Http/Controllers/ConvocationController.php
- _bmad-output/implementation-artifacts/7-3-endpoint-prof-presence-mark-scan-qr.md

### Change Log

- 2026-03-06: Ajout endpoint prof `/presence/mark` + auth clé + matching temporel + multi-match.

## Review Notes

- À valider avec un vrai scan sur téléphone et l'app prof.
- Décider si l'endpoint doit être migré vers `routes/api.php` si le projet ajoute une stack API dédiée.
