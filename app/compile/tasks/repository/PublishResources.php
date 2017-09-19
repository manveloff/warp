<?php

namespace WARP\CC\app\compile\tasks\repository;
use WARP\CC\app\compile\tasks\BaseTask,
    WARP\CC\app\compile\tasks\iTask,
    Illuminate\Support\Facades\Artisan;

class PublishResources extends BaseTask implements iTask {

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
   * Publish all WARP application resources
   */
  public function task(){

    // 1. Notify about synchronization SP registrations start

      // Log
      $this->log->logger->info("\n");
      $this->log->logger->info("  All WARP application resources publishing");

      // Output
      $this->output->info("");
      $this->output->comment("  All WARP application resources publishing");

    // 2. Publish all WARP resources
    $result = Artisan::call('vendor:publish', ['--tag' => ['warp'], '--force' => true]);

    // 3. Notify about synchronization SP registrations emd

      // Log
      $this->log->logger->info("  Ready.");

      // Output
      $this->output->line("  Ready.");


  }



} 