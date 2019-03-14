<?php

return [

    'available' => true,

    /*
    |--------------------------------------------------------------------------
    | Emtity Block
    |--------------------------------------------------------------------------
    */
    'blocks' => [

        /*
         * You must create next model and publish migration.
         */
        'model' => \App\Models\Block::class,
        
        'table_name' => 'blocks',
        
        'blade_dir' => 'front.blocks',
   ],
];
