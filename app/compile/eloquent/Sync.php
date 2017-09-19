<?php

namespace WARP\CC\app\compile\eloquent;
use Illuminate\Support\Facades\DB;

class Sync {

//---------//
// General //
//---------//

  /**
   * The class constructor
   */
  public function __construct($task) {

    // 1. Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
    $this->fs = warp_fs_manager();

    // 2. Write down the task instance
    $this->task = $task;

    // 3. Get list of module names installed in the system
    $this->modules = collect($this->fs->directories('warp/modules'))->map(function($element){
      return basename($element);
    })->toArray();

  }

  /**
   * The class destructor
   */
  public function __destruct() {

    // 1. Destroy fs
    unset($this->fs);

  }


//------//
// Data //
//------//

  /** Monolog instance */
  public $fs;

  /** Task instance */
  public $task;

  /** List of module names installed in the system */
  public $modules;

  /** Data for models creation */
  public $data;


//---------//
// Methods //
//---------//

  /**
   * Notify about sync start
   */
  public function start(){

    // Log
    $this->task->log->logger->info("\n");
    $this->task->log->logger->info("  Laravel eloquent models of WARP application synchronization");

    // Output
    $this->task->output->info("");
    $this->task->output->comment("  Laravel eloquent models of WARP application synchronization");

  }

  /**
   * Notify about sync successful end
   */
  public function success(){

    // Log
    $this->task->log->logger->info("  Ready.");

    // Output
    $this->task->output->line("  Ready.");

  }

  /**
   * Get base data for models creation for each module
   */
  public function getBaseData(){ foreach($this->modules as $module) {

    // 1. Check if the $module database exists in the current connection
    if(!warp_check_schema_exist($module)) {
      throw new \Exception("There is no database '".$module."' in current connection!");
      continue;
    }

    // 2. Get all tables from $module DB, sort them into ordinary, pivot and connectors
    $tables = (function() USE ($module) {

      // 1] All tables
      $tables_all = (function() USE ($module) {

        $list = DB::select('SHOW tables FROM '.mb_strtolower($module));
        $list = array_values(array_map(function($item) USE ($module) {
          $item = (array)$item;
          return $item['Tables_in_'.mb_strtolower($module)];
        }, $list));
        return $list;

      })();

      // 2] pivot
      $tables_pivot = array_values(array_filter($tables_all, function($item){
        return preg_match("/^pivot_.*/ui",$item) != 0;
      }));

      // 3] connectors
      $tables_con = array_values(array_filter($tables_all, function($item){
        return preg_match("/^connector_.*/ui",$item) != 0;
      }));

      // 4] ordinary
      $tables_ord = array_values(array_filter($tables_all, function($item) USE ($tables_con, $tables_pivot) {
        return !in_array($item, $tables_con) && !in_array($item, $tables_pivot);
      }));

      // n] Return results
      return [
        "all"         => $tables_all,
        "ordinary"    => $tables_ord,
        "pivot"       => $tables_pivot,
        "connectors"  => $tables_con,
      ];

    })();

    // 3. For each ordinary table get some additional data
    $tables['ordinary_final'] = (function() USE (&$tables, $module) {
      $results = [];
      foreach($tables['ordinary'] as $table) {

        // 1] Get list of all columns of $table
        $columns = DB::select("SHOW COLUMNS FROM ".mb_strtolower($module.".".$table));
        $columns = array_map(function($item){
          return $item->Field;
        }, $columns);

        // 2] Check about auto maintenance of timestamps created_at / updated_at
        $timestamps = call_user_func(function() USE ($columns) {
          return in_array('updated_at',$columns) && in_array('created_at',$columns) ? 'true' : 'false';
        });

        // 3] Check about soft delete
        $softdeletes = call_user_func(function() USE ($columns) {
          return in_array('deleted_at',$columns) ? 'true' : 'false';
        });

        // 4] Добавить значение в $list_final
        $results[$table] = [
          "table"       => $table,
          "timestamps"  => $timestamps,
          "softdeletes" => $softdeletes
        ];

      }
      return $results;
    })();

    // 4. Write down $tables to $this->data
    if(!is_array($this->data))
      $this->data = [];
    $this->data[$module] = $tables;

  }}

