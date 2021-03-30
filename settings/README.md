Maak hier je settings.php file, de inhoud is anders voor iedereen, het formaat zal het volgende zijn:

<?php

    const SETTINGS = [
        "db" => [
            "user"      => "root",
            "password"  => "your_password",
            "host"      => "localhost",
            "port"      => 3306,
            "dbname"    => "bokaal"
        ]
    ];