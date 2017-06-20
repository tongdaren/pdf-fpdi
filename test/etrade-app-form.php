<?php

require_once __DIR__ . '/bootstrap.php';

$outFile = ROOT_PATH . '/test/out/etrad-app-form.pdf';

$config = require(ROOT_PATH . '/test/asset/etrade-app-form.php');
$data = require(ROOT_PATH . '/test/asset/etrade-app-form.data');
$doc = new \BD\pdf\Document($config, $data, ['baseTemplateDir' => __DIR__ . '/asset', 'debug' => true]);
$doc->render($outFile);