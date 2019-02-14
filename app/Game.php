<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Kill;
use App\Player;

class Game extends Model
{
    private $name;
    private $players;
    private $time_start;
    private $time_end;

    public function __construct($name, $time_start)
    {   
        $this->time_end = 0;
        $this->players = array();
        $this->name = $name;
        $this->time_start = $time_start;

    }

    public function getName(){
        return $this->name;
    }

    public function getPlayers(){
        return $this->players;
    }

    public function findPlayer($player_name)
    {
        if ($key = array_search($player_name, $this->players))
            return $this->players[$key];
        else
            return false;
    }

    public function addPlayer($player)
    {
        array_push($this->players, $player);
        return true;
    }

    public function addKill($time_kill, $player_killer, $player_dead, $killed_by)
    {   
        
        if ($player = $this->findPlayer($player_killer)) {
            if ($player_killer = "<world>" || $player_dead == $player_killer)
                return true;
            $kill = new Kill($time_kill, $player_killer, $player_dead, $killed_by);
            $player->addKill($kill);
            $this->updatePlayer($player);
            return true;
        } else {
            
            $player = new Player($player_killer);
            if ($player_killer = "<world>" || $player_dead == $player_killer) {
                $this->addPlayer($player);
                return true;
            }
            $kill = new Kill($time_kill, $player_killer, $player_dead, $killed_by);
            $player->addKill($kill);
            $this->addPlayer($player);
            return true;
        }
    }

    public function updatePlayer($player)
    {
        $key = array_search($player->getName(), $this->players);
        $this->players[$key] = $player;
    }

    public function endGame($time_end)
    {
        $this->time_end = $time_end;
    }
}
