<?php

namespace WARP\CC\app\make\constructors\module;
use \WARP\CC\app\make\Make,
    \WARP\CC\app\make\constructors\Base,
    \WARP\CC\app\make\Validators;

class Middleware extends Base {

//---------//
// General //
//---------//

  public function __construct(&$output) {

    // Invoke base class constructor
    parent::__construct($output);

    // Set this constructor methods to iterator array
    $this->array = [
      'get_module_name',
      'get_mw_type',      // 'before' or 'after'
      'get_mw_name',
      'get_mw_description'
    ];

  }


//------------------//
// Constructor data //
//------------------//

  /** @var string Name of the module */
  public $module_name;

  /** @var string Middleware type (Before or After) */
  public $mw_type;

  /** @var string Name of the middleware*/
  public $mw_name;

  /** @var string Description of the middleware */
  public $mw_description;


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
    $result = mb_strtolower($this->output->choice("Module to add middleware", $modules));

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
   * Get the mw type (Before or After)
   */
  protected function get_mw_type() {

    // Ask user about middleware type
    $result = warp_mb_ucfirst(mb_strtolower($this->output->choice("Choose middleware type", [
      'Before',
      'After'
    ])));

    // Write down the $result
    $this->mw_type = $result;

    // Else continue
    return $this->done();

  }

  /**
   * Get the mw name
   */
  protected function get_mw_name() {

    // Ask user about module name
    $result = warp_mb_ucfirst(mb_strtolower($this->output->ask("New middleware name (in english)"))) . $this->mw_type;

    // Check if there is already any middleware with such name in the specified module
    $validation = Validators::mw_name($result, $this->module_name);

    // If not valid, ask to input data again
    if(!$validation['is_valid']) {
      $this->output->comment($validation['msg']);
      return $this->done(Make::EDIT);
    }

    // Write down the $result
    $this->mw_name = $result;

    // Else continue
    return $this->done();

  }

  /**
   * Get the mw description
   */
  protected function get_mw_description() {

    // Ask user about module name
    $result = warp_mb_ucfirst(mb_strtolower($this->output->ask("New middleware description (in english)")));

    // Write down the $result
    $this->mw_description = $result;

    // Else continue
    return $this->done();

  }

}
