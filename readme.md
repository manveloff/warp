# WARP Project Control Center (aka hub)
---
## Table of contents

  - [Links](#link1)
  - [Description](#link2)
  - [Install and uninstall for users](#link3)
  - [Install and uninstall for developers](#link4)
  - [Release notes](#link100)

---

## Links <a id="link1"></a>
```

  > Address on GitHub
      https://github.com/warpcomplex/warp
	
			
```

## Description <a id="link2"></a>
```
WARP Project Control Center


 
```

## Install and uninstall for users <a id="link3"></a>
```
What do you mean "for users"?
-----------------------------
You could use this type of install/uninstall, if you are not
going to make some contributions to this package as a developer.

Step-by-step installation instruction
-------------------------------------

  1. Put the package to 'require' in 'composer.json' of your project:

    "require": {
      ...
	  "warpcomplex/warp": "dev-master"
    },

  2. Invoke this command in terminal at your project root:

    composer update

  3. Put this string to aliases in config/app.php of your project:

    "aliases" => [
      ...
      WARP => WARP\App::class,
    ]

  4. Put this strings to providers in config/app.php of your project:

    "providers" => [
      ...
      WARP\providers\General::class,
      WARP\providers\Validators::class,
      WARP\providers\Gates::class,
    ]

  5. Invoke this commands in terminal at your project root:

    composer dump-autoload    // will have updated composer class autoloader
    artisan warp:install      // will have performed several install processes

Step-by-step uninstallation instruction
---------------------------------------

  1. Remove the package from 'require' in 'composer.json' of your project:

    "require": {
      ...
	  "warpcomplex/warp": "dev-master"
    },

  2. Invoke this command in terminal at your project root:

    composer update

  3. Remove this string from aliases in config/app.php of your project:

    "aliases" => [
      ...
      WARP => WARP\App::class,
    ]

  4. Remove this strings from providers in config/app.php of your project:

    "providers" => [
      ...
      WARP\providers\General::class,
      WARP\providers\Validators::class,
      WARP\providers\Gates::class,
    ]

  5. Invoke this commands in terminal at your project root:

    composer dump-autoload    // will have updated composer class autoloader
    artisan warp:uninstall    // will have performed several uninstall processes


```

## Install and uninstall for developers <a id="link4"></a>
```
What do you mean "for developers"?
----------------------------------
You could use this type of install/uninstall, if you are going
to make some contributions to this package as a developer.

Step-by-step installation instruction
-------------------------------------

  1. From the project root clone the package repository from github to vendor/warpcomplex/warp:

    git clone https://github.com/warpcomplex/warp.git vendor/warpcomplex/warp

  2. Put this to 'require' in 'composer.json' of your project:

    "require": {
      ...
      "predis/predis": "^1.0"
    },

  3. Invoke this command in terminal at your project root:

    composer update

  4. Put this to 'PSR-4' in 'autoload' in 'composer.json' of your project:

    "autoload": {
      ...
      "PSR-4": {
        ...
	    "WARP\\": "vendor/warpcomplex/warp/app"
	  }
    },

  5. Put this string to aliases in config/app.php of your project:

    "aliases" => [
      ...
      WARP => WARP\App::class,
    ]

  6. Put this strings to providers in config/app.php of your project:

    "providers" => [
      ...
      WARP\providers\General::class,
      WARP\providers\Validators::class,
      WARP\providers\Gates::class,
    ]

  7. Invoke this commands in terminal at your project root:

    composer dump-autoload    // will have updated composer class autoloader
    artisan warp:install      // will have performed several install processes

Step-by-step uninstallation instruction
---------------------------------------

  1. Remove folder vendor/warpcomplex/warp

  2. Remove this from 'require' in 'composer.json' of your project:

    "require": {
      ...
	  "predis/predis": "^1.0"
    },

  3. Invoke this command in terminal at your project root:

    composer update

  4. Remove this from 'PSR-4' in 'autoload' in 'composer.json' of your project:

    "autoload": {
      ...
      "PSR-4": {
        ...
	    "WARP\\": "vendor/warpcomplex/warp/app"
	  }
    },

  5. Remove this string from aliases in config/app.php of your project:

    "aliases" => [
      ...
      WARP => WARP\App::class,
    ]

  6. Remove this strings from providers in config/app.php of your project:

    "providers" => [
      ...
      WARP\providers\General::class,
      WARP\providers\Validators::class,
      WARP\providers\Gates::class,
    ]

  7. Invoke this commands in terminal at your project root:

    composer dump-autoload    // will have updated composer class autoloader
    artisan warp:uninstall    // will have performed several uninstall processes

```

## Release notes <a id="link100"></a>
```

  5.4.0
    - This will be the first release of this package.

```










