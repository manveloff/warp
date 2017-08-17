<?php
/**
 *
 * WARP CLI reference
 *
 */

namespace WARP\console;
use Illuminate\Console\Command,
    Illuminate\Routing\Controller as BaseController,
    Illuminate\Support\Facades\App,
    Illuminate\Support\Facades\Artisan,
    Illuminate\Support\Facades\Auth,
    Illuminate\Support\Facades\Blade,
    Illuminate\Support\Facades\Bus,
    Illuminate\Support\Facades\Cache,
    Illuminate\Support\Facades\Config,
    Illuminate\Support\Facades\Cookie,
    Illuminate\Support\Facades\Crypt,
    Illuminate\Support\Facades\DB,
    Illuminate\Database\Eloquent\Model,
    Illuminate\Support\Facades\Event,
    Illuminate\Support\Facades\File,
    Illuminate\Support\Facades\Hash,
    Illuminate\Support\Facades\Input,
    Illuminate\Foundation\Inspiring,
    Illuminate\Support\Facades\Lang,
    Illuminate\Support\Facades\Log,
    Illuminate\Support\Facades\Mail,
    Illuminate\Support\Facades\Password,
    Illuminate\Support\Facades\Queue,
    Illuminate\Support\Facades\Redirect,
    Illuminate\Support\Facades\Redis,
    Illuminate\Support\Facades\Request,
    Illuminate\Support\Facades\Response,
    Illuminate\Support\Facades\Route,
    Illuminate\Support\Facades\Schema,
    Illuminate\Support\Facades\Session,
    Illuminate\Support\Facades\Storage,
    Illuminate\Support\Facades\URL,
    Illuminate\Support\Facades\Validator,
    Illuminate\Support\Facades\View;

class Warp extends Command {

  /**
   * Artisan command template
   * Examples:
   *
   *  '[command name] {user}'        | set argument
   *  '[command name] {user=foo}'    | set argument with default value
   *  '[command name] {--queue}'     | set option
   *  '[command name] {--queue=}'    | set option with value
   *  '[command name] {--queue=foo}' | set option with default value
   *  '[command name] {user : desc}' | set argument/option description
   *
   * @var string
   */
  protected $signature = 'warp';

  /**
   * Artisan command description
   *
   * @var string
   */
  protected $description = 'Show WARP CLI reference';

  /**
   * The class constructor
   */
  public function __construct()
  {

    // Invoke parent (Command) class constructor
    parent::__construct();

  }

  /**
   * Artisan command handler
   * Reference:
   *
   *  • Ger arguments/options values
   *
   *    - $this->argument()    | get argument value by its name, or array of all argument values
   *    - $this->option()      | get option value by its name, or array of all option values
   *
   *  • Information request to user
   *
   *    - $this->ask()         | request string
   *    - $this->secret()      | request string safely
   *    - $this->confirm()     | request confirm (y/n)
   *    - $this->anticipate()  | request choosing between several variants with possibility of free input
   *    - $this->choice()      | request choosing between several variants without possibility of free input
   *
   *        $x = $this->ask('Enter some sring');
   *        $y = $this->choice('Choose between variants', ['1'=>'Variant #1', '2'=>'Variant #2'], '1');
   *        $z = $this->confirm('You are already 18 years old?', true);
   *
   *  • Output to the terminal
   *
   *    - $this->output->write()    | line, info, etc. - only wrappers for other output implementation wrappers
   *    - $this->output->newLine()  | new line
   *
   *    - $this->line()             | white text
   *    - $this->info()             | green text
   *    - $this->comment()          | yellow text
   *    - $this->question()         | black on cyan background
   *    - $this->error()            | white on red background
   *    - $this->table()            | output table
   *
   *      Example of table output:
   *        $this->table(['header1','header2','header3'], ['row1_cell1', 'row1_cell2', 'row1_cell3'], ['row2_cell1', 'row2_cell2', 'row2_cell3'] )
   */
  public function handle()
  {

    // 1. Version
    $this->output->write('WARP Complex ');
    $this->info(\WARP\App::version());
    $this->output->newLine();

    // 2. Usage
    $this->comment('Usage:');
    $this->line('  warp [options] [arguments]');
    $this->output->newLine();

    // 3. Available commands

      // 3.1. Prepare available commands array
      $ac = [
        ['warp',                    'Display this help message'],
        ['warp:install',            'Invoke all necessary install operations'],
        ['warp:uninstall',          'Invoke all necessary uninstall operations']
      ];

      // 3.2. Set length of command names equal to 24
      foreach($ac as &$item) {
        $item[0] = str_pad($item[0], 22, ' ', STR_PAD_RIGHT);
      }

      // 3.3. Output
      $this->comment('Available commands:');
      foreach($ac as $i) {
        $this->output->write('  <info>'.$i[0].'</info>');
        $this->line($i[1]);
      }
      $this->output->newLine();

  }

}