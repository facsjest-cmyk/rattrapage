---
stepsCompleted: ['step-01-init', 'step-02-discovery', 'step-02b-vision', 'step-02c-executive-summary', 'step-03-success', 'step-04-journeys', 'step-05-domain', 'step-06-innovation', 'step-07-project-type', 'step-08-scoping', 'step-09-functional', 'step-10-nonfunctional', 'step-11-polish']
inputDocuments: ['brainstorming/brainstorming-session-2026-02-25.md']
workflowType: 'prd'
documentCounts:
  briefs: 0
  research: 0
  brainstorming: 1
  projectDocs: 0
classification:
  projectType: web_app
  domain: edtech
  complexity: medium
  projectContext: greenfield
---

# Product Requirements Document - Rattrapage

**Author:** Hamza
**Date:** 2026-02-26

## Executive Summary

**Rattrapage** est une application web destinée aux étudiants universitaires pour consulter et imprimer leurs convocations d'examens de rattrapage. L'application résout un problème critique : le stress et la perte de temps causés par des informations d'examens fragmentées entre fichiers Excel, affichages physiques et groupes WhatsApp.

L'étudiant s'authentifie avec son code Apogée et sa date de naissance, puis accède instantanément à tous ses examens (module, date, horaire, salle, site) sur une page unique. Il peut générer une convocation PDF officielle avec QR code de vérification.

**Utilisateurs cibles :** Étudiants universitaires en session de rattrapage.

**Problème résolu :** Centralisation des informations d'examens dispersées, réduisant le stress et éliminant les erreurs de consultation.

**Périmètre MVP :** Le MVP se concentre exclusivement sur le rôle étudiant (consultation et impression de convocation). Les rôles administrateur et professeur (gestion des données, statistiques, notifications) sont prévus pour une phase ultérieure.

### What Makes This Special

- **Accès immédiat** — Une authentification, toutes les informations sur une seule page
- **Source unique de vérité** — Fin de la fragmentation entre Excel, affichages et WhatsApp
- **Zéro friction** — Pas de navigation complexe, pas de recherche
- **QR Code de vérification** — Validation rapide à l'entrée en salle d'examen

**Insight clé :** Le problème n'est pas technique (les données existent dans la base universitaire), mais un problème d'accessibilité. L'information est disponible mais inaccessible rapidement au moment où les étudiants sont sous pression.

## Project Classification

| Attribut | Valeur |
|----------|--------|
| **Type de projet** | Web Application (Laravel + Blade + Tailwind) |
| **Domaine** | EdTech (éducation universitaire) |
| **Complexité** | Medium (données étudiants sensibles, périmètre MVP limité) |
| **Contexte** | Greenfield (nouveau projet) |

## Success Criteria

### User Success

- **Mission accomplie** — L'étudiant a vu ses informations d'examens à l'écran ET téléchargé son PDF de convocation
- **Parcours rapide** — Moins de 20 secondes entre la connexion et le téléchargement du PDF
- **Zéro friction** — Authentification en 2 champs (Apogée + date naissance), résultat immédiat

### Business Success

- **Adoption cible** — 100% des étudiants en rattrapage utilisent l'application
- **Remplacement total** — L'app devient la source unique d'information, remplaçant Excel/affichages/WhatsApp
- **Satisfaction** — Zéro plainte liée à des informations manquantes ou erronées

### Technical Success

- **Capacité** — Support de 10 000 utilisateurs simultanés
- **Disponibilité** — 100% uptime pendant la période de rattrapages
- **Performance** — Temps de réponse <2 secondes pour l'affichage des examens

### Measurable Outcomes

| Métrique | Cible | Mesure |
|----------|-------|--------|
| Temps connexion → PDF | <20 sec | Logs applicatifs |
| Utilisateurs simultanés | 10 000 | Monitoring serveur |
| Taux d'adoption | 100% | Nb connexions uniques / Nb étudiants inscrits |
| Disponibilité | 100% | Monitoring uptime |

## User Journeys

### Journey 1: Sarah — Consultation Sereine (Happy Path)

**Persona :** Sarah, 21 ans, étudiante en L3 Informatique. Elle a raté 2 modules au semestre dernier et doit passer les rattrapages.

**Contexte :** Une semaine avant les rattrapages, Sarah veut s'organiser. Elle est sur son PC, calme, et veut savoir quand et où se présenter.

**Le Parcours :**

1. **Ouverture** — Sarah ouvre l'application depuis son navigateur PC. Elle voit un formulaire simple : code Apogée et date de naissance.

2. **Authentification** — Elle entre son code `21045678` et sa date `15/03/2005`. Clic sur "Voir ma convocation".

3. **Découverte** — En moins de 2 secondes, elle voit la liste de ses 2 examens :
   - Algorithmique avancée — 12/03 à 09h00 — Amphi A — Site Principal
   - Bases de données — 14/03 à 14h00 — Salle 201 — Site Annexe

