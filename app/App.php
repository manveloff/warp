<?php

namespace WARP\CC\app;

/**
 *
 * WARP Project Control Center (aka hub) entry point
 *
 */
class App {

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

  /**
   * Invoke all necessary install operations
   */
  public static function install() {



  }

  /**
   * Invoke all necessary uninstall operations
   */
  public static function uninstall($del_schema = false) {



  }

  /**
   * Make compiler
   */
  public static function compiler($del_schema = false) {

    return new \WARP\CC\app\compile\Compiler();

  }

  /**
   * Make Make
   */
  public static function make(&$output) {

    return new \WARP\CC\app\make\Make($output);

  }

  /**
   * Make Remove
   */
  public static function remove(&$output) {

    return new \WARP\CC\app\remove\Remove($output);

  }

  /**
   * Sync WARP application structure
   */
  public static function makeStructure(&$output) {

    // 1. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $fs = warp_fs_manager();

    // 2. Prepare function creating catalogue if it is not exists
    $makeDirectory = function(&$fs, $path){
      if(!$fs->exists($path))
        $fs->makeDirectory($path);
    };

    // 3. Prepare array with path list to check
    $paths = [
      'config/warp',
      'config/warp/modules',
      'config/warp/slots',
      'config/warp/connectors',
      'warp',
      'warp/modules',
      'warp/slots',
      'warp/connectors',
      'storage/warp'
    ];

    // 4. Check all
    foreach($paths as $path) {
      $makeDirectory($fs, $path);
    }

    // 5. Unset $fs
    unset($fs);

  }


}
