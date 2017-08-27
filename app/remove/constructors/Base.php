<?php

namespace WARP\CC\app\remove\constructors;
use \WARP\CC\app\remove\Remove;

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
        if($result === Remove::BACK) {
          goto start;
          break;
        }

        // Need global restart
        else if($result === Remove::RESTART) {
          return Remove::RESTART;
        }

        // Need exit
        else if($result === Remove::EX) {
          return Remove::EX;
        }

        // Need edit
        else if($result === Remove::EDIT) {
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
        Remove::BACK,
        Remove::EDIT,
        Remove::RESTART,
        Remove::EX
      ]);
      if($next == Remove::BACK) return $this->back($this->output);
      else if($next == Remove::RESTART) return Remove::RESTART;
      else if($next == Remove::EX) return Remove::EX;
      else if($next == Remove::EDIT) return Remove::EDIT;
      return true;

    } else if(in_array($direction, [Remove::RESTART,Remove::EX,Remove::EDIT])) {
      return $direction;
    } else if($direction == Remove::BACK) {
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
        return Remove::BACK;

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
