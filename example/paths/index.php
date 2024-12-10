<?php

declare(strict_types=1);

use JobRouter\Sdk\PathsInterface;

return function (PathsInterface $pathsInterface): void {
    echo '<h1 style="color: #fc0">SDK Example to demonstrate the PathsInterface!</h1>';

    try {
        echo '<pre>JobRouter URL: ' . print_r($pathsInterface->getJobRouterUrl(), true) . '</pre>';
        echo '<pre>Data path: ' . print_r($pathsInterface->getDataPath('extra/data/path', 'Example_Proccess', 1), true) . '</pre>';
        echo '<pre>Functions path: ' . print_r($pathsInterface->getFunctionsPath(), true) . '</pre>';
        echo '<pre>Temp path: ' . print_r($pathsInterface->getTempPath(), true) . '</pre>';
        echo '<pre>Upload path: ' . print_r($pathsInterface->getUploadPath(), true) . '</pre>';

    } catch (\IllegalFilesystemAccessException|\JobRouterException $e) {
        echo '<h3 style="color: #f44;">ERROR!</h3>';
        echo '<p style="color: #f44;">Message: ' . $e->getMessage() .  '</p>';
    }
};
