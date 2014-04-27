<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Database;


use T4s\CamelotAuth\Config\ConfigInterface;

class EloquentDatabase extends AbstractDatabase implements DatabaseInterface
{

	protected $config;

	public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->setModels($this->config->get('camelot.models'));
	}

	public function loadRepository($repository,$model,$table = null)
	{

		$class = 'T4s\CamelotAuth\\'.$repository;

		return new $class($this->config,$this->getModel($model,$table));
	}
	
}