<?php

namespace {
    if (false) {
        class JobRouterException extends \Exception
        {
        }

        class NoInstanceFoundException extends \JobRouterException
        {
        }

        class IllegalFilesystemAccessException extends \JobRouterException
        {
        }
    }
}

namespace Doctrine\DBAL {
    if (false) {
        class Exception extends \Exception
        {
        }
    }
}

namespace JobRouter\Component\Security\Authentication {
    if (false) {
        abstract class AuthenticationException extends \JobRouterException
        {
        }
    }
}

namespace JobRouter\Authentication {
    if (false) {
        class NoActiveAuthenticationException extends \JobRouter\Component\Security\Authentication\AuthenticationException
        {
        }
    }
}

namespace JobRouter\Sdk {

    if (false) {
        interface ConnectionManagerInterface
        {
            /**
             * Return the default JobRouter Database Connection.
             *
             * @return \JobRouter\Sdk\JobDBInterface JobDB Interface
             */
            public function getJobDB(): \JobRouter\Sdk\JobDBInterface;

            /**
             * Return a JobRouter Database Connection by its name.
             *
             * @param string $connectionName Connection name
             *
             * @return \JobRouter\Sdk\JobDBInterface JobDB Interface
             *
             * @throws \Doctrine\DBAL\Exception
             * @throws \JobRouterException
             */
            public function getDBConnection(string $connectionName): \JobRouter\Sdk\JobDBInterface;
        }

        interface DateFormatterInterface
        {
            /**
             * Date format id for d.m.Y
             */
            public const FORMAT_WITH_POINT = 1;

            /**
             *  Date format id for d/m/Y
             */
            public const FORMAT_WITH_SLASHES = 2;

            /**
             * Date format id for m/d/Y
             */
            public const FORMAT_WITH_SLASHES_MONTH_FIRST = 3;

            /**
             * Date format id for Y-m-d
             */
            public const FORMAT_WITH_HYPHENS = 4;

            /**
             * Returns a formatted date according to a date $id (DateFormatterInterface::FORMAT_WITH_*). If an invalid ID
             * is specified, the method returns the date in the standard format.
             *
             * @param string|int|bool $date Date string or date timestamp; if the value is false, the current timestamp is used
             * @param bool $fullDateTime Flag whether the time should also be returned
             * @param bool $isTimestamp Flag whether $date is a timestamp
             * @param string $timeZone TimeZone
             * @phpstan-param \JobRouter\Sdk\DateFormatterInterface::FORMAT_WITH_* $id ID of the date format
             *
             * @return string formatted date
             */
            public function getFormattedDate(
                int             $id,
                string|int|bool $date = false,
                bool            $fullDateTime = false,
                bool            $isTimestamp = false,
                string          $timeZone = '',
            ): string;

            /**
             * Returns a date in the standard format YYYY-MM-DD.
             *
             * @param string $date Date string
             * @param bool $fullDateTime Flag whether the time should also be returned
             * @param string $sourceTimeZone Source time zone
             * @param string $targetTimeZone Target time zone
             * @phpstan-param \JobRouter\Sdk\DateFormatterInterface::FORMAT_WITH_* $id ID of the date format
             *
             * @return string Date in the standard format YYY-MM-DD
             *
             * @throws \JobRouterException
             */
            public function getUnformattedDate(
                int    $id,
                string $date,
                bool   $fullDateTime = false,
                string $sourceTimeZone = '',
                string $targetTimeZone = '',
            ): string;
        }

        interface ResultInterface
        {
            /** Data indexed by column names (associative array). */
            public const MODE_ASSOC = 2;

            /** Default fetch mode if none specified. */
            public const MODE_DEFAULT = 0;

            /** Column names as top-level keys; rows as second-level keys. */
            public const MODE_FLIPPED = 4;

            /** Data as objects with properties corresponding to column names. */
            public const MODE_OBJECT = 3;

            /** Data indexed numerically by column order. */
            public const MODE_ORDERED = 1;

            /**
             * Fetches all rows from the query.
             *
             * @param int $fetchMode The fetch mode to use (default: MODE_DEFAULT).
             * @param bool $rekey if set to true, return array will have the first column as
             * its first dimension
             * @param bool $force_array used only when the query returns exactly two
             * columns. If true, the values of the returned array will be one-element
             * arrays instead of scalars.
             * @param bool $group if true, the values of the returned array is wrapped in another array.  If the same
             * key value (in the first column) repeats itself, the values will be appended to this array instead of
             * overwriting the existing values.
             *
             * @return array<mixed>  data array on success, a error on failure.
             */
            public function fetchAll(
                int $fetchMode = self::MODE_DEFAULT,
                $rekey = false,
                $force_array = false,
                $group = false,
            );

            /**
             * Fetches a single column of data from the result.
             *
             * @param int $colNum The column number to fetch (default: 0).
             *
             * @return array<mixed> The values of the specified column.
             */
            public function fetchCol(int $colNum = 0);

            /**
             * Fetches a single value from the result.
             *
             * @param int $colNum The column number to fetch (default: 0).
             * @param int|null $rowNum The row number to fetch (default: first row).
             *
             * @return mixed The fetched value.
             */
            public function fetchOne(int $colNum = 0, ?int $rowNum = null);

            /**
             * Fetches a single row from the result.
             *
             * @param int $fetchMode The fetch mode to use (default: MODE_DEFAULT).
             * @param int|null $rowNum The row number to fetch (default: first row).
             *
             * @return array<mixed> data array on success, a error on failure.
             */
            public function fetchRow(int $fetchMode = self::MODE_DEFAULT, ?int $rowNum = null);
        }

        interface JobDBInterface
        {
            /**
             * Quotes a literal string.  This method is NOT meant to fix SQL injections! It is only meant to escape this
             * platform's string literal quote character inside the given literal string.
             *
             * @param mixed $value A literal string to quote
             * @param string|null $type Type to which the value should be converted to
             *
             * @return mixed according to value; otherwise null in case of error.
             *
             * @throws \JobRouterException
             */
            public function quote($value, ?string $type = null): mixed;

            /**
             * Executes an SQL statement and return the number of affected rows.
             *
             * @param string $sql SQL query
             *
             * @return mixed according to sql.
             *
             * @throws \JobRouterException
             */
            public function exec(string $sql): mixed;

            /**
             * Executes an SQL statement, returning a result set as a Statement object.
             *
             * @param string $sql SQL query
             *
             * @return \JobRouter\Sdk\ResultInterface|false SQL result set; otherwise false in case of error.
             *
             * @throws \JobRouterException
             */
            public function query(string $sql): \JobRouter\Sdk\ResultInterface|false;

            /**
             * Return a dataset from the result as an associative array.
             * If there are no more datasets, a null will be returned, false will be returned on error.
             *
             * @param \JobRouter\Sdk\ResultInterface $result Object returned by query()
             *
             * @return mixed data set as array, null or false in case of error.
             *
             * @throws \JobRouterException
             */
            public function fetchRow(\JobRouter\Sdk\ResultInterface $result): mixed;

            /**
             * Method returns all rows of the query result.
             * If an error occurs, the method returns false.
             *
             * @param \JobRouter\Sdk\ResultInterface $result result object returned by query()
             *
             * @return mixed array or false in case of error
             */
            public function fetchAll(\JobRouter\Sdk\ResultInterface $result): mixed;

            /**
             * Returns the first column of the first data set.
             * If an error occurs, the method returns false.
             *
             * @param \JobRouter\Sdk\ResultInterface $result result object returned by query
             *
             * @return mixed prepared statement; otherwise false.
             */
            public function fetchOne(\JobRouter\Sdk\ResultInterface $result): mixed;

            /**
             * Prepare an optionally parametrized SQL selection.
             *
             * @param string $sql SQL Query to prepare
             * @param array $params Optional sql query parameter
             * @param array|null $types Optional sql query parameter types
             *
             * @return \JobRouter\Sdk\ResultInterface|int|false Prepared result set; otherwise an integer based on sql
             * select statement or false.
             */
            public function preparedSelect(
                string $sql,
                array $params,
                ?array $types = [],
            ): \JobRouter\Sdk\ResultInterface|int|false;

            /**
             * Executes an optionally parametrized SQL selection.
             *
             * @param string $sql SQL Query to prepare
             * @param array $params Optional sql query parameter
             * @param array|null $types Optional sql query parameter types
             *
             * @return \JobRouter\Sdk\ResultInterface|int Prepared result set; otherwise an integer based on sql select
             * statement or false in case of error. The error message can then be retrieved via getErrorMessage.
             */
            public function preparedExecute(
                string $sql,
                array $params,
                ?array $types = [],
            ): \JobRouter\Sdk\ResultInterface|int;

            /**
             * Get additional user-supplied error information.
             *
             * @return string user-supplied error information; otherwise an empty if no error message exist
             */
            public function getErrorMessage(): string;
        }

        interface PathsInterface
        {
            /**
             * Return the JobRouter data path.
             *
             * @param string|null $relativePath Optional relative path inside the data path
             * @param string|null $processName Optional process name
             * @param int|null $processVersion Optional process version
             *
             * @return string the data path with the optional relative path, optional process name and there optional process version.
             *
             * @throws \IllegalFilesystemAccessException
             */
            public function getDataPath(?string $relativePath = '', ?string $processName = '', ?int $processVersion = null): string;

            /**
             * Return the JobRouter functions path.
             *
             * @param string|null $relativePath Optional relative path inside the functions path
             * @param string|null $processName Optional process name
             * @param int|null $processVersion Optional process version
             *
             * @return string the data path with the optional relative path, optional process name and there optional process version.
             *
             * @throws \IllegalFilesystemAccessException
             */
            public function getFunctionsPath(?string $relativePath = '', ?string $processName = '', ?int $processVersion = null): string;

            /**
             * Return the JobRouter URL with corresponding slash (/) at the end.
             *
             * @return string the JobRouter URL
             *
             * @throws \JobRouterException
             */
            public function getJobRouterUrl(): string;

            /**
             * Return the JobRouter output path.
             *
             * @param string $relativePath Optional relative path inside the output path
             *
             * @throws \IllegalFilesystemAccessException
             */
            public function getOutputPath(string $relativePath = ''): string;

            /**
             * Return the JobRouter temp path.
             *
             * @param string $relativePath Optional relative path inside the temp path
             *
             * @throws \IllegalFilesystemAccessException
             */
            public function getTempPath(string $relativePath = ''): string;

            /**
             * Return the JobRouter upload path.
             *
             * @param string $relativePath Optional relative path inside the upload path
             * @param bool|null $skipAssert Optional to skip assertion
             *
             * @throws \IllegalFilesystemAccessException
             */
            public function getUploadPath(string $relativePath = '', ?bool $skipAssert = false): string;
        }

        interface UserInterface
        {
            /**
             * Returns the user's language.
             *
             * @return string user's language
             */
            public function getLanguage(): string;

            /**
             * Returns the user's avatar image url.
             *
             * @return string Avatar image url or the avatar fallback image path
             */
            public function getAvatarUrl(): string;

            /**
             * Returns the login name for the user.
             *
             * @return string Login name of the user.
             */
            public function getUsername(): string;

            /**
             * Returns the user's first name (pre-name).
             *
             * @return string First name of the user.
             */
            public function getPrename(): string;

            /**
             * Returns the last name of the user.
             *
             * @return string Last name of the user.
             */
            public function getLastName(): string;

            /**
             * Returns the complete name of the user in the form of "pre-name lastname".
             *
             * Is equivalent to:
             *
             *      <?php
             *      echo $user->getPrename() . ' ' .  $user->getLastName();
             *
             * @return string Complete name of the user.
             */
            public function getFullName(): string;

            /**
             * Returns the user's e-mail address
             *
             * @return string user's e-mail address.
             */
            public function getEmail(): string;

            /**
             * Returns the first user-defined settings of the user.
             *
             * @return string First user-defined settings of the user; otherwise an empty string.
             */
            public function getUserDefined1(): string;

            /**
             * Returns the second user-defined settings of the user.
             *
             * @return string Second user-defined settings of the user; otherwise an empty string.
             */
            public function getUserDefined2(): string;

            /**
             * Returns the third user-defined settings of the user.
             *
             * @return string Third user-defined settings of the user; otherwise an empty string.
             */
            public function getUserDefined3(): string;

            /**
             * Returns the fourth user-defined settings of the user.
             *
             * @return string Fourth user-defined settings of the user; otherwise an empty string.
             */
            public function getUserDefined4(): string;

            /**
             * Returns the fifth user-defined settings of the user.
             *
             * @return string Fifth user-defined settings of the user; otherwise an empty string.
             */
            public function getUserDefined5(): string;

            /**
             * Returns the supervisor of the user.
             *
             * @return string Supervisor of the user; otherwise an empty string.
             */
            public function getSupervisor(): string;

            /**
             * Returns the user's department.
             *
             * @return string Department of the user; otherwise an empty string.
             */
            public function getDepartment(): string;

            /**
             * Returns the user's phone number.
             *
             * @return string Phone number of the user; otherwise an empty string
             */
            public function getPhone(): string;

            /**
             * Returns the user's fax number.
             *
             * @return string Fax number of the user; otherwise an empty string
             */
            public function getFax(): string;

            /**
             * Returns the user's date format id.
             *
             * @return int Date format id from the user
             */
            public function getDateFormatId(): int;

            /**
             * Returns the user's date format as specified in their settings. If an invalid date format is configured,
             * a default value of YYYY-MM-DD HH:mm:ss is returned.
             *
             * @return string Date format from the user
             */
            public function getDateFormat(): string;

            /**
             * Returns the user's decimal separator.
             *
             * @return string User's decimal separator.
             */
            public function getDecimalSeparator(): string;

            /**
             * Returns the user's thousands separator.
             *
             * @return string User's thousands separator.
             */
            public function getThousandsSeparator(): string;

            /**
             * Returns the user's time zone.
             *
             * @return string Time Zone of the user
             */
            public function getTimezone(): string;

            /**
             * Returns the user's job functions.
             *
             * @return string[] user job functions
             *
             * @throws \JobRouterException
             */
            public function getJobFunctions(): array;

            /**
             * Returns the selected user's profile.
             *
             * @return int Selected user profile.
             */
            public function getUserProfile(): int;

            /**
             * Checks whether the user has administration rights.
             *
             * @return bool true has the user administrator rights; otherwise false
             */
            public function hasAdminRights(): bool;

            /**
             * Checks whether the user is the owner of any processes.
             *
             * @return bool true is the user owner of any processes; otherwise false
             *
             * @throws \JobRouterException If an error occurs during the database query to fetch the processes
             * a JobRouterException containing the DB error message is thrown.
             */
            public function hasOwnProcesses(): bool;

            /**
             * Checks whether the user is in the specified role.
             *
             * @param string $jobFunction Specified JobFunction name
             *
             * @return bool true a user in the given JobFunction; otherwise false
             */
            public function isInJobFunction(string $jobFunction): bool;

            /**
             * Checks whether the user is blocked or not.
             *
             * @return bool true if a user is blocked or not
             */
            public function isBlocked(): bool;
        }

        interface UserManagerInterface
        {
            /**
             * Returns the SDK UserInterface for the specified user name.
             *
             * @param string $userName Name of the user to be returned
             *
             * @return \JobRouter\Sdk\UserInterface the SDK UserInterface for the specified user name.
             *
             * @throws \JobRouterException
             * @throws \JobRouter\Authentication\NoActiveAuthenticationException
             * @throws \NoInstanceFoundException
             */
            public function getUserByUsername(string $userName): \JobRouter\Sdk\UserInterface;

            /**
             * Returns the currently logged-in JobRouter user as SDK UserInterface.
             *
             * @return \JobRouter\Sdk\UserInterface the currently logged in JobRouter user as SDK user.
             *
             * @throws \JobRouterException
             * @throws \JobRouter\Authentication\NoActiveAuthenticationException
             * @throws \NoInstanceFoundException
             */
            public function getCurrentUser(): \JobRouter\Sdk\UserInterface;
        }
    }
}

