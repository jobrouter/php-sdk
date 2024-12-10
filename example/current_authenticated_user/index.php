<?php

declare(strict_types=1);

use JobRouter\Sdk\UserManagerInterface;

return function (UserManagerInterface $userInterface): void {
    echo '<h1 style="color: #fc0">SDK Example to demonstrate the UserManagerInterface and the UserInterface!</h1>';

    try {
        $user = $userInterface->getCurrentUser();

        echo '<h3 style="color: #59aa6e;">The user with username "' . $user->getUserName() . '" is authenticated!</h3>';

        $fullName = $user->getFullName();
        $inJobFunction = $user->isInJobFunction('Administrator') === true
            ? 'Yes'
            : 'No';

        echo '<pre>FullName: ' . print_r($fullName, true) . '</pre>';
        echo '<pre>In JobFunctions (Administrator): ' . print_r($inJobFunction, true) . '</pre>';

    } catch (\NoInstanceFoundException $e) {
        echo '<h3 style="color: #f44;">The user is not authenticated!</h3>';
        echo '<h3 style="color: #f44;">' . $e->getMessage() . '</h3>';
    }
};
