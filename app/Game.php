<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Kill;
use App\Player;
use DateTime;

class Game extends Model
{
    private $name;
    private $players;
    private $time_start;
    private $time_end;
    private $kills;
    private $totalKills;
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'game';

    public function __construct($name, $time_start)
    {   
        $this->time_end = 0;
        $this->players = array();
        $this->kills = array();
        $this->name = $name;
        $this->time_start = $time_start;
        $this->totalKills = 0;
    }

    public function getName(){
        return $this->name;
    }

    public function getPlayers(){
        return $this->players;
    }

    public function getKills(){
        return $this->kills;
    }

    public function setKills($kills){
        $this->kills = $kills;
    }

    public function setTotalsKills($kills){
        $this->totalKills = $kills;
    }
    public function setPlayers($players){
        $this->players = $players;
    }

    public function findPlayer($player_name)
    {
        if ($key = array_search($player_name, $this->players))
            return $this->players[$key];
        else
            return false;
    }

    public function endGame($time_end)
    {
        $this->time_end = $time_end;
    }

    public function parseJson(){
        $json = null;
        $json[$this->getName()];
        $time_start = date('H:i', strtotime($this->time_start));
        $time_end = date('H:i', strtotime($this->time_end));
        $time_start = new DateTime($time_start);
        $time_end = new DateTime($time_end);
        $total = $time_end->diff($time_start);
        $json[$this->getName()]['time_start'] = $time_start->format('H\\hi\\m');
        $json[$this->getName()]['time_end'] = $time_end->format('H\\hi\\m');
        $json[$this->getName()]['time_total'] = $total->format('%hh%im');
        $json[$this->getName()]['total_kills'] = $this->totalKills;
        $players = array();
        foreach($this->players as $player){
            if($player->getName() != "world"){
                array_push($players, $player->getName());
            }
        }
        $json[$this->getName()]['players'] = $players;
        $players_kills = array();
        foreach($this->kills as $kill ){
            if(!array_key_exists($kill->getPlayer_killer(), $players_kills)){
                if($kill->getPlayer_killer() == 'world' && array_key_exists($kill->getPlayer_dead(), $players_kills)){
                    $players_kills[$kill->getPlayer_dead()] = $players_kills[$kill->getPlayer_dead()];
                    continue;
                }else{
                    $players_kills[$kill->getPlayer_dead()] = 0;
                    continue;
                }
                $players_kills[$kill->getPlayer_killer()] = 1;
            }else{
                $players_kills[$kill->getPlayer_killer()] = $players_kills[$kill->getPlayer_killer()]+1;
            }
        }
        $json[$this->getName()]['kills'] = $players_kills;
        return json_encode($json, JSON_PRETTY_PRINT);
    }
}
