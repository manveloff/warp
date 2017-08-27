<?php

namespace WARP\CC\app\make\constructors\module;
use \WARP\CC\app\make\Make,
    \WARP\CC\app\make\constructors\Base,
    \WARP\CC\app\make\Validators;

class Listener extends Base {

//---------//
// General //
//---------//

  public function __construct(&$output) {

    // Invoke base class constructor
    parent::__construct($output);

    // Set this constructor methods to iterator array
    $this->array = [
      'one',
      'two',
      'three'
    ];

  }


//------------------//
// Constructor data //
//------------------//




//---------------------//
// Constructor methods //
//---------------------//

  /**
   * One
   */
  protected function one() {

    $this->output->line('one');
    if($this->output->confirm('restart?')) return Make::RESTART;

  }

  /**
   * Two
   */
  protected function two() {

    $this->output->line('two');
    if($this->output->confirm('Back?')) return $this->back($this->output);

  }

  /**
   * Three
   */
  protected function three() {

    $this->output->line('three');

  }

}
