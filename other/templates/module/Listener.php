<?php
/**
 *
 * The Event Listener "({[listener_name]})" of the module "({[module_name]})"
 *
 * ({[listener_description]})
 *
 */

namespace WARP\modules\({[module_name]})\listeners;
use Illuminate\Foundation\Bus\Dispatchable,
    Illuminate\Queue\InteractsWithQueue,
    Illuminate\Bus\Queueable,
    Illuminate\Queue\SerializesModels,
    Illuminate\Contracts\Queue\ShouldQueue,
    Illuminate\Routing\Controller as BaseController,
    Illuminate\Support\Facades\App,
    Illuminate\Support\Facades\Artisan,
    Illuminate\Support\Facades\Auth,
    Illuminate\Support\Facades\Blade,
    Illuminate\Support\Facades\Bus,
    Illuminate\Support\Facades\Cache,
    Illuminate\Support\Facades\Config,
    Illuminate\Support\Facades\Cookie,
    Illuminate\Support\Facades\Crypt,
    Illuminate\Support\Facades\DB,
    Illuminate\Database\Eloquent\Model,
    Illuminate\Support\Facades\Event,
    Illuminate\Support\Facades\File,
    Illuminate\Support\Facades\Hash,
    Illuminate\Support\Facades\Input,
    Illuminate\Foundation\Inspiring,
    Illuminate\Support\Facades\Lang,
    Illuminate\Support\Facades\Log,
    Illuminate\Support\Facades\Mail,
    Illuminate\Support\Facades\Password,
    Illuminate\Support\Facades\Queue,
    Illuminate\Support\Facades\Redirect,
    Illuminate\Support\Facades\Redis,
    Illuminate\Support\Facades\Request,
    Illuminate\Support\Facades\Response,
    Illuminate\Support\Facades\Route,
    Illuminate\Support\Facades\Schema,
    Illuminate\Support\Facades\Session,
    Illuminate\Support\Facades\Storage,
    Illuminate\Support\Facades\URL,
    Illuminate\Support\Facades\Validator,
    Illuminate\Support\Facades\View;

class ({[listener_name]}) {  // write here "implements ShouldQueue" - and then the handler will be added to the task queue, rather than being executed in real time

  /**
   * The listener method
   * Table of contents:
   *
   *  1. ...
   *
   *  n. Commit transaction
   *  m. Return results
   *
   */
  public function listener(&$event) { try { //DB::beginTransaction();


    // 1. ...



    // TODO: listener code



    // n. Commit transaction
    //DB::commit();

    // m. Return results
    return [
      "success" => true,
      "data"    => [],
    ];


  } catch(\Exception $e) {

    // Make rollback
    DB::rollback();

    // Prepare error text
    $errortext = 'Invoking of event listener "({[listener_name]})" in module "({[module_name]})" have ended on line "'.$e->getLine().'" on file "'.$e->getFile().'" with error: '.$e->getMessage();

    // Send $errortext to the Laravel log
    Log::info($errortext);

    // Return answer
    return [
      "success" => false,
      "data"    => [],
      "error"   => [
        "full"    => $errortext,
        "msg"     => $e->getMessage()
      ]
    ];

  }}

  /**
   * The handle method
   */
  public function handle(\WARP\CC\other\events\Event $event) {

    // 1. Get the keys sent with the event
    $eventKeys = $event->data['keys'];

    // 2. Get the keys supported by the listener
    $handlerKeys = [
      "({[listener_keys]})"
    ];

    // 3. If at least 1 of $handlerKeys is in $eventKeys, call the handler.
    $testKeys = array_intersect($handlerKeys, $eventKeys);
    if(!empty($testKeys))
      return $this->listener($event);

  }

}

