# Robo Phinx Extension
[![Build Status](https://travis-ci.org/robertboloc/robo-phinx.svg?branch=master)](https://travis-ci.org/robertboloc/robo-phinx)

Integrates Phinx tool with the Robo task runner.


## Table of contents
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)

## Installation
Add `"robertboloc/robo-phinx": "dev-master"` to your composer.json.
```json
    {
        "require": {
            "robertboloc/robo-phinx": "dev-master"
        }
    }
```

Execute `composer update`

## Usage

Use the `Phinx` trait in your `RoboFile.php`
```php
<?php

class Robofile extends \Robo\Tasks
{
    use \Rb\Robo\Task\Phinx;
    
    //...
}
```

Build your tasks using the `Phinx` commands:

### Init
```php
<?php

$this->taskPhinx()
     ->init($path = '.')
     ->getCommand();
```
### Create
```php
<?php

$this->taskPhinx()
     ->create($migration)
     ->getCommand();
```
### Migrate
```php
<?php

$this->taskPhinx()
     ->migrate($target = null)
     ->getCommand();
```
### Rollback
```php
<?php

$this->taskPhinx()
     ->rollback($target = null)
     ->getCommand();
```
### Status
```php
<?php

$this->taskPhinx()
     ->status()
     ->getCommand();
```

## Configuration

You can apply configuration parameters to all the commands using the configuration modifiers:

### Config
```php
<?php

$this->taskPhinx()
     ->config($file = 'phinx.yml')
     ->status()
     ->getCommand();
```

### Parser 
```php
<?php

$this->taskPhinx()
     ->parser($format = 'yaml')
     ->status()
     ->getCommand();
```

### Environment
```php
<?php

$this->taskPhinx()
     ->environment($environment = 'development')
     ->status()
     ->getCommand();
```

Note that all the commands have their default arguments in parenthesis. If no argument is specified the command takes no argument.
