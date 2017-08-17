<?php
/**
 *
 * After middleware
 *
 */

namespace M5\Middlewares;
use Closure;

class After {

  /**
   * The middleware handler method
   *
   * The request passes through this code after the request is handled by the application.
   * Table of contents:
   *
   *  1. Forward reply further to the app
   *  2. ...
   *
   *  n. Forward reply further
   *
   */
  public function handle($request, Closure $next) {

    // 1. Forward reply further to the app
    $response = $next($request);

    // 2. ...


      // TODO: after middleware code


    // n. Forward reply further
    return $response;

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
