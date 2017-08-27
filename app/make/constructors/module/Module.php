<?php

namespace WARP\CC\app\make\constructors\module;
use \WARP\CC\app\make\Make,
    \WARP\CC\app\make\constructors\Base,
    \WARP\CC\app\make\Validators;

class Module extends Base {

//---------//
// General //
//---------//

  public function __construct(&$output) {

    // Invoke base class constructor
    parent::__construct($output);

    // Set this constructor methods to iterator array
    $this->array = [
      'get_module_name',
      'get_module_description'
    ];

  }


//------------------//
// Constructor data //
//------------------//

  /** @var string Name of the module */
  public $module_name;

  /** @var string Description of the module */
  public $module_description;


//---------------------//
// Constructor methods //
//---------------------//

  /**
   * Get new module name
   */
  protected function get_module_name() {

    // Ask user about module name
    $result = mb_strtolower($this->output->ask("New module name (in english)"));

    // Check if there is already a module with such name
    $validation = Validators::module_name($result);

    // If not valid, ask to input data again
    if(!$validation['is_valid']) {
      $this->output->comment($validation['msg']);
      return $this->done(Make::EDIT);
    }

    // Write down the $result
    $this->module_name = $result;

    // Else continue
    return $this->done();

  }

  /**
   * Get new module description
   */
  protected function get_module_description() {

    // Ask user about module name
    $result = warp_mb_ucfirst(mb_strtolower($this->output->ask("New module description (in english)")));

    // Write down the $result
    $this->module_description = $result;

    // Else continue
    return $this->done();

  }


}
