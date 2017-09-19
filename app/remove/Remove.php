<?php

namespace WARP\CC\app\remove;

/**
 *
 * WARP resource remove system
 *
 */
class Remove {

//---------//
// General //
//---------//

  /**
   * Output interface
   */
  protected $output;

  /**
   * The class constructor
   */
  public function __construct(&$output) {

    // Write down output
    $this->output = $output;

    // Sync WARP application structure
    \WARP::makeStructure($output);

  }

//-----------------------//
// Resource construction //
//-----------------------//

  /** Constants */
  const EX            = '× exit';
  const EX_MSG        = 'Interrupt process';

  const RESTART       = '↔ restart';
  const RESTART_MSG   = 'Restart process';

  const BACK          = '← back';
  const BACK_MSG      = 'Back to 1 step';

  const EDIT          = '→ edit';
  const EDIT_MSG      = 'Edit last step value';


  /** Package types and chosen package type */
  protected $pTypes = [
    'module',
    'slot',
    'connector',

    self::EX
  ];
  protected $pTypeChosen;

  /** Resource types for each package type, and chosen resource of chosen package type */
  protected $rTypes = [
    'module'    => [
      'Connector',
      'Console',
      'Exception',
      'Job',
      'Listener',
      'Middleware',
      'Model',
      'Module',
      'Provider',
      'Test',

      self::RESTART,
      self::EX
    ],
    'slot'      => [
      '',
      '',
      '',
    ],
    'connector' => [
      '',
      '',
      '',
    ]
  ];
  protected $rTypeChosen;

  /** Resource */
  public $resource;

  /**
   * Start construction process
   */
  public function construct() {

    // Choose package type
    if($this->choosePackageType($this->output) == self::EX) return false;

    // Choose resource type
    if(in_array($this->chooseResourceType($this->output), [self::EX, self::RESTART])) return false;

    // Create new instance of chosen resource constructor, run and get result
    $class = "\\WARP\\CC\\app\\remove\\constructors\\$this->pTypeChosen\\$this->rTypeChosen";
    $constructor = new $class($this->output);
    $result = $constructor->start();

    // Handle construct results

      // Need restart
      if($result == self::RESTART)
        $this->restart($this->output);

      // Need exit
      if($result == self::EX)
        return false;

    // Write down $constructor to $this->resource
    $this->resource = $constructor;

    // If returns true, continue process
    return true;

  }

  /**
   * Restart construction process
   */
  public function restart() {

    $this->output->comment(self::RESTART_MSG);
    $this->construct($this->output);

  }


  /**
   * Choose package type
   */
  public function choosePackageType() {

    // Ask the user what type of package he wants to create a resource for
    $result = $this->output->choice('Choose type of package for which you want to remove a resource', $this->pTypes);

    // Output chosen package type
    $this->output->line($result);

    // If the command 'exit' selected
    if($result == self::EX)
      return self::EX;

    // Write down chosen package type to $pTypeChosen
    $this->pTypeChosen = $result;

    // Return $result
    return $result;

  }

  /**
   * Choose resource type
   */
  public function chooseResourceType() {

    // Ask the user what type of resource he wants to create
    $result = $this->output->choice('Choose type of resource you want to remove', $this->rTypes[$this->pTypeChosen]);

    // Output chosen package type
    $this->output->line($result);

    // If the command 'exit' has been selected
    if($result == self::EX)
      return self::EX;

    // If the command 'restart' has been selected
    if($result == self::RESTART)
      $this->restart($this->output);

    // Write down chosen package type to $pTypeChosen
    $this->rTypeChosen = $result;

    // Return $result
    return $result;

  }

//-------------------//
// Resource removing //
//-------------------//

  /**
   * Remove resource
   */
  public function remove() {

    // Get remover class full name
    $class = "\\WARP\\CC\\app\\remove\\removers\\$this->pTypeChosen\\$this->rTypeChosen";

    // If there is no resource, or $class does not exists, return
    if(empty($this->resource) || !class_exists($class)) return;

    // Create new instance of chosen resource remover, run and get result
    $remover = new $class($this->output, $this->resource);
    $result = $remover->remove();

    // Return result
    return $result;

  }



}



