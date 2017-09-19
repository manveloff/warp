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
  public static function compiler(&$output, $array = []) {

    return new \WARP\CC\app\compile\Compiler($output, $array);

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
  public static function makeStructure(&$output, &$log = NULL) {

    // 1. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $fs = warp_fs_manager();

    // 2. Prepare function creating catalogue if it is not exists
    $makeDirectory = function(&$fs, $path) USE ($log, $output) {
      if(!$fs->exists($path)) {

        // Make directory
        $result = $fs->makeDirectory($path);

        // Return true
        return true;

      }
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

      // 4.1. Notify about structure making start

        // Log
        if(!empty($log)) {
          $log->logger->info("\n");
          $log->logger->info("  WARP structure synchronization");
        }

        // Output
        $output->info("");
        $output->comment("  WARP structure synchronization");

      // 4.2. Check all
      $count = 0;
      foreach($paths as $path) {
        if($makeDirectory($fs, $path) === true) {
          $count++;
          $output->line("  -> $path");
          if(!empty($log)) $log->logger->info("  -> $path");
        }
      }
      if($count === 0) {
        $output->line("  Nothing to synchronize.");
        if(!empty($log)) $log->logger->info("  Nothing to synchronize.");
      }

    // 5. Unset $fs
    unset($fs);

  }


}