namespace JobRouter\Sdk\Template {

    if (false) {
        interface TwigRendererInterface
        {
            /**
             * Disables the auto_reload option.
             */
            public function disableAutoReload(): void;

            /**
             * Enables the auto_reload option.
             *
             * <b>Important:</b>
             * This method allows you to make changes to the Twig template during development without clearing the
             * cache. Using this method will cause Twig to regenerate the template again.
             *
             * So be careful!
             */
            public function enableAutoReload(): void;

            /**
             * Enables the strict_variables option.
             */
            public function enableStrictVariables(): void;

            /**
             * Disables the strict_variables option.
             */
            public function disableStrictVariables(): void;

            /**
             * Set the absolute template cache path.
             *
             * <b>Important:</b>
             * It is important that this method is executed after calling enableAutoReload(), otherwise the
             * revalidation / recompilation of the template will not take effect.
             *
             * This is only necessary if you want to separate the cache folder from JobRouter. By default, the template
             * cache path is located under \<jobrouter-path\>/cache/symfony/prod/twig
             *
             * @param string $path The absolute path to the compiled templates
             */
            public function setTemplateCachePath(string $path): void;

            /**
             * Set paths where to look for templates
             *
             * @param string|array $paths A path or an array of paths where to look for templates
             * @param string|null $rootPath The root path common to all relative paths (null for getcwd())
             *
             * @throws \Twig\Error\LoaderError When the template path cannot be found
             */
            public function setTemplatePath(string|array $paths = [], ?string $rootPath = null): void;

            /**
             * Renders a template.
             *
             * @param string $fileName The template file name
             * @param array $context The optional template variables
             *
             * @throws \Twig\Error\LoaderError When the template cannot be found
             * @throws \Twig\Error\SyntaxError When an error occurred during compilation
             * @throws \Twig\Error\RuntimeError When an error occurred during rendering
             */
            public function render(string $fileName, array $context = []): string;
        }
    }
}
