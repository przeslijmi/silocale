<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitddedd25ac13c898096081f4701494191
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Przeslijmi\\Silocale\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Przeslijmi\\Silocale\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitddedd25ac13c898096081f4701494191::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitddedd25ac13c898096081f4701494191::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
