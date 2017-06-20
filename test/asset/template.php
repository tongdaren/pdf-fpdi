<?php

return [
    'sourceFile' => 'template.pdf',
    'dhekFile' => 'template.json',
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
                    'y' => 64,
                    'w' => 612,
                    'h' => 728,
                ],
                'type' => 'loop',
                'dataIdx' => 'items',
                'section' => 'section-4',
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
        'section-4' => [
            'tplIdx' => 4,
            'area' => [
                'x' => 0,
                'y' => 64,
                'w' => 612,
                'h' => 204
            ],
        ],
    ],
    'document' => [
        'format' => 'Letter',
        'fontFamily' => 'Arial',
        'fontSize' => 8,
        'textColor' => [255, 0, 0],
        'pages' => [
            'page-1',
            'page-2',
            'page-3',
        ]
    ]
];