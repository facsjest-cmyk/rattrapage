---
stepsCompleted: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
inputDocuments: ['planning-artifacts/prd.md', 'planning-artifacts/architecture.md']
workflowType: 'ux-design'
project_name: 'Rattrapage'
user_name: 'Hamza'
date: '2026-02-26'
lastStep: 14
status: 'complete'
completedAt: '2026-02-26'
---

# UX Design Specification Rattrapage

**Author:** Hamza
**Date:** 2026-02-26

---

## Executive Summary

### Project Vision

**Rattrapage** vise à transformer un moment de stress (retrouver ses informations d'examen) en une expérience de soulagement immédiat. L'application élimine la fragmentation des sources d'information en offrant une interface ultra-simple : 2 champs, 1 clic, toutes les réponses.

### Target Users

**Persona principal :** Étudiant universitaire en session de rattrapage

| Persona | Contexte émotionnel | Besoin UX |
|---------|---------------------|-----------|
| **Sarah** | Calme, planification | Clarté, organisation, PDF téléchargeable |
| **Youssef** | Stressé, urgence | Rapidité, tolérance aux erreurs, feedback bienveillant |

**Caractéristiques communes :**
- Familiarité web standard
- Usage principal desktop (salles informatiques, PC personnel)
- Moment d'utilisation = période de stress (pré-examens)

### Key Design Challenges

1. **Réduire le stress, pas l'amplifier** — Chaque élément UI doit rassurer, pas inquiéter
2. **Tolérance aux erreurs** — Format de date incorrect = message clair, pas d'échec brutal
3. **Performance perçue** — Même si le serveur met 1.5s, l'utilisateur doit sentir que c'est instantané
4. **Bilingue FR/AR** — Interface complète en arabe avec support RTL natif

### Design Opportunities

1. **Moment "Ouf !"** — L'instant où les examens s'affichent doit visuellement communiquer "tu as trouvé ce que tu cherches"
2. **Convocation PDF officielle** — Design professionnel qui inspire confiance pour l'impression
3. **Minimalisme radical** — Aucune distraction, focus 100% sur l'information essentielle

## Core User Experience

### Defining Experience

**Flow unique linéaire :** Authentification → Examens → PDF

L'expérience Rattrapage se définit par son extrême simplicité : pas de navigation, pas de menu, pas de compte à créer. L'utilisateur arrive, saisit 2 informations, obtient tout ce dont il a besoin sur une seule page.

**Action critique :** Le moment où les examens s'affichent est le cœur de l'expérience. Tout le reste existe pour servir cet instant de soulagement.

### Platform Strategy

| Aspect | Décision |
|--------|----------|
| **Type** | Web application (MPA) |
| **Primary input** | Desktop (souris/clavier) |
| **Secondary** | Mobile tactile (fonctionnel) |
| **Offline** | Non supporté |
| **Langues** | Français + Arabe (RTL) |

### Effortless Interactions

1. **Saisie date flexible** — Accepter plusieurs formats, convertir automatiquement
2. **Validation inline** — Erreurs affichées immédiatement sans rechargement
3. **Résultats instantanés** — Transition fluide login → examens
4. **PDF en 1 clic** — Téléchargement direct, pas d'étape intermédiaire

### Critical Success Moments

| Moment | Ce qui doit se passer |
|--------|----------------------|
| **Premier essai auth** | Succès → confiance établie |
| **Examens affichés** | Soulagement visible → mission accomplie |
| **PDF téléchargé** | Document officiel → légitimité confirmée |

### Experience Principles

1. **Minimalisme radical** — Chaque élément doit justifier sa présence
2. **Feedback immédiat** — L'utilisateur ne doit jamais se demander "ça marche ?"
3. **Tolérance aux erreurs** — Guider, ne pas punir
4. **Une page, une mission** — Pas de navigation, pas de distraction

## Desired Emotional Response

### Primary Emotional Goals

**Émotion principale :** SOULAGEMENT — Transformer l'anxiété en calme

L'utilisateur arrive stressé et doit repartir soulagé. Chaque élément de design doit contribuer à cette transformation émotionnelle.

**Émotions secondaires :**
- **Confiance** — "Je peux faire confiance à cette application"
- **Clarté** — "Je comprends exactement ce que je dois faire"
- **Légitimité** — "C'est officiel, ça compte"

### Emotional Journey Mapping

| Phase | Émotion cible | Comment y arriver |
|-------|---------------|-------------------|
| **Découverte** | Clarté immédiate | Interface minimaliste, 2 champs visibles |
| **Authentification** | Confiance | Feedback instantané, pas de rechargement |
| **Résultats** | SOULAGEMENT | Affichage rapide, infos complètes visibles |
| **PDF** | Assurance | Document officiel, QR code, mise en page pro |
| **Erreur** | Pardon | Message bienveillant, guidance claire |

### Micro-Emotions

| Micro-émotion | Statut | Impact sur le design |
|---------------|--------|---------------------|
| **Confiance vs Doute** | Critique | Esthétique professionnelle, logo université |
| **Clarté vs Confusion** | Critique | Zéro jargon, labels explicites |
| **Légitimité vs Suspicion** | Haute | Format PDF officiel, en-tête université |
| **Pardon vs Culpabilité** | Haute | Erreurs = suggestions, pas de blâme |

### Design Implications

| Émotion cible | Approche UX |
|---------------|-------------|
| **Soulagement** | Transition fluide vers les résultats, contraste visuel "succès" |
| **Confiance** | Design sobre, couleurs institutionnelles, sans publicité |
| **Clarté** | Labels courts, placeholders explicatifs, validation inline |
| **Légitimité** | PDF avec en-tête officiel, QR code vérifiable |

### Emotional Design Principles

1. **Calmer, pas exciter** — Pas d'animations flashy, couleurs apaisantes
2. **Guider, pas punir** — Erreurs = opportunité d'aider
3. **Officiellité discrète** — Professionnel sans être froid
4. **Instant de soulagement visible** — Le moment "examens affichés" doit être visuellement célébré

## UX Pattern Analysis & Inspiration

### Inspiring Products Analysis

**Boarding Pass (Apple/Google Wallet)**
- **Force :** Information critique accessible instantanément
- **Pattern :** Carte unique avec hiérarchie visuelle claire
- **Leçon :** Le QR code et les infos essentielles dominent visuellement

**Doctolib**
- **Force :** Auth simple, confirmation rassurante
- **Pattern :** Feedback visuel fort après action réussie
- **Leçon :** L'utilisateur doit VOIR que ça a marché

**Pronote/ENT (Contre-exemple)**
- **Faiblesse :** Navigation complexe, UX administrative
- **Anti-pattern :** Menus profonds, jargon technique
- **Leçon :** Ne PAS reproduire l'UX institutionnelle classique

### Transferable UX Patterns

| Pattern | Source | Application |
|---------|--------|-------------|
| **Carte info critique** | Boarding pass | Chaque examen = 1 carte visuelle |
| **Hiérarchie surdimensionnée** | Boarding pass | Date + Salle en très grand |
| **Feedback succès animé** | Doctolib | Checkmark subtil après auth |
| **Document téléchargeable** | Billets événements | PDF = ticket officiel |
| **Zéro navigation** | Apps single-purpose | Pas de menu, flow linéaire |

### Anti-Patterns to Avoid

| Anti-pattern | Risque | Alternative Rattrapage |
|--------------|--------|------------------------|
| **Menu hamburger** | Clics inutiles | Aucun menu |
| **Multi-step forms** | Abandon | 1 page, 2 champs |
| **Captcha visible** | Frustration | Rate limiting serveur |
| **Jargon administratif** | Confusion | Labels simples |
| **Redirection login** | Perte contexte | Tout sur même page |

### Design Inspiration Strategy

**Adopter directement :**
- Pattern "boarding pass" pour l'affichage examens
- Hiérarchie visuelle surdimensionnée pour date/salle
- PDF comme "ticket officiel" téléchargeable

**Adapter :**
- Feedback Doctolib → version subtile (pas d'animation longue)
- QR code wallet → QR vérification convocation

**Éviter absolument :**
- Tout ce qui ressemble à Pronote/ENT (complexité administrative)
- Menus, sous-menus, breadcrumbs
- Processus multi-étapes

## Design System Foundation

### 1.1 Design System Choice

**Choix :** Système “themeable” basé sur Tailwind CSS, avec un mini design system aligné sur la charte **FSJEST** (design tokens + composants Blade réutilisables).

### Rationale for Selection

- **Équilibre vitesse / unicité :** Tailwind accélère l’implémentation tout en permettant d’appliquer précisément l’identité visuelle FSJEST.
- **Périmètre MVP réduit :** très peu de composants nécessaires → approche légère, maintenable.
- **Crédibilité institutionnelle :** cohérence visuelle + ton sobre renforcent la confiance.
- **Accessibilité sérieuse dès v1 :** focus states, contrastes, erreurs inline, navigation clavier imposés au niveau des composants.

### Implementation Approach

- Définir des **design tokens** dans la configuration Tailwind (couleurs FSJEST, typographie, radius, ombres).
- Créer un petit set de **composants Blade** (Button, Input, Alert, Card) utilisés partout.
- Standardiser les états : `default`, `hover`, `focus-visible`, `disabled`, `error`, `success`.
- Tester systématiquement clavier (Tab/Shift+Tab/Enter) sur le flow login → examens → PDF.

### Customization Strategy

- **Branding :** couleurs + logo FSJEST, style sobre “institutionnel”.
- **Pattern clé :** “boarding pass / carte info critique” pour la convocation (infos date/salle surdimensionnées).
- **i18n/RTL :** styles compatibles FR/AR, en conservant la même hiérarchie visuelle.

## 2. Core User Experience

### 2.1 Defining Experience

**Défining experience (phrase utilisateur) :**
“Je saisis mon code Apogée et ma date de naissance, et je trouve immédiatement mes salles et horaires de rattrapage, avec une convocation officielle (PDF) prête à enregistrer et imprimer.”

**Différenciation clé :**
Centraliser instantanément une information critique (salle + horaire) qui était auparavant dispersée entre Excel, WhatsApp et panneaux d’affichage.

### 2.2 User Mental Model

**Comment l’étudiant résout le problème aujourd’hui :**
- Cherche dans un fichier Excel (souvent via partage)
- Demande/scroll dans WhatsApp
- Vérifie un panneau d’affichage physique

**Conséquence UX :**
- Stress amplifié par la recherche multi-sources
- Incertitude (“est-ce la bonne info ? la dernière version ?”)

**Mental model attendu pour Rattrapage :**
- “Je connais mon identifiant (Apogée) → je dois pouvoir accéder directement à MES informations.”
- L’étudiant s’attend à une interaction simple type “portail / convocation”.

**Ce qui rend l’info ‘officielle’ :**
- Présence du logo FSJEST
- Mention administrative explicite
- QR code (pour vérification)

### 2.3 Success Criteria

**Critères de succès (fonctionnels et UX) :**
1. **Rapidité perçue** : affichage des examens en **0–1 seconde** (ou feeling équivalent via UI)
2. **Clarté immédiate** : salle + horaire visibles sans scroll excessif et sans jargon
3. **Confiance** : éléments institutionnels visibles (logo + mention admin) dès l’écran résultats
4. **PDF sans friction** : la convocation **s’ouvre dans le navigateur**, avec options naturelles d’**enregistrement** et **impression**
5. **Erreurs actionnables** : messages spécifiques qui expliquent quoi corriger

### 2.4 Novel UX Patterns

**Type de patterns :** majoritairement **établis** (formulaire simple + page résultat + téléchargement/preview PDF)

**Twist spécifique au produit :**
- Traitement “information critique” façon *boarding pass* :
  - hiérarchie visuelle très forte sur **date + heure + salle**
- Légitimité institutionnelle (logo + mention admin + QR) intégrée au parcours, pas seulement dans le PDF.

### 2.5 Experience Mechanics

**1) Initiation**
- Page d’accueil minimaliste : 2 champs (Apogée + date de naissance) + bouton primaire
- Microcopy orientée “rassurance” (ex: “Accédez à votre convocation en quelques secondes”)

**2) Interaction**
- Saisie Apogée (clavier)
- Saisie date (avec validation et tolérance)
- Soumission (Enter + clic)

