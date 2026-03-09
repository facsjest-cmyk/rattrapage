---
stepsCompleted: ['step-01-validate-prerequisites', 'step-02-design-epics', 'step-03-create-stories', 'step-04-final-validation']
inputDocuments:
  - 'planning-artifacts/prd.md'
  - 'planning-artifacts/architecture.md'
  - 'planning-artifacts/ux-design-specification.md'
---

# Rattrapage - Epic Breakdown

## Overview

This document provides the complete epic and story breakdown for Rattrapage, decomposing the requirements from the PRD, UX Design if it exists, and Architecture requirements into implementable stories.

## Requirements Inventory

### Functional Requirements

FR1: L'étudiant peut s'authentifier avec son code Apogée et sa date de naissance
FR2: L'étudiant peut voir un message d'erreur explicite si ses identifiants sont incorrects
FR3: L'étudiant peut voir un message d'erreur si le format de date est invalide
FR4: L'étudiant peut réessayer de se connecter après une erreur (pas de blocage)
FR5: L'étudiant authentifié peut voir la liste de tous ses examens de rattrapage
FR6: L'étudiant peut voir pour chaque examen : module, professeur, semestre, groupe, date, horaire, salle, site
FR7: L'étudiant peut voir ses informations personnelles (nom, prénom, code Apogée, filière)
FR8: L'étudiant peut télécharger sa convocation au format PDF
FR9: L'étudiant peut voir sur la convocation PDF ses informations personnelles et la liste de ses examens
FR10: L'étudiant peut voir sur la convocation PDF un QR code de vérification (v1.1 si délai serré)
FR11: L'étudiant peut accéder à l'application depuis un navigateur desktop
FR12: L'étudiant peut accéder à l'application depuis un navigateur mobile (fonctionnalité basique)
FR13: L'étudiant peut voir un formulaire de connexion simple avec 2 champs
FR14: L'administrateur peut accéder à une interface de recherche par code Apogée
FR15: L'administrateur peut saisir le code Apogée d'un étudiant pour consulter tous ses examens de rattrapage
FR16: L'administrateur peut voir les mêmes informations que l'étudiant (module, date, horaire, salle, site)
FR17: L'administrateur peut importer les données étudiants via injection SQL directe
FR18: L'administrateur peut importer les données examens via injection SQL directe
FR19: Le système conserve les données indéfiniment (pas de suppression automatique)
FR20: Liste étudiants de rattrapage par date (jour) et par salle/amphi
FR21: Génération et impression (ou téléchargement) d’un PDF de la liste des étudiants de rattrapage groupée par date et par salle/amphi
FR22: Le PDF des listes contient, pour chaque étudiant, les informations nécessaires à l'organisation (identité + détails d'examen)

### NonFunctional Requirements

NFR1: Performance — TTFB <500ms sous charge normale
NFR2: Performance — Affichage examens <2s après authentification
NFR3: Performance — Génération PDF <3s pour une convocation complète
NFR4: Performance — Flow complet Connexion → PDF téléchargé <20s
NFR5: Scalabilité — Supporter 10 000 utilisateurs simultanés sans dégradation >10%
NFR6: Scalabilité — Supporter le volume étudiants université (~50 000 enregistrements max)
NFR7: Fiabilité — Disponibilité 100% pendant la période rattrapages (2 semaines)
NFR8: Fiabilité — Récupération <1h en cas de panne serveur
NFR9: Fiabilité — Sauvegardes quotidiennes de la base MySQL
NFR10: Sécurité — Sessions avec expiration après inactivité (30 min)
NFR11: Sécurité — HTTPS obligatoire en production
NFR12: Sécurité — Protection contre l’injection SQL via Eloquent / requêtes préparées

### Additional Requirements

