<?php
namespace App\Utils;


Class EncodingConverter{

    public static function convertUtf8($dat)
   {
      if (is_string($dat)) {
         return mb_convert_encoding($dat,  'UTF-8', 'ISO-8859-1');
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::ConvertUtf8($d);
         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::ConvertUtf8($d);
         return $dat;
      } else {
         return $dat;
      }
   }
}