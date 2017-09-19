<?php

namespace WARP\CC\app\compile;
use WARP\CC\app\compile\BaseCompiler,
    WARP\CC\app\compile\log\Log;

/**
 *
 * Compiler
 *
 */
class Compiler extends BaseCompiler implements \SeekableIterator {

//---------//
// General //
//---------//

  public function __construct(&$output, $array = []) {

    // Invoke base class constructor
    parent::__construct($output);

    // Set this constructor methods to iterator array

      // If there is no special list of tasks passed
      if(empty($array))
        $this->array = self::$arrayStandard;

      // If there is special list of tasks passed
      else {

        // Filter out from $array items that absent in $arrayStandard
        $filtered_array1 = array_values(array_intersect(self::$arrayStandard, $array));

        // Filter out from $filtered_array1 items that absent in tasks/list catalogue
        $filtered_array2 = collect($filtered_array1)
          ->filter(function ($value, $key) {

            // 1. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
            $fs = warp_fs_manager();

            // 2. Get array of all installed module names
            $tasks = collect($fs->directories('vendor/warpcomplex/warp/app/compile/tasks/list'))->map(function($element){
              return basename($element);
            })->toArray();

            // 3. Unset $fs
            unset($fs);

            // 4. Return
            return in_array($value.'.php', $tasks);

          })
          ->toArray();

        // Write down $filtered_array2
        $this->array = $filtered_array2;

      }

    // Create new logger instance
    $this->log = new Log(base_path() . '/storage/warp/compilation.log', $this->output);

  }

//---------------//
// Compiler data //
//---------------//

  /** @var array Array of standard compilation task names */
  public static $arrayStandard = [
    'MakeStructure',        // Make sure that WARP app structure is present
    'SyncProviders',        // Synchronize service provider registrations
    'PublishResources',     // Publish all WARP application resources
    'SyncSchedule',         // Synchronize WARP tasks in Laravel scheduler
    'SyncEloquentModels',   // Synchronize all Laravel eloquent models of WARP application
    //'SyncSlots',            // Looking for and using suitable implementation for all WARP application slots
    //'SyncConnectors',       // Looking for and using suitable implementation for all WARP application connectors
    //'ExecuteTests'          // Execute all WARP application tests
  ];

  /** Logger instance */
  public $log;


//------------------//
// Compiler methods //
//------------------//

  /**
   * Start compilation process
   */
  public function compile() { try {

    // Make start note to the log
    $this->log->start();

    // Invoke compilation tasks one by one
    foreach($this as $key => $value) {

      // Create $value class task instance
      $taskClass = "\\WARP\\CC\\app\\compile\\tasks\\repository\\$value";
      $task = new $taskClass($this->log, $this->output);

      // Call "task" method
      $task->task();

    }

    // Call finish method
    $this->success();

  } catch (\Exception $e) {

    // Call failure method
    $this->failure($e);

    // Call default exception handler for $e
    throw $e;

  }}

  /**
   * End compilation process with error
   */
  protected function failure(&$e) {

    // Make failure note to the log
    $this->log->endFailure($e);

  }

  /**
   * End compilation process with success
   */
  protected function success() {

    // Make success note to the log
    $this->log->endSuccess();

  }

}
