<?php

return [
    'types' => 'admin,builder,home-owner,franchise,evaluator',
    'classBindings' => [
        'admin' => "\App\Models\User",
        'evaluator' => "\App\Models\Evaluator",
        'homeowner' => "\App\Models\HomeOwner",
        'franchise' => "\App\Models\Franchise",
        'builder' => "\App\Models\Builder",
    ]
];