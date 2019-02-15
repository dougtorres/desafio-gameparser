<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Game;   
use App\Player;  
use App\Kill;  
use Illuminate\Support\Facades\DB;

class GameParserController extends Controller
{
    private $games = array();
    private $game;
    private $kills = array();
    private $players = array();
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function task1(){

        $lines = $this->read("app/game.log");
        $i = 1;
        $kills = 0;
        foreach($lines as $line){
            switch($line["action"]){
                case "InitGame":
                $this->game = new Game("game_".$i, $line["time"]);
                break;
                case "Kill":
                    $kill = new Kill($line["time"], $line["killer"], $line["dead"], $line["killed_by"]);
                    $kills++;
                    array_push($this->kills, $kill);
                    if(!array_key_exists($line["killer"], $this->players)){
                        $player = new Player($line["killer"]);
                        $this->players[$line["killer"]] = $player;
                    }elseif(!array_key_exists($line["dead"], $this->players)){
                        $player = new Player($line["dead"]);
                        $this->players[$line["dead"]] = $player;
                    }
                break;
                case "ShutdownGame":
                $this->game->setPlayers($this->players);
                $this->game->setKills($this->kills);
                $this->game->setTotalsKills($kills);
                $kills = 0;
                $this->game->endGame($line["time"]);
                array_push($this->games, $this->game);
                $i++;
                $this->players = array();
                $this->kills = array();
                unset($this->game);
                break;
            }

        }
        foreach($this->games as $game){
                echo '<pre>';
                echo $game->parseJson();
                echo '</pre>';
        } 
    }

    public function task2(){

        $lines = $this->read("app/game.log");
        $i = 1;
        $kills = 0;
        foreach($lines as $line){
            switch($line["action"]){
                case "InitGame":
                $this->game = new Game("game_".$i, $line["time"]);
                $this->game->name = "game_".$i;
                $this->game->time_start = $line["time"];
                
                break;
                case "Kill":
                    $kill = new Kill($line["time"], $line["killer"], $line["dead"], $line["killed_by"]);
                    $kill->time_kill = $line["time"];
                    $kill->game_name = $this->game->getName();
                    $kills++;
                    array_push($this->kills, $kill);
                    if(!array_key_exists($line["killer"], $this->players)){
                        $player = new Player($line["killer"]);
                        if (DB::table('player')->where('name', '=', $line["killer"])->count() == 0){
                            $player->name = $line["killer"];
                            $player->save();
                        }
                        $this->players[$line["killer"]] = $player;
                    }elseif(!array_key_exists($line["dead"], $this->players)){
                        $player = new Player($line["dead"]);
                        if (DB::table('player')->where('name', '=', $line["dead"])->count() == 0){
                            $player->name = $line["dead"];
                            $player->save();
                        }
                        $this->players[$line["killer"]] = $player;
                    }
                    $kill->player_killer = $line["killer"];
                    $kill->player_dead = $line["dead"];
                    $kill->killed_by = $line["killed_by"];
                    $kill->save();
                break;
                case "ShutdownGame":
                $this->game->setPlayers($this->players);
                $this->game->setKills($this->kills);
                $this->game->setTotalsKills($kills);
                $kills = 0;
                $this->game->endGame($line["time"]);
                array_push($this->games, $this->game);
                $i++;
                $this->players = array();
                $this->kills = array();
                $this->game->time_end = $line["time"];
                $this->game->save();
                unset($this->game);
                break;
            }
        }
        echo "Tabelas Populadas com Sucesso";
    }

    public function task3(){

        $players= DB::table('player')->select("*")->get();
        $ranking = array();
        foreach($players as $player){
            if($player->name == 'world')
            continue;
            $kills = DB::table('kill')->select("*")->where('player_killer', '=', $player->name)->count();
            $deaths = DB::table('kill')->select("*")->where('player_dead', '=', $player->name)->count();
            $ranking[$player->name]['kills'] = $kills;
            $ranking[$player->name]['deaths'] = $deaths;
            $ranking[$player->name]['player'] = $player->name;
        }
        arsort($ranking);
        return view('task3')->with('ranking', $ranking);;
    }

    public function search(Request $request){

        $players= DB::table('player')->select("*")->where('name', 'like',  '%'.$request->search. '%')->get();
        $ranking = array();
        foreach($players as $player){
            if($player->name == 'world')
            continue;
            $kills = DB::table('kill')->select("*")->where('player_killer', '=', $player->name)->count();
            $deaths = DB::table('kill')->select("*")->where('player_dead', '=', $player->name)->count();
            $ranking[$player->name]['kills'] = $kills;
            $ranking[$player->name]['deaths'] = $deaths;
            $ranking[$player->name]['player'] = $player->name;
        }
        arsort($ranking);
        //return redirect()->route('task3', [$ranking]);
        return view('task3')->with('ranking', $ranking);
    }

    public function read($path){

        $gamelog = fopen(storage_path($path), "r");
        $i = 0;
        while (!feof($gamelog)) {
            $row = fgets($gamelog, 4096);
            $row = str_replace("<", "", $row );
            $row = str_replace(">", "", $row );
            $params = explode(":", trim($row), 3);
            $lines[$i]["time"] = $params[0].":".substr($params[1],0,2);
            $lines[$i]["action"] = trim(substr($params[1],2)); 
            if($lines[$i]["action"] != "Kill"){
                $lines[$i]["killed_by"] = ""; 
                $lines[$i]["killer"] = "";
                $lines[$i]["dead"] = "";
                $i++;
                continue;
            }
            else{
            $params = explode("by", trim($params[2]), 3);
            $lines[$i]["killed_by"] = trim($params[1]); 
            $params = explode(":", trim($params[0]), 3);
            $params = explode("killed", trim($params[1]), 3);
            if(strlen($params[0])<3)
            $lines[$i]["killer"] = "<world>"; 
            else
            $lines[$i]["killer"] = trim($params[0]); 
            $lines[$i]["dead"] = trim($params[1]); 
            $i++;
            }
        }
        return $lines;
    }
}
