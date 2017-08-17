<?php
/**
 *
 * Job for testing warp_job helper
 *
 */

namespace WARP\jobs;
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

class Test {

  /**
   * Add several traits
   */
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * @var array Accept incoming data
   */
  public $data;

  /**
   * The class constructor
   * @param string $data Test param
   */
  public function __construct($data) {

    // Accept incoming data to $data
    $this->data = $data;

  }

  /**
   * The job handler
   *
   *  1. ...
   *
   *  n. Return results
   *
   */
  public function handle() { $res = call_user_func(function() { try { //DB::beginTransaction();



    // TODO: job code



    // n. Return results
    return [
      "success" => true,
      "data"    => [],
    ];

   } catch(\Exception $e) {
    DB::rollback();
    $errortext = 'Invoking of command Test from WARP package have ended on line "'.$e->getLine().'" on file "'.$e->getFile().'" with error: '.$e->getMessage();
    Log::info($errortext);
    return [
      "success" => false,
      "data"    => [],
      "error"   => [
        "full"    => $errortext,
        "msg"     => $e->getMessage()
      ]
    ];
  }}); if(!empty($res)) return $res;
  return [
    "success" => true,
    "data"    => []
  ];}

}

?>

