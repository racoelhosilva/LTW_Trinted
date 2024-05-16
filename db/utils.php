<?php
declare(strict_types=1);

function getDatabaseConnection(): PDO {
    return new PDO('sqlite:db/database.db');
}