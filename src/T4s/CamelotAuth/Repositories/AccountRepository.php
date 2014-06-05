<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Repositories;



class AccountRepository extends AbstractRepository{


    public function getByFields($keys,$operator= null,$value = null)
    {
        $query = $this->getNewModel();
// if there is a value then there is also a operator so its a single request
        if(!is_null($value))
        {
            return $query->where($keys,$operator,$value)->first();
        }
// if operator is set then we have a key value pair
        else if(!is_null($operator))
        {
            return $query->where($keys,$operator)->first();
        }

        foreach ($keys as $key => $value)
        {
// if the key contains the word password then skip it
            if(!str_contains($key,'password'))
            {
                $query->where($key,$value);
            }
        }
        return $query->first();
    }
} 