<?php

namespace WARP\CC\app\compile\tasks\repository;
use WARP\CC\app\compile\tasks\BaseTask,
    WARP\CC\app\compile\tasks\iTask,
    WARP\CC\app\compile\eloquent\Sync;

class SyncEloquentModels extends BaseTask implements iTask {

//---------//
// General //
//---------//

  /**
   * The class constructor
   */
  public function __construct(&$log, &$output) {

    // Invoke base class constructor
    parent::__construct($log, $output);



  }

//-----------//
// Task data //
//-----------//



//--------------//
// Task methods //
//--------------//

  /**
   * The main task method
   * Synchronize all Laravel eloquent models of WARP application
   */
  public function task(){

    // 1. Create new sync instance
    $sync = new Sync($this);

    // 2. Notify about sync start
    $sync->start();

    // 3. Get base data for models creation for each module
    $sync->getBaseData();

    // 4. Complement base data by local relationships data
    $sync->getLocalRels();


    //\Log::info($sync->data);


    // 5. Complement base data by trans-module relationships data
    //$sync->getTransModuleRels();

    // n. Notify about sync successful end
    $sync->success();


    // По всем таблицам подготовить:
    // - Данные для создания моделей (кроме связей)
    // - Связи локальные
    // - Связи трансмодульные

    // Пересоздать все соответствующие модели:
    // - Если модель не существует, просто создавать её с нуля из шаблона.
    // - Если существует, создавать с обновлением системной части и сохранением пользовательской.



    // 1. Получить имена всех установленных модулей.
    // 2. Пробежаться по всем модулям:
    //   2.1. Получить все таблицы БД модуля.
    //   2.2. Для каждой обычной таблицы:
    //     2.2.1. Сохранить пользовательскую часть в переменную.
    //     2.2.2. Переименовать модель в <имя_модели>_timestamp
    //     2.2.3. Создать новую модель из шаблона.
    //     2.2.4. Вписать в новую модель пользовательские данные из переменной.
    //     2.2.5. Обновить связи новой модели (локальные и трансмодульные)
    //     2.2.6. Удалить старую модель из 2.2.2.

  }



} 