- Stack imposée : Laravel 10+ (projet actuel en Laravel 12), Blade (MPA), Tailwind, MySQL 8.0+
- Authentification custom : Apogée + date de naissance (pas de password)
- Sessions : stockage fichier (MVP) avec expiration 30 minutes
- Rate limiting login : 5 tentatives/minute par IP
- CSRF activé (comportement par défaut Laravel)
- Modèle de données : tables `etudiants` (PK `cod_etu`) et `examens` (FK `cod_etu`)
- Génération PDF via `barryvdh/laravel-dompdf`
- QR Code via `simplesoftwareio/simple-qrcode` (prévu v1.1)
- Bilingue FR/AR : support RTL en arabe, et textes via système i18n (`lang/fr`, `lang/ar`)
- UX : validation inline + messages d’erreur spécifiques et actionnables
- UX : tolérance aux formats de date (accepter plusieurs formats, conversion automatique)
- UX : conserver les valeurs saisies lors d’une erreur + focus sur le premier champ en erreur
- UX : loading “perçu instantané” (skeleton discret, pas de spinner plein écran)
- UX : responsive desktop-first, mobile “fonctionnel” (table scroll horizontal ou fallback cartes)
- UX : accessibilité cible WCAG AA, navigation clavier complète, `:focus-visible` visible
- Support navigateurs : dernières 2 versions (Chrome/Firefox/Safari/Edge), pas d’IE11

### FR Coverage Map

FR1: Epic 1 - Authentification étudiant (Apogée + date)
FR2: Epic 1 - Erreur identifiants incorrects
FR3: Epic 1 - Validation format date + erreur format
FR4: Epic 1 - Réessayer après erreur
FR5: Epic 1 - Voir la liste des examens de rattrapage
FR6: Epic 1 - Voir le détail d’un examen (module, prof, semestre, groupe, date, horaire, salle, site)
FR7: Epic 1 - Voir les informations personnelles (nom, prénom, Apogée, filière)
FR8: Epic 2 - Télécharger la convocation PDF
FR9: Epic 2 - PDF contient infos personnelles + liste examens
FR10: Epic 2 - QR code sur PDF (v1.1 / post-MVP)
FR11: Epic 1 - Accès via navigateur desktop
FR12: Epic 1 - Accès via navigateur mobile (fonctionnel)
FR13: Epic 1 - Formulaire de connexion simple (2 champs)
FR14: Epic 3 - Interface admin de recherche par Apogée
FR15: Epic 3 - Admin saisit Apogée pour consulter examens
FR16: Epic 3 - Admin voit les mêmes infos que l’étudiant
FR17: Epic 5 - Import des données étudiants (injection SQL)
FR18: Epic 5 - Import des données examens (injection SQL)
FR19: Epic 5 - Conservation indéfinie des données (pas de suppression)
FR20: Epic 4 - Liste étudiants par date et par salle/amphi (préparation impression)
FR21: Epic 4 - Génération/Impression PDF des listes groupées (date + salle/amphi)
FR22: Epic 4 - Contenu PDF liste étudiants (champs nécessaires)

## Epic List

### Epic 1: Consulter ses examens (auth + résultats) — Étudiant (MVP)
L’étudiant s’authentifie en 2 champs, obtient immédiatement ses informations personnelles et la liste complète de ses examens avec les détails critiques (date/heure/salle), en FR/AR (RTL) et avec une UX tolérante aux erreurs.
**FRs covered:** FR1, FR2, FR3, FR4, FR5, FR6, FR7, FR11, FR12, FR13

**Implementation notes (NFR/UX/Arch):**
- Auth custom Apogée + DOB, sessions 30 min, rate limiting login.
- Validation inline + erreurs spécifiques (format date / identifiants), conserver saisie, focus champ en erreur.
- i18n FR/AR + RTL appliqué (baseline dès v1).
- Performance perçue (skeleton/transition), objectif <2s affichage examens.

### Epic 2: Convocation officielle PDF — Étudiant (MVP + v1.1)
L’étudiant peut ouvrir/télécharger une convocation PDF officielle avec ses infos + ses examens, prête à enregistrer et imprimer.
**FRs covered:** FR8, FR9, FR10

**Implementation notes (NFR/UX/Arch):**
- DomPDF, rendu “officiel” + ouverture navigateur.
- Perf PDF <3s.
- QR code explicitement **post-MVP (v1.1)**.

### Epic 3: Recherche admin (consultation examens par Apogée)
Un administrateur peut rechercher un étudiant par Apogée et consulter ses examens (mêmes champs que côté étudiant).
**FRs covered:** FR14, FR15, FR16

**Implementation notes (NFR/UX/Arch):**
- Interface simple, orientée efficacité (sans complexifier le parcours étudiant).
- Séparer les routes/vues admin.

### Epic 4: Liste étudiants par date/salle + export PDF (opérations jour J)
Préparer le jour J en obtenant une liste des étudiants de rattrapage sous forme de **tableau**, groupée/filtrable par **date** et par **salle/amphi**, puis générer un PDF prêt à imprimer.
**FRs covered:** FR20, FR21, FR22

