<?php

namespace WARP\CC\app\make\makers\module;
use \WARP\CC\app\make\Make,
    \WARP\CC\app\make\makers\Base;

class Module extends Base {

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
   * Main function to execute make process
   */
  public function make() { try {

    // 1. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $fs = warp_fs_manager();

    // 2. Copy template directory
    // - From 'vendor/warpcomplex/warp/other/templates/module/module'
    // - To 'warp/modules/$this->resource->module_name'
    if(!$fs->copyDirectory( "vendor/warpcomplex/warp/other/templates/module/module",
                        "warp/modules/".$this->resource->module_name))
      throw new \Exception("Can't copy template directory from 'vendor/warpcomplex/warp/other/templates/module/module'");

    // 3. Copy new module config file (if it's not already there)
    // - From 'warp/modules/$this->resource->module_name/config.default.php'
    // - To 'config/warp/modules/'.$this->resource->module_name
    if(!$fs->exists('config/warp/modules/'.$this->resource->module_name.'.php')) {
      if(!$fs->copy('warp/modules/'.$this->resource->module_name.'/config.default.php',
                'config/warp/modules/'.$this->resource->module_name.'.php'))
        throw new \Exception("Can't copy new module config file");
    }

    // 4. Change file-workbench-model name
    // - From 'warp/modules/$this->resource->module_name/other/workbench/({[module_name]}).mwb'
    // - To 'warp/modules/$this->resource->module_name/other/workbench/$this->resource->module_name.mwb'
    if(!$fs->move('warp/modules/'.$this->resource->module_name.'/other/workbench/({[module_name]}).mwb',
              'warp/modules/'.$this->resource->module_name.'/other/workbench/'.$this->resource->module_name.'.mwb'))
      throw new \Exception("Can't change file-workbench-model name");

    // 5. Find and replace all placeholders in all files

      // 5.1. Prepare placeholder and file names
      $data = [
        'module_name' => [
          'warp/modules/'.$this->resource->module_name.'/app/App.php',
          'warp/modules/'.$this->resource->module_name.'/app/interfaces/iApp.php',
          'warp/modules/'.$this->resource->module_name.'/providers/General.php',
          'warp/modules/'.$this->resource->module_name.'/providers/Gates.php',
          'warp/modules/'.$this->resource->module_name.'/readme.md',
          'config/warp/modules/'.$this->resource->module_name.'.php'
        ],
        'module_description' => [
          'warp/modules/'.$this->resource->module_name.'/readme.md'
        ]
      ];

      // 5.2. Find and replace
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

    // 6. Unset $fs
    unset($fs);

    // 7. Notify about successful resource creation
    $this->output->info("Module '".$this->resource->module_name."' has been created successfully!");

  } catch(\Exception $e) {

    // 1. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $fs = warp_fs_manager();

    // 2. Delete if exists 'warp/modules/$this->resource->module_name'
    if($fs->exists('warp/modules/'.$this->resource->module_name)) {
      $fs->deleteDirectory('warp/modules/'.$this->resource->module_name);
    }

    // 3. Delete if exists 'config/warp/modules/$this->resource->module_name'
    if($fs->exists('config/warp/modules/'.$this->resource->module_name.'.php')) {
      $fs->delete('config/warp/modules/'.$this->resource->module_name.'.php');
    }

    // n. Unset $fs
    unset($fs);

    // m. Call default exception handler for $e
    throw $e;

  }}

}
