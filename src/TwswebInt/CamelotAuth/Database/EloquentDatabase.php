<?php namespace TwswebInt\ICamelotAuth\Database;

use TwswebInt\CamelotAuth\Models\Eloquent;
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

		$modelClass = 'TwswebInt\CamelotAuth\Models\Eloquent\\'.$modelName;
		if(!class_exists($modelClass,false))
		{
			throw new \Exception("Cannot Find the ".$modelName." Eloquent Model");	
		}

		return new $modelClass;

	}
}