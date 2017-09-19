<?php

namespace WARP\CC\app\compile\tasks\repository;
use WARP\CC\app\compile\tasks\BaseTask,
    WARP\CC\app\compile\tasks\iTask;

class SyncSlots extends BaseTask implements iTask {

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
   */
  public function task(){

    $this->output->line(123);

  }



} 