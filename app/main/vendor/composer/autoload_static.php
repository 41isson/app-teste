<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd3eb14d6ec320fbf59f26a2d28ca18bf
{
    public static $prefixesPsr0 = array (
        'U' => 
        array (
            'Unirest\\' => 
            array (
                0 => __DIR__ . '/..' . '/mashape/unirest-php/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitd3eb14d6ec320fbf59f26a2d28ca18bf::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitd3eb14d6ec320fbf59f26a2d28ca18bf::$classMap;

        }, null, ClassLoader::class);
    }
}
