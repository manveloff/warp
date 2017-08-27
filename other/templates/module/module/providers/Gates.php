<?php
/**
 *
 * Gates Service Provider of the module
 *
 */

namespace WARP\modules\({[module_name]})\providers;
use Illuminate\Support\ServiceProvider,
    Illuminate\Contracts\Events\Dispatcher,
    Illuminate\Support\Facades\Gate;

class Gates extends ServiceProvider {

  /**
   * boot
   */
  public function boot() {

    /**
     * [DEMO] Can the user change the post or not?
     */
    //Gate::define('update-post', function ($user, $post) {
    //  return $user->id == $post->user_id;
    //});

  }

  /**
   * register
   */
  public function register() {}

}