**Implementation notes (NFR/UX/Arch):**
- Doit permettre un usage “opérationnel” (tri/groupe clair, PDF lisible).
- Les données existent déjà dans `examens` (date_examen, horaire, salle, site) + `etudiants` (identité) — nécessite une requête join.

### Epic 5: Import & gouvernance des données (opérations)
L’équipe peut alimenter le système via import SQL (étudiants + examens) et garantir la conservation indéfinie des données.
**FRs covered:** FR17, FR18, FR19

**Implementation notes (NFR/UX/Arch):**
- Process/import reproductible (script SQL, validations basiques), cohérence FK `cod_etu`.
- Backups/restore et pratiques d’exploitation (surtout en période rattrapages).

### Epic 6: Refonte modèle de données — Table unique (flat)
Refondre le modèle de données en remplaçant les tables `etudiants` + `examens` par une table unique `planing` “flat” contenant, sur chaque ligne, les informations d’un étudiant + un examen (format proche Excel), puis adapter l’application, l’import et les tests.
**FRs covered:** FR1–FR22 (impact transversal; mêmes fonctionnalités, stockage différent)

**Implementation notes (NFR/UX/Arch):**
- 1 ligne = 1 examen, les champs étudiant sont dupliqués si l’étudiant a plusieurs examens.
- Conserver un `id` auto-increment pour l’identification technique.
- Indexer au minimum : `cod_etu`, `date`, `salle`.
- Prévoir une migration de données, puis suppression des anciennes tables.

## Epic 1: Consulter ses examens (auth + résultats) — Étudiant (MVP)

L’étudiant s’authentifie en 2 champs, obtient immédiatement ses informations personnelles et la liste complète de ses examens avec les détails critiques (date/horaire/salle), en FR/AR (RTL) et avec une UX tolérante aux erreurs.

### Story 1.0: Setup projet (Laravel vanilla + dépendances)

As a développeur (équipe produit),
I want initialiser le projet depuis le starter Laravel vanilla et installer/configurer les dépendances nécessaires,
So that le reste des stories (auth, UI, PDF, exports) peut être implémenté rapidement et de manière reproductible.

**Acceptance Criteria:**

**Given** un repository propre pour le projet
**When** je finalise le setup local
**Then** l’application Laravel démarre en local

**And** les dépendances nécessaires au MVP sont en place :
- Tailwind (via npm/Vite)
- DomPDF (`barryvdh/laravel-dompdf`)

**And** la configuration de base respecte l’architecture :
- MySQL configuré via `.env`
- sessions configurées pour expiration 30 minutes (driver fichier)

**And** les commandes principales de dev (serve + build assets) sont documentées/connues pour l’équipe

### Story 1.1: Schéma BDD + modèles Eloquent (Étudiants/Examens)

As a développeur (équipe produit),
I want créer le schéma BDD et les modèles (Etudiant, Examen) conformes à l’architecture,
So that le reste du parcours (auth + affichage examens + PDF + exports) peut fonctionner sur des données fiables.

**Acceptance Criteria:**

**Given** un projet Laravel initialisé et une base MySQL disponible
**When** j’exécute les migrations
**Then** les tables suivantes existent et respectent les conventions définies :
- `etudiants` avec `cod_etu` (PK), `nom`, `prenom`, `date_naissance`, `filiere`
- `examens` avec `id` (PK), `cod_etu` (FK), `module`, `professeur`, `semestre`, `groupe`, `date_examen`, `horaire`, `salle`, `site`

**And** la contrainte FK `examens.cod_etu` → `etudiants.cod_etu` est en place
**And** les modèles Eloquent existent :
- `Etudiant` (PK = `cod_etu`, `incrementing=false`, `keyType=string`) avec relation `hasMany(Examen)`
- `Examen` avec relation `belongsTo(Etudiant)` via `cod_etu`

**And** aucune table “future” non nécessaire n’est créée (uniquement ce qui est requis ici)
**And** la base est compatible avec :
- la consultation étudiant (FR5–FR7)
- les exports admin plus tard (Epic 4)
- l’import SQL (Epic 5)

### Story 1.2: Écran Login (FR/AR) + validation format date (inline)

