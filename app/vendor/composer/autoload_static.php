<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf31c384aeca70ecd12cf67aaff734f72
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Abraham\\TwitterOAuth\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Abraham\\TwitterOAuth\\' => 
        array (
            0 => __DIR__ . '/..' . '/abraham/twitteroauth/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf31c384aeca70ecd12cf67aaff734f72::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf31c384aeca70ecd12cf67aaff734f72::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}