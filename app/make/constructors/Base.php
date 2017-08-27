<?php

namespace WARP\CC\app\make\constructors;
use \WARP\CC\app\make\Make;

class Base implements \SeekableIterator {

//------//
// Main //
//------//

  /**
   * Constants
   */


  /**
   * Output interface
   */
  protected $output;

  /**
   * The class constructor
   */
  public function __construct(&$output) {
    $this->output = $output;
    $this->position = 0;
  }

  /**
   * Start construction process
   */
  public function start() {

    start:
    foreach($this as $key => $value) {

      step_start:

      // Invoke $value method
      $result = $this->{$value}($this->output);

      // Handle $result

        // Need resource constructor restart
        if($result === Make::BACK) {
          goto start;
          break;
        }

        // Need global restart
        else if($result === Make::RESTART) {
          return Make::RESTART;
        }

        // Need exit
        else if($result === Make::EX) {
          return Make::EX;
        }

        // Need edit
        else if($result === Make::EDIT) {
          goto step_start;
          break;
        }

    }

  }

  /**
   * Intermediate step
   */
  public function done($direction = true) {

    if($direction === true) {

      $next = $this->output->choice("What's next?", [
        'Go to the next step',
        Make::BACK,
        Make::EDIT,
        Make::RESTART,
        Make::EX
      ]);
      if($next == Make::BACK) return $this->back($this->output);
      else if($next == Make::RESTART) return Make::RESTART;
      else if($next == Make::EX) return Make::EX;
      else if($next == Make::EDIT) return Make::EDIT;
      return true;

    } else if(in_array($direction, [Make::RESTART,Make::EX,Make::EDIT])) {
      return $direction;
    } else if($direction == Make::BACK) {
      return $this->back($this->output);
    } else
      return true;

  }


//------------------------//
// Iterator functionality //
//------------------------//

  /**
   * Iterator position
   */
  private $position = 0;

  /**
   * Iterator position array
   */
  protected $array = array();

  /**
   * Restart iterator
   */
  public function rewind() {
    $this->position = 0;
  }

  /**
   * Get current position value
   */
  public function current() {
    return $this->array[$this->position];
  }

  /**
   * Get current position key
   */
  public function key() {
    return $this->position;
  }

  /**
   * Check if current position is valid
   */
  public function valid() {
    return isset($this->array[$this->position]);
  }

  /**
   * Go to the next position
   */
  public function next() {
    if($this->valid($this->position + 1))
      ++$this->position;
  }

  /**
   * Go to the next position
   */
  public function back() {
    if($this->valid($this->position - 1)) {

      if($this->position - 1 > 0)
        $this->seek($this->position - 1);

      else
        return Make::BACK;

    }
  }

  /**
   * Change iterator $position
   */
  public function seek($position) {
    if (!isset($this->array[$position])) {
      throw new \OutOfBoundsException("invalid seek position ($position)");
    }
    $this->position = $position;
  }


}
