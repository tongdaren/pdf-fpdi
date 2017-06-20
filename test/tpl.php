<?php

require_once __DIR__ . '/bootstrap.php';

$tplFile = ROOT_PATH . '/test/asset/template.pdf';
$outFile = ROOT_PATH . '/test/out/template.pdf';

//$mpdf = new \BD\pdf\Mpdf('', 'Letter');
//$mpdf->setImportUse();
//$mpdf->setSourceFile($tplFile);
//$mpdf->newPage();
//$idx = $mpdf->importPage(1, 0, 0, 216, 279);
//$mpdf->useTemplate($idx, null, null);
//$mpdf->output($outFile, 'F');

$data = [
    'a0.fullname' => 'Jin',
    'a1.fullname' => 'Mole',
    'a0.isUscYes' => '1',
    'a1.isUscNo' => '1',
    'items' => [
        [
            'a0.fullname' => 'Jin',
            'a1.fullname' => 'Mole',
        ],
        [
            'a0.fullname' => 'Jin',
            'a1.fullname' => 'Mole',
        ],
        [
            'a0.fullname' => 'Jin',
            'a1.fullname' => 'Mole',
        ]
    ]
];
$config = require(ROOT_PATH . '/test/asset/template.php');
$doc = new \BD\pdf\Document($config, $data, ['baseTemplateDir' => __DIR__ . '/asset']);
$doc->render($outFile);