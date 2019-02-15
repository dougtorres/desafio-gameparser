<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    private $name;
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'player';

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

}
