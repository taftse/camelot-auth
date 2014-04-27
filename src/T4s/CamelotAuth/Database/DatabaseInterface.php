<?php namespace T4s\CamelotAuth\Database;


interface DatabaseInterface
{

	//public function loadModel($model);

    public function loadRepository($repository,$model);
}