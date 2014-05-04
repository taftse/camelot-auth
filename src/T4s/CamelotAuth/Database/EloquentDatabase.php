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
        if(isset($this->repositories[$repository]))
        {
            return $this->repositories[$repository];
        }

        $model = $this->models[$model];

		$class = 'T4s\CamelotAuth\\'.$repository;

		return $this->repositories[$repository] = new $class($model['model'],$model['table']);
	}
	
}