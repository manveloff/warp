<?php
/**
 *
 * WARP Project Control Center (aka hub) entry point
 *
 */

namespace WARP;

class App {

  /** @var string|null Public test property */
  public $test;


  /**
   *
   * The class constructor
   *
   * @param string $test Test param
   *
   */
  function __construct($test) {

  }

  /**
   *
   * Invokes all necessary "after package install operations" for the hub package
   *
   */
  function install() {

  }

  /**
   *
   * Invokes all necessary operations and clean everything up before uninstalling the hub package
   *
   */
  function uninstall() {

  }


}
