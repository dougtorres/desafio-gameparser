<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Game;   

class GameParserController extends Controller
{
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
        $gamelog = Storage::get('game.log');
        $games = $this->read($gamelog);

        foreach($games as $game){
            $players = $game->getPlayers();
            echo count($players);
            die;
        }
    }

    public function read($gamelog){

        $lines = explode("\n", $gamelog);
        $i = 1;
        $games = array();
        foreach($lines as $line){
            $words = preg_split('/[\s]+/', $line, -1, PREG_SPLIT_NO_EMPTY);
            switch($words[1]){
                case "InitGame:":
                $game = new Game("game_".$i, $words[0]);
                break;
                case "Kill:":
                if($words[5] == '')
                $player_killer = '<world>';
                else
                $player_killer = $words[5];
                $game->addKill($words[0], $player_killer, $words[7], $words[9]);
                break;
                case "ShutdownGame:":
                $game->endGame($words[0]);
                $i++;
                array_push($games, $game);
                break;
            }
        }
        return $games;
    }
}