As a étudiant,
I want voir un formulaire de connexion simple (Apogée + date de naissance) en FR/AR, avec validation immédiate du format de date,
So that je peux saisir correctement mes informations sans stress et sans erreurs bloquantes.

**Acceptance Criteria:**

**Given** je suis sur la page d’accueil (non authentifié)
**When** je consulte l’écran
**Then** je vois un formulaire avec 2 champs :
- Code Apogée
- Date de naissance
et un bouton principal pour soumettre

**And** un switch de langue permet de basculer FR/AR
**And** en langue AR, l’UI est en RTL (layout `dir="rtl"` ou équivalent)

**Given** je saisis une date de naissance
**When** le format est invalide (format attendu : JJ/MM/AAAA)
**Then** un message d’erreur inline, spécifique et actionnable s’affiche (FR/AR)
**And** le bouton de soumission reste utilisable après correction (pas de blocage permanent)

**And** lors d’une erreur, les champs gardent leurs valeurs saisies (pas d’effacement)
**And** le focus est placé sur le champ en erreur (au moins côté accessibilité clavier)

### Story 1.3: Auth serveur Apogée + DOB + erreurs spécifiques (FR/AR) + rate limit

As a étudiant,
I want m’authentifier avec mon Apogée + ma date de naissance,
So that je puisse accéder à mes examens et à ma convocation.

**Acceptance Criteria:**

**Given** je suis sur le formulaire login
**When** je soumets un Apogée existant + une date de naissance correcte
**Then** je suis authentifié (session créée)
**And** je suis redirigé vers la page résultats/convocation

**Given** je soumets un Apogée inexistant
**When** je valide le formulaire
**Then** je vois une erreur spécifique (FR/AR) : “Aucun étudiant trouvé avec ce code Apogée.”
**And** je reste sur le formulaire avec mes valeurs conservées

**Given** je soumets un Apogée existant mais une date de naissance incorrecte
**When** je valide le formulaire
**Then** je vois une erreur spécifique (FR/AR) : “Date de naissance incorrecte pour ce code Apogée.”
**And** je reste sur le formulaire avec mes valeurs conservées

**Given** je fais trop de tentatives de login depuis la même IP
**When** je dépasse 5 tentatives par minute
**Then** je reçois une réponse/erreur de limitation (FR/AR) indiquant de réessayer plus tard
**And** l’application ne bloque pas définitivement l’utilisateur (il peut réessayer après la fenêtre de temps)

### Story 1.4: Middleware d’accès + expiration session 30 min (FR/AR)

As a étudiant,
I want que l’accès à la page convocation soit protégé par une session,
So that mes informations ne soient pas accessibles sans authentification et que ma session expire après inactivité.

**Acceptance Criteria:**

**Given** je ne suis pas authentifié (aucune session valide)
**When** j’essaie d’accéder à `/convocation` (ou toute route protégée)
**Then** je suis redirigé vers la page login
**And** je vois un message (FR/AR) indiquant que je dois me connecter

**Given** je suis authentifié avec une session valide
**When** j’accède à `/convocation`
**Then** la page s’affiche normalement

**Given** je suis authentifié
**When** je reste inactif pendant 30 minutes
**Then** la session expire
**And** au prochain accès à une page protégée, je suis redirigé vers login avec un message (FR/AR) du type “Votre session a expiré. Veuillez vous reconnecter.”

### Story 1.5: Page convocation (infos perso + tableau examens “critical info first”) FR/AR

As a étudiant,
I want voir mes informations personnelles et la liste de mes examens de rattrapage sur une page claire,
So that je sache immédiatement quand et où je dois me présenter.

**Acceptance Criteria:**

**Given** je suis authentifié
**When** j’accède à `/convocation`
**Then** je vois mes informations personnelles :
- nom
- prénom
- code Apogée
- filière

**And** je vois un tableau (ou liste) de mes examens contenant au minimum :
- module
- professeur
- semestre
- groupe
- date
- horaire
- salle/amphi
- site

**And** la hiérarchie visuelle met en avant date + heure + salle (lecture rapide sous stress)
**And** l’UI est disponible en FR/AR, et en AR elle s’affiche en RTL
**And** si l’étudiant n’a aucun examen, un message clair s’affiche (FR/AR) : “Aucun examen de rattrapage n’est disponible pour le moment.”

## Epic 2: Convocation officielle PDF — Étudiant (MVP + v1.1)

L’étudiant peut ouvrir/télécharger une convocation PDF officielle avec ses infos + ses examens, prête à enregistrer et imprimer.

