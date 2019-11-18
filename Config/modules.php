<?php

return [
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
        'generator' => [
            'entity' => ['path' => 'Entities', 'generate' => false],
            'entity-policy' => ['path' => 'Entities/Policies', 'generate' => false],
            'entity-routes' => ['path' => 'Entities/Routes', 'generate' => false],
            'entity-actions' => ['path' => 'Entities/Actions', 'generate' => false],
            'entity-uris' => ['path' => 'Entities/Uris', 'generate' => false]
        ]
    ],
];
