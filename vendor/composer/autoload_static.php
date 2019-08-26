<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4cf23fc741133070bdf40697e482fdac
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Projet5\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Projet5\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Projet5\\Controller\\ControllerAdmin' => __DIR__ . '/../..' . '/controller/ControllerAdmin.php',
        'Projet5\\Controller\\ControllerAdminComment' => __DIR__ . '/../..' . '/controller/ControllerAdminComment.php',
        'Projet5\\Controller\\ControllerAdminMessage' => __DIR__ . '/../..' . '/controller/ControllerAdminMessage.php',
        'Projet5\\Controller\\ControllerAdminPost' => __DIR__ . '/../..' . '/controller/ControllerAdminPost.php',
        'Projet5\\Controller\\ControllerAdminUser' => __DIR__ . '/../..' . '/controller/ControllerAdminUser.php',
        'Projet5\\Controller\\ControllerComment' => __DIR__ . '/../..' . '/controller/controllerComment.php',
        'Projet5\\Controller\\ControllerLogin' => __DIR__ . '/../..' . '/controller/ControllerLogin.php',
        'Projet5\\Controller\\ControllerMessage' => __DIR__ . '/../..' . '/controller/ControllerMessage.php',
        'Projet5\\Controller\\ControllerPost' => __DIR__ . '/../..' . '/controller/ControllerPost.php',
        'Projet5\\Controller\\ControllerRegister' => __DIR__ . '/../..' . '/controller/ControllerRegister.php',
        'Projet5\\Model\\AreaAdmin' => __DIR__ . '/../..' . '/model/AreaAdmin.php',
        'Projet5\\Model\\Comment' => __DIR__ . '/../..' . '/model/Comment.php',
        'Projet5\\Model\\CommentManager' => __DIR__ . '/../..' . '/model/CommentManager.php',
        'Projet5\\Model\\DataBase' => __DIR__ . '/../..' . '/model/BaseManager.php',
        'Projet5\\Model\\Message' => __DIR__ . '/../..' . '/model/Message.php',
        'Projet5\\Model\\MessageManager' => __DIR__ . '/../..' . '/model/MessageManager.php',
        'Projet5\\Model\\Post' => __DIR__ . '/../..' . '/model/Post.php',
        'Projet5\\Model\\PostManager' => __DIR__ . '/../..' . '/model/PostManager.php',
        'Projet5\\Model\\User' => __DIR__ . '/../..' . '/model/User.php',
        'Projet5\\Model\\UserManager' => __DIR__ . '/../..' . '/model/UserManager.php',
        'Projet5\\Service\\GenerateView' => __DIR__ . '/../..' . '/service/GenerateView.php',
        'Projet5\\Service\\Hydrate' => __DIR__ . '/../..' . '/service/Hydrate.php',
        'Projet5\\Service\\Router' => __DIR__ . '/../..' . '/service/Router.php',
        'Projet5\\View\\View' => __DIR__ . '/../..' . '/view/View.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4cf23fc741133070bdf40697e482fdac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4cf23fc741133070bdf40697e482fdac::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4cf23fc741133070bdf40697e482fdac::$classMap;

        }, null, ClassLoader::class);
    }
}
