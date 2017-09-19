<?php

namespace WARP\CC\app\make\constructors\module;
use \WARP\CC\app\make\Make,
    \WARP\CC\app\make\constructors\Base,
    \WARP\CC\app\make\Validators;

class Model extends Base {

//---------//
// General //
//---------//

  public function __construct(&$output) {

    // Invoke base class constructor
    parent::__construct($output);

    // Set this constructor methods to iterator array
    $this->array = [
      'get_module_name',
      'get_model_name'
    ];

    // Set default values for some counstructor data
    $this->is_timestamps_auto_maintenance_on = "false";
    $this->is_soft_deletes_on = "";
    $this->relationships = "";

  }


//------------------//
// Constructor data //
//------------------//

  /** @var string Name of the module */
  public $module_name;

  /** @var string Name of the model */
  public $model_name;

  /** @var bool Is timestamps automatic maintenance on/off */
  public $is_timestamps_auto_maintenance_on;

  /** @var string Is soft deletes on */
  public $is_soft_deletes_on;

  /** @var string Local and transmodule relationships of the module */
  public $relationships;


//---------------------//
// Constructor methods //
//---------------------//

  /**
   * None interactive construction
   */
  public function start_non_interactive($data) {

    // 1. Validate
    $validator = warp_validate($data, [

      "module_name"                         => ["regex:/^[a-z1234567890]+$/ui"],
      "model_name"                          => ["regex:/^[a-z1234567890]+$/ui"],
      "is_timestamps_auto_maintenance_on"   => ["in:true,false"],
      "is_soft_deletes_on"                  => ["string"],
      "relationships"                       => ["string"],

    ]); if($validator['status'] == -1) {

      throw new \Exception($validator['data']);

    }

    // 2. Fill object data
    $this->module_name                          = $data['module_name'];
    $this->model_name                           = $data['model_name'];
    $this->is_timestamps_auto_maintenance_on    = $data['is_timestamps_auto_maintenance_on'];
    $this->is_soft_deletes_on                   = $data['is_soft_deletes_on'];
    $this->relationships                        = $data['relationships'];

  }

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
   * Get the model name
   */
  protected function get_model_name() {

    // Ask user about module name
    $result = warp_mb_ucfirst(mb_strtolower($this->output->ask("New model name (in english)")));

    // Check if there is already any model with such name in the specified module
    $validation = Validators::model_name($result, $this->module_name);

    // If not valid, ask to input data again
    if(!$validation['is_valid']) {
      $this->output->comment($validation['msg']);
      return $this->done(Make::EDIT);
    }

    // Write down the $result
    $this->model_name = $result;

    // Else continue
    return $this->done();

  }

}



