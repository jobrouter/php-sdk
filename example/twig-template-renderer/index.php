<?php

use JobRouter\Sdk\Template\TwigRendererInterface;
use JobRouter\Sdk\UserManagerInterface;

return function (UserManagerInterface $userManagerInterface, TwigRendererInterface $twigRenderer): void {
    // Set the path of the template relative to the root path of index.php. This is the second parameter of this method.
    // This method must be called for the Twig templates to be found, if this method is not used, an error will occur
    // stating that the Twig template cannot be found.
    $twigRenderer->setTemplatePath('templates', __DIR__);

    // This method allows you to make changes to the Twig template during development without clearing the
    // cache. Using this method will cause Twig to regenerate the template again. So be careful!
    //$twigRenderer->enableAutoReload();

    // This method can be used to validate variables in templates. This means that if we have forgotten to
    // define a variable, we can't access it via the Twig template.
    //$twigRenderer->enableStrictVariables();

    // It is important that this method is executed after calling enableAutoReload(), otherwise the
    // revalidation / recompilation of the template will not take effect.
    //
    // This method sets the absolute template cache path. This is only necessary if you want to separate the cache
    // folder from JobRouter. By default, the template cache path is located under <jobrouter-path>/cache/symfony/prod/twig
    /*$twigRenderer->setTemplateCachePath(
        __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'cache',
    );*/

    // Define the variable context to use in the twig template
    $templateVariables = [
        'authorized' => [],
    ];

    try {
        $user = $userManagerInterface->getCurrentUser();

        $templateVariables['authorized'] = [
            'userName' => $user->getUsername(),
            'preName' => $user->getPreName(),
            'lastName' => $user->getLastName(),
            'fullName' => $user->getFullName(),
            'email' => $user->getEmail(),
            'userDefined1' => $user->getUserDefined1(),
            'userDefined2' => $user->getUserDefined2(),
            'userDefined3' => $user->getUserDefined3(),
            'userDefined4' => $user->getUserDefined4(),
            'userDefined5' => $user->getUserDefined5(),
            'supervisor' => $user->getSupervisor(),
            'department' => $user->getDepartment(),
            'phone' => $user->getPhone(),
            'fax' => $user->getFax(),
            'language' => $user->getLanguage(),
            'dateFormat' => $user->getDateFormat(),
            'decimalSeparator' => $user->getDecimalSeparator(),
            'thousandsSeparator' => $user->getThousandsSeparator(),
            'timezone' => $user->getTimezone(),
            'jobFunctions' => $user->getJobFunctions(),
            'inJobFunctions' => $user->isInJobFunction('Administrator') === false ? 'no (Administrator)' : 'yes (Administrator)',
            'userProfile' => $user->getUserProfile(),
            'avatarUrl' => $user->getAvatarUrl(),
        ];
    } catch (\Throwable) {
        $templateVariables['authorized'] = [
            'error' => true,
        ];
    }

    // Render the given twig template with above defined context variables
    $result = $twigRenderer->render('index.html.twig', $templateVariables);

    // Output the complete rendered twig template with the context variables
    echo $result;
};
