# Story 5.3: Conservation + sauvegardes (pas de suppression) + check-list période rattrapage

Status: done

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a administrateur / ops,
I want garantir la conservation des données et une stratégie de sauvegarde/restore simple,
so that l’application reste fiable pendant toute la période de rattrapage (et après).

## Acceptance Criteria

1. **Given** les données d’examens sont importées en base
   **When** l’application fonctionne en production
   **Then** aucune fonctionnalité ne supprime automatiquement les données (FR19)

2. **And** une procédure de sauvegarde est définie et exécutable :
   - export complet de la base (ex: dump MySQL)
   - fréquence minimale (ex: quotidienne pendant la période rattrapages)

3. **And** une procédure de restauration est définie :
   - restaurer la base depuis un dump
   - vérifier que l’application redémarre et que les pages clés fonctionnent

4. **And** une check-list “période rattrapage” existe (opérationnelle) :
   - backup OK
   - import OK
   - tests rapides (login + convocation + PDF + export listes) OK

## Tasks / Subtasks

- [x] Définir la stratégie de backup
  - [x] Commande `mysqldump` (ou équivalent) + paramètres
  - [x] Stockage des dumps (où, combien de jours)

- [x] Définir la procédure restore
  - [x] Commande de restauration
  - [x] Vérifications post-restore

- [x] Check-list ops “période rattrapage”
  - [x] Documenter une check-list exécutable (pas juste un paragraphe)

## Procédure Ops

### 1) Garantie “pas de suppression”

- Aucune route/commande applicative ne supprime automatiquement les données.
- La commande `ops:import-sql` n'exécute **aucun DELETE/TRUNCATE/DROP**.

### 2) Backup (dump MySQL)

- Pré-requis: avoir `mysqldump` installé sur la machine qui exécute le backup.
- Emplacement recommandé:
  - `storage/backups/mysql/`
  - Conservation: garder au minimum **7 jours** pendant la période rattrapage.

Commande (PowerShell, exemple):

```powershell
mysqldump --host=127.0.0.1 --port=3306 --user=<USER> --password=<PASSWORD> <DB_NAME> > storage/backups/mysql/rattrapage-$(Get-Date -Format "yyyyMMdd-HHmmss").sql
```

Fréquence recommandée:

- 1 dump **quotidien** pendant la période rattrapage.

### 3) Restore

- Pré-requis: avoir `mysql` (client) installé.

Commande (PowerShell, exemple):

```powershell
mysql --host=127.0.0.1 --port=3306 --user=<USER> --password=<PASSWORD> <DB_NAME> < storage/backups/mysql/<DUMP_FILE>.sql
```

Vérifications post-restore:

- `php artisan migrate --force` (si nécessaire)
- Ouvrir:
  - `/` (login)
  - `/convocation` (après login)
  - `/convocation/pdf`
  - `/ops/liste-etudiants`
  - `/ops/export-pdfs`

### 4) Check-list “période rattrapage”

- [ ] Backup du jour généré et stocké (`storage/backups/mysql/...sql`)
- [ ] Import exécuté (si besoin)
  - `php artisan ops:import-sql --etudiants=<PATH> --examens=<PATH>`
  - Vérifier le chemin `Report:` affiché par la commande
- [ ] Sanity checks fonctionnels
  - [ ] login OK
  - [ ] convocation page OK
  - [ ] PDF convocation OK
  - [ ] ops liste étudiants OK
  - [ ] export PDFs (liens + téléchargement d’un PDF) OK

## Dev Notes

- Cette story est principalement **documentation/procédure** (ops).

### References

- [Source: _bmad-output/planning-artifacts/epics.md#Story 5.3]
- [Source: _bmad-output/planning-artifacts/prd.md#Fiabilité]

## Dev Agent Record

### Agent Model Used

Cascade

### Debug Log References

- Documentation ops ajoutée (backup/restore/check-list)

### Completion Notes List

### File List

- _bmad-output/implementation-artifacts/5-3-conservation-sauvegardes-pas-de-suppression-check-list-periode-rattrapage.md

### Change Log

- 2026-03-02: Ajout procédure ops backup/restore + check-list période rattrapage (pas de suppression). 
