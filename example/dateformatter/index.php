<?php

declare(strict_types=1);

use JobRouter\Sdk\DateFormatterInterface;

return function (DateFormatterInterface $jobRouterDateFormatter): void {
    echo '<h1 style="color: #fc0">SDK Example to demonstrate the DateFormatterInterface!</h1>';

    try {
        echo '<pre>Formatted Date (FORMAT_WITH_POINT): ' . print_r(
                $jobRouterDateFormatter->getFormattedDate(
                    DateFormatterInterface::FORMAT_WITH_POINT,
                    fullDateTime: true,
                    isTimestamp: true,
                ),
                true,
            ) . '</pre>';

        echo '<pre>Formatted Date (FORMAT_WITH_SLASHES): ' . print_r(
                $jobRouterDateFormatter->getFormattedDate(
                    DateFormatterInterface::FORMAT_WITH_SLASHES,
                    fullDateTime: true,
                    isTimestamp: true,
                ),
                true,
            ) . '</pre>';

        echo '<pre>Formatted Date (FORMAT_WITH_SLASHES_MONTH_FIRST): ' . print_r(
                $jobRouterDateFormatter->getFormattedDate(
                    DateFormatterInterface::FORMAT_WITH_SLASHES_MONTH_FIRST,
                    fullDateTime: true,
                    isTimestamp: true,
                ),
                true,
            ) . '</pre>';

        echo '<pre>Formatted Date (FORMAT_WITH_HYPHENS): ' . print_r(
                $jobRouterDateFormatter->getFormattedDate(
                    DateFormatterInterface::FORMAT_WITH_HYPHENS,
                    fullDateTime: true,
                    isTimestamp: true,
                ),
                true,
            ) . '</pre>';

        echo '<br />';
        echo '<pre>Unformatted Date (FORMAT_WITH_POINT): ' . print_r(
                $jobRouterDateFormatter->getUnformattedDate(
                    DateFormatterInterface::FORMAT_WITH_POINT,
                    $jobRouterDateFormatter->getFormattedDate(
                        DateFormatterInterface::FORMAT_WITH_POINT,
                        fullDateTime: true,
                        isTimestamp: true,
                    ),
                ),
                true,
            ) . '</pre>';
    } catch (\RuntimeException $e) {
        echo '<h3 style="color: #f44;">Error!</h3>';
        echo '<p style="color: #f44;">Message: ' . $e->getMessage() . '</p>';
    }
};
