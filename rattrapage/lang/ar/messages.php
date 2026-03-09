<?php

return [
    'app_name' => 'الاستدراك',

    'locale' => [
        'fr' => 'FR',
        'ar' => 'AR',
    ],

    'login' => [
        'title' => 'تسجيل الدخول',
        'heading' => 'تسجيل الدخول',
        'fields' => [
            'code' => 'رمز أبوجي',
            'dob' => 'تاريخ الازدياد',
        ],
        'help' => [
            'dob_format' => 'الصيغة المطلوبة: يوم/شهر/سنة',
        ],
        'placeholders' => [
            'dob' => 'JJ/MM/AAAA',
        ],
        'actions' => [
            'submit' => 'متابعة',
        ],
        'errors' => [
            'code_required' => 'المرجو إدخال رمز أبوجي.',
            'dob_required' => 'المرجو إدخال تاريخ الازدياد.',
            'dob_format' => 'صيغة غير صحيحة. استعمل JJ/MM/AAAA (مثال: 07/03/2000).',
            'dob_invalid_format' => 'صيغة غير صحيحة. استعمل JJ/MM/AAAA (مثال: 07/03/2000).',
            'apogee_not_found' => 'لا يوجد طالب بهذا الرمز.',
            'dob_mismatch' => 'تاريخ الازدياد غير صحيح لهذا الرمز.',
            'throttle' => 'محاولات كثيرة. أعد المحاولة لاحقاً.',
        ],
        'status' => [
            'validated' => 'تم التحقق من الصيغة.',
        ],
    ],

    'admin' => [
        'search' => [
            'title' => 'لوحة الإدارة - البحث',
            'heading' => 'بحث عن طالب',
            'fields' => [
                'apogee' => 'رمز أبوجي',
            ],
            'actions' => [
                'submit' => 'بحث',
            ],
            'sections' => [
                'student' => 'الطالب',
                'examens' => 'امتحانات الاستدراك',
            ],
            'not_found' => 'لم يتم العثور على طالب بهذا الرمز.',
            'no_examens' => 'لا توجد امتحانات استدراك لهذا الطالب.',
        ],
    ],

    'ops' => [
        'list' => [
            'title' => 'العمليات - قائمة الطلبة',
            'heading' => 'قائمة الطلبة',
            'filters' => [
                'date' => 'التاريخ',
                'salle' => 'القاعة/المدرج',
                'all' => 'الكل',
            ],
            'actions' => [
                'apply' => 'تطبيق',
                'export_pdfs' => 'تصدير ملفات PDF',
            ],
            'table' => [
                'title' => 'النتائج',
                'date' => 'التاريخ',
                'salle' => 'القاعة/المدرج',
                'horaire' => 'الوقت',
                'nom' => 'اللقب',
                'prenom' => 'الاسم',
                'apogee' => 'رمز أبوجي',
                'module' => 'الوحدة',
                'site' => 'الموقع',
            ],
            'empty_state' => 'لا يوجد طلبة مطابقون للفلاتر المحددة.',
        ],

        'export' => [
            'title' => 'العمليات - تصدير PDF',
            'heading' => 'تصدير ملفات PDF',
            'back' => 'الرجوع إلى القائمة',
            'empty_state' => 'لا توجد ملفات PDF لإنشائها للفلاتر المحددة.',
            'link_label' => 'تحميل PDF — :date / :horaire / :salle',
        ],

        'presence_pdf' => [
            'title' => 'لائحة الحضور',
            'heading' => 'لائحة الحضور',
            'meta' => 'التاريخ: :date — الوقت: :horaire — القاعة/المدرج: :salle',
            'table' => [
                'nom' => 'اللقب',
                'prenom' => 'الاسم',
                'apogee' => 'رمز أبوجي',
                'module' => 'الوحدة',
                'signature' => 'التوقيع',
            ],
        ],
    ],

    'convocation' => [
        'title' => 'الاستدعاء',
        'heading' => 'الاستدعاء',
        'sections' => [
            'student' => 'المعلومات الشخصية',
            'examens' => 'امتحانات الاستدراك',
        ],
        'fields' => [
            'nom' => 'اللقب',
            'prenom' => 'الاسم',
            'code_apogee' => 'رمز أبوجي',
            'filiere' => 'الشعبة',
        ],
        'table' => [
            'module' => 'الوحدة',
            'professeur' => 'الأستاذ',
            'semestre' => 'السداسي',
            'groupe' => 'المجموعة',
            'date' => 'التاريخ',
            'horaire' => 'الوقت',
            'salle' => 'القاعة/المدرج',
            'site' => 'الموقع',
        ],
        'empty_state' => 'لا توجد امتحانات استدراك متاحة في الوقت الحالي.',
        'pdf' => [
            'helper' => 'استدعاء PDF رسمي',
            'open' => 'فتح استدعاء PDF',
            'download' => 'تحميل PDF',
            'error' => 'تعذر إنشاء ملف PDF حالياً. المرجو إعادة المحاولة.',
        ],
    ],

    'auth' => [
        'must_login' => 'يرجى تسجيل الدخول للوصول إلى هذه الصفحة.',
        'session_expired' => 'انتهت صلاحية الجلسة. يرجى تسجيل الدخول مرة أخرى.',
    ],

    'pdf_smoke' => [
        'title' => 'PDF (smoke)',
        'heading' => 'PDF (smoke)',
        'body' => 'OK',
    ],
];