  /**
   * Get base data for models creation for each module
   */
  public function getLocalRels(){ foreach($this->modules as $module) {

    // 1. Prepare array for result
    $result = [];

    // 2. Get from MySQL info about all relationships of $module
    $all_rels = DB::select("SELECT CONSTRAINT_SCHEMA, CONSTRAINT_NAME, TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_SCHEMA, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME is not null AND CONSTRAINT_SCHEMA='".$module."'");

    // 3. Find in $all_rels pairs with same "TABLE_NAME"
    // - Format of which is matching with "^pivot_"
    // - And get array in such format:
    /**
     *  [
     *    "TABLE_NAME" => [
     *      [
     *        ...
     *      ],
     *      [
     *        ...
     *      ]
     *    ]
     *  ]
     */
    $rels4mn = call_user_func(function() USE ($all_rels, $module) {

      // 1] Prepare array for results
      $result = [];

      // 2] Find
      foreach($all_rels as $rel) {
        if(preg_match("/^pivot_/ui", $rel->TABLE_NAME) != 0) {

          // 2.1] If there is no key "TABLE_NAME" in $result, add
          if(!array_key_exists($rel->TABLE_NAME, $result))
            $result[$rel->TABLE_NAME] = [];

          // 2.2] Add $rel to $result[$rel->TABLE_NAME]
          array_push($result[$rel->TABLE_NAME], $rel);

        }
      }

      // 3] Check the $result integrity
      // - Need that each array-item in $result contain exactly 2 elements
      foreach($result as $rel) {
        if(!array_key_exists(0, $rel) || !array_key_exists(1, $rel) || array_key_exists(2, $rel))
          throw new \Exception("Database of module '$module' has broken m:n relationship.есть недоделанная m:n связь (look pivot-table $rel->TABLE_NAME).");
      }

      // n] Return results
      return $result;

    });

    // 4. Add to $result all model names of $module
    // - In format: "model name" => []

      // 1] Create key/value pair
      $result[$module] = [];

      // 2] Add there all model names of this $module
      foreach($this->data[$module]['ordinary_final'] as $model) {
        $result[$module][$model['table']] = [];
      }

    // 5. Prepare and add to $result belongsToMany-связи
    (function() USE (&$result, $rels4mn, $module) { foreach($rels4mn as $rel) {

      // 1] Check keys existence in $result
      // - $rel[0]->REFERENCED_TABLE_NAME
      // - $rel[1]->REFERENCED_TABLE_NAME
      // - If some of keys is absent, create it
      if(!array_key_exists($rel[0]->REFERENCED_TABLE_NAME, $result[$module]))
        $result[$module][$rel[0]->REFERENCED_TABLE_NAME] = [];
      if(!array_key_exists($rel[1]->REFERENCED_TABLE_NAME, $result[$module]))
        $result[$module][$rel[1]->REFERENCED_TABLE_NAME] = [];

      // 2] Add relationship for model $rel[0]->REFERENCED_TABLE_NAME

        // 2.1] Get rel name
        $relname = $rel[1]->REFERENCED_TABLE_NAME;

        // 2.2] Get related model name
        $relmodel = warp_mb_ucfirst(mb_strtolower($rel[1]->REFERENCED_TABLE_NAME));

        // 2.3] Prepare additional columns array to add to withPivot of the relationship
        $withpivot = call_user_func(function() USE ($rel, $module) {

          // 2.3.1] Get list of all column names of pivot-table in format:
          //
          // [
          //   {
          //     "COLUMN_NAME" => "ИМЯ1"
          //   },
          //   {
          //     "COLUMN_NAME" => "ИМЯ2"
          //   },
          // ]
          //
          $all_pivot_column_names = collect(DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$module."' AND TABLE_NAME = '".mb_strtolower($rel[1]->TABLE_NAME)."'"))
            ->map(function($item){
              return $item->COLUMN_NAME;
            })->toArray();

          // 2.3.2] Get array of 2 column names of pivot-table related to relationship
          $relatedToRelCols = [
            $rel[0]->COLUMN_NAME,
            $rel[1]->COLUMN_NAME
          ];

          // 2.3.3] Get and return array of $all_pivot_column_names without $relatedToRelCols
          return array_values(array_diff($all_pivot_column_names, $relatedToRelCols));

        });

        // 2.4] Add relationship to $result
        $result[$module][$rel[0]->REFERENCED_TABLE_NAME][$relname] = [
          "type"            => "belongsToMany",
          "pivot"           => mb_strtolower($module).".".$rel[0]->TABLE_NAME,
          "related_model"   => "\\WARP\\modules\\".mb_strtoupper($module)."\\models\\$relmodel",
          "foreign_key"     => $rel[1]->COLUMN_NAME,
          "local_key"       => $rel[0]->COLUMN_NAME,
          "withpivot"       => $withpivot
        ];

      // 3] Add relationship for model $rel[1]->REFERENCED_TABLE_NAME

        // 3.1] Get rel name
        $relname = $rel[0]->REFERENCED_TABLE_NAME;

        // 3.2] Get related model name
        $relmodel = warp_mb_ucfirst(mb_strtolower($rel[0]->REFERENCED_TABLE_NAME));

        // 3.3] Prepare additional columns array to add to withPivot of the relationship
        $withpivot = call_user_func(function() USE ($rel, $module) {

          // 3.3.1] Get list of all column names of pivot-table in format:
          //
          // [
          //   {
          //     "COLUMN_NAME" => "ИМЯ1"
          //   },
          //   {
          //     "COLUMN_NAME" => "ИМЯ2"
          //   },
          // ]
          //
          $all_pivot_column_names = collect(DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$module."' AND TABLE_NAME = '".mb_strtolower($rel[0]->TABLE_NAME)."'"))
            ->map(function($item){
              return $item->COLUMN_NAME;
            })->toArray();

          // 3.3.2] Get array of 2 column names of pivot-table related to relationship
          $relatedToRelCols = [
            $rel[0]->COLUMN_NAME,
            $rel[1]->COLUMN_NAME
          ];

          // 3.3.3] Get and return array of $all_pivot_column_names without $relatedToRelCols
          return array_values(array_diff($all_pivot_column_names, $relatedToRelCols));

        });

        // 2.4] Add relationship to $result
        $result[$module][$rel[1]->REFERENCED_TABLE_NAME][$relname] = [
          "type"            => "belongsToMany",
          "pivot"           => mb_strtolower($module).".".$rel[1]->TABLE_NAME,
          "related_model"   => "\\WARP\\modules\\".mb_strtoupper($module)."\\models\\$relmodel",
          "foreign_key"     => $rel[0]->COLUMN_NAME,
          "local_key"       => $rel[1]->COLUMN_NAME,
          "withpivot"       => $withpivot
        ];

    }})();



    //\Log::info($rels4mn);



  }}


} 