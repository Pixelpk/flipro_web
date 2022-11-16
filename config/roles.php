<?php

##Roles 🔐
#List of roles covering all application

return [
    'roles' => [
        'administrator',
        'franchise',
        #Users permissions
        'view-admin',
        'view-franchise',
        'view-evaluator',
        'view-home-owner',
        'view-builder',
        'create-admin',
        'create-franchise',
        'create-evaluator',
        'create-home-owner',
        'create-builder',
        #Leads permissions
        'view-leads',
        'create-leads',
        'edit-leads',
    ],
    'projectRoles' => [
        'view',
        'add_value',
        'add_notes',
        'upload_progress',
        'add_photos',
        'request_payment',
        'review_progress',
        'review_evaluation',
    ],

    'homeownerroles' => [
        'view',
        // 'add_value',
        'add_notes',
        // 'upload_progress',
        // 'add_photos',
        // 'request_payment',
        'review_progress',
        // 'review_evaluation',
    ],

    'builderroles' => [
        'view',
        // 'add_value',
        'add_notes',
        'upload_progress',
        'add_photos',
        // 'request_payment',
        // 'review_progress',
        // 'review_evaluation',
    ],

    'franchiseroles' => [
        'view',
        'add_value',
         'add_notes',
        'upload_progress',
        // 'add_photos',
        'request_payment',
        'review_progress',
        // 'review_evaluation',
    ],

    'valuerroles' => [
        'view',
        'add_value',
        'add_notes',
        // 'upload_progress',
        // 'add_photos',
        // 'request_payment',
        // 'review_progress',
        // 'review_evaluation',
    ]
];
