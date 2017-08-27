<?php
/**
 *
 * Validators Service Provider of the hub
 * Custom validation rules
 * Table of contents:
 *
 *  r4_numpos           | must be a positive integer
 *  r4_numnn            | must be not negative positive integer
 *  r4_defined          | Must be not undefined
 *  r4_true             | must be true (not 1 or '1', only true)
 *  r4_false            | must be false (not 0 or '0', only false)
 *  r4_min:min          | number must be more or equal than min
 *  r4_max:max          | number must be less or equal than max
 *  r4_between:min,max  | number must be between min and max (inclusive)
 *
 */

namespace WARP\CC\providers;
use Illuminate\Support\ServiceProvider,
    Illuminate\Contracts\Events\Dispatcher,
    Illuminate\Support\Facades\Validator,
    Illuminate\Support\Facades\Event;

class Validators extends ServiceProvider {

  /**
   * boot
   */
  public function boot(Dispatcher $events, \Illuminate\Contracts\Http\Kernel $kernel) {

    Validator::extend('r4_numpos', function($attribute, $value, $parameters) {

      return preg_match("/^[1-9]+[0-9]*$/ui", $value);

    }, ":attribute must be a positive integer");


    Validator::extend('r4_numnn', function($attribute, $value, $parameters) {

      return preg_match("/^[0-9]+$/ui", $value);

    }, ":attribute must be not negative positive integer");


    Validator::extend('r4_defined', function($attribute, $value, $parameters) {

      return isset($value);

    }, ":attribute must be not undefined");


    Validator::extend('r4_true', function($attribute, $value, $parameters) {

      if($value === true) return true;
      return false;

    }, ":attribute must be must be true (not 1 or '1', only true)");


    Validator::extend('r4_false', function($attribute, $value, $parameters) {

      if($value === false) return true;
      return false;

    }, ":attribute must be false (not 0 or '0', only false)");


    Validator::extend('r4_min', function($attribute, $value, $parameters) {

      // 1] Если длина массива $parameters не равна 1, вернуть false
      if(count($parameters) != 1) return false;

      // 2] Получить min
      $min = $parameters[0];

      // 3] Сравнить $value с $min
      if(gmp_cmp($value, $min) < 0) return false;

      // 4] Вернуть true
      return true;

    }, ":attribute must be more or equal than min");


    Validator::extend('r4_max', function($attribute, $value, $parameters) {

      // 1] Если длина массива $parameters не равна 1, вернуть false
      if(count($parameters) != 1) return false;

      // 2] Получить max
      $max = $parameters[1];

      // 3] Сравнить $value с $max
      if(gmp_cmp($max, $value) < 0) return false;

      // 4] Вернуть true
      return true;

    }, ":attribute must be less or equal than max");


    Validator::extend('r4_between', function($attribute, $value, $parameters) {

      // 1] Если длина массива $parameters не равна 2, вернуть false
      if(count($parameters) != 2) return false;

      // 2] Получить min и max
      $min = $parameters[0];
      $max = $parameters[1];

      // 3] Сравнить $value с $min
      if(gmp_cmp($value, $min) < 0) return false;

      // 4] Сравнить $value с $max
      if(gmp_cmp($max, $value) < 0) return false;

      // 5] Вернуть true
      return true;

    }, ":attribute must be between min and max (inclusive)");


  }

  /**
   * register
   */
  public function register() {}

}