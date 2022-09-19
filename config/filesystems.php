<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        /*
         |--------------------------------------------------------------------------
         | Diferencias entre local y public
         |--------------------------------------------------------------------------
         | Podemos observar que Laravel incluye 2 discos por defecto que usan el
         | driver "local": "local" y "public".
         | "local" está pensado para archivos que sean de uso interno para el
         | framework. Es decir, que no sean accesibles para el usuario de la web.
         | "public", como el nombre indica, está pensado para almacenar archivos que
         | deban ser utilizados en la web, como imágenes subidas por usuarios, PDFs,
         | etc.
         | Por eso vemos que el disco de "public" tiene un par de claves más,
         | incluyendo una "url" que define la ruta de acceso a esos archivos que debe
         | generarse.
         | En ambos casos, vemos que tienen una clave "root" que apunta al
         | "storage_path('app')". La función storage_path crea una ruta absoluta a la
         | carpeta "storage" del proyecto en el servidor.
         | Para los archivos de la app, usa la carpeta "storage/app", y para los que
         | son de acceso público, "storage/app/public".
         */
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
