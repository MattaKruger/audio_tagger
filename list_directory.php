<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

use AudioTagger\Utils\DirectoryLister;

$lister = new DirectoryLister();

$dataDirectory = __DIR__ . "/data";

echo "Listing files: \n\n";
$lister->displayFiles($dataDirectory);
