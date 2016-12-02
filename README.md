README
======

![license](https://img.shields.io/packagist/l/bafs/via.svg?style=flat-square)
![PHP 5.4+](https://img.shields.io/badge/PHP-5.4+-brightgreen.svg?style=flat-square)

What is Onus?
-----------------

Onus is a PHP Dependency Injection manager.

Installation
------------

The best way to install is to use the composer by command:

composer require newclass/onus

composer install

Use example
------------
    
    use Onus\ClassLoader;
    use Onus\MetadataClass;
    use Onus\MetadataMethod;

    $cl=new ClassLoader();

    $metadataClass=new MetadataClass('standalone',StandaloneClass::class); //StandaloneClass is your custom class.

    $metadataClass->addMethod('__construct')
        ->addArgument(MetadataMethod::PRIMITIVE_TYPE,'value1')
        ->addArgument(MetadataMethod::PRIMITIVE_TYPE,'value2');

    $metadataClass->addMethod('setParam3')
        ->addArgument(MetadataMethod::STATIC_TYPE,StandaloneClass::class.'::DATA');

    $cl->register($metadataClass);

    $metadataClass=new MetadataClass('dependency',DependencyClass::class); //DependencyClass is your custom class.

    $metadataClass->addMethod('setStandalone')
        ->addArgument(MetadataMethod::REFERENCE_TYPE,'standalone');

    $metadataClass->addMethod('enableFlag');

    $cl->register($metadataClass);

    $dependencyClass=$cl->get('dependency');

    $param1=$dependencyClass->getParam1(); //return "value1"
    $param2=$dependencyClass->getParam2(); //return "value2"
    $param3=$dependencyClass->getParam3(); //return data1
    $flag=$dependencyClass->isFlag(); //return true
