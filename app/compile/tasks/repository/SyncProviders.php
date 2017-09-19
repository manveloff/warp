<?php

namespace WARP\CC\app\compile\tasks\repository;
use WARP\CC\app\compile\tasks\BaseTask,
    WARP\CC\app\compile\tasks\iTask;

class SyncProviders extends BaseTask implements iTask {

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
   * Synchronize service provider registrations
   */
  public function task(){

    // 1. Notify about synchronization SP registrations start

      // Log
      $this->log->logger->info("\n");
      $this->log->logger->info("  Service provider registrations synchronization");

      // Output
      $this->output->info("");
      $this->output->comment("  Service provider registrations synchronization");

    // 2. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $fs = warp_fs_manager();

    // 3. Get current list of SP registrations from app.php config
    // - And filter out from it all WARP SP registrations (all that's begin with 'WARP\modules')
    $providers = collect(array_values(array_filter(config('app.providers'), function($item){
      if(preg_match("#^WARP\\\\modules#ui", $item)) return false;
      else return true;
    })))->map(function($element){
      return basename($element) . '::class';
    })->toArray();

    // 4. Get list of fully qualified sp names of all WARP modules
    $warpProviders = (function() USE (&$fs) {

      // 1] Prepare array for results
      $warpProviders = [];

      // 2] Get modules list
      $modules = collect($fs->directories('warp/modules'))->map(function($element){
        return basename($element);
      })->toArray();

      // 3] Fill $warpProviders array
      foreach($modules as $module) {

        // 3.1] Get all $module provider names without '.php'
        // - Set General provider at 0 position, and Gates at 1-st position
        $providerNames = collect($fs->files("warp/modules/$module/providers"))->map(function($element){
          return preg_replace("/.php$/ui", "", basename($element));
        })->filter(function($value, $key){
          return !in_array($value, ["General", "Gates"]);
        })->toArray();
        array_unshift($providerNames, 'Gates');
        array_unshift($providerNames, 'General');

        // 3.2] Add new values to $warpProviders
        foreach($providerNames as $providerName) {
          array_push($warpProviders, "WARP\\modules\\$module\\providers\\$providerName::class");
        }

      }

      // n] Return results
      return $warpProviders;

    })();

    // 5. Add $warpProviders to the end of $providers
    $finalProviders = array_values(array_merge($providers, $warpProviders));

    // 6. Insert $finalProviders to app.php config
    (function() USE (&$fs, &$finalProviders) {

      // 1] Get app.php content
      $config = $fs->get('config/app.php');

      // 2] Form a string to insert
      $providersStr = call_user_func(function() USE ($finalProviders) {

        // 2.1] Prepare a string for result
        $result = "[" . PHP_EOL;

        // 2.2] Insert to $result all values from $finalProviders
        for($i=0; $i<count($finalProviders); $i++) {
          if($i != count($finalProviders)-1 )
            $result = $result . "        " . $finalProviders[$i] . "," . PHP_EOL;
          else
            $result = $result . "        " . $finalProviders[$i] . "" . PHP_EOL;
        }

        // 2.3] Finish by square bracket with comma
        $result = $result . "    ],";

        // 2.4] Return result
        return $result;

      });

      // 3] Insert $providersStr to $config
      $config = preg_replace("#'providers' *=> *\[.*\],#smuiU", "'providers' => ".$providersStr, $config);

      // 4] Write down $config to $fs
      $fs->put('config/app.php', $config);

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