# Epic 7: QR code convocation + présence via scan prof

Status: review

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Goal

Ajouter un QR code (unique par étudiant) sur la convocation PDF afin de:

- Permettre à n'importe quelle application de scan (étudiant) d'ouvrir une page web publique affichant les données de l'étudiant + ses examens.
- Permettre à une application mobile "Prof" de scanner le même QR et de marquer `present=1` dans la table `planing` sur la bonne ligne (examen) en fonction de la date/heure actuelle.

## Scope

- BDD: ajout d'une colonne `present` sur `planing` (default: 0).
- QR PDF: URL signée vers endpoint public `/verify`.
- Endpoint public: `GET /verify`.
- Endpoint prof: `POST /presence/mark` sécurisé par clé API, avec logique de matching temporel.

## Out of Scope

- Développement de l'app mobile prof.
- UI avancée côté prof (sélection graphique) — cela se fait via l'app mobile.

## Stories

- Story 7.1 — Ajouter `present` à `planing` (done)
- Story 7.2 — Endpoint public `/verify` (done)
- Story 7.3 — Endpoint prof `/presence/mark` sécurisé + matching temporel + multi-match (review)

## Acceptance Criteria

1. **Given** un étudiant génère sa convocation PDF
   **When** le QR est activé
   **Then** le QR s'affiche dans le header du PDF et il est scannable.

2. **Given** je scanne le QR avec une app générique
   **When** j'ouvre l'URL
   **Then** je vois les données de l'étudiant et la liste des examens.

3. **Given** un prof scanne le QR avec son app
   **When** l'app appelle `/presence/mark` avec la clé
   **Then** l'API marque `present=1` pour l'examen du jour correspondant à la fenêtre:
   - 10 minutes avant l'heure annoncée
   - 40 minutes après l'heure annoncée

4. **And** si plusieurs examens matchent la fenêtre
   **Then** l'API renvoie une liste de choix et exige `planing_id` pour confirmer.

## Dev Notes

- Sécurité:
  - QR payload signé (HMAC) avec `app.key`.
  - App prof authentifiée via header `X-Prof-Key` (env `CONVOCATION_PROF_API_KEY`).
- CSRF:
  - L'endpoint prof doit être callable sans cookie/session.

### References

- _bmad-output/implementation-artifacts/2-3-post-mvp-v1-1-qr-code-sur-la-convocation-pdf.md