**3) Feedback**
- **Succès :**
  - affichage immédiat de la page résultats
  - mise en avant salle/horaire
  - bloc “Convocation PDF” avec action claire
- **Erreur (spécifique) :**
  - “Aucun étudiant trouvé avec ce code Apogée.”
  - “Date de naissance incorrecte pour ce code Apogée.”
  - “Format de date invalide (JJ/MM/AAAA).”
  - Chaque erreur propose une action (“Vérifiez…”, “Réessayez…”)

**4) Completion**
- L’utilisateur considère la tâche terminée quand :
  - il a vu clairement salle + horaire
  - et/ou le PDF est ouvert dans le navigateur puis enregistré/imprimé
- Next obvious action : “Télécharger / Imprimer” (pas de navigation additionnelle)

## Visual Design Foundation

### Color System

**Contraintes charte :** bleu + blanc + noir.

**Palette de travail (à ajuster dès que les HEX officiels FSJEST sont disponibles) :**
- **Primary (Bleu)** : `#1D4ED8`
- **Primary (hover/dark)** : `#1E40AF`
- **Background** : `#FFFFFF`
- **Text (Noir)** : `#0F172A`
- **Muted text** : `#334155`
- **Border** : `#E2E8F0`
- **Surface** : `#F8FAFC`

