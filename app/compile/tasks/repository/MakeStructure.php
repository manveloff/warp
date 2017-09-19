<?php

namespace WARP\CC\app\compile\tasks\repository;
use WARP\CC\app\compile\tasks\BaseTask,
    WARP\CC\app\compile\tasks\iTask;

class MakeStructure extends BaseTask implements iTask {

//---------//
// General //
//---------//

  /**
   * The class constructor
   */
  public function __construct(&$log, &$output) {

    // Invoke base class constructor
    parent::__construct($log, $output);

  }

//-----------//
// Task data //
//-----------//

//--------------//
// Task methods //
//--------------//

  /**
   * The main task method
   * Sync WARP application structure
   */
  public function task(){

    // Sync WARP application structure
    \WARP::makeStructure($this->output, $this->log);

  }

}