### Story 2.1: Génération PDF convocation (DomPDF) + template officiel (FR/AR)

As a étudiant,
I want générer une convocation PDF officielle contenant mes informations et mes examens,
So that je puisse l’enregistrer et l’imprimer facilement.

**Acceptance Criteria:**

**Given** je suis authentifié et j’ai accès à ma page `/convocation`
**When** je demande la génération du PDF (route dédiée)
**Then** un PDF est généré via DomPDF
**And** le PDF contient :
- mes informations personnelles (nom, prénom, code Apogée, filière)
- la liste de mes examens (au minimum : module, date, horaire, salle/amphi, site)

**And** le PDF existe en FR/AR
**And** en AR, le contenu est rendu en RTL (lecture correcte)

**And** la génération du PDF respecte une contrainte de performance : < 3 secondes dans des conditions normales

### Story 2.2: Bouton “Ouvrir/Télécharger PDF” depuis `/convocation` + parcours 1 clic

As a étudiant,
I want accéder au PDF depuis la page convocation via un bouton clair,
So that je peux ouvrir/télécharger/imprimer ma convocation en 1 clic.

**Acceptance Criteria:**

**Given** je suis authentifié et je suis sur `/convocation`
**When** je vois la page
**Then** je vois un bouton/CTA explicite (FR/AR) du type “Ouvrir la convocation PDF” / “Télécharger PDF”

**Given** je clique sur ce bouton
**When** la requête est envoyée
**Then** le PDF est renvoyé au navigateur de façon exploitable (ouverture/preview ou téléchargement)
**And** le nom du fichier est explicite (ex: `convocation_rattrapage_<apogee>.pdf`)

**And** l’action fonctionne en FR/AR (le PDF suit la langue active)
**And** si la génération échoue, un message d’erreur clair est affiché (FR/AR)

### Story 2.3: (Post-MVP v1.1) QR code sur la convocation PDF

As a étudiant,
I want voir un QR code de vérification sur ma convocation PDF,
So that le document peut être vérifié rapidement.

**Acceptance Criteria:**

**Given** je génère mon PDF de convocation
**When** la fonctionnalité v1.1 est activée
**Then** le PDF contient un QR code visible et scannable
**And** le QR code encode une donnée/URL de vérification (à définir)
**And** le rendu reste compatible FR/AR (et RTL en AR)
**And** la présence du QR code ne dégrade pas la perf PDF au-delà de l’objectif (<3s) dans des conditions normales

## Epic 3: Recherche admin (consultation examens par Apogée)

Un administrateur peut rechercher un étudiant par Apogée et consulter ses examens (mêmes champs que côté étudiant).

### Story 3.1: Admin: saisir Apogée → consulter examens de l’étudiant

As a administrateur,
I want saisir le code Apogée d’un étudiant pour consulter ses examens de rattrapage,
So that je puisse aider rapidement un étudiant / vérifier ses informations.

**Acceptance Criteria:**

**Given** je suis sur l’interface admin de recherche
**When** je saisis un code Apogée et je valide
**Then** je vois les informations de l’étudiant :
- nom
- prénom
- code Apogée
- filière

**And** je vois la liste de ses examens avec au minimum :
- module
- date
- horaire
- salle/amphi
- site

**And** l’interface admin est distincte du parcours étudiant (route/vues séparées)

### Story 3.2: Admin: erreurs & cas limites (Apogée introuvable / aucun examen)

As a administrateur,
I want obtenir des retours clairs quand la recherche ne retourne rien,
So that je ne perds pas de temps et je peux guider l’étudiant.

**Acceptance Criteria:**

**Given** je suis sur l’interface admin de recherche
**When** je saisis un Apogée inexistant et je valide
**Then** je vois un message clair indiquant qu’aucun étudiant n’a été trouvé
**And** le formulaire conserve la valeur saisie pour corriger rapidement

**Given** je saisis un Apogée existant
**When** l’étudiant n’a aucun examen de rattrapage
**Then** je vois un message clair : “Aucun examen de rattrapage n’est disponible pour cet étudiant.”
**And** les infos de l’étudiant restent visibles

## Epic 4: Liste étudiants par date/salle + export PDF (opérations jour J)

Préparer le jour J en obtenant une liste des étudiants de rattrapage sous forme de tableau, groupée/filtrable par date et par salle/amphi, puis générer un PDF prêt à imprimer.

