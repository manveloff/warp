<?php
/**
 *
 * Library of WARP php-helpers
 *
 */

use Illuminate\Routing\Controller as BaseController,
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


if(!function_exists('warp_')) {

  /**
   *  <h1>WARP helpers reference</h1>
   *  <pre>
   *
   *    warp_job                    | Invoke the job now or sent to queue
   *    warp_url_exist              | Check specific URL existence
   *    warp_array_unique_recursive | Like array_unique, but for multidimensional arrays
   *    warp_udatetime              | Get from timestamp formatted representation of datetime with microseconds
   *    warp_fs                     | Set base path and get instance of '\Illuminate\Filesystem\FilesystemManager instance'
   *    warp_fs_manager             | Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'
   *    warp_countdim               | Counting multidimensional array dimension number
   *    warp_isJSON                 | Whether the passed string is valid JSON
   *    warp_check_schema_exist     | Check if the specified database exists in the current connection
   *    warp_has_table              | Check if database in the current connection has specified table
   *    warp_has_column             | Check if database in the current connection has specified table with specified column
   *    warp_get_columns            | Get all column names of specified table in the current connection
   *    warp_checksum               | Get file checksum
   *    warp_encrypt_data           | Encrypt text with specific key
   *    warp_decrypt_data           | Decrypt text with specific key
   *    warp_validate               | Perform validation process
   *    warp_mb_ucfirst             | Multibyte ucfirst
   *
   *  </pre>
   * @return bool
   */
  function warp_() {

    return true;

  }

} else {
  \Log::info("Attention! Can't create WARP helper 'warp_', because such function is already exists!");
}

if(!function_exists('warp_job')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Invoke the job now or sent to queue
   *  </pre>
   *  <h1>Returns</h1>
   *  <pre>
   *
   *    [
   *      "timestamp"     // Request timestamp
   *      "data"          // Returned by job data
   *      "success"       // Is command successfully ended (true/false)?
   *      "error" => [    // Empty array if success == true, and filled if not
   *        "full"        // Full error text
   *        "msg"         // Error message from getMessage
   *      ]
   *    ]
   *
   *  <h1>Examples</h1>
   *  <pre>
   *
   *    • Synchronous invoking
   *
   *      warp_job('\WARP\jobs\Job');                                       | Simple synchronous request
   *      warp_job('\WARP\jobs\Job', ['key1'=>'value1','key2'=>'value2']);  | With data passing
   *
   *    • Adding to job queue
   *
   *      warp_job('\WARP\jobs\Job', [], true);           | Without any delay to 'default' queue
   *      warp_job('\WARP\jobs\Job', [], true, 5);        | With 5 seconds delay to 'default' queue
   *
   *      warp_job('\WARP\jobs\Job', [], 'another');      | Without any delay to 'another' queue
   *      warp_job('\WARP\jobs\Job', [], 'another', 5);   | With 5 seconds delay to 'another' queue
   *
   *  </pre>
   *
   * @param  mixed $job
   * @param  array $data
   * @param  mixed $queue
   * @param  mixed $delay_sec
   *
   * @return mixed
   */
  function warp_job($job, $data = [], $queue = false, $delay_sec = 0) {

    // 1. Validate incoming arguments

      // $job
      if(!is_string($job) || !class_exists($job))
        return [
          "timestamp" => "",
          "data"      => [],
          "success"   => false,
          "error" => [
            "full"  => "Can't invoke the job '".var_export($job, true)."', because such class is not exists, or \$job is not a string.",
            "msg"   => "Can't invoke the job '".var_export($job, true)."', because such class is not exists, or \$job is not a string."
          ]
        ];

      // $data
      if(!is_array($data))
        return [
          "timestamp" => "",
          "data"      => [],
          "success"   => false,
          "error" => [
            "full"  => "Can't invoke the job '".var_export($job, true)."', because passed \$data is not array.",
            "msg"   => "Can't invoke the job '".var_export($job, true)."', because passed \$data is not array."
          ]
        ];

      // $queue
      if(!is_bool($queue) && !is_string($queue))
        return [
          "timestamp" => "",
          "data"      => [],
          "success"   => false,
          "error" => [
            "full"  => "Can't invoke the job '".var_export($job, true)."', because passed \$queue is not boolean and not string.",
            "msg"   => "Can't invoke the job '".var_export($job, true)."', because passed \$queue is not boolean and not string."
          ]
        ];

      // $delay_sec
      if(!is_int(intval($delay_sec)))
        return [
          "timestamp" => "",
          "data"      => [],
          "success"   => false,
          "error" => [
            "full"  => "Can't invoke the job '".var_export($job, true)."', because passed \$delay_sec is not integer.",
            "msg"   => "Can't invoke the job '".var_export($job, true)."', because passed \$delay_sec is not integer."
          ]
        ];

    // 2. Pass $data to $job and invoke it, or send to $queue

      // 2.1. Invoke if $queue is boolean and equal to false
      if(is_bool($queue) && $queue === false) {

        // Invoke
        $response = Bus::dispatch(new $job($data));

        // If timestamp key in data, attach it to $response
        if(array_key_exists('timestamp', $data))
          $response['timestamp'] = $data['timestamp'];

        // Return response
        return $response;

      }

      // 2.2. Send $job to 'default' $queue if $queue is boolean and equal to true
      if(is_bool($queue) && $queue === true) {

        // If $delay_sec == 0, send without delay
        if(!is_int($delay_sec) || $delay_sec == 0)
          Queue::push(new $job($data), [], 'default');

        // If $delay_sec > 0, send with $delay_sec
        if(is_int($delay_sec) && $delay_sec > 0)
          Queue::later($delay_sec, new $job($data), [], 'default');

      }

      // 2.3. Send $job to $queue, if $queue is not boolean
      if(!is_bool($queue)) {

        // If $delay_sec == 0, send without delay
        if($delay_sec == 0)
          Queue::push(new $job($data), [], $queue);

        // If $delay_sec > 0, send with $delay_sec
        if(is_int($delay_sec) && $delay_sec > 0)
          Queue::later($delay_sec, new $job($data), [], $queue);

      }

    // 3. Return response if $job was sent to queue

      // Prepare response
      $response = [
        "status"    => 0,
        "data"      => "",
        "error"     => []
      ];

      // If timestamp key in data, attach it to $response
      if(array_key_exists('timestamp', $data))
        $response['timestamp'] = $data['timestamp'];

      // Return
      return $response;

  }
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_job', because such function is already exists!");
}