**Couleurs sémantiques (neutres, sobres, orientées accessibilité) :**
- **Success** : `#16A34A`
- **Warning** : `#D97706`
- **Error** : `#DC2626`
- **Info** : `#2563EB`

**Règles d’usage :**
- Le **bleu** est réservé aux actions et états “officiels” (boutons primaires, liens, focus).
- Le contenu critique (date/heure/salle) se distingue par la **hiérarchie typographique**, pas par des couleurs agressives.
- Pas de fonds saturés sur de grandes surfaces (objectif : calmer / rassurer).

### Typography System

**Contraintes :** pas de police imposée, **même famille** pour FR/AR.

**Stratégie :** utiliser une famille sans-serif lisible avec couverture Latin + Arabic.

**Hiérarchie (approche Tailwind) :**
- **H1** : 24–30px, bold
- **H2** : 20–24px, semibold
- **H3** : 16–18px, semibold
- **Body** : 14–16px, regular
- **Meta** : 12–14px, medium

**Lisibilité :**
- Interlignage confortable (>= 1.4)
- Éviter les paragraphes longs : privilégier titres + blocs courts + tableau

### Spacing & Layout Foundation

**Direction :** aérée et rassurante.

**Base d’espacement :** grille 8px (Tailwind spacing standard).

**Layout desktop-first :**
- Conteneur centré avec largeur de lecture contrôlée
- Sections en “cards” sobres (surface claire + bordures légères)
- Page “examens” : **tableau** comme représentation principale

