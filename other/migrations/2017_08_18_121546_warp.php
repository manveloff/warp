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
    DB::connection()->statement('CREATE DATABASE IF NOT EXISTS warp DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci');

    // 2. Create 'migration' table if not exists
    DB::statement("CREATE TABLE IF NOT EXISTS `warp`.`migrations` (
      `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `migration` VARCHAR(255) NOT NULL,
      `batch` INT(11) NOT NULL,
      PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;");

    // 3. Create 'users' table if not exists
    DB::statement("CREATE TABLE IF NOT EXISTS `warp`.`users` (
      `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `email` VARCHAR(512) NOT NULL,
      `password` VARCHAR(512) NOT NULL,
      `remember_token` VARCHAR(512) NULL DEFAULT NULL,
      PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;");

    // 4. Create 'groups' table if not exists
    DB::statement("CREATE TABLE IF NOT EXISTS `warp`.`groups` (
      `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(512) NOT NULL,
      `description` TEXT NOT NULL,
      PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;");

    // 5. Create 'pivot_users_groups' table with n:m relationships between 'users' and 'groups'
    DB::statement("CREATE TABLE IF NOT EXISTS `warp`.`pivot_users_groups` (
      `users_id` INT(10) UNSIGNED NOT NULL,
      `groups_id` INT(10) UNSIGNED NOT NULL,
      INDEX `fk_pivot_users_groups_users_idx` (`users_id` ASC),
      INDEX `fk_pivot_users_groups_groups1_idx` (`groups_id` ASC),
      CONSTRAINT `fk_pivot_users_groups_users`
        FOREIGN KEY (`users_id`)
        REFERENCES `warp`.`users` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_pivot_users_groups_groups1`
        FOREIGN KEY (`groups_id`)
        REFERENCES `warp`.`groups` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;");

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {

    // 1. Drop 'pivot_users_groups' table
    DB::statement("DROP TABLE IF EXISTS `warp`.`pivot_users_groups`");

    // 2. Drop 'users' table
    DB::statement("DROP TABLE IF EXISTS `warp`.`users`");

    // 3. Drop 'groups' table
    DB::statement("DROP TABLE IF EXISTS `warp`.`groups`");

  }
}
