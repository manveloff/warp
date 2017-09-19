<?php

namespace WARP\CC\app\make\constructors\module;
use \WARP\CC\app\make\Make,
    \WARP\CC\app\make\constructors\Base,
    \WARP\CC\app\make\Validators;

class Provider extends Base {

//---------//
// General //
//---------//

  public function __construct(&$output) {

    // Invoke base class constructor
    parent::__construct($output);

    // Set this constructor methods to iterator array
    $this->array = [
      'get_module_name',
      'get_sp_name',
      'get_sp_description'
    ];

  }


//------------------//
// Constructor data //
//------------------//


  /** @var string Name of the module */
  public $module_name;

  /** @var string Name of the service provider */
  public $sp_name;

  /** @var string Description of the service provider */
  public $sp_description;


//---------------------//
// Constructor methods //
//---------------------//

  /**
   * Get the module name
   */
  protected function get_module_name() {

    // Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $fs = warp_fs_manager();

    // Get array of all installed module names
    $modules = collect($fs->directories('warp/modules'))->map(function($element){
      return basename($element);
    })->toArray();

    // Ask user about module name
    $result = mb_strtolower($this->output->choice("Module to add service provider", $modules));

    // Check if there is already any module with such name
    $validation = Validators::module_exists($result);

    // If not valid, ask to input data again
    if(!$validation['is_valid']) {
      $this->output->comment($validation['msg']);
      return $this->done(Make::EDIT);
    }

    // Write down the $result
    $this->module_name = $result;

    // Unset $fs
    unset($fs);

    // Else continue
    return $this->done();

  }

  /**
   * Get the sp name
   */
  protected function get_sp_name() {

    // Ask user about module name
    $result = warp_mb_ucfirst(mb_strtolower($this->output->ask("New service provider name (in english)")));

    // Check if there is already any middleware with such name in the specified module
    $validation = Validators::sp_name($result, $this->module_name);

    // If not valid, ask to input data again
    if(!$validation['is_valid']) {
      $this->output->comment($validation['msg']);
      return $this->done(Make::EDIT);
    }

    // Write down the $result
    $this->sp_name = $result;

    // Else continue
    return $this->done();

  }

  /**
   * Get the sp description
   */
  protected function get_sp_description() {

    // Ask user about module name
    $result = warp_mb_ucfirst(mb_strtolower($this->output->ask("New service provider description (in english)")));

    // Write down the $result
    $this->sp_description = $result;

    // Else continue
    return $this->done();

  }

}