if(!function_exists('warp_url_exist')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Check specific URL existence
   *    Returns: true / false
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    warp_url_exist("http://google.com");
   *  </pre>
   *
   * @param  string $url
   *
   * @return bool
   */
  function warp_url_exist($url) {

    if(preg_match("#^https://#ui", $url) != 0)
      $url = str_replace("https://", "", $url);
    if(preg_match("#^http://#ui", $url) != 0)
      $url = str_replace("http://", "", $url);

    if (strstr($url, "/")) {
        $url = explode("/", $url, 2);
        $url[1] = "/".$url[1];
    } else {
        $url = array($url, "/");
    }

    try {
      $fh = fsockopen($url[0], 80);
    } catch(\Exception $e) {}
    if(isset($fh) && $fh) {
        fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
        if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { return FALSE; }
        else { return TRUE;    }

    } else { return FALSE;}

  }
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_url_exist', because such function is already exists!");
}

if(!function_exists('warp_array_unique_recursive')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Like array_unique, but for multidimensional arrays
   *    Returns processed array.
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    $array = [1,2,3,2,1,[1,2,3,2,1]];
   *    warp_array_unique_recursive($array);  // [1,2,3,[1,2,3]]
   *  </pre>
   *
   * @param  array $array
   *
   * @return array
   */
  function warp_array_unique_recursive($array) {
    $result = array_map("unserialize", array_unique(array_map("serialize", $array)));
    $result = array_values($result);

    foreach ($result as $key => $value)
    {
      if ( is_array($value) )
      {
        $result[$key] = warp_array_unique_recursive($value);
      }
    }

    return $result;
  }
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_array_unique_recursive', because such function is already exists!");
}

if(!function_exists('warp_udatetime')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Get from timestamp formatted representation of datetime with microseconds
   *  </pre>
   *  <h1>Examples</h1>
   *  <pre>
   *    r1_udatetime();                 // '605252'
   *    r1_udatetime('u');              // '605252'
   *    r1_udatetime('Y-m-d H:i:s.u');  // '2017-08-11 15:14:11.605252'
   *  </pre>
   *
   * @param  string $format
   * @param  string $utimestamp
   *
   * @return array
   */
  function warp_udatetime($format = 'u', $utimestamp = null) {
    if (is_null($utimestamp))
        $utimestamp = microtime(true);

    $timestamp = floor($utimestamp);
    $milliseconds = round(($utimestamp - $timestamp) * 1000000);

    return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
  }
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_udatetime', because such function is already exists!");
}

