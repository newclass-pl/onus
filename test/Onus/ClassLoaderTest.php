<?php
/**
 * Onus: Dependency Injection
 * Copyright (c) NewClass (http://newclass.pl)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the file LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) NewClass (http://newclass.pl)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */


namespace Test\Onus;

use Onus\ClassLoader;
use Onus\InvalidTypeException;
use Onus\MetadataAlreadyRegisteredException;
use Onus\MetadataClass;
use Onus\MetadataMethod;
use Test\Asset\DependencyClass;
use Test\Asset\StandaloneClass;

/**
 * Class DependencyInjectionTest
 * @package Test\DependencyInjection
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class ClassLoaderTest extends \PHPUnit_Framework_TestCase{

    /**
     *
     */
	public function testGetStandalone(){

		$metadataClass=new MetadataClass('standalone',StandaloneClass::class);

		$metadataMethod=new MetadataMethod('__construct');
		$metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param1');
		$metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param2');
		$metadataClass->register($metadataMethod);

		$metadataMethod=new MetadataMethod('setParam3');
		$metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'data');
		$metadataClass->register($metadataMethod);

		$cl=new ClassLoader();
		$cl->register($metadataClass);

		$standaloneClass=$cl->get('standalone');

		$this->assertEquals('param1',$standaloneClass->getParam1());
		$this->assertEquals('param2',$standaloneClass->getParam2());
		$this->assertEquals('data',$standaloneClass->getParam3());
	}

    /**
     *
     */
	public function testGetDependency(){
		$cl=new ClassLoader();

		$metadataClass=new MetadataClass('standalone',StandaloneClass::class);

		$metadataClass->addMethod('__construct')
            ->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param1')
            ->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param2');

		$metadataClass->addMethod('setParam3')
            ->addArgument(MetadataMethod::STATIC_TYPE,StandaloneClass::class.'::DATA');

		$cl->register($metadataClass);

		$metadataClass=new MetadataClass('dependency',DependencyClass::class);

        $metadataClass->addMethod('setStandalone')
            ->addArgument(MetadataMethod::REFERENCE_TYPE,'standalone');

        $metadataClass->addMethod('enableFlag');

		$cl->register($metadataClass);

		$dependencyClass=$cl->get('dependency');

		$this->assertEquals('param1',$dependencyClass->getParam1());
		$this->assertEquals('param2',$dependencyClass->getParam2());
		$this->assertEquals('data1',$dependencyClass->getParam3());
		$this->assertTrue($dependencyClass->isFlag());
	}

    /**
     *
     */
    public function testGetNotSingleton(){

        $metadataClass=new MetadataClass('standalone',StandaloneClass::class,false);

        $metadataMethod=new MetadataMethod('__construct');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param1');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param2');
        $metadataClass->register($metadataMethod);

        $metadataMethod=new MetadataMethod('setParam3');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'data');
        $metadataClass->register($metadataMethod);

        $cl=new ClassLoader();
        $cl->register($metadataClass);

        $standaloneClass1=$cl->get('standalone');
        $standaloneClass2=$cl->get('standalone');

        $this->assertNotEquals(spl_object_hash($standaloneClass1),spl_object_hash($standaloneClass2));
    }

    /**
     *
     */
    public function testGetSingleton(){

        $metadataClass=new MetadataClass('standalone',StandaloneClass::class);

        $metadataMethod=new MetadataMethod('__construct');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param1');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param2');
        $metadataClass->register($metadataMethod);

        $metadataMethod=new MetadataMethod('setParam3');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'data');
        $metadataClass->register($metadataMethod);

        $cl=new ClassLoader();
        $cl->register($metadataClass);

        $standaloneClass1=$cl->get('standalone');
        $standaloneClass2=$cl->get('standalone');

        $this->assertEquals(spl_object_hash($standaloneClass1),spl_object_hash($standaloneClass2));
    }

    /**
     *
     */
    public function testAddInstance(){
		$cl=new ClassLoader();
		$instance=new StandaloneClass('1','2');
		$cl->addInstance('class',$instance);

		$dependencyClass=$cl->get('class');

		$this->assertEquals('1',$dependencyClass->getParam1());
		$this->assertEquals('2',$dependencyClass->getParam2());
	}

    /**
     *
     */
    public function testRegisterMetadataAlreadyRegisteredException(){
        $metadataClass=new MetadataClass('standalone','Asset\StandaloneClass');

        $metadataMethod=new MetadataMethod('__construct');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param1');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param2');
        $metadataClass->register($metadataMethod);

        $metadataMethod=new MetadataMethod('setParam3');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'data');
        $metadataClass->register($metadataMethod);

        $cl=new ClassLoader();
        $cl->register($metadataClass);
        $exception=null;
        try{
            $cl->register($metadataClass);
        }
        catch (\Exception $e){
            $exception=$e;
        }

        $this->assertInstanceOf(MetadataAlreadyRegisteredException::class,$exception);
    }

    /**
     *
     */
    public function testGetInvalidTypeException(){
        $metadataClass=new MetadataClass('standalone','Asset\StandaloneClass');

        $metadataMethod=new MetadataMethod('__construct');
        $metadataMethod->addArgument('unknown','param1');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'param2');
        $metadataClass->register($metadataMethod);

        $metadataMethod=new MetadataMethod('setParam3');
        $metadataMethod->addArgument(MetadataMethod::PRIMITIVE_TYPE,'data');
        $metadataClass->register($metadataMethod);

        $cl=new ClassLoader();
        $cl->register($metadataClass);
        $exception=null;
        try{
            $cl->get('standalone');
        }
        catch (\Exception $e){
            $exception=$e;
        }

        $this->assertInstanceOf(InvalidTypeException::class,$exception);
    }

}