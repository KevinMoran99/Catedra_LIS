<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc3726f7144c526629da70bb94382e4da
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Http\\Models\\' => 12,
            'Http\\Controllers\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Http\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/http/models',
        ),
        'Http\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/http/controllers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc3726f7144c526629da70bb94382e4da::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc3726f7144c526629da70bb94382e4da::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