if(!function_exists('warp_fs')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Set base path and get instance of '\Illuminate\Filesystem\FilesystemManager instance'
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    Get list of names of all catalogues in 'vendor/warpcomplex'
   *    warp_fs('vendor/warpcomplex')->directories();               // ["warp"]
   *  </pre>
   *
   * @param  string $path
   *
   * @return object
   */
  function warp_fs($path) {

    config(['filesystems.default' => 'local']);
    config(['filesystems.disks.local.root' => base_path($path)]);
    return new \Illuminate\Filesystem\FilesystemManager(app());

  }
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_fs', because such function is already exists!");
}

if(!function_exists('warp_fs_manager')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Get instance (base path always equal to base_path()) of '\Illuminate\Filesystem\Filesystem'.
   *    Unlike warp_fs, you can't set base path for warp_fs_manager - it always equal to base_path() value.
   *    But, warp_fs_manager has more methods.
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    Get list of names of all catalogues in 'vendor/warpcomplex'
   *    warp_fs_manager()->directories('vendor/warpcomplex');       // ["vendor/warpcomplex/warp"]
   *  </pre>
   *
   * @return object
   */
  function warp_fs_manager() {

    return new \Illuminate\Filesystem\Filesystem();

  }
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_fs_manager', because such function is already exists!");
}

if(!function_exists('warp_countdim')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Counting multidimensional array dimension number
   *    Returns:
   *
   *      0     | In case of failure
   *      >= 1  | In case of success
   *
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    $arr = [1,2,[1,2,[1,2]]];
   *    $dims = warp_countdim($arr);  // 3
   *  </pre>
   *
   * @param  string $array
   *
   * @return object
   */
  function warp_countdim($array)
  { try {

    // 1] Если $array не массив, возбудить исключение
    if(!is_array($array))
      throw new \Exception('Параметр array не является массивом');

    // 2] Подготовить переменную для результата
    $result = 1;

    // 3] Если длина массива $array == 0, вернуть $result
    if(count($array) == 0) return $result;

    // 4] Написать рекурсивную функцию для прощупывания глубины
    $recur = function($item, $depth = 0) USE (&$recur) {

      // 4.1] Если $item не массив, вернуть 0
      if(!is_array($item)) return 0;

      // 4.2] Если $item это пустой массив
      if(count($item) == 0) return $depth;

      // 4.3] Если же $item это массив
      $results = [];
      foreach($item as $elem) {

        // 4.3.1] Если $elem не массив
        if(!is_array($elem)) array_push($results, +$depth);

        // 4.3.2] Если $elem массив
        else array_push($results, $recur($elem, +$depth+1));

      }

      // 4.4] Вернуть максимальное из $results
      return max($results);

    };

    // 5] Вернуть результат
    return +$result + +$recur($array);

  } catch(\Exception $e) {
    return 0;
  }}
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_countdim', because such function is already exists!");
}

if(!function_exists('warp_isJSON')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Whether the passed string is valid JSON
   *    Returns: true / false
   *  </pre>
   *  <h1>Пример использования</h1>
   *  <pre>
   *    $maybe_json = '{"name":"Ivan"}';
   *    $is_json = warp_isJSON($maybe_json);  // true
   *  </pre>
   *
   * Является ли переданная строка валидным JSON
   *
   * @param  string $string
   *
   * @return object
   */
  function warp_isJSON($string)
  { try {

    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);

  } catch(\Exception $e) {
    return false;
  }}
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_isJSON', because such function is already exists!");
}

