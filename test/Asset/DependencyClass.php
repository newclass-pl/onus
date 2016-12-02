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


namespace Test\Asset;

/**
 * Class DependencyClass
 * @package Test\Asset
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class DependencyClass{

    /**
     * @var StandaloneClass
     */
	private $standalone;
    /**
     * @var bool
     */
	private $flag=false;

    /**
     * @param StandaloneClass $standalone
     */
	public function setStandalone(StandaloneClass $standalone){
		$this->standalone=$standalone;
	}

    /**
     *
     */
	public function enableFlag(){
		$this->flag=true;
	}

    /**
     * @return mixed
     */
	public function getParam1(){
		return $this->standalone->getParam1();
	}

    /**
     * @return mixed
     */
	public function getParam2(){
		return $this->standalone->getParam2();
	}

    /**
     * @return mixed
     */
	public function getParam3(){
		return $this->standalone->getParam3();
	}

    /**
     * @return bool
     */
	public function isFlag(){
		return $this->flag;
	}

}