### Story 4.1: Liste étudiants par date/salle : filtres + tableau

As a administrateur (opérations),
I want consulter une liste des étudiants de rattrapage sous forme de tableau, filtrable/groupée par date et par salle/amphi,
So that je prépare les listes de présence et l’organisation du jour J.

**Acceptance Criteria:**

**Given** je suis sur la page “Liste étudiants” (interface opérations)
**When** la page se charge
**Then** je peux filtrer au minimum par :
- date (jour)
- salle/amphi

**And** le résultat s’affiche sous forme d’un tableau listant les étudiants correspondant au filtre

**And** le tableau est groupé (ou au minimum trié) par :
- date puis salle/amphi

**And** pour chaque ligne étudiant, le tableau affiche au minimum :
- identité (nom, prénom, code Apogée)
- détails d’examen nécessaires (module, date, horaire, salle/amphi, site)

### Story 4.2: Export multi-PDF (1 PDF par date + horaire + salle/amphi)

As a administrateur (opérations),
I want générer des PDFs séparés par salle/amphi et par horaire (et par date),
So that j’imprime une liste de présence distincte pour chaque salle et chaque créneau.

**Acceptance Criteria:**

**Given** je suis sur la page “Liste étudiants” (avec ou sans filtre de date)
**When** je clique sur “Exporter PDFs”
**Then** le système génère un PDF par groupe unique (date, horaire, salle/amphi)

**And** chaque PDF contient :
- un en-tête avec date, horaire, salle/amphi (et éventuellement site)
- un tableau avec au minimum : nom, prénom, code Apogée, module

**And** si un groupe (date, horaire, salle) n’a aucun étudiant, aucun PDF n’est généré pour ce groupe

**And** le résultat est téléchargeable sous forme de plusieurs PDFs (téléchargement PDF par PDF via liste de liens)

### Story 4.3: Qualité du PDF “liste présence” (mise en page opérationnelle + pagination + signature)

As a administrateur (opérations),
I want des PDFs lisibles et prêts à imprimer pour chaque (date, horaire, salle),
So that je peux les utiliser directement comme listes de présence.

**Acceptance Criteria:**

**Given** un PDF généré pour un groupe (date, horaire, salle/amphi)
**When** je l’ouvre
**Then** le PDF affiche clairement en en-tête :
- date
- horaire
- salle/amphi
- (optionnel) site

**And** le tableau est optimisé pour l’impression :
- colonnes stables (nom, prénom, Apogée, module)
- une colonne “Signature” (ou zone d’émargement) vide pour chaque étudiant
- lignes lisibles (espacement suffisant)
- pagination si la liste dépasse 1 page (le header se répète ou reste lisible)

## Epic 5: Import & gouvernance des données (opérations)

L’équipe peut alimenter le système via import SQL (étudiants + examens) et garantir la conservation indéfinie des données.

### Story 5.1: Import SQL (étudiants + examens) + validation minimale

As a administrateur / ops,
I want importer les données étudiants et examens via injection SQL contrôlée,
So that l’application soit alimentée rapidement sans interface admin lourde.

**Acceptance Criteria:**

**Given** un fichier SQL d’import pour `etudiants` et un fichier SQL d’import pour `examens`
**When** j’exécute l’import sur la base MySQL
**Then** les données sont insérées dans les tables correspondantes sans erreur

**And** l’import respecte les contraintes minimales suivantes :
- pour chaque `examens.cod_etu`, un `etudiants.cod_etu` correspondant existe (cohérence FK)
- les formats de `date_examen` (DATE) et `horaire` (TIME) sont valides
- la colonne `cod_etu` n’est jamais vide dans `examens`

**And** si l’import échoue, la cause est identifiable (erreur SQL exploitable / log)

### Story 5.2: Cohérence & anti-doublons import (FK, formats, règles minimales)

As a administrateur / ops,
I want détecter et éviter les incohérences/doublons lors des imports,
So that les listes (étudiant + PDF admin) restent fiables et exploitables.

**Acceptance Criteria:**

**Given** un import d’examens est exécuté
**When** une ligne d’examen viole une règle de cohérence (cod_etu manquant/inexistant, date/heure invalides)
**Then** l’import signale clairement les lignes problématiques (log exploitable)
**And** les données invalides ne sont pas insérées

