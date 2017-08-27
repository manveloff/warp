<?php
/**
 *
 * WARP Event
 *
 */

namespace WARP\CC\other\events;
use Illuminate\Queue\SerializesModels,
    Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Event {

  //--------------//
  // A. Use trait //
  //--------------//
  use SerializesModels;

  //----------------------------//
  // B. Variables for arguments //
  //----------------------------//
  // - During translation, public variables will be passed
  public $data;

  //---------------------------------------------------------------------//
  // C. Accept arguments passed when an instance of the event is created //
  //---------------------------------------------------------------------//
  // - The instances of the model passed in the argument will be serialized
  public function __construct($data) {

    $this->data = $data;

  }

}















