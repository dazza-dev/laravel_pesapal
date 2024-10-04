<?php

namespace Bryceandy\Laravel_Pesapal;

class PesapalConfig
{
    /**
     * Indicates if Pesapal migrations will be run.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * Configure Pesapal to not register its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;
    }
}
