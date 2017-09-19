<?php

namespace WARP\CC\app\make\makers\module;
use \WARP\CC\app\make\Make,
    \WARP\CC\app\make\makers\Base;

class Model extends Base {

//---------//
// General //
//---------//

  /**
   * Class constructor
   */
  public function __construct(&$output, $resource, $silent = false) {

    // Invoke base class constructor
    parent::__construct($output, $resource);

    // Assign silent property
    $this->silent = $silent;

  }

  /**
   * Turn on/off silent mode
   */
  protected $silent;

  /**
   * Main function to execute make process
   */
  public function make() {

    // 1. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $fs = warp_fs_manager();

    // 2. Copy template file
    // - From 'vendor/warpcomplex/warp/other/templates/module/Model.php'
    // - To 'warp/modules/$this->resource->module_name/models/$this->resource->model_name.php'
    if(!$fs->copy( "vendor/warpcomplex/warp/other/templates/module/Model.php",
                   "warp/modules/".$this->resource->module_name."/models/".$this->resource->model_name.".php"))
      throw new \Exception("Can't copy template model from 'vendor/warpcomplex/warp/other/templates/module/Model.php'");

    // 3. Find and replace all placeholders in all files

      // 3.1. Prepare placeholder and file names
      $data = [
        'module_name' => [
          'warp/modules/'.$this->resource->module_name.'/models/'.$this->resource->model_name.".php",
        ],
        'model_name' => [
          'warp/modules/'.$this->resource->module_name.'/models/'.$this->resource->model_name.".php",
        ],
        'is_timestamps_auto_maintenance_on' => [
          'warp/modules/'.$this->resource->module_name.'/models/'.$this->resource->model_name.".php",
        ],
        'is_soft_deletes_on' => [
          'warp/modules/'.$this->resource->module_name.'/models/'.$this->resource->model_name.".php",
        ],
        'relationships' => [
          'warp/modules/'.$this->resource->module_name.'/models/'.$this->resource->model_name.".php",
        ],
      ];

      // 3.2. Find and replace
      foreach($data as $parameter => $value) {
        foreach($data[$parameter] as $path) {

          // Extract file content
          $file = $fs->get($path);

          // Find and replace placeholders
          $file = preg_replace("/\(\{\[".$parameter."\]\}\)/ui", $this->resource->{$parameter}, $file);

          // 4] Перезаписать файл
          $fs->put($path, $file);

        }
      }

    // m. Unset $fs
    unset($fs);

    // n. Notify about successful resource creation
    // - Only if silent = false
    if($this->silent === false)
      $this->output->info("Model '".$this->resource->model_name."' in module '".$this->resource->module_name."' has been created successfully!");

  }


//---------------//
// Maker methods //
//---------------//




}
