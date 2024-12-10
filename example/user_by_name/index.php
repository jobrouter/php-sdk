<?php

declare(strict_types=1);

use JobRouter\Sdk\UserManagerInterface;

return function (UserManagerInterface $userInterface): void {
    echo '<h1 style="color: #fc0">SDK Example to demonstrate the UserManagerInterface and the UserInterface!</h1>';

    try {
        $currentUser = $userInterface->getCurrentUser();
        // Do something with the $currentUser
        $userName = $currentUser->getUsername();
        // Do something with $userName

        $userByName = $userInterface->getUserByUsername('example_user');
        // Do something with the $userByName
        $userAvatarUrl = $userByName->getAvatarUrl();
        // Do something with $userAvatarUrl
    } catch (\NoInstanceFoundException $e) {
        echo '<h3 style="color: #f44;">The user does not exist!</h3>';
        echo '<h3 style="color: #f44;">' . $e->getMessage() . '</h3>';
    }
};
