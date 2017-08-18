<?php
/**
 *
 * WARP package migration #1
 *
 */

use Illuminate\Database\Schema\Blueprint,
    Illuminate\Database\Migrations\Migration,
    Illuminate\Console\Command,
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

class Warp extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {

    // 1. Create 'warp' database if not exists
    DB::connection()->statement('CREATE DATABASE IF NOT EXISTS warp');



  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {

    // 1. Drop 'warp' database if exists
    DB::connection()->statement('DROP DATABASE IF EXISTS warp');



  }
}
