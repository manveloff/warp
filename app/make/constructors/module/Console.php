<?php

namespace WARP\CC\app\make\constructors\module;
use \WARP\CC\app\make\Make,
    \WARP\CC\app\make\constructors\Base,
    \WARP\CC\app\make\Validators;

class Console extends Base {

//---------//
// General //
//---------//

  public function __construct(&$output) {

    // Invoke base class constructor
    parent::__construct($output);

    // Set this constructor methods to iterator array
    $this->array = [
      'get_module_name',
      'get_cmd_name',
      'get_cmd_description'
    ];

  }


//------------------//
// Constructor data //
//------------------//

  /** @var string Name of the module */
  public $module_name;

  /** @var string Name of the cmd*/
  public $cmd_name;
  public $cmd_name_lowcase;

  /** @var string Description of the cmd */
  public $cmd_description;


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
    $result = mb_strtolower($this->output->choice("Module to add job", $modules));

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
   * Get the cmd name
   */
  protected function get_cmd_name() {

    // Ask user about module name
    $result = warp_mb_ucfirst(mb_strtolower($this->output->ask("New artisan command name (in english)")));

    // Check if there is already any cmd with such name in the specified module
    $validation = Validators::cmd_name($result, $this->module_name);

    // If not valid, ask to input data again
    if(!$validation['is_valid']) {
      $this->output->comment($validation['msg']);
      return $this->done(Make::EDIT);
    }

    // Write down the $result
    $this->cmd_name = $result;
    $this->cmd_name_lowcase = mb_strtolower($result);

    // Else continue
    return $this->done();

  }

  /**
   * Get the cmd description
   */
  protected function get_cmd_description() {

    // Ask user about module name
    $result = warp_mb_ucfirst(mb_strtolower($this->output->ask("New artisan command description (in english)")));

    // Write down the $result
    $this->cmd_description = $result;

    // Else continue
    return $this->done();

  }

}
