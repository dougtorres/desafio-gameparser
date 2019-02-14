<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    private $name;
    private $kills;

    public function __construct($name)
    {
        $this->name;
        $this->kills = array();
    }

    public function getName(){
        return $this->name;
    }

    public function getKills(){
        return $this->kills;
    }

    public function addKill($kill){
        if(array_push($this->kills, $kill))
        return true;
        else {
            echo "error";
            die;
        }
    }
}
