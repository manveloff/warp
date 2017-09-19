<?php

namespace WARP\CC\app\remove\removers\module;
use \WARP\CC\app\remove\Remove,
    \WARP\CC\app\remove\removers\Base;

class Model extends Base {

//---------//
// General //
//---------//

  /**
   * Class constructor
   */
  public function __construct(&$output, $resource) {

    // Invoke base class constructor
    parent::__construct($output, $resource);

  }

  /**
   * Main function to execute remove process
   */
  public function remove() { try {

    // 1. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $fs = warp_fs_manager();

    // 2. Remove model file
    if($fs->exists('warp/modules/'.$this->resource->module_name.'/models/'.$this->resource->model_name)) {
      if(!$fs->delete('warp/modules/'.$this->resource->module_name.'/models/'.$this->resource->model_name))
        throw new \Exception("Can't find model to remove in the module");
    }

    // m. Unset $fs
    unset($fs);

    // n. Notify about successful resource remove
    $this->output->info("Model '".$this->resource->model_name."' has been removed from the module '".$this->resource->module_name."' successfully!");

  } catch(\Exception $e) {

    // 1. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $fs = warp_fs_manager();


    // n. Unset $fs
    unset($fs);

    // m. Call default exception handler for $e
    throw $e;

  }}


//---------------//
// Maker methods //
//---------------//



}
