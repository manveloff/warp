<?php

namespace WARP\CC\app\remove\removers;
use \WARP\CC\app\remove\Remove;

class Base {

//------//
// Main //
//------//

  /**
   * Output interface
   */
  protected $output;

  /**
   * Resource to make
   */
  protected $resource;

  /**
   * The class constructor
   */
  public function __construct(&$output, &$resource) {
    $this->output = $output;
    $this->resource = $resource;
  }

}
