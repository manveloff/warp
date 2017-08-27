<?php
/**
 *
 * Test listener
 *
 */

namespace WARP\CC\listeners;
use Illuminate\Queue\InteractsWithQueue,
    Illuminate\Contracts\Queue\ShouldQueue;

class Test {  // write here "implements ShouldQueue" - and then the handler will be added to the task queue, rather than being executed in realtime

  /**
   * The class constructor
   */
  public function __construct(){

  }

  /**
   * The event handler method
   */
  public function handle(\WARP\CC\events\Event $event) {

    /**
     * Check the keys and get the incoming data
     */
    try {

      // Get the keys sent with the event
      $eventkeys = $event->data['keys'];

      // Get the keys supported by the handler
      $handlerkeys = ["m1:afterupdate","m4:afterupdate"];

      // If no key is suitable, return
      $testkeys = array_intersect($handlerkeys, $eventkeys);
      if(empty($testkeys)) return;

      // Get Inbound Data
      $data = $event->data;

    } catch(\Exception $e) {
      $errortext = 'Keys checking in event handler Test of package warpcomplex/warp have ended with error: '.$e->getMessage();
      Log::info($errortext);
      return [
        "success" => false,
        "data"    => [],
        "error"   => [
          "full"    => $errortext,
          "msg"     => $e->getMessage()
        ]
      ];
    }

    /**
     * The listener handler
     * Table of contents:
     *
     *  1. ...
     *
     *
     */
    $res = call_user_func(function() USE ($event) { try {



      // TODO: listener code



      // n. Return results
      return [
        "success" => true,
        "data"    => [],
      ];

    } catch(\Exception $e) {
        $errortext = 'Invoking of event handler Test of package warpcomplex/warp have ended with error: '.$e->getMessage();
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

    /**
     * Return default response
     */
    return [
      "success" => true,
      "data"    => []
    ];

  }

}