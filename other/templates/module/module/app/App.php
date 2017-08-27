<?php

namespace WARP\modules\({[module_name]});
use WARP\modules\({[module_name]})\interfaces\iApp;

/**
 *
 * WARP Project Control Center (aka hub) entry point
 *
 */
class App implements iApp {

  /** @var string|null WARP version */
  public static $version = '5.4.0';

  /**
   * The class constructor
   */
  public function __construct() {

  }

  /**
   * Get current WARP version
   */
  public static function version() {
    return self::$version;
  }



}