4. **Soulagement** — Sarah voit clairement ses infos. Pas besoin de chercher dans des fichiers Excel ou des groupes WhatsApp.

5. **Action** — Elle clique "Télécharger PDF". Une convocation officielle avec QR code se génère. Elle l'enregistre et l'imprime.

**Résolution :** Sarah a ses infos en moins de 20 secondes. Elle peut planifier ses révisions sereinement.

---

### Journey 2: Youssef — Veille d'Examen Stressé (Stress Path)

**Persona :** Youssef, 20 ans, étudiant en L2 Droit. Il a oublié de vérifier sa convocation et c'est la veille de son examen.

**Contexte :** 22h, Youssef se rappelle qu'il a un rattrapage demain mais ne sait plus la salle. Stress maximum.

**Le Parcours :**

1. **Urgence** — Youssef ouvre l'app sur son PC, stressé. Il doit trouver sa salle rapidement.

2. **Erreur** — Dans sa précipitation, il tape mal sa date de naissance : `15/30/2006` (mois invalide).

3. **Feedback clair** — L'application affiche immédiatement : "Date de naissance invalide. Format attendu : JJ/MM/AAAA"

4. **Correction** — Youssef corrige : `15/03/2006`. Clic.

5. **Soulagement** — Il voit son examen : Droit civil — 13/03 à 08h00 — Amphi B — Site Principal

6. **Action rapide** — Il télécharge le PDF, note la salle, et peut dormir (un peu) plus serein.

**Résolution :** Malgré le stress et l'erreur, Youssef trouve son info en moins de 30 secondes.

---

### Journey Requirements Summary

| Journey | Capacités Révélées |
|---------|-------------------|
| **Sarah (Happy Path)** | Auth simple, affichage liste examens, génération PDF, QR code |
| **Youssef (Stress/Error)** | Validation inputs, messages d'erreur clairs, feedback immédiat |

**Capacités MVP identifiées :**
- Authentification 2 champs avec validation
- Affichage tableau examens (module, prof, date, horaire, salle, site)
- Génération PDF convocation avec QR code
- Messages d'erreur explicites et bienveillants

## Domain-Specific Requirements

### Conformité & Réglementation

- **Pas de contraintes spécifiques** — Pas de règles universitaires internes concernant le code Apogée et la date de naissance
- **Pas d'exigences d'accessibilité formelles** — RGAA/WCAG non requis pour le MVP

### Contraintes Techniques

- **Hébergement** — Aucune contrainte sur le lieu de stockage des données
- **Conservation des données** — Les données d'examens doivent être conservées **indéfiniment** (pas de suppression)

### Risques & Mitigations

| Risque | Mitigation |
|--------|------------|
| Perte de données | Sauvegardes régulières de la base MySQL |
| Accès non autorisé | Authentification par Apogée + date naissance (connaissance utilisateur) |

## Web Application Specific Requirements

### Project-Type Overview

Application web multi-pages (MPA) construite avec Laravel Blade, optimisée pour une utilisation desktop dans un contexte universitaire interne.

### Technical Architecture Considerations

| Aspect | Décision | Justification |
|--------|----------|---------------|
| **Architecture** | MPA (Laravel Blade) | Simplicité, rendu serveur, pas de complexité SPA |
| **SEO** | Non requis | Application interne université |
| **Temps réel** | Non requis | Données mises à jour via import Excel |
| **State management** | Sessions Laravel | Pas besoin de state client complexe |

### Browser Support

| Navigateur | Support |
|------------|--------|
| Chrome | Dernières 2 versions |
| Firefox | Dernières 2 versions |
| Safari | Dernières 2 versions |
| Edge | Dernières 2 versions |

*Pas de support IE11 ni navigateurs obsolètes.*

### Responsive Design

