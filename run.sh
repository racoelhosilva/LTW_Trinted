#!/bin/bash

# Checking if php-gd is installed and enabled 
if php check_gd.php; then
    echo "GD extension found and enabled"
else
    echo "GD extension is either not installed or not enabled"
    exit 1
fi

# Rebuilding the database
if command -v sqlite3 &> /dev/null; then
    sqlite3 db/database.db < db/create.sql && sqlite3 db/database.db < db/populate.sql
    echo "Re-generated database"
else
    echo "SQLite not found, using pre-made database"
    echo "Consider installing SQLite for future runs"
fi

# Re-compiling the typescript
if command -v tsc &> /dev/null; then
    tsc
    echo "Re-compiled typescript into javascript"
else
    echo "tsc not found, not regenerating javascript"
    echo "Consider installing tsc for future runs"
fi

xdg-open localhost:9000
php -S localhost:9000