<?php

require_once('match.class.php');
require_once('player.class.php');

class Tournament
{
    private $nbplayers;
    private $nbterrains;
    public $players = [];

    // Constructor
    public function __construct($nbplayers,$nbterrains){
        $this->nbplayers = $nbplayers;
        $this->nbterrains = $nbterrains;
        $this->players = $this->generate_players_arr($nbplayers);
    }

    private function generate_players_arr($nbplayers){
        for($i = 1; $i <= $nbplayers; $i++){
            $this->players[$i] = $i;
        }
        return $this->players;
    }

    public function get_matches($players){
        $match = new Match();
        $all_matches = $match->generate_all_matches($players);
        return $all_matches;
    }
      
}