**Tableau examens (principes) :**
- Colonnes critiques : **date**, **heure**, **salle** (hiérarchie visuelle la plus forte)
- Largeur suffisante desktop, scroll horizontal évité
- Ligne zebra très légère ou séparateurs discrets
- CTA PDF visible sans détour (au-dessus ou à côté du tableau)

### Accessibility Considerations

**Objectif :** accessibilité sérieuse dès v1.

- Focus visible systématique (`:focus-visible`) sur tous les éléments interactifs
- Contrastes suffisants (texte sur blanc, boutons primaires lisibles)
- Erreurs inline avec texte explicite + association champ/erreur
- Navigation clavier complète (Tab/Shift+Tab/Enter)
- Taille de texte minimum 14px, zones cliquables confortables

## Design Direction Decision

### Design Directions Explored

Un showcase HTML a été généré pour comparer plusieurs directions de design (variations de densité, hiérarchie, poids visuel et “tone” institutionnel) sur l’écran **Résultats** (tableau examens + CTA PDF), incluant des états **loading** et **erreur spécifique** :

- Fichier : `_bmad-output/planning-artifacts/ux-design-directions.html`
- Directions : D1 à D6

### Chosen Direction

**Direction retenue : D2 — “Bleu accent + surface douce”**

Caractéristiques retenues :
- Design institutionnel, aéré, rassurant (surface claire + bordures légères)
- Hiérarchie claire sur les colonnes critiques (date / heure / salle)
- CTA principal “Ouvrir la convocation PDF” immédiatement visible
- Éléments d’officiel (logo + mention admin + QR) intégrés au layout

