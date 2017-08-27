<?php
/**
 *
 * WARP Broadcast Event
 *
 */

namespace WARP\CC\other\events;
use Illuminate\Queue\SerializesModels,
    Illuminate\Broadcasting\Channel,
    Illuminate\Broadcasting\PrivateChannel,
    Illuminate\Broadcasting\PresenceChannel,
    Illuminate\Broadcasting\InteractsWithSockets,
    Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Broadcast {

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

  //------------------------------------//
  // D. Methods for the broadcast event //
  //------------------------------------//

    // D1. The array of channels to which the translator must broadcast //
    //------------------------------------------------------------------//
    public function broadcastOn() {

      //$channels_classes = [];
      //foreach($channels as $channel) {
      //  array_push($channels_classes, new Channel($channel));
      //}

      // Вернуть массив таких каналов
      // - Подсказка: можно использовать ID пользователя
      return $this->data['channels'];

    }

    // D2. An array of data that the user must broadcast //
    //---------------------------------------------------//
    //public function broadcastWith() {
    //    return ['name' => 'Иван', 'age' => 18];
    //}

    // D3. In what queue to place the event //
    //--------------------------------------//
    public function onQueue() {
      return array_key_exists('queue', $this->data) ? $this->data['queue'] : 'default';
    }

}















