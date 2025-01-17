<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfc31fdc5663bba8429eea0f1cbeb2fd2
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Codemanas\\Webex\\Inc\\' => 20,
            'Codemanas\\Webex\\Core\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Codemanas\\Webex\\Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
        'Codemanas\\Webex\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
    );

    public static $classMap = array (
        'Codemanas\\Webex\\Core\\Admin\\Admin' => __DIR__ . '/../..' . '/core/Admin/Admin.php',
        'Codemanas\\Webex\\Core\\Admin\\Events\\EventDetails' => __DIR__ . '/../..' . '/core/Admin/Events/EventDetails.php',
        'Codemanas\\Webex\\Core\\Admin\\Events\\PostType' => __DIR__ . '/../..' . '/core/Admin/Events/PostType.php',
        'Codemanas\\Webex\\Core\\Admin\\Importer\\Importer' => __DIR__ . '/../..' . '/core/Admin/Importer/Importer.php',
        'Codemanas\\Webex\\Core\\Admin\\Menu\\Menu' => __DIR__ . '/../..' . '/core/Admin/Menu/Menu.php',
        'Codemanas\\Webex\\Core\\Admin\\Recordings\\Recordings' => __DIR__ . '/../..' . '/core/Admin/Recordings/Recordings.php',
        'Codemanas\\Webex\\Core\\Admin\\Settings\\Settings' => __DIR__ . '/../..' . '/core/Admin/Settings/Settings.php',
        'Codemanas\\Webex\\Core\\Admin\\Users\\Users' => __DIR__ . '/../..' . '/core/Admin/Users/Users.php',
        'Codemanas\\Webex\\Core\\Api\\ApiException' => __DIR__ . '/../..' . '/core/Api/ApiException.php',
        'Codemanas\\Webex\\Core\\Api\\Client' => __DIR__ . '/../..' . '/core/Api/Client.php',
        'Codemanas\\Webex\\Core\\Api\\Endpoints' => __DIR__ . '/../..' . '/core/Api/Endpoints.php',
        'Codemanas\\Webex\\Core\\Data\\Config' => __DIR__ . '/../..' . '/core/Data/Config.php',
        'Codemanas\\Webex\\Core\\Data\\Meetings' => __DIR__ . '/../..' . '/core/Data/Meetings.php',
        'Codemanas\\Webex\\Core\\Helpers\\Constants' => __DIR__ . '/../..' . '/core/Helpers/Constants.php',
        'Codemanas\\Webex\\Core\\Helpers\\DateParser' => __DIR__ . '/../..' . '/core/Helpers/DateParser.php',
        'Codemanas\\Webex\\Core\\Helpers\\Fields' => __DIR__ . '/../..' . '/core/Helpers/Fields.php',
        'Codemanas\\Webex\\Core\\Helpers\\FieldsInterface' => __DIR__ . '/../..' . '/core/Helpers/FieldsInterface.php',
        'Codemanas\\Webex\\Core\\Helpers\\FormHelper' => __DIR__ . '/../..' . '/core/Helpers/FormHelper.php',
        'Codemanas\\Webex\\Core\\Helpers\\Helper' => __DIR__ . '/../..' . '/core/Helpers/Helper.php',
        'Codemanas\\Webex\\Core\\Helpers\\Logger' => __DIR__ . '/../..' . '/core/Helpers/Logger.php',
        'Codemanas\\Webex\\Core\\Helpers\\TemplateRouter' => __DIR__ . '/../..' . '/core/Helpers/TemplateRouter.php',
        'Codemanas\\Webex\\Core\\Kernel' => __DIR__ . '/../..' . '/core/Kernel.php',
        'Codemanas\\Webex\\Core\\Modules\\Events\\Ajax' => __DIR__ . '/../..' . '/core/Modules/Events/Ajax.php',
        'Codemanas\\Webex\\Core\\Modules\\Events\\Events' => __DIR__ . '/../..' . '/core/Modules/Events/Events.php',
        'Codemanas\\Webex\\Core\\Modules\\Modules' => __DIR__ . '/../..' . '/core/Modules/Modules.php',
        'Codemanas\\Webex\\Core\\Plugin' => __DIR__ . '/../..' . '/core/Plugin.php',
        'Codemanas\\Webex\\Core\\Shortcodes\\Shortcodes' => __DIR__ . '/../..' . '/core/Shortcodes/Shortcodes.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfc31fdc5663bba8429eea0f1cbeb2fd2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfc31fdc5663bba8429eea0f1cbeb2fd2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfc31fdc5663bba8429eea0f1cbeb2fd2::$classMap;

        }, null, ClassLoader::class);
    }
}
