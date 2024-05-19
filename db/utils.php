<?php
declare(strict_types=1);

function getDatabaseConnection(): PDO {
    return new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
}