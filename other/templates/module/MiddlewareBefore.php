<?php
/**
 *
 * The Before Middleware "({[mw_name]})" of the module "({[module_name]})"
 *
 * ({[mw_description]})
 *
 */

namespace WARP\modules\({[module_name]})\other\middleware;
use Closure;

class ({[mw_name]}) {

  /**
   * The middleware handler method
   *
   * The request passes through this code before the request is handled by the application.
   * Table of contents:
   *
   *  1. ...
   *
   *  n. Forward reply further
   *
   */
  public function handle($request, Closure $next) {

    // 1. ...


      // TODO: before middleware code


    // n. Forward reply further
    return $next($request);

  }

  /**
   * Terminable middleware
   *
   * This code is executed after the response is sent to the user.
   * Uncomment in the case of implementing the middleware interface Terminable Middleware.
   */
  //public function terminate($request, $response) {
  //
  //  // TODO: terminable middleware code
  //  // For example, you can save session data here...
  //
  //}

}
