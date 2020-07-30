<?php

declare(strict_types=1);

function bbq_ignite (string $pClassName) {
    $className = __DIR__ . "/../../" . str_replace("\\", "/", $pClassName) . ".php" ;
    if (false === file_exists($className)) {
        //throw new \Exception("What? " . $className);
        null;
    }
    include($className);
}

spl_autoload_register("bbq_ignite");
