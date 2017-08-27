<?php

namespace WARP\CC\app\make\makers\module;
use \WARP\CC\app\make\Make,
    \WARP\CC\app\make\makers\Base;

class Provider extends Base {

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
  public function make() {

    $this->output->line('make');

  }


//---------------//
// Maker methods //
//---------------//

  /**
   * One
   */
  protected function one() {

    $this->output->line('one');

  }


}
