<?php

namespace App\Utils;

use Exception;

/**
 * 
 */
class Misc
{

  function __construct()
  {
  }

  public static function startsWith($string, $startString)
  {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
  }

  public static function str_replace_first($from, $to, $content)
  {
    $from = '/' . preg_quote($from, '/') . '/';

    return preg_replace($from, $to, $content, 1);
  }

  public static function reformatPhone($phone)
  {
    if (empty($phone)) {
      return null;
    }

    if (self::startsWith($phone, '0')) {
      return self::str_replace_first('0', '+62', $phone);
    }

    if (self::startsWith($phone, '62')) {
      return self::str_replace_first('62', '+62', $phone);
    }

    return $phone;
  }


  public static function checkPhone($phone)
  {
    preg_match('/(\+62 ((\d{3}([ -]\d{3,})([- ]\d{4,})?)|(\d+)))|(\(\d+\) \d+)|\d{3}( \d+)+|(\d+[ -]\d+)|\d+/gm', $phone, $matches, PREG_OFFSET_CAPTURE);

    return $matches;
  }

  public static function slugify($text)
  {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    return empty($text) ? 'n-a' : $text;
  }

  public static function castBoolean($text)
  {
    return !empty($text) ? filter_var($text, FILTER_VALIDATE_BOOLEAN) : false;
  }

  public static function getMetaFile($file)
  {
    return [
      'mimeType' => $file->getClientMimeType(),
      'content' => $file->getContent(),
      'size' => $file->getSize(),
      'ext' => $file->extension(),
      'ext2' => $file->getClientOriginalExtension(),
      'filename' => [
        'full' => $file->getClientOriginalName(),
        'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
        'ext' => pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION),
      ]
    ];
  }

  public static function csvReader($file, $separated = ",", $ignoreFirstLine = true)
  {
    try {
      $csv = public_path() . "" . $file;

      $rows = array();
      if (($handle = fopen($csv, "r")) !== FALSE) {
        $i = 0;
        while (($data = fgetcsv($handle, null, "$separated")) !== FALSE) {
          $i++;
          if ($ignoreFirstLine && $i == 1) {
            continue;
          }
          $rows[] = $data;
        }
        fclose($handle);
      }

      return $rows;
    } catch (Exception $e) {
      $response['error'] = 1;
      $response['msg'] = $e->getMessage();
      return $response;
    }
  }

  public static function checkPredikat($val)
  {
    if ($val == null) return null;
    elseif ($val > 89) return 'A';
    elseif ($val > 79) return 'B';
    elseif ($val > 69) return 'C';
    else return 'D';
  }

  public static function integerToRoman($integer)
  {
    // Convert the integer into an integer (just to make sure)
    $integer = intval($integer);
    $result = '';

    // Create a lookup array that contains all of the Roman numerals.
    $lookup = array(
      'M' => 1000,
      'CM' => 900,
      'D' => 500,
      'CD' => 400,
      'C' => 100,
      'XC' => 90,
      'L' => 50,
      'XL' => 40,
      'X' => 10,
      'IX' => 9,
      'V' => 5,
      'IV' => 4,
      'I' => 1
    );

    foreach ($lookup as $roman => $value) {
      // Determine the number of matches
      $matches = intval($integer / $value);

      // Add the same number of characters to the string
      $result .= str_repeat($roman, $matches);

      // Set the integer to be the remainder of the integer and the value
      $integer = $integer % $value;
    }

    // The Roman numeral should be built, return it
    return $result;
  }
}
