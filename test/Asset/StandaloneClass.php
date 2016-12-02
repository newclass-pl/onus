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
 * Class StandaloneClass
 * @package Test\Asset
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class StandaloneClass{

    /**
     * @var mixed
     */
	private $param1;
    /**
     * @var mixed
     */
	private $param2;
    /**
     * @var mixed
     */
	private $param3;

	const DATA='data1';

    /**
     * StandaloneClass constructor.
     * @param mixed $param1
     * @param mixed $param2
     */
	public function __construct($param1,$param2){
		$this->param1=$param1;
		$this->param2=$param2;
	}

    /**
     * @return mixed
     */
	public function getParam1(){
		return $this->param1;
	}

    /**
     * @return mixed
     */
	public function getParam2(){
		return $this->param2;
	}

    /**
     * @return mixed
     */
	public function getParam3(){
		return $this->param3;
	}

    /**
     * @param mixed $data
     */
	public function setParam3($data){
		$this->param3=$data;
	}

}