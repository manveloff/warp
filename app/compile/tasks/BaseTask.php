<?php

namespace WARP\CC\app\compile\tasks;

class BaseTask {

//------//
// Main //
//------//

  /**
   * Constants
   */


  /**
   * Output
   */
  public $output;

  /**
   * Logger
   */
  public $log;

  /**
   * The class constructor
   */
  public function __construct(&$log, &$output) {
    $this->log = $log;
    $this->output = $output;
  }

} 