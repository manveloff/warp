<?php
/**
 *
 * Groups model
 *
 */

namespace WARP\models;
use Illuminate\Database\Eloquent\Model,
    Illuminate\Database\Eloquent\SoftDeletes;

/**
 *  Table of content:
 *
 *    1. Basic
 *    2. Relationships
 *    3. Additional
 *    4. Scopes
 *    5. Accessors
 *    6. Mutators
 *    
 *    Model relationships reference
 *
 */
class Groups extends Model {

  //----------//
  // 1. Basic //
  //----------//

    /**
     * Table name (qualified by database name)
     *
     *  • By default, the name of the model class with 's' on the end
     *  • Attention! The register in the table name matters!
     *
     */
    protected $table = 'warp.groups';

    /**
     * Turn on(default) / off auto-maintenance of columns created_at / updated_at
     */
    public $timestamps = true;

    /**
     * Turn on / off(default) soft delete
     */
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];


  //------------------//
  // 2. Relationships //
  //------------------//

    // relationships start


    // relationships stop


  //-----------------------------//
  // 3. The auxiliary functional //
  //-----------------------------//

    /**
     * DB connection name
     *
     * By default, specified in 'default' in config / database.php
     */
    // protected $connection = '';

    /**
     * Column with primary key name
     *
     * By default: 'id'
     */
    // protected $primaryKey = '';

    /**
     * Turn on (default) / off primary key column autoincrement
     */
    // protected $incrementing = false;

    /**
     * Configure whitelist for mass assignment
     */
    // protected $fillable = ['id', 'password'];

    /**
     * Configure blacklist for mass assignment
     */
    // protected $guarded = ['id', 'password'];
    // protected $guarded = ['*'];

    /**
     * Configure auto-cast types
     */
    // protected $casts = [
    //   'options' => 'array',
    // ];

    /**
     * Exclude this columns from result array/json
     *
     *  • This setting is triggered when the model is converted to an array/JSON.
     *  • The columns listed in the list will be excluded from the conversion results.
     *
     */
    // protected $hidden = ['password'];

    /**
     * Include this columns to result array/json
     *
     *  • This setting is triggered when the model is converted to an array/JSON.
     *  • Only the columns listed in the list will be present in the conversion results.
     *
     */
    // protected $visible = ['first_name', 'last_name'];

    /**
     * Append this columns to result array/json
     *
     *  • This setting is triggered when the model is converted to an array/JSON.
     *  • The columns listed in the list will be appended to the conversion results.
     *  • What exactly values will be added is indicated in the corresponding assessors.
     *
     */
    // protected $appends = ['is_admin'];

    /**
     * The attributes that should be mutated to dates.
     *
     * By default: 'created_at', 'updated_at', 'deleted_at'
     *
     */
    //protected $dates = [
    //  'created_at',
    //  'updated_at',
    //  'deleted_at'
    //];


  //-----------//
  // 4. Scopes //
  //-----------//
  // - Query chunk templates.
  // - Their names should start with 'scope'.
  // - How to use (example):
  //
  //    User::scopeGetUsersWithNPosts(100)->get();
  //

    /**
     * [EXAMPLE] Get users having more than 100 posts
     */
     public function scopeGetUsersWithNPosts($query, $postsNumber) {
       return $query->where('posts', '>', $postsNumber)->get();
     }


  //--------------//
  // 5. Accessors //
  //--------------//
  //
  //  • In general, it looks like a filter
  //    - The accessor allows you to get the "slightly processed" data from the specified columns.
  //    - That is, to make the specified changes to them.
  //
  //  • We will analyze what the name of the accessor consists of in the example below:
  //
  //    ▪ get           | Accessor names starts with 'get'
  //    ▪ Name          | The name of the column for which this accessor is intended
  //    ▪ Attribute     | The technical part of the accessor, it is always unchanged
  //
  //  • What if the column name is in the snake_case style?
  //    - To write it all the same in CamelCase.
  //    - For example, if the name of the column is 'id_user', then the name of the accessor function is: 'getIdUserAttribute'.
  //

    /**
     * [EXAMPLE] Change 1-st letter to capital when get user_name value
     */
    public function getUserNameAttribute($value) {
      return ucfirst($value);
    }


  //-------------//
  // 6. Mutators //
  //-------------//
  //
  //  • In general, it looks like a filter
  //    - The accessor allows you to get the "slightly processed" data from the specified columns.
  //    - That is, to make the specified changes to them.
  //
  //  • We will analyze what the name of the mutator consists of in the example below:
  //
  //    ▪ set           | Mutator names starts with 'set'
  //    ▪ Name          | The name of the column for which this mutator is intended
  //    ▪ Attribute     | The technical part of the mutator, it is always unchanged
  //
  //  • What if the column name is in the snake_case style?
  //    - To write it all the same in CamelCase.
  //    - For example, if the name of the column is 'id_user', then the name of the mutator function is: 'setIdUserAttribute'.
  //

    /**
     * [EXAMPLE] Change 1-st letter to capital when set user_name column
     */
    public function setUserNameAttribute($value) {
      return ucfirst($value);
    }

  
  //-------------------------------//
  // Model relationships reference //
  //-------------------------------//

    //-----------------------------//
    // Три быстрых примера-шаблона //
    //-----------------------------//

      // 1]  //
      //---------------------//
      // - 1:n прямая
      // - [X]---Є[Y] Какие Y принадлежат этому X
      //public function many_y()
      //{
      //  return $this->hasMany('\M5\Models\MD2_y', 'id_y', 'id');
      //}

      // 1]  //
      //---------------------//
      // - 1:n обратная
      // - [Y]Э---[X] Какому X принадлежит этот Y
      //public function one_x()
      //{
      //  return $this->belongsTo('\M5\Models\MD1_x', 'id_y', 'id');
      //}

      // 1]  //
      //---------------------//
      // - n:m
      // - [A]Э---Є[B] С какими A связан этот B
      //public function many_a()
      //{
      //  return $this->belongsToMany('\M5\Models\MD3_a', 'm5.md1000', 'id_b', 'id_a');
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








