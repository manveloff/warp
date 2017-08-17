<?php

namespace WARP;

/**
 *
 * WARP Project Control Center (aka hub) entry point
 *
 */
class App {

  /** @var string|null WARP version */
  public static $version = '5.4.0';

  /** @var string|null Public test property */
  public $test;


  /**
   * The class constructor
   * @param string $test Test param
   */
  public function __construct($test) {

  }

  /**
   * Get current WARP version
   */
  public static function version() {
    return self::$version;
  }

  /**
   * Invoke all necessary install operations
   */
  public function install() {

    // - Добавить алиас WARP => WARP\App::class в aliases в config/app.php
    // - Заменить App\User::class (или иное значение) в providers->users->model на WARP\models\Users::class в config/auth.php
    // - Раскомментировать App\Providers\BroadcastServiceProvider в config/app.php
    // - Выполнить команду warp:compile
    // - Выполнить миграции пакета.




  }

  /**
   * Invoke all necessary uninstall operations
   */
  public function uninstall($del_schema = false) {

    // - Убрать алиас WARP => WARP\App::class из aliases в config/app.php
    // - Заменить значение в providers->users->model в config/auth.php на App\User::class
    // - Откатить миграции пакета, если $del_schema = true
    // - Удалить все задачи пакета из планировщика проекта

  }


}
