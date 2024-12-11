<?php

use Doctrine\DBAL\Exception;
use JobRouter\Sdk\ConnectionManagerInterface;

return function (ConnectionManagerInterface $connectionManager): void {
    echo '<h1 style="color: #fc0">SDK Example to demonstrate the ConnectionManagerInterface and JobDBInterface!</h1>';

    echo '<h3 style="color: #fc0;">JobRouter Users (internal connection) - getJobDB()</h3>';

    $jobDB = $connectionManager->getJobDB();

    $result = $jobDB->query('SELECT COUNT(*) FROM JRUSERS');
    $count = $jobDB->fetchOne($result);
    // Do something with the $count

    $result = $jobDB->query('SELECT lastname, prename, supervisor FROM JRUSERS');
    if ($result === false) {
        echo '<h3 style="color: #f44;">ERROR!</h3>';
        echo '<p style="color: #f44;">Message: ' . $jobDB->getErrorMessage() . '</p>';
    } else {
        $users = $jobDB->fetchAll($result);
        // Do something with the $users
    }

    try {
        $preparedResult = $jobDB->preparedSelect(
            'SELECT DISTINCT language_name FROM JRPROCESSLANGUAGES WHERE processname = :processname AND version = :version ORDER BY language_name',
            [
                'processname' => 'example_processname',
                'version' => 1,
            ],
            [
                'text',
                'integer',
            ],
        );

        $result = $preparedResult->fetchOne();
        // Do something with the $result
    } catch (\JobRouterException|Exception $e) {
        echo '<h3 style="color: #f44;">ERROR!</h3>';
        echo '<p style="color: #f44;">Message: ' . $e->getMessage() . '</p>';
    }

    echo '<h3 style="color: #59aa6e;">JobRouter (Global connection) - getDBConnection(\'GC_JOBDATA\')</h3>';
    try {
        $gcJobdata = $connectionManager->getDBConnection('GC_JOBDATA');
        $data = $gcJobdata->query('SELECT COUNT(*) FROM DATA_TABLE');
        $dataObject = $data->fetchOne();
        // Do something with the $dataObject
    } catch (\JobRouterException|Exception $e) {
        echo '<h3 style="color: #f44;">ERROR!</h3>';
        echo '<p style="color: #f44;">Message: ' . $e->getMessage() . '</p>';
    }

    echo '<h3 style="color: #59aa6e;">JobRouter (Global connection) - getDBConnection(\'GlobalConnectionFromJobRouterDosNotExists\')</h3>';
    try {
        $connectionManager->getDBConnection('GlobalConnectionFromJobRouterDosNotExists');
    } catch (\JobRouterException|\Exception $e) {
        echo '<h3 style="color: #f44;">ERROR!</h3>';
        echo '<p style="color: #f44;">Message: ' . $e->getMessage() . '</p>';
    }
};
