<?php

# config
#
define('ROOT', __DIR__);

include ROOT.'/fns.inc.php';

$json = ROOT.'/json/sites.json';
$errors = ROOT.'/json/errors.json';
$server = 'localhost';

# sites
#
if (file_exists($json)) {
    $sites = json_decode(file_get_contents($json), true);
    $codes = json_decode(file_get_contents($errors), true);

    // echo '<pre>';
    // exit(print_r($sites));
}

if (!empty($_REQUEST['server'])) {
    $server = $_REQUEST['server'];
}

if (class_exists('Memcache')) {
    $mcache = new Memcache;
    $mcache_driver = 'memcache';

    if ($mcache->connect($server, 11211)) {
        $mcache_enable = true;
    }
}

require __DIR__ . '/template/index.phtml';