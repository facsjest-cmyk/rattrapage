<?php

return [
    'app_name' => 'Rattrapage',

    'locale' => [
        'fr' => 'FR',
        'ar' => 'AR',
    ],

    'login' => [
        'title' => 'Connexion',
        'heading' => 'Connexion',
        'fields' => [
            'code' => 'Code Apogée',
            'dob' => 'Date de naissance',
        ],
        'help' => [
            'dob_format' => 'Format attendu : JJ/MM/AAAA',
        ],
        'placeholders' => [
            'dob' => 'JJ/MM/AAAA',
        ],
        'actions' => [
            'submit' => 'Continuer',
        ],
        'errors' => [
            'code_required' => 'Veuillez saisir votre code Apogée.',
            'dob_required' => 'Veuillez saisir votre date de naissance.',
            'dob_format' => 'Format invalide. Utilisez JJ/MM/AAAA (ex: 07/03/2000).',
            'dob_invalid_format' => 'Format invalide. Utilisez JJ/MM/AAAA (ex: 07/03/2000).',
            'apogee_not_found' => 'Aucun étudiant trouvé avec ce code Apogée.',
            'dob_mismatch' => 'Date de naissance incorrecte pour ce code Apogée.',
            'throttle' => 'Trop de tentatives. Réessayez plus tard.',
        ],
        'status' => [
            'validated' => 'Format validé.',
        ],
    ],

    'admin' => [
        'search' => [
            'title' => 'Admin - Recherche',
            'heading' => 'Recherche étudiant',
            'fields' => [
                'apogee' => 'Code Apogée',
            ],
            'actions' => [
                'submit' => 'Rechercher',
            ],
            'sections' => [
                'student' => 'Étudiant',
                'examens' => 'Examens de rattrapage',
            ],
            'not_found' => 'Aucun étudiant trouvé avec ce code Apogée.',
            'no_examens' => 'Aucun examen de rattrapage disponible pour cet étudiant.',
        ],
    ],

    'ops' => [
        'list' => [
            'title' => 'Opérations - Liste étudiants',
            'heading' => 'Liste étudiants',
            'filters' => [
                'date' => 'Date',
                'salle' => 'Salle/Amphi',
                'all' => 'Tous',
            ],
            'actions' => [
                'apply' => 'Appliquer',
                'export_pdfs' => 'Exporter PDFs',
            ],
            'table' => [
                'title' => 'Résultats',
                'date' => 'Date',
                'salle' => 'Salle/Amphi',
                'horaire' => 'Horaire',
                'nom' => 'Nom',
                'prenom' => 'Prénom',
                'apogee' => 'Code Apogée',
                'module' => 'Module',
                'site' => 'Site',
            ],
            'empty_state' => 'Aucun étudiant ne correspond aux filtres sélectionnés.',
        ],

        'export' => [
            'title' => 'Opérations - Export PDFs',
            'heading' => 'Exporter PDFs',
            'back' => 'Retour à la liste',
            'empty_state' => 'Aucun PDF à générer pour les filtres sélectionnés.',
            'link_label' => 'Télécharger PDF — :date / :horaire / :salle',
        ],

        'presence_pdf' => [
            'title' => 'Liste de présence',
            'heading' => 'Liste de présence',
            'meta' => 'Date : :date — Horaire : :horaire — Salle/Amphi : :salle',
            'table' => [
                'nom' => 'Nom',
                'prenom' => 'Prénom',
                'apogee' => 'Code Apogée',
                'module' => 'Module',
                'signature' => 'Signature',
            ],
        ],
    ],

    'convocation' => [
        'title' => 'Convocation',
        'heading' => 'Convocation',
        'sections' => [
            'student' => 'Informations personnelles',
            'examens' => 'Examens de rattrapage',
        ],
        'fields' => [
            'nom' => 'Nom',
            'prenom' => 'Prénom',
            'code_apogee' => 'Code Apogée',
            'filiere' => 'Filière',
        ],
        'table' => [
            'module' => 'Module',
            'professeur' => 'Professeur',
            'semestre' => 'Semestre',
            'groupe' => 'Groupe',
            'date' => 'Date',
            'horaire' => 'Horaire',
            'salle' => 'Salle/Amphi',
            'site' => 'Site',
        ],
        'empty_state' => 'Aucun examen de rattrapage n’est disponible pour le moment.',
        'pdf' => [
            'helper' => 'Convocation PDF officielle',
            'open' => 'Ouvrir la convocation PDF',
            'download' => 'Télécharger PDF',
            'error' => 'Impossible de générer le PDF pour le moment. Veuillez réessayer.',
        ],
    ],

    'auth' => [
        'must_login' => 'Veuillez vous connecter pour accéder à cette page.',
        'session_expired' => 'Votre session a expiré. Veuillez vous reconnecter.',
    ],

    'pdf_smoke' => [
        'title' => 'PDF (smoke)',
        'heading' => 'PDF (smoke)',
        'body' => 'OK',
    ],
];
