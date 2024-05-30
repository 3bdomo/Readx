<?php

namespace App\Helpers;

trait EnvUpdaterTrait
{


    public function setEnvValue($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $escaped = preg_quote('=' . env($key), '/');
            file_put_contents($path, preg_replace(
                "/^{$key}{$escaped}/m",
                "{$key}={$value}",
                file_get_contents($path)
            ));
        }


    }
}
