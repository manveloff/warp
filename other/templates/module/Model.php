<?php
/**
 *
 * The Model "({[model_name]})" of the module "({[module_name]})"
 *
 */

namespace WARP\modules\({[module_name]})\models;
use Illuminate\Database\Eloquent\Model,
    Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Table of contents
 *
 *  A. System data (don't edit manually, changes will not save)
 *
 *    A1. Table name
 *    A2. Timestamps auto maintenance on/off
 *    A3. Soft deletes on/off
 *    A4. Auto table relationships (local and trans-module)
 *
 *  B. User data (you can edit it, changes will save)
 *
 *    B1. Connection name
 *    B2. Primary key column
 *    B3. Autoincrement on/off
 *    B4. Mass assignment white list
 *    B5. Mass assignment black list
 *    B6. Automatic type conversion
 *    B7. Columns to hide when converting a model to an array/json
 *    B8. Only these columns will be passed when converting a model to an array/json
 *    B9. These columns will be added to the result when converting a model to an array/json
 *
 *    B10. Scopes (model request templates)
 *    B11. Accessors
 *    B12. Mutators
 *
 *  C. Relationships handbook (rus)
 *
 *
 *
 */
class ({[model_name]}) extends Model {

  //-------------------------------------------------------------//
  // A. System data (don't edit manually, changes will not save) //
  //-------------------------------------------------------------//

    /** A1. Table name */
    protected $table = '({[module_name]}).({[model_name]})';

    /** A2. Timestamps auto maintenance on/off */
    public $timestamps = ({[is_timestamps_auto_maintenance_on]});

    /**
     * A3. Soft deletes on/off
     *
     * How to turn on:
     *
     *  use SoftDeletes;
     *  protected $dates = ['deleted_at'];
     *
     */
    ({[is_soft_deletes_on]})

    /** A4. Auto table relationships (local and trans-module) */
    ({[relationships]})


  //---------------------------------------------------//
  // B. User data (you can edit it, changes will save) //
  //---------------------------------------------------//
  // USER DATA: START //

    //###################################################//
    //!!!!!!!!!!!!!!!! A T T E N T I O N !!!!!!!!!!!!!!!!//
    //###################################################//
    //                                                   //
    // Don't delete/change/move "USER DATA: START" and   //
    // "USER DATA: END" marks, or everything will break! //
    //                                                   //
    //###################################################//

    /**
     * B1. Connection name
     * Default value in 'default' in 'config/database.php'
     */
    //protected $connection = '';

    /**
     * B2. Primary key column
     * 'id' by default
     */
    //$primaryKey = '';

    /**
     * B3. Autoincrement on/off
     * true by default
     */
    //$incrementing = true;

    /**
     * B4. Mass assignment white list
     * Hint: You can use asterisk to say 'all': ['*']
     */
    //protected $fillable = ['id', 'password'];

    /**
     * B5. Mass assignment black list
     * Hint: You can use asterisk to say 'all': ['*']
     */
    //protected $guarded = ['id', 'password'];

    /**
     * B6. Automatic type conversion
     */
    //protected $casts = [
    //  'example' => 'array',
    //];

    /**
     * B7. Columns to hide when converting a model to an array/json
     */
    //protected $hidden = ['password'];

    /**
     * B8. Only these columns will be passed when converting a model to an array/json
     */
    //protected $visible = ['first_name', 'last_name'];

    /**
     * B9. These columns will be added to the result when converting a model to an array/json
     * Hint: exactly values should be pointed in accessors.
     */
    //protected $appends = ['is_admin'];

    //---------------------------------------//
    // B10. Scopes (model request templates) //
    //---------------------------------------//
    // - Scope names should start with 'scope', for example: "scopeName1"
    // - How to use (example): User::name1()->name2()->get();

      /** Scope with parameter example */
      //public function scopeName1($query, $param1) {
      //  return $query->where('votes', '>', $param1);
      //}

    //----------------//
    // B11. Accessors //
    //----------------//
    //
    // Accessor allows making some changes to columns data when
    // reading data from the model.
    //
    // Accessor name schema: getNameAttribute
    //
    //  • get         | All accessor names have to start with "get"
    //  • Name        | Column name
    //  • Attribute   | All accessor names have to end with "Attribute"
    //
    // Examples of accessor names:
    //
    //  • getIdUserAttribute    | column name: 'id_user'
    //  • getIdUserAttribute    | column name: 'iduser'
    //  • getUserNameAttribute  | column name: 'user_name'
    //  • getGroupAttribute     | column name: 'group'
    //

      /** Accessor example (make user name always start with a capital letter) */
      //public function getUserNameAttribute($value) {
      //  return ucfirst($value);
      //}

    //---------------//
    // B12. Mutators //
    //---------------//
    //
    // Mutator allows making some changes to columns data when
    // writing data to the model.
    //
    // Mutator name schema: setNameAttribute
    //
    //  • set         | All mutator names have to start with "set"
    //  • Name        | Column name
    //  • Attribute   | All mutator names have to end with "Attribute"
    //
    // Examples of mutator names:
    //
    //  • setIdUserAttribute    | column name: 'id_user'
    //  • setIdUserAttribute    | column name: 'iduser'
    //  • setUserNameAttribute  | column name: 'user_name'
    //  • setGroupAttribute     | column name: 'group'
    //

      /** Mutator example (make user name always start with a capital letter) */
      //public function setUserNameAttribute($value) {
      //  $this->attributes['user_name'] = ucfirst($value);
      //}


  // USER DATA: END //
  //---------------------------------//
  // C. Relationships handbook (rus) //
  //---------------------------------//

    //-----------------------------//
    // Три быстрых примера-шаблона //
    //-----------------------------//

      // 1]  //
      //---------------------//
      // - 1:n прямая
      // - [X]---Є[Y] Какие Y принадлежат этому X
      //public function many_y()
      //{
      //  return $this->hasMany('\PARAMmpackidPARAM\Models\MD2_y', 'id_y', 'id');
      //}

      // 2]  //
      //---------------------//
      // - 1:n обратная
      // - [Y]Э---[X] Какому X принадлежит этот Y
      //public function one_x()
      //{
      //  return $this->belongsTo('\PARAMmpackidPARAM\Models\MD1_x', 'id_y', 'id');
      //}

      // 3]  //
      //---------------------//
      // - n:m
      // - [A]Э---Є[B] С какими A связан этот B
      //public function many_a()
      //{
      //  return $this->belongsToMany('\PARAMmpackidPARAM\Models\MD3_a', 'PARAMmpackid_strtolowerPARAM.md1000', 'id_b', 'id_a');
      //}


    //------------------------------------------------------//
    // Шаблоны (примеры) определений и использования связей //
    //------------------------------------------------------//

      //----------------------------------//
      // 1] hasOne() - cвязь 1:1 "прямая" //
      //----------------------------------//

        // Определение
        //--------------------------------//
        // - 1 аргумент: с какой моделью связь
        // - 2 аргумент: имя столбца в той модели, с которым связана эта
        // - 3 аргумент: имя столбца в этой модели, с которым связана та

          //  public function phone()
          //  {
          //    return $this->hasOne('\M1\Models\MD1_name', 'foreign_key', 'local_key');
          //  }

        // Использование
        //--------------------------------//

          // $phone = User::find(1)->phone;


      //-------------------------------------------------------------//
      // 2] belongsTo() - связь 1:1 "обратная", связь 1:n "обратная" //
      //-------------------------------------------------------------//

        // Определение
        //--------------------------------//
        // - 1 аргумент: с какой моделью связь
        // - 2 аргумент: имя столбца в этой модели, с которым связана та
        // - 3 аргумент: имя столбца в той модели, с которым связана эта

          //  public function user()
          //  {
          //    return $this->belongsTo('\M1\Models\MD1_name', 'local_key', 'parent_key');
          //  }

        // Использование
        //--------------------------------//

          // $user = Phone::find(1)->user;


      //-----------------------------------//
      // 3] hasMany() - связь 1:n "прямая" //
      //-----------------------------------//

        // Определение прямой 1:n связи
        //--------------------------------//
        // - 1 аргумент: с какой моделью связь
        // - 2 аргумент: имя столбца в той модели, с которым связана эта
        // - 3 аргумент: имя столбца в этой модели, с которым связана та

          //  public function comments()
          //  {
          //    return $this->hasMany('\M1\Models\MD1_name', 'foreign_key', 'local_key');
          //  }

        // Использование прямой 1:n связи
        //--------------------------------//

          //  - Получим коллекцию комментариев по определенному посту:
          //
          //      $comments = Post::find(1)->comments;
          //
          //  - Получим 1 найденный  коммент. к опред.посту с опред.заголовком:
          //
          //      $comment = Post::find(1)->comments()->where('title', '=', 'foo')->first();


        // Определение обратной 1:n связи
        //--------------------------------//
        // - 1 аргумент: с какой моделью связь
        // - 2 аргумент: имя столбца в этой модели, с которым связана та
        // - 3 аргумент: имя столбца в той модели, с которым связана эта

          //  public function user()
          //  {
          //    return $this->belongsTo('\M1\Models\MD1_name', 'foreign_key', 'parent_key');
          //  }

        // Использование обратной 1:n связи
        //--------------------------------//

          // $post = Comment::find(1)->post;


      //----------------------------------------------//
      // 4] hasManyThrough() - связь 1:n "транзитная" //
      //----------------------------------------------//

        // Определение
        //--------------------------------//
        // - В этом примере связываем текущую модель с MD1 через MD2.
        // - 1 аргумент: с какой моделью связь
        // - 2 аргумент: модель-посредник, через которую связь
        // - 3 аргумент: имя столбца в этой модели, с которым связана та
        // - 4 аргумент: имя столбца в той модели, с которым связана эта

          //  public function user()
          //  {
          //    return $this->hasManyThrough('\M1\Models\MD1_name', '\M1\Models\MD2_name', 'foreign_key', 'local_key');
          //  }

        // Использование
        //--------------------------------//

          // $posts = Country::find(1)->posts;


      //---------------------------------------------------------//
      // 5] morphMany() - связь 1:n, 1:x, 1:y, ... "полиморфная" //
      //---------------------------------------------------------//

        // Определение
        //--------------------------------//

          //  # Дочерняя модель
          //  class Comments extends Model {
          //    public function morphowner(){
          //      return $this->morphTo();
          //    }
          //  }
          //
          //  # Родительские модели
          //  class Blogs extends Model {
          //    public function comments(){
          //      return $this->morphMany('App\Blogs', 'morphowner');
          //    }
          //  }
          //  class Goods extends Model {
          //    public function comments(){
          //      return $this->morphMany('App\Goods', 'morphowner');
          //    }
          //  }
          //  class News extends Model {
          //    public function comments(){
          //      return $this->morphMany('App\News', 'morphowner');
          //    }
          //  }


        // Использование
        //--------------------------------//

          //  $blog = Blogs::find(1);
          //  foreach($blog->comments as $comment) {
          //    //
          //  }
          //
          //  $good = Goods::find(1);
          //  foreach($good->comments as $comment) {
          //    //
          //  }
          //
          //  $news = News::find(1);
          //  foreach($news->comments as $n) {
          //    //
          //  }


        // Получение родителя полиморфной связи по дочке
        //----------------------------------------------//

          //  $comment = Comments::find(1);
          //  $owner = $comment->morphowner;


      //--------------------------------//
      // 6] belongsToMany() - связь n:m //
      //--------------------------------//

        // Определение (прямая и обратная определяются одинаково)
        //-------------------------------------------------------//
        // - 1 аргумент: с какой моделью связь
        // - 2 аргумент: имя pivot-таблицы
        // - 3 аргумент: столбец в родительской таблице, с которым связь
        // - 4 аргумент: столбец в этой таблице, с которым связь

          //  public function students()
          //  {
          //    return $this->belongsToMany('App\Student', 'user_roles', 'user_id', 'foo_id');
          //  }


        // Использование
        //--------------------------------//

          //  # Получить коллекцию всех студентов данного учителя
          //  $students = Teacher::find(1)->students;
          //
          //  # Получить коллекцию всех учителей данного студента
          //  $teachers = Student::find(1)->teachers;


      //-----------------------------------------------------------//
      // 7] morphToMany() - связь n:m, n:x, n:y, ... "полиморфная" //
      //-----------------------------------------------------------//

        // Определение
        //--------------------------------//

          //  # Дочерняя модель
          //  class Tag extends Model {
          //
          //      public function posts()
          //      {
          //          return $this->morphedByMany('App\Post', 'taggable');
          //      }
          //
          //      public function videos()
          //      {
          //          return $this->morphedByMany('App\Video', 'taggable');
          //      }
          //
          //  }
          //
          //  # Родительские модели
          //  class Post extends Model {
          //
          //      public function tags()
          //      {
          //          return $this->morphToMany('App\Tag', 'taggable');
          //      }
          //
          //  }
          //  class Video extends Model {
          //
          //      public function tags()
          //      {
          //          return $this->morphToMany('App\Tag', 'taggable');
          //      }
          //
          //  }

        // Использование
        //--------------------------------//

          //  # Получить коллекцию видео по указанному тегу
          //  $videos = Tags::find(1)->videos;
          //
          //  # Получить коллекцию постов по указанному тегу
          //  $videos = Tags::find(1)->posts;




}








