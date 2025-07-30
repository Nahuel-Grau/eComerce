<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConvertUtf8Providers extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
         $this->app->singleton(ImageManager::class, public static function convert_from_latin1_to_utf8_recursively(){
            if (is_string($dat)) {
         return mb_convert_encoding($dat, 'ISO-8859-1', 'UTF-8');
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);
         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);
         return $dat;
      } else {
         return $dat;
      }
        });
        
      

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