### Design Rationale

- Alignement avec l’objectif émotionnel principal : **SOULAGEMENT** (évite surcharge, privilégie clarté)
- Confiance renforcée (style sobre + marqueurs officiels)
- Lecture rapide “sous stress” : la salle et l’horaire sont trouvables sans effort
- Compatible avec la fondation visuelle (bleu/blanc/noir) et la stratégie Tailwind + tokens FSJEST

### Implementation Approach

- Implémenter le layout D2 dans Blade + Tailwind :
  - page résultats centrée, sections en cards sobres
  - tableau examens avec en-tête distinct et séparateurs discrets
  - CTA PDF au-dessus (et/ou à droite) du tableau
- Respecter l’accessibilité v1 :
  - `:focus-visible` sur CTA / liens / actions
  - états d’erreur spécifiques inline
  - navigation clavier complète

## User Journey Flows

### Journey 1 — Sarah (Happy Path) : Consultation + PDF

 **But utilisateur :** voir immédiatement ses examens (date/heure/salle), puis ouvrir la convocation PDF pour l’enregistrer/imprimer.

 ```mermaid
 flowchart TD
   A[Entrée: Accueil] --> B[Saisie Apogée + Date de naissance]
   B --> C{Validation format date}
   C -- invalide --> C1[Erreur inline: format JJ/MM/AAAA] --> B
   C -- valide --> D[Soumettre]
   D --> E{Identifiants corrects ?}
   E -- non --> E1[Erreur spécifique: Apogée introuvable OU DOB incorrecte] --> B
   E -- oui --> F[Page Résultats (D2)\nTableau examens + CTA PDF]
   F --> G[Utilisateur consulte date/heure/salle]
   G --> H[CTA: Ouvrir la convocation PDF]
   H --> I[PDF s’ouvre dans le navigateur]
   I --> J[Enregistrer / Imprimer]
   J --> K[Fin: Mission accomplie]
 ```

 **Points UX clés :**
 - Mettre **date/heure/salle** en hiérarchie maximale dans le tableau.
 - CTA PDF visible au-dessus/à côté du tableau.
 - Marqueurs officiels visibles (logo + mention admin + QR).

 ### Journey 2 — Youssef (Stress/Error Path) : Urgence + correction

 **But utilisateur :** trouver sa salle vite, malgré une erreur de saisie initiale.

 ```mermaid
 flowchart TD
   A[Entrée: Accueil (stress)] --> B[Saisie rapide Apogée + DOB]
   B --> C{Validation format DOB}
   C -- invalide --> C1[Erreur inline spécifique:\n"Format de date invalide (JJ/MM/AAAA)"\n+ exemple] --> B
   C -- valide --> D[Soumettre]
   D --> E{Identifiants corrects ?}
   E -- Apogée introuvable --> E1[Erreur: "Aucun étudiant trouvé avec ce code Apogée."] --> B
   E -- DOB incorrecte --> E2[Erreur: "Date de naissance incorrecte pour ce code Apogée."] --> B
   E -- oui --> F[Page Résultats (D2)]
   F --> G[Lecture immédiate salle + heure]
   G --> H[Option: Ouvrir PDF (si besoin)]
   H --> I[PDF navigateur]
   I --> J[Fin: info critique récupérée]
 ```

 **Points UX clés :**
 - Les erreurs doivent être **spécifiques** et **actionnables** (sans culpabiliser).
 - Le système doit “ressortir” l’info critique très vite (tableau lisible, colonnes critiques).

 ### Journey Patterns (communs)

 - **Pattern 1 — Validation inline**
   - Format date invalid → message immédiat + guidance.
 - **Pattern 2 — Erreurs spécifiques**
   - Distinguer : Apogée introuvable vs DOB incorrecte.
 - **Pattern 3 — “Critical info first”**
   - Résultats : date/heure/salle dominent la hiérarchie.
 - **Pattern 4 — PDF sans friction**
   - CTA clair → PDF s’ouvre navigateur → impression/enregistrement.

 ### Flow Optimization Principles

 - Minimiser le temps jusqu’à la valeur : Login → Résultats en perception **0–1s**
 - Réduire la charge cognitive : une page de résultats, pas de navigation
 - Conserver confiance : marqueurs officiels visibles (logo + mention admin + QR)
 - Recovery rapide : “corriger et réessayer” sans blocage

 ## Component Strategy

 ### Design System Components

 **Fondation :** Tailwind + design tokens FSJEST + composants Blade réutilisables.

 **Composants foundation (réutilisables MVP) :**
 - **Button** (primary / ghost / disabled)
 - **Input** (label + placeholder + aide + erreur inline)
 - **Alert** (info/success/warning/error)
 - **Card** (surface douce D2, bordure légère)
 - **Badge/Pill** (statuts: “Validé par la scolarité”)
 - **Table** (header distinct, séparateurs discrets, hiérarchie)
 - **Link** (état hover + focus-visible)
 - **Divider**
 - **Skeleton** (état loading, perception 0–1s)

 ### Custom Components

 ### OfficialStamp
 **Purpose:** renforcer la légitimité institutionnelle (confiance).
 **Usage:** page résultats + PDF.
 **Anatomy:** logo FSJEST + “Service scolarité” + mention administrative.
 **States:** default uniquement.
 **Variants:** compact (header) / complet (zone officielle).
 **Accessibility:** texte lisible, pas uniquement iconographique.
 **Content Guidelines:** wording constant, sobre.
 **Interaction Behavior:** non interactif.

 ### QrCodeBlock
 **Purpose:** fournir un QR de vérification “officiel”.
 **Usage:** résultats (optionnel) + PDF (prioritaire).
 **Anatomy:** QR + label + (optionnel) code/URL courte.
 **States:** default.
 **Variants:** small (résultats) / medium (PDF).
 **Accessibility:** label textuel “QR de vérification”, contraste suffisant.
 **Interaction Behavior:** non interactif (ou lien vers vérification si prévu plus tard).

 ### ExamCriticalCell
 **Purpose:** rendre la lecture “salle + heure + date” instantanée (stress).
 **Usage:** colonnes critiques du tableau examens.
 **Anatomy:** valeur principale (bold) + meta (muted).
 **States:** default.
 **Variants:** date / heure / salle.
 **Accessibility:** taille min 14px, contraste, pas uniquement couleur.

 ### PdfActionsBar
 **Purpose:** accès immédiat au PDF (sans friction).
 **Usage:** au-dessus/à côté du tableau.
 **Anatomy:** bouton primaire “Ouvrir la convocation PDF” + secondaire “Imprimer”.
 **States:** default / hover / focus-visible / disabled (si PDF indisponible).
 **Accessibility:** focus-visible, libellés explicites, ordre clavier.

 ### LocaleSwitcher
 **Purpose:** switch FR/AR dès v1.
 **Usage:** topbar.
 **States:** default / focus-visible.
 **Accessibility:** `aria-label`, support clavier, RTL appliqué en arabe.

 ### ErrorMessage (spécifique)
 **Purpose:** guider sans culpabiliser, réduire stress.
 **Usage:** sous champ / zone formulaire.
 **States:** error.
 **Variants:** format date / Apogée introuvable / DOB incorrecte.
 **Accessibility:** associer erreur au champ, message actionnable.

 ### Component Implementation Strategy

 - Implémenter les composants en Blade en s’appuyant sur tokens Tailwind (couleurs, radius, spacing).
 - Centraliser les variantes via props simples (ex: `variant=primary|ghost`, `state=error`).
 - Standardiser les comportements :
   - focus-visible systématique
   - erreurs inline actionnables
   - hiérarchie critique dans le tableau
 - Assurer compatibilité FR/AR (RTL) au niveau layout et composants.

 ### Implementation Roadmap

 **Phase 1 — Critique (login + résultats + PDF) :**
 - Input, Button, ErrorMessage, Alert
 - Table + ExamCriticalCell
 - PdfActionsBar
 - Skeleton (loading)

 **Phase 2 — Confiance & cohérence :**
 - Card, Badge/Pill, OfficialStamp
 - LocaleSwitcher

 **Phase 3 — Raffinements :**
 - QrCodeBlock sur résultats (si retenu), micro-variantes, polish accessibilité

 ## UX Consistency Patterns

 ### Button Hierarchy

 **Règle principale :** une page = une action primaire.

 - **Primary button**
   - Usage : action principale de la page (ex: “Voir ma convocation”, “Ouvrir la convocation PDF”)
   - Style : bleu (charte), contraste fort, taille suffisante
   - Position : au-dessus/à côté du contenu principal (sans scroll)
 - **Secondary / Ghost**
   - Usage : actions de support (ex: “Imprimer”, “Retour”, “Réessayer”)
   - Ne doit jamais concurrencer visuellement le primary
 - **Disabled**
   - Utilisé uniquement si une action est impossible (ex: PDF indisponible)
   - Doit rester lisible + expliquer pourquoi via microcopy ou alert

 **Accessibilité :**
 - Focus visible obligatoire (`:focus-visible`)
 - Libellés explicites (verbe + objet)
 - Ordre clavier logique (primary accessible rapidement)

 ### Feedback Patterns

 **Succès**
 - Après authentification réussie : transition directe vers Résultats (pas de “page succès”)
 - Optionnel : micro-indicateur discret (“Informations chargées”)

 **Erreur (spécifique et actionnable)**
 - Toujours proche du champ / du formulaire
 - Messages autorisés (exemples) :
   - “Format de date invalide (JJ/MM/AAAA).”
   - “Aucun étudiant trouvé avec ce code Apogée.”
   - “Date de naissance incorrecte pour ce code Apogée.”
 - Ton : neutre, sans blâme + suggestion de correction

 **Loading (perception 0–1s)**
 - Skeleton discret (tableau + CTA)
 - Pas de spinner bloquant plein écran
 - Si >1s : afficher une ligne “Chargement…” (sans alarmer)

 ### Form Patterns

 **Structure**
 - 2 champs maximum : Apogée + Date de naissance
 - Labels visibles (pas uniquement placeholder)
 - Aide courte sous champ (format attendu)

 **Validation**
 - Validation format date côté client (si possible) + côté serveur (obligatoire)
 - Conserver les valeurs saisies lors d’une erreur (ne pas vider le formulaire)
 - Mettre le focus sur le premier champ en erreur

 **Soumission**
 - Entrée clavier (Enter) supportée
 - Bouton primary toujours visible

 ### Navigation Patterns

 **Principe :** “zéro navigation” (MVP).
 - Pas de menu hamburger
 - Pages minimales :
   1) Accueil/Login
   2) Résultats (tableau + actions PDF)
   3) PDF (ou ouverture navigateur)

 **Retour**
 - Bouton “Retour” uniquement si nécessaire (ex: depuis erreur globale)
 - Éviter les chemins complexes (pas de breadcrumbs)

 ### Additional Patterns

 **Empty state (0 examens)**
 - Message clair : “Aucun examen de rattrapage n’est disponible pour le moment.”
 - CTA : “Réessayer plus tard” + info scolarité si besoin

 **Session/expira**
 - Si session expirée : rediriger vers login avec message “Votre session a expiré. Veuillez vous reconnecter.”

 **Bilingue FR/AR**
 - Switch accessible (clavier)
 - RTL en arabe, mais hiérarchie identique

 ## Responsive Design & Accessibility

 ### Responsive Strategy

 **Desktop (prioritaire)**
 - Layout centré, largeur maîtrisée (lecture confortable)
 - Résultats en **tableau** avec hiérarchie forte sur date/heure/salle
 - CTA PDF visible sans scroll
 - Espace disponible utilisé pour clarté (pas pour ajouter de navigation)

 **Tablet**
 - Conserver le tableau si lisible ; sinon basculer en tableau scrollable horizontal léger ou “table → cartes”
 - CTA toujours visible en haut
 - Interactions touch OK (targets suffisants)

 **Mobile (compatibilité basique)**
 - Objectif : consulter l’information critique sans blocage
 - Stratégie :
   - soit tableau avec colonnes réduites + scroll horizontal contrôlé
   - soit bascule en cartes (date/heure/salle en premier) si le tableau devient illisible
 - Pas de menu hamburger (MVP) : navigation minimale

 ### Breakpoint Strategy

 **Approche :** desktop-first avec breakpoints standards Tailwind.
 - `sm` ~ 640px : ajustements mineurs (padding, tailles)
 - `md` ~ 768px : tablette
 - `lg` ~ 1024px : desktop (layout de référence)

 Règle : la version desktop est la référence (D2), la version mobile reste fonctionnelle.

 ### Accessibility Strategy

 **Cible :** WCAG **AA** (recommandé) dès v1.

 Exigences clés :
 - Contraste texte normal >= 4.5:1
 - Navigation clavier complète (Tab/Shift+Tab/Enter)
 - `:focus-visible` fortement visible sur tous éléments interactifs
 - Champs de formulaire :
   - labels explicites
   - erreurs inline associées au champ
 - Touch targets min 44x44px (mobile/tablet)
 - Structure HTML sémantique (titles, tables avec `thead/th`, etc.)
 - Support RTL en arabe tout en gardant la même hiérarchie d’information

 ### Testing Strategy

 **Responsive**
 - Vérifier sur Chrome/Firefox/Edge (desktop)
 - Tester au minimum 1 iPhone + 1 Android (ou simulateur)
 - Tester la lisibilité du tableau (et fallback mobile si besoin)

 **Accessibilité**
 - Clavier-only sur le flow : login → résultats → ouvrir PDF
 - Vérifier focus visible partout
 - Vérifier erreurs spécifiques et lecture (structure + ordre)
 - Vérifier RTL en arabe (alignements, ordre de lecture, tableaux)

 ### Implementation Guidelines

 **Responsive**
 - Utiliser les breakpoints Tailwind (pas de pixels “magiques” dispersés)
 - Gérer le tableau :
   - éviter la casse de layout
   - autoriser scroll horizontal si nécessaire, avec indices visuels discrets
 - Garder CTA PDF accessible en haut de page

 **Accessibilité**
 - HTML sémantique (table correcte, labels, boutons)
 - ARIA seulement si nécessaire (ex: switch langue)
 - Ne pas supprimer l’outline ; utiliser `focus-visible`
 - Erreurs : texte clair + action (“Vérifiez…”, “Réessayez…”)