if(!function_exists('warp_check_schema_exist')) {
  /**
   *  <h1>Описание</h1>
   *  <pre>
   *    Check if the specified database exists in the current connection
   *    Attention! Database name is case-sensitive!
   *    Returns: true / false
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    $schema = "warp";
   *    $is_schema_exists = warp_check_schema_exist(warp);  // true
   *  </pre>
   *
   * @param  string $schema
   *
   * @return bool
   */
  function warp_check_schema_exist($schema)
  { try {

    $check = \DB::SELECT("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$schema."'");
    if(empty($check)) return false;
    return true;

  } catch(\Exception $e) {
    return false;
  }}
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_check_schema_exist', because such function is already exists!");
}

if(!function_exists('warp_has_table')) {
  /**
   *  <h1>Описание</h1>
   *  <pre>
   *    Check if database in the current connection has specified table.
   *    Attention! Don't mess table and model; and db/table names are case-sensitive!
   *    Returns: true / false
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    $schema = "warp";
   *    $table  = "users";
   *    $result  = warp_has_table($schema, $table);
   *  </pre>
   *
   * @param  string $db_name
   * @param  string $table_name
   *
   * @return bool
   */
  function warp_has_table($db_name, $table_name)
  { try {

    // Проверить
    $exists = DB::table('information_schema.tables')
        ->where('table_schema','=',$db_name)
        ->where('table_name','=',$table_name)
        ->first();

    // Вернуть результат
    return !empty($exists);

  } catch(\Exception $e) {
    return false;
  }}
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_has_table', because such function is already exists!");
}

if(!function_exists('warp_has_column')) {
  /**
   *  <h1>Описание</h1>
   *  <pre>
   *    Check if database in the current connection has specified table with specified column
   *    Attention! Don't mess table and model; and db/table/column names are case-sensitive!
   *    Returns: true / false
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    $schema  = "m1";
   *    $table   = "md2_packages";
   *    $column  = "deleted_at";
   *    $result  = warp_has_column($schema, $table, $column);
   *  </pre>
   *
   * @param  string $db_name
   * @param  string $table_name
   * @param  string $column_name
   *
   * @return bool
   */
  function warp_has_column($db_name, $table_name, $column_name)
  { try {

    // Проверить
    $exists = DB::table('information_schema.columns')
          ->where('table_schema','=',$db_name)
          ->where('table_name','=',$table_name)
          ->where('column_name','=',$column_name)
          ->first();

    // Вернуть результат
    return !empty($exists);

  } catch(\Exception $e) {
    return false;
  }}
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_has_column', because such function is already exists!");
}


if(!function_exists('warp_get_columns')) {
  /**
   *  <h1>Описание</h1>
   *  <pre>
   *    Get all column names of specified table in the current connection
   *    Returns NULL in case of failure, or names array in case of success.
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    $schema  = "warp";
   *    $table   = "users";
   *    $columns = warp_get_columns($schema, $table);
   *  </pre>
   *
   * @param  string $db_name
   * @param  string $table_name
   *
   * @return bool
   */
  function warp_get_columns($db_name, $table_name)
  { try {

    // Получить
    $columns = DB::SELECT("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$db_name."' AND TABLE_NAME = '".$table_name."'");

    // Отвильтровать
    $columns = array_map(function($item){
      return $item->COLUMN_NAME;
    }, $columns);

    // Вернуть результат
    return $columns;

  } catch(\Exception $e) {
    write2log('Ошибка в хелпере r1_getColumns: '.$e->getMessage(), ['r1_getColumns']);
    return NULL;
  }}
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_get_columns', because such function is already exists!");
}


if(!function_exists('warp_checksum')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Get file checksum
   *    Returns: checksum or false in case of failure
   *  </pre>
   *  <h1>Пример использования</h1>
   *  <pre>
   *    $path       = "/c/some/dir";
   *    $checksum   = warp_checksum($path);
   *  </pre>
   *
   * @param  string $path
   *
   * @return mixed
   */
  function warp_checksum($path)
  { try {

    // 1. Если по адресу $path нет ни файла, ни папки, вернуть пустую строку
    if(!file_exists($path)) return "";

    // 2. Если по адресу $path находится файл, вернуть его md5-хэш
    if(is_file($path)) return md5_file($path);

    // 3. Если по адресу $path находится каталог, вернуть сумму хэшей его файлов
    $md5_dir = function($path) USE (&$md5_dir) {

      $filemd5s = array();
      $d = dir($path);

      while (false !== ($entry = $d->read()))
      {

          if ($entry != '.' && $entry != '..')
          {
               if (is_dir($path.'/'.$entry))
               {
                   $filemd5s[] = $md5_dir($path.'/'.$entry);
               }
               else
               {
                   $filemd5s[] = md5_file($path.'/'.$entry);
               }
           }
      }

      $d->close();
      return md5(implode('', $filemd5s));

    };
    return $md5_dir($path);

  } catch(\Exception $e) {
    return false;
  }}
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_checksum', because such function is already exists!");
}


if(!function_exists('warp_encrypt_data')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Encrypt text with specific key
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    $crypttext = warp_encrypt_data($key,$text);
   *  </pre>
   *
   * @param  string $key
   * @param  string $text
   *
   * @return mixed
   */
  function warp_encrypt_data($text, $key)
  { try {
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_text = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
    return base64_encode($encrypted_text);
  } catch(\Exception $e) {
    return false;
  }}
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_encrypt_data', because such function is already exists!");
}


if(!function_exists('warp_decrypt_data')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Decrypt text with specific key
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    $crypttext = warp_decrypt_data($key,$text);
   *  </pre>
   *
   * @param  string $key
   * @param  string $text
   *
   * @return mixed
   */
  function warp_decrypt_data($text, $key)
  { try {
    $text = base64_decode($text);
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_text = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
    return rtrim($decrypted_text, "\0");
  } catch(\Exception $e) {
    return false;
  }}
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_decrypt_data', because such function is already exists!");
}


if(!function_exists('warp_validate')) {
  /**
   *
   *  <h1>Description</h1>
   *  <pre>
   *    Perform validation process
   *  </pre>
   *  <h1>Example of $values</h1>
   *  <pre>
   *    ["id" => 1, "name" => "ivan"]
   *  </pre>
   *  <h1>Example of $rules</h1>
   *  <pre>
   *    ["id" => "required|digits|max:255", "name" => "sometimes"]
   *  </pre>
   *  <h1>Standard Laravel validation rules</h1>
   *  <pre>
   *    accepted             | The field under validation must be yes, on, 1, or true. This is useful for validating "Terms of Service" acceptance.
   *    active_url           | The field under validation must be a valid URL according to the checkdnsrr PHP function.
   *    after:date           | The field under validation must be a value after a given date. The dates will be passed into the strtotime PHP function.
   *    alpha                | The field under validation must be entirely alphabetic characters.
   *    alpha_dash           | The field under validation may have alpha-numeric characters, as well as dashes and underscores.
   *    alpha_num            | The field under validation must be entirely alpha-numeric characters.
   *    array                | The field under validation must be a PHP array.
   *    before:date          | The field under validation must be a value preceding the given date. The dates will be passed into the PHP strtotime function.
   *    between:min,max      | The field under validation must have a size between the given min and max. Strings, numerics, and files are evaluated in the same fashion as the size rule.
   *    boolean              | The field under validation must be able to be cast as a boolean. Accepted input are true, false, 1, 0, "1", and "0".
   *    confirmed            | The field under validation must have a matching field of foo_confirmation. For example, if the field under validation is password, a matching password_confirmation field must be present in the input.
   *    date                 | The field under validation must be a valid date according to the strtotime PHP function.
   *    date_format:format   | The field under validation must match the given format. The format will be evaluated using the PHP date_parse_from_format function. You should use either date or date_format when validating a field, not both.
   *    different:field      | The field under validation must have a different value than field.
   *    digits:value         | The field under validation must be numeric and must have an exact length of value.
   *    digits_between::min,max  | The field under validation must have a length between the given min and max.
   *    email                | The field under validation must be formatted as an e-mail address.
   *    exists:table,column  | The field under validation must exist on a given database table. 'state' => 'exists:states,abbreviation'
   *    image                | The file under validation must be an image (jpeg, png, bmp, gif, or svg)
   *    in:foo,bar,...       | The field under validation must be included in the given list of values.
   *    integer              | The field under validation must be an integer.
   *    ip                   | The field under validation must be an IP address.
   *    jSON                 | The field under validation must a valid JSON string.
   *    max:value            | The field under validation must be less than or equal to a maximum value. Strings, numerics, and files are evaluated in the same fashion as the size rule.
   *    mimes:foo,bar,...    | The file under validation must have a MIME type corresponding to one of the listed extensions. 'photo' => 'mimes:jpeg,bmp,png'
   *    min:value            | The field under validation must have a minimum value. Strings, numerics, and files are evaluated in the same fashion as the size rule.
   *    not_in:foo,bar,...   | The field under validation must not be included in the given list of values.
   *    numeric              | The field under validation must be numeric.
   *    regex:pattern        | The field under validation must match the given regular expression. When using the regex pattern, it may be necessary to specify rules in an array instead of using pipe delimiters, especially if the regular expression contains a pipe character.
   *    required             | The field under validation must be present in the input data and not empty. A field is considered "empty" if one of the following conditions are true: null, empty string, empty array, uploaded file with no path
   *    required_if:anotherfield,value,...      | The field under validation must be present if the anotherfield field is equal to any value.
   *    required_unless:anotherfield,value,...  | The field under validation must be present unless the anotherfield field is equal to any value.
   *    required_with:foo,bar,...               | The field under validation must be present only if any of the other specified fields are present.
   *    required_with_all:foo,bar,...           | The field under validation must be present only if all of the other specified fields are present.
   *    required_without:foo,bar,...            | The field under validation must be present only when any of the other specified fields are not present.
   *    required_without_all:foo,bar,...        | The field under validation must be present only when all of the other specified fields are not present.
   *    same:field           | The given field must match the field under validation.
   *    size:value           | The field under validation must have a size matching the given value. For string data, value corresponds to the number of characters. For numeric data, value corresponds to a given integer value. For files, size corresponds to the file size in kilobytes.
   *    string               | The field under validation must be a string.
   *    timezone             | The field under validation must be a valid timezone identifier according to the timezone_identifiers_list PHP function.
   *    unique:table,column,except,idColumn     | The field under validation must be unique on a given database table. If the column option is not specified, the field name will be used.
   *    url                  | The field under validation must be a valid URL according to PHP's filter_var function.
   *  </pre>
   *  <h1>Choosen standard Laravel validation rules</h1>
   *  <pre>
   *    sometimes            | Validate only if that field presents in $values
   *    required             | That field must present in $values
   *    regex:pattern        | Must match regex. Example: regex:/^[DLW]{1}[0-9]+$/ui
   *    numeric              | Must be a number
   *    digits:value         | Must be numeric and must have an exact length of value
   *    in:foo,bar,...       | Must be in list of foo,bar,...
   *    boolean              | Must be: true, false, 1, 0, "1", and "0".
   *    email                | Must be formatted as an e-mail address
   *    max:value            | Must be less than or equal to a maximum value
   *    min:value            | Must be more than or equal to a minimum value
   *    image                | Must be an image (jpeg, png, bmp, gif, or svg)
   *    mimes:foo,bar,...    | Must have a MIME type corresponding to one of the listed
   *  </pre>
   *  <h1>Custom validation rules</h1>
   *  <pre>
   *    warp_numpos            | Must be a positive integer
   *    warp_numnn             | Must be not negative positive integer
   *    warp_defined           | Must be not undefined
   *    warp_true              | must be true (not 1 or '1', only true)
   *    warp_false             | must be false (not 0 or '0', only false)
   *    warp_min:min           | number must be more or equal than min
   *    warp_max:max           | number must be less or equal than max
   *    warp_between:min,max   | number must be between min and max (inclusive)
   *  </pre>
   *
   * @param  string $values
   * @param  array $rules
   *
   * @return mixed
   */
  function warp_validate($values, $rules) {
    try {

      // 1. Создать объект-валидатор
      $validator = Validator::make($values, $rules);

      // 2. Если валидация провалилась
      if($validator->fails()) {

        // Вернуть сериализованный объект с ошибками валидации
        return [
            "status" => -1,
            "data"   => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
        ];

      }

      // 3. Если валидация не провалилась
      return [
          "status" => 0,
          "data"   => ""
      ];

    } catch(\Exception $e) {

      return [
        "status" => -1,
        "data"   => $e->getMessage()
      ];

    }
  }
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_validate', because such function is already exists!");
}


if(!function_exists('warp_mb_ucfirst')) {
  /**
   *  <h1>Description</h1>
   *  <pre>
   *    Multibyte ucfirst
   *  </pre>
   *  <h1>Example</h1>
   *  <pre>
   *    $result = warp_mb_ucfirst('one two three');     // "One tho three"
   *  </pre>
   *
   * @param  string $text
   *
   * @return string
   */
  function warp_mb_ucfirst($text)
  { try {
    if($text{0}>="\xc3")
         return (($text{1}>="\xa0")?
         ($text{0}.chr(ord($text{1})-32)):
         ($text{0}.$text{1})).substr($text,2);
    else return ucfirst($text);
  } catch(\Exception $e) {
    return false;
  }}
} else {
  \Log::info("Attention! Can't create WARP helper 'warp_mb_ucfirst', because such function is already exists!");
}











