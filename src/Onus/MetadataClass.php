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

namespace Onus;

/**
 * Metadata class container
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class MetadataClass{
	
	/**
	 *
	 * @var string
	 */
	private $name;

	/**
	 *
	 * @var string
	 */
	private $className;

	/**
	 *
	 * @var MetadataMethod[]
	 */
	private $methods=[];

    /**
     * @var bool
     */
    private $singleton;

    /**
     *
     * @param string $name
     * @param string $className
     * @param bool $singleton
     */
	public function __construct($name,$className,$singleton=true){
		$this->name=$name;
		$this->className=$className;
        $this->singleton=$singleton;
	}

	/**
	 *
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 *
	 * @return string
	 */
	public function getClassName(){
		return $this->className;
	}

	/**
	 *
	 * @param MetadataMethod $method
	 */
	public function register(MetadataMethod $method){
		$this->methods[]=$method;
	}

    /**
     * @return MetadataMethod[]
     */
	public function getMethods(){
		return $this->methods;
	}

    /**
     * @return bool
     */
    public function isSingleton(){
        return $this->singleton;
    }

    /**
     * @param string $name
     * @return MetadataMethod
     */
    public function addMethod($name)
    {
        $method=new MetadataMethod($name);
        $this->register($method);
        return $method;
    }
}