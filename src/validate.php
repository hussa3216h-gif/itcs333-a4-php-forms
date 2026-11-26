<?php
declare(strict_types=1);

/**
 * ITCS333 A4 starter — implement the three pure validation functions.
 * They are unit-tested by the autograder (tests/UnitTest.php).
 */

function validate_required(string $v): bool
{
    // TODO: return true when $v is not empty after trimming
    if (trim($v) !== '') {
        return true;
    }
    return false;
}

function validate_email(string $v): bool
{
    // TODO: return true when $v is a valid email address
    if (filter_var($v, FILTER_VALIDATE_EMAIL) !== false) {
        return true;
    }
    return false;
}

function validate_length(string $v, int $min, int $max): bool
{
    // TODO: return true when mb_strlen($v) is within [$min, $max]
    $length = mb_strlen($v, 'UTF-8');

    if ($length >= $min && $length <= $max) {
        return true;
    }
    return false;
}
