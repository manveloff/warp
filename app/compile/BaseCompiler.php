<?php

namespace WARP\CC\app\compile;

class BaseCompiler implements \SeekableIterator {

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
   * Go to the prev position
   */
  public function back() {
    //if($this->valid($this->position - 1)) {
    //
    //  if($this->position - 1 > 0)
    //    $this->seek($this->position - 1);
    //
    //  else
    //    return Make::BACK;
    //
    //}
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