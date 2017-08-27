<?php

namespace WARP\CC\app\make\makers;
use \WARP\CC\app\make\Make;

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