**And** l’import empêche les doublons “évidents” selon une règle minimale :
- même `cod_etu` + `module` + `date_examen` + `horaire` + `salle` ⇒ un seul enregistrement

### Story 5.3: Conservation + sauvegardes (pas de suppression) + check-list période rattrapage

As a administrateur / ops,
I want garantir la conservation des données et une stratégie de sauvegarde/restore simple,
So that l’application reste fiable pendant toute la période de rattrapage (et après).

**Acceptance Criteria:**

**Given** les données d’examens sont importées en base
**When** l’application fonctionne en production
**Then** aucune fonctionnalité ne supprime automatiquement les données (FR19)

**And** une procédure de sauvegarde est définie et exécutable :
- export complet de la base (ex: dump MySQL)
- fréquence minimale (ex: quotidienne pendant la période rattrapages)

**And** une procédure de restauration est définie :
- restaurer la base depuis un dump
- vérifier que l’application redémarre et que les pages clés fonctionnent

**And** une check-list “période rattrapage” existe (opérationnelle) :
- backup OK
- import OK
- tests rapides (login + convocation + PDF + export listes) OK

## Epic 6: Refonte modèle de données — Table unique (flat)
Refondre le modèle de données en remplaçant les tables `etudiants` + `examens` par une table unique “flat” contenant, sur chaque ligne, les informations d’un étudiant + un examen (format proche Excel), puis adapter l’application, l’import et les tests.
**FRs covered:** FR1–FR22 (impact transversal; mêmes fonctionnalités, stockage différent)

**Implementation notes (NFR/UX/Arch):**
- 1 ligne = 1 examen, les champs étudiant sont dupliqués si l’étudiant a plusieurs examens.
- Conserver un `id` auto-increment pour l’identification technique.
- Ajouter des index utiles (au minimum `cod_etu`, `date`, `salle`).
- Prévoir une migration de données et la suppression des anciennes tables.

### Story 6.1: Schéma BDD table unique + migration de données + suppression des anciennes tables

As a développeur (équipe produit),
I want introduire une table unique contenant les données étudiant + examen (1 ligne = 1 examen) et migrer les données existantes,
So that l’application fonctionne avec un modèle “flat” et les anciennes tables peuvent être supprimées.

**Acceptance Criteria:**

**Given** une base contenant `etudiants` et `examens`
**When** j’exécute les migrations
**Then** une nouvelle table unique existe et contient au minimum les colonnes suivantes :
- `id` (PK auto-increment)
- `cod_etu`
- `lib_nom_pat_ind`
- `date_nai_ind`
- `lib_pr1_ind`
- `cod_elp`
- `filiere`
- `cod_tre`
- `cod_ext_gpe`
- `mod_groupe`
- `prof`
- `module`
- `salle`
- `site`
- `date`
- `heure`

**And** les données existantes (si présentes) sont migrées de `etudiants`/`examens` vers la table unique
**And** les tables `examens` et `etudiants` sont supprimées (dans cet ordre)

**And** des index existent au minimum sur :
- `cod_etu`
- `date`
- `salle`

### Story 6.2: Refactor application (auth, convocation, admin, ops) vers la table unique

As a développeur (équipe produit),
I want adapter les requêtes Eloquent/DB pour lire depuis la table unique,
So that le login, la convocation (page + PDF), la recherche admin et les exports ops continuent de fonctionner.

**Acceptance Criteria:**

**Given** l’application déployée avec la table unique
**When** un étudiant se connecte (Apogée + DOB)
**Then** l’authentification fonctionne en se basant sur la table unique

**And** la page convocation et le PDF affichent la liste des examens de l’étudiant (triée par date/heure)
**And** la recherche admin par Apogée fonctionne
**And** les pages ops (liste étudiants, export PDFs, présence PDF) fonctionnent sur les mêmes filtres (date/salle/horaire)

### Story 6.3: Import SQL vers table unique + validations + mise à jour des tests

As a administrateur / ops,
I want importer les données via SQL vers la table unique (flat) avec validations et reporting,
So that l’import reste reproductible et les fonctionnalités restent fiables.

**Acceptance Criteria:**

**Given** un fichier SQL d’import pour la table unique
**When** j’exécute la commande d’import
**Then** les données sont importées dans la table unique et les erreurs sont reportées dans un fichier texte exploitable

**And** les tests automatisés sont mis à jour et passent (import, convocation, ops exports)
