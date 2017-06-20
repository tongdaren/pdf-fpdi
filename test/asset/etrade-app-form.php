<?php

return [
    'sourceFile' => 'etrade-app-form.pdf',
    'dhekFile' => 'etrade-app-form.json',
    'pages' => [
        'page-1' => [
            [
                'container' => [
                    'x' => 0,
                    'y' => 0,
                    'w' => 612,
                    'h' => 792,
                ],
                'type' => 'once',
                'section' => 'section-1'
            ]
        ],
        'page-2' => [
            [
                'container' => [
                    'x' => 0,
                    'y' => 0,
                    'w' => 612,
                    'h' => 792,
                ],
                'type' => 'once',
                'section' => 'section-2'
            ]
        ],
        'page-3' => [
            [
                'container' => [
                    'x' => 0,
                    'y' => 0,
                    'w' => 612,
                    'h' => 792,
                ],
                'type' => 'once',
                'section' => 'section-3',
            ],
        ],
    ],
    'sections' => [
        'section-1' => [
            'tplIdx' => 1,
            'area' => [
                'x' => 0,
                'y' => 0,
                'w' => 612,
                'h' => 792,
            ],
        ],
        'section-2' => [
            'tplIdx' => 2,
            'area' => [
                'x' => 0,
                'y' => 0,
                'w' => 612,
                'h' => 792,
            ],
        ],
        'section-3' => [
            'tplIdx' => 3,
            'area' => [
                'x' => 0,
                'y' => 0,
                'w' => 612,
                'h' => 792,
            ],
        ],
    ],
    'document' => [
        'format' => 'Letter',
        'fontFamily' => 'Arial',
        'fontSize' => 8,
        'textColor' => [0, 0, 0],
        'pages' => [
            'page-1',
            'page-2',
            'page-3',
        ]
    ]
];