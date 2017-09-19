<?php

namespace WARP\CC\app\compile\log;
use Monolog\Logger,
    Monolog\Handler\StreamHandler,
    Monolog\Formatter\LineFormatter;

class Log {

//---------//
// General //
//---------//

  /**
   * The class constructor
   */
  public function __construct($path, &$output) {

    // 1. Create new logger

      // Create a log channel warpcc
      $log = new Logger('compilation');

      // Create and configure new handler
      $handler = new StreamHandler($path, Logger::DEBUG);
      $formatter = new LineFormatter("%message%\n");
      $handler->setFormatter($formatter);

      // Add handler for $log
      // - Writing data to file: $path
      $log->pushHandler($handler);

      // Write down the link to $log to $this->logger
      $this->logger = $log;

    // 2. Write down output link
    $this->output = $output;

  }

  /**
   * The class destructor
   */
  public function __destruct() {

    // Destroy logger object
    unset($this->logger);

  }

//------//
// Data //
//------//

  /** Monolog instance */
  public $logger;

  /** Output instance */
  public $output;

//---------//
// Methods //
//---------//

  /**
   * Make a note to the log about compilation process start
   */
  public function start(){

    // Log start messages
    $this->logger->info("\n");
    $this->logger->info("\n");
    $this->logger->info('=========================');
    $this->logger->info('  Compilation start      ');
    $this->logger->info('  '.\Carbon\Carbon::now()->toDateTimeString());
    $this->logger->info('=========================');

    // Output end messages
    $this->output->info("");
    $this->output->comment('Compilation start ('.\Carbon\Carbon::now()->toDateTimeString().')');

  }

  /**
   * Make a note to the log about compilation process end without errors
   */
  public function endSuccess(){

    // Log end messages
    $this->logger->info("\n");
    $this->logger->info('=========================');
    $this->logger->info('  Compilation success    ');
    $this->logger->info('  '.\Carbon\Carbon::now()->toDateTimeString());
    $this->logger->info('=========================');

    // Output end messages
    $this->output->info("");
    $this->output->info('Compilation success ('.\Carbon\Carbon::now()->toDateTimeString().')');
    $this->output->info("");

  }

  /**
   * Make a note to the log about compilation process end with errors
   */
  public function endFailure(&$e){

    // Log end messages
    $this->logger->info("\n");
    $this->logger->info('Error: '.$e->getMessage());
    $this->logger->info('=========================');
    $this->logger->info('  Compilation failure    ');
    $this->logger->info('  '.\Carbon\Carbon::now()->toDateTimeString());
    $this->logger->info('=========================');

    // Output end messages
    $this->output->info("");
    $this->output->error('Compilation failure ('.\Carbon\Carbon::now()->toDateTimeString().'): '.$e->getMessage());
    $this->output->info("");

  }



} 