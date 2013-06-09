<?php namespace T4s\CamelotAuth\Database;

use T4s\CamelotAuth\Models\Eloquent;
class EloquentDatabase implements DatabaseInterface
{
	

	public function newModel($modelName,$options = null)
	{
		//$driverFile = __DIR__.'/Models/'

	
	}

	public function createModel($modelName)
	{
		$modelName =ucfirst($modelName);

		$modelFile = __DIR__.'/../Models/Eloquent/'.$modelName.'.php';
		
		if(!file_exists($modelFile))
		{
			throw new \Exception("Cannot Find ".$modelName." Model File");
		}

		include_once $modelFile;

		$modelClass = 'T4s\CamelotAuth\Models\Eloquent\\'.$modelName;
		if(!class_exists($modelClass,false))
		{
			throw new \Exception("Cannot Find the ".$modelName." Eloquent Model");	
		}

		return new $modelClass;

	}

	public function getByID($accountID)
	{
		return $this->createModel('Account')->newQuery()->find($accountID);
	}
}