- **Approche** : Desktop-first
- **Desktop** : Expérience optimale, design principal
- **Mobile** : Compatibilité basique fonctionnelle (consultation possible, pas d'optimisation poussée)
- **Breakpoints** : Standard Tailwind (sm: 640px, md: 768px, lg: 1024px)

### Implementation Considerations

- **Framework** : Laravel 10+ avec Blade templating
- **CSS** : Tailwind CSS (utility-first)
- **PDF** : barryvdh/laravel-dompdf
- **QR Code** : simplesoftwareio/simple-qrcode
- **Base de données** : MySQL 8.0+
- **Serveur** : Apache/Nginx sur serveur université

## Project Scoping & Phased Development

### MVP Strategy & Philosophy

**Approche MVP :** Problem-solving MVP — Résoudre le problème de fragmentation des informations d'examens avec la solution la plus simple possible.

**Ressources :** Développeur solo, 2 semaines

**Import données :** Injection SQL directe (pas d'interface admin pour le MVP)

### MVP Feature Set (Phase 1) — 2 semaines

**Core User Journeys Supportés :**
- ✅ Sarah (Happy Path) — Consultation sereine
- ✅ Youssef (Stress Path) — Consultation urgente avec erreur

**Must-Have Capabilities :**
- Authentification Apogée + date de naissance
- Affichage tableau des examens (module, prof, date, horaire, salle, site)
- Génération PDF convocation (format officiel)
- Messages d'erreur clairs
- Interface desktop-first avec compatibilité mobile basique

**Déféré à v1.1 (si délai serré) :**
- QR Code sur la convocation PDF

### Post-MVP Features

**Phase 2 — v1.1 (Post-lancement) :**
- QR Code de vérification sur convocation
- Interface administrateur pour import données
- Statistiques de consultation

**Phase 3 — Vision (Future) :**
- Notifications email/SMS avant examens
- Compte à rebours personnalisé
- Tableau de bord professeur
- Intégration directe avec le système Apogée

### Risk Mitigation Strategy

| Type de Risque | Risque | Mitigation |
|----------------|--------|------------|
| **Technique** | Import Excel → MySQL | Injection SQL directe, format de données validé avant import |
| **Délai** | 2 semaines serrées | QR Code reportable en v1.1 |
| **Ressource** | Développeur solo | Stack simple (Laravel), pas de complexité SPA |

## Functional Requirements

### Authentification Étudiant

- **FR1:** L'étudiant peut s'authentifier avec son code Apogée et sa date de naissance
- **FR2:** L'étudiant peut voir un message d'erreur explicite si ses identifiants sont incorrects
- **FR3:** L'étudiant peut voir un message d'erreur si le format de date est invalide
- **FR4:** L'étudiant peut réessayer de se connecter après une erreur (pas de blocage)

### Consultation Examens

- **FR5:** L'étudiant authentifié peut voir la liste de tous ses examens de rattrapage
- **FR6:** L'étudiant peut voir pour chaque examen : module, professeur, semestre, groupe, date, horaire, salle, site
- **FR7:** L'étudiant peut voir ses informations personnelles (nom, prénom, code Apogée, filière)

### Génération Convocation

- **FR8:** L'étudiant peut télécharger sa convocation au format PDF
- **FR9:** L'étudiant peut voir sur la convocation PDF ses informations personnelles et la liste de ses examens
- **FR10:** L'étudiant peut voir sur la convocation PDF un QR code de vérification *(v1.1 si délai serré)*

### Interface Utilisateur

- **FR11:** L'étudiant peut accéder à l'application depuis un navigateur desktop
- **FR12:** L'étudiant peut accéder à l'application depuis un navigateur mobile (fonctionnalité basique)
- **FR13:** L'étudiant peut voir un formulaire de connexion simple avec 2 champs

### Administration — Recherche Étudiant

- **FR14:** L'administrateur peut accéder à une interface de recherche par code Apogée
- **FR15:** L'administrateur peut saisir le code Apogée d'un étudiant pour consulter tous ses examens de rattrapage
- **FR16:** L'administrateur peut voir les mêmes informations que l'étudiant (module, date, horaire, salle, site)

### Gestion des Données (Backend)

- **FR17:** L'administrateur peut importer les données étudiants via injection SQL directe
- **FR18:** L'administrateur peut importer les données examens via injection SQL directe
- **FR19:** Le système conserve les données indéfiniment (pas de suppression automatique)

## Non-Functional Requirements

### Performance

| Métrique | Cible | Condition |
|----------|-------|-----------|
| **TTFB** | <500ms | Sous charge normale |
| **Affichage examens** | <2s | Après authentification |
| **Génération PDF** | <3s | Convocation complète |
| **Flow complet** | <20s | Connexion → PDF téléchargé |

### Scalabilité

| Métrique | Cible | Condition |
|----------|-------|-----------|
| **Utilisateurs simultanés** | 10 000 | Sans dégradation >10% |
| **Pics de charge** | Période pré-examen | Dimensionnement serveur adapté |
| **Base de données** | Support volume étudiants université | ~50 000 enregistrements max |

### Fiabilité

| Métrique | Cible | Condition |
|----------|-------|-----------|
| **Disponibilité** | 100% | Pendant période rattrapages (2 semaines) |
| **Récupération** | <1h | En cas de panne serveur |
| **Sauvegardes** | Quotidiennes | Base de données MySQL |

### Sécurité

| Exigence | Description |
|----------|-------------|
| **Authentification** | Code Apogée + date naissance (vérification côté serveur) |
| **Sessions** | Expiration après inactivité (30 min) |
| **HTTPS** | Obligatoire en production |
| **Injection SQL** | Protection via Eloquent ORM / requêtes préparées |
