<?php
/**
 *
 * General Service Provider of the module
 *
 */

namespace WARP\modules\({[module_name]})\providers;
use Illuminate\Support\ServiceProvider,
    Illuminate\Contracts\Events\Dispatcher;

class General extends ServiceProvider {

  /**
   * boot
   */
  public function boot(Dispatcher $events, \Illuminate\Contracts\Http\Kernel $kernel) {

    // 1. Publish config
    if(!file_exists(config_path('warp/modules/({[module_name]}).php'))) {
      $this->publishes([
          realpath(__DIR__ . '/../../config.default.php') =>
          config_path('warp/modules/({[module_name]}).php'),
      ], 'warp');
    }

    // 2. Register listeners
    // - Example: 'WARP\listeners\<listener name>' => 'WARP\other\events\Event'

      // Listener pairs
      $listeners = [

      ];

      // Register $listeners
      foreach($listeners as $listener => $event) {
        $events->listen($event, $listener);
      }

    // 3. Publish localization files to 'resources/lang/<locale>'

      // ru
      $this->publishes([
        realpath(__DIR__ . '/../other/localization/ru/localization.php') => resource_path('lang/ru/warp.php'),
      ], 'warp');

      // en
      $this->publishes([
        realpath(__DIR__ . '/../other/localization/en/localization.php') => resource_path('lang/en/warp.php'),
      ], 'warp');

  }

  /**
   * register
   */
  public function register() {

    // 1. Register console artisan commands
    // - Example: '\WARP\console\<command name>',

      // Commands to register
      $commands = [

      ];

      // Register $commands
      $this->commands($commands);

    /**
     * !!! ATTENTION !!!
     * There is no way in Laravel to register tasks in service providers from the box.
     * But the hub has appropriate method.
     * That's why after you change $tasks, you have to invoke this method or method compile,
     * for the changes to take effect.
     *
     */
    // 2. Register tasks on scheduler
    // - Use console artisan commands as tasks.
    // - Look about cron format here: http://www.nncron.ru/help/EN/working/cron-format.htm
    // - Reference:
    //
    //    ->cron('* * * * * *');	        | Run the task on a custom Cron schedule
    //    ->everyMinute();	              | Run the task every minute
    //    ->everyFiveMinutes();	          | Run the task every five minutes
    //    ->everyTenMinutes();	          | Run the task every ten minutes
    //    ->everyThirtyMinutes();	        | Run the task every thirty minutes
    //    ->hourly();	                    | Run the task every hour
    //    ->hourlyAt(17);	                | Run the task every hour at 17 mins past the hour
    //    ->daily();	                    | Run the task every day at midnight
    //    ->dailyAt('13:00');	            | Run the task every day at 13:00
    //    ->twiceDaily(1, 13);	          | Run the task daily at 1:00 & 13:00
    //    ->weekly();	                    | Run the task every week
    //    ->monthly();	                  | Run the task every month
    //    ->monthlyOn(4, '15:00');	      | Run the task every month on the 4th at 15:00
    //    ->quarterly();	                | Run the task every quarter
    //    ->yearly();	                    | Run the task every year
    //    ->timezone('America/New_York');	| Set the timezone
    //
    // - Examples:
    //
    //    $schedule->command("task")->withoutOverlapping()->hourly();                        | every hour
    //    $schedule->command("task")->withoutOverlapping()->cron("0,15,30,45 * * * * *");    | each 15 minutes
    //
    //
    //
    $tasks = [

    ];

  }

}