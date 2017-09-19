<?php

namespace WARP\CC\app\compile\tasks\repository;
use WARP\CC\app\compile\tasks\BaseTask,
    WARP\CC\app\compile\tasks\iTask;

class SyncSchedule extends BaseTask implements iTask {

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
   * Synchronize WARP tasks in Laravel scheduler
   */
  public function task(){

    // 1. Notify about synchronization SP registrations start

      // Log
      $this->log->logger->info("\n");
      $this->log->logger->info("  WARP tasks in Laravel scheduler synchronization");

      // Output
      $this->output->info("");
      $this->output->comment("  WARP tasks in Laravel scheduler synchronization");

    // 2. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $fs = warp_fs_manager();

    // 3. Get schedule tasks from "General" service providers of all WARP modules
    $warpTasks = (function() USE ($fs) {

      // 1] Prepare array for WARP schedule tasks
      $warpScheduleTasks = [];

      // 2] Get modules list
      $modules = collect($fs->directories('warp/modules'))->map(function($element){
        return basename($element);
      })->toArray();

      // 3] Fill $warpProviders array
      foreach($modules as $module) {

        // 3.1] Check if "General" service provider in $module exists
        if(!$fs->exists("warp/modules/$module/providers/General.php"))
          throw new \Exception("There is no necessary service provider 'General' in module ".$module."!");

        // 3.2] Get content of "General" service provider of $module
        $content = $fs->get("warp/modules/$module/providers/General.php");

        // 3.3] Get $tasks from $content
        $tasks = (function() USE ($content) {
          $tasks_temp = [];
          preg_match('#\$tasks = \[.*\];#smuiU', $content, $tasks_temp);
          return eval($tasks_temp[0].' return $tasks; ');
        })();

        // 3.4] Add $tasks to $warpScheduleTasks without repeats
        foreach($tasks as $task) {
          if(!in_array($task, $warpScheduleTasks)) array_push($warpScheduleTasks, $task);
        }

      }

      // 4] Return result
      return $warpScheduleTasks;

    })();

    // 4. Get content of Kernel.php
    $kernel = $fs->get('app/Console/Kernel.php');

    // 5. Get current task list from scheduler, marked as 'warp task'
    $scheduleTasks = (function() USE ($fs, $kernel) {

      // 1] Prepare array for results
      $scheduleTasks = [];

      // 2] Get tasks without marks
      preg_match_all("#.* *// *warp task#ui", $kernel, $scheduleTasksTemp, PREG_SET_ORDER);
      foreach($scheduleTasksTemp as &$elem) {
        $elem[0] = preg_replace("/^ */ui", '', $elem[0]);
        $elem[0] = preg_replace("# *// *warp task.*$#sui", '', $elem[0]);
      };
      for($i=0; $i<count($scheduleTasksTemp); $i++) {
        if(!in_array($scheduleTasksTemp[$i][0], $scheduleTasks))
          array_push($scheduleTasks, $scheduleTasksTemp[$i][0]);
      }

      // 3] Return result
      return $scheduleTasks;

    })();

    // 6. Get task list that should be deleted from scheduler
    $str2del = array_values(array_diff($scheduleTasks, $warpTasks));

    // 7. Get task list that should be left
    $str2leave = array_values(array_intersect($scheduleTasks, $warpTasks));

    // 8. Get task list that should be added to scheduler
    $str2add = [];
    foreach($warpTasks as $item) {
      if(!in_array($item, $str2del) && !in_array($item, $str2leave))
        array_push($str2add, $item);
    }

    // 8. Remove $str2leave from $kernel
    foreach($str2del as $del) {

      $del = $del . " // warp task";
      $del = preg_quote($del);
      $kernel = preg_replace("#$del#ui", '', $kernel);

    }

    // 9. Add $str2add strings to the end of "schedule" method in $kernel
    (function() USE ($fs, $kernel, $str2add) {

      // 1] Get "schedule" method content from $kernel as a string
      preg_match("/protected function schedule\(Schedule .{1}schedule\).*{.*}/smuiU", $kernel, $schedule_str);
      $schedule_str = $schedule_str[0];
      $schedule_str = preg_replace("/[{}]/smuiU", '', $schedule_str);
      $schedule_str = preg_replace("/protected function schedule\(Schedule .{1}schedule\)/smuiU", '', $schedule_str);
      $schedule_str = preg_replace("/^[\s\t]*(\r\n|\n)/smuiU", '', $schedule_str);
      $schedule_str = PHP_EOL . $schedule_str . PHP_EOL;

      // 2] Form string in format of method "schedule"

        // 2.1] Begin
        $schedule_result = "protected function schedule(Schedule \$schedule)" . PHP_EOL;

        // 2.2] Add opening curly brace
        $schedule_result = $schedule_result . "    {" . PHP_EOL;

        // 2.3] Add $schedule_str
        $schedule_result = $schedule_result . $schedule_str;

        // 2.4] Add strings from $str2add with warp task at the end
        foreach($str2add as $add) {

          $schedule_result = $schedule_result . "        " . $add . ' // warp task' .  PHP_EOL;

        }

        // 2.5] Add closing curly brace
        $schedule_result = $schedule_result . PHP_EOL . "    }";

      // 3] Insert $schedule_result to $kernel
      $kernel = preg_replace("/protected function schedule\(Schedule .{1}schedule\).*{.*}/smuiU", $schedule_result, $kernel);

      // 4] Replace $kernel
      $fs->put('app/Console/Kernel.php', $kernel);

    })();

    // n. Unset $fs
    unset($fs);

    // m. Notify about synchronization SP registrations emd

      // Log
      $this->log->logger->info("  Ready.");

      // Output
      $this->output->line("  Ready.");


  }



} 