# WARP Project Control Center (aka hub)
---
## Tabla of contents

  - [Links](#link1)
  - [Description](#link2)
  - [Installation](#link3)
  - [Release notes](#link100)

---

## Ссылки <a id="link1"></a>
```

  > Address on GitHub
      https://github.com/warpcomplex/warp
	
			
```

## Description <a id="link2"></a>
```
WARP Project Control Center, also known as "hub".


 
```

## Installation <a id="link3"></a>
```

  Полный процесс установки:
  - Добавить провайдеры в config/app.php

        WARP\providers\General::class,
        WARP\providers\Validators::class,
        WARP\providers\Gates::class,

  - Раскомментировать провайдер BroadcastServiceProvider в config/app.php
  - Добавить алиас WARP => WARP\App::class в aliases в config/app.php
  - Заменить App\User::class (или иное значение) в providers->users->model на WARP\models\Users::class в config/auth.php
  - Выполнить composer dump-autoload
  - Выполнить artisan warp:install







  - Add this strings to provider array in config/app.php:

        WARP\providers\General::class,
        WARP\providers\Validators::class,
        WARP\providers\Gates::class,

  - Uncomment BroadcastServiceProvider in config/app.php
  - Invoke: composer dump-autoload
  - Invoke: artisan warp:install

```

## Release notes <a id="link100"></a>
```

  5.4.0
    - First release.

```










