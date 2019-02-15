<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kill extends Model
{
    private $time_kill;
    private $player_killer;
    private $player_dead;
    private $killed_by;
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'kill';

    public function __construct($time_kill, $player_killer, $player_dead, $killed_by)
    {
        $this->time_kill = $time_kill;
        $this->player_killer = $player_killer;
        $this->player_dead = $player_dead;
        $this->killed_by = $killed_by;
    }

    public function getPlayer_killer(){
        return $this->player_killer;
    }

    public function getPlayer_dead(){
        return $this->player_dead;
    }

    public function getTime_kill(){
        return $this->time_kill;
    }

    public function getKilled_by(){
        return $this->killed_by;
    }
    
   
}
