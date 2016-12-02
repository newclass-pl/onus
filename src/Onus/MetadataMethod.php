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
 * Metadata method container
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class MetadataMethod{

	/**
	 *
	 * @var string
	 */
	const PRIMITIVE_TYPE='primitive';

	/**
	 *
	 * @var string
	 */
	const STATIC_TYPE='static';

	/**
	 *
	 * @var string
	 */
	const REFERENCE_TYPE='reference';
	
	/**
	 *
	 * @var string
	 */
	private $name;

	/**
	 *
	 * @var mixed[]
	 */
	private $arguments=[];

	/**
	 *
	 * @param string $methodName
	 */
	public function __construct($methodName){
		$this->name=$methodName;
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
     * @param string $type
     * @param mixed $value
     * @return $this
     */
	public function addArgument($type,$value){
		$this->arguments[]=['type'=>$type,'value'=>$value];
		return $this;
	}

	/**
	 *
	 * @return mixed[]
	 */
	public function getArguments(){
		return $this->arguments;
	}

}