# Easy to use class for working with php configuration files from Illuminate/config
## Installing
    `composer require jamalosm/config 1.*`
## Usage
[illuminate/config repository](https://github.com/illuminate/config/blob/master/Repository.php)
```php
<?php
// config/app.php
return [
    "name" => 'B-ONE Application',
    "versions" => [
        "v1" => "19.02.2017",
        "v2" => "23.04.2018",
    ]
];
```
```php
<?php
// index.php
require 'vendor/autoload.php';
$instance = \BONE\Config\Config::getInstance(__DIR__."/config");
$instance->get('app.name'); //B-ONE Application
```
###Methods

#### has(string $key) :bool
Determine if the given configuration value exists.
```php  
   $instance->has('app.name'); //true
   $instance->has('app.path'); //false
```

#### get($key, $default = null)
Get the specified configuration value.
```php

    $instance->get('app.name'); //'B-ONE Application'
    
    $instance->get('app.versions');
    /*
    [
        "v1" => "19.02.2017",
        "v2" => "23.04.2018"
    ]
    */
 
    $instance->get('app.path'); //NULL
        
    $instance->get('app.path', 'application'); //'application'
   
    $instance->get(['app.name','app.versions.v1']);
    /*
    [
        "app3.name" => "B-ONE Application",
        "app3.versions.v1" => "19.02.2017",
    ]
     */
     
     $instance->get(['app.name','app.versions.v1','app.path']);
     /*
     [
         "app3.name" => "B-ONE Application",
         "app3.versions.v1" => "19.02.2017",
         "app.path" => null
     ]
      */
```

#### set($key, $value = null)
Set a given configuration value.
```php

    //Example 1
    $instance->get('app.path'); //NULL
    
    $instance->set('app.path', '\app\path');
    
    $instance->get('app.path'); //'\app\path'
    
    //Example 2
    $instance->get('app');
    /*
    [
         "name" => "B-ONE Application",
         "versions" => [
             "v1" => "19.02.2017",
             "v2" => "23.04.2018",
         ],
         "path" => "\app\path"
    ]
    */
    $instance->set([
        "app.versions.v1" => "19.02.2019",
        "app.versions.v3" => "19.06.2020",
        "app.path" => '\app\folder'
    ])
    $instance->get('app');
    /*
    [
         "name" => "B-ONE Application",
         "versions" => [
             "v1" => "19.02.2019",
             "v2" => "23.04.2018",
             "v3" => "19.06.2020",
         ],
         "path" => "\app\folder"
    ]
    */
    
    //Example 3
    $instance->set([
        "app" => [
            "name" => "Laravel Application", 
            "versions" => [
                "v4" => "12.07.2013",
            ]
        ]
    ]);
    $instance->get('app');
    /*
    [
        "name" => "Laravel Application", 
        "versions" => [
            "v4" => "12.07.2013",
        ]
    ]
    */
```

#### prepend($key, $value)
Prepend a value onto an array configuration value.
```php

    $instance->get('app.versions');
    /*
    [
        "v1" => "19.02.2017",
        "v2" => "23.04.2018",
    ]
    */

     $instance->prepend('app.versions',"12.07.2013")
     
     $instance->get('app.versions');
     /*
     [
         0 => "12.07.2013",
         "v1" => "19.02.2017",
         "v2" => "23.04.2018",
     ]
     */
         
```

#### push($key, $value)
Push a value onto an array configuration value.
```php
    $instance->get('app.versions');
    /*
    [
        "v1" => "19.02.2017",
        "v2" => "23.04.2018",
    ]
    */

     $instance->prepend('app.versions',"12.07.2013")
     
     $instance->get('app.versions');
     /*
     [
         "v1" => "19.02.2017",
         "v2" => "23.04.2018",
         0 => "12.07.2013",
     ]
     */
```

#### all()
Get all of the configuration items for the application.
```php
    $instance->all();
    /*
    [
        "app" => [
             "name" => "B-ONE Application",
             "versions" => [
                 "v1" => "19.02.2017",
                 "v2" => "23.04.2018",
             ],
             "path" => "\app\path"
        ]
    ]
    */
```