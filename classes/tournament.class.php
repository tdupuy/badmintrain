<?php

require_once('match.class.php');
require_once('team.class.php');

class Tournament
{
    private $nbplayers;
    private $nbterrains;

    // Constructor
    public function __construct($nbplayers,$nbterrains){
        $this->nbplayers = $nbplayers;
        $this->nbterrains = $nbterrains;
    }

    private function generate_players_arr($nbplayers){
        for($i = 1; $i <= $nbplayers; $i++){
            $players[$i] = $i;
        }
        return $players;
    }

    public function get_teams($nbplayers){
        $team = new Team();
        $players = $this->generate_players_arr($nbplayers);
        $teams = $team->generate_teams($players);
        return $teams;
    }

    public function get_matches($nbterrains,$teams){
        $match = new Match();
        $matches = $match->get_matches($nbterrains,$teams);
        return $matches;
    }

    public function generate($nbplayers,$nbterrains){
        $teams = $this->get_teams($nbplayers);
        while(sizeof($teams) > ($nbterrains * 4)){
            $i++;
            $matches = $this->get_matches($nbterrains,$teams);
            foreach($matches as $match){
                $teams_key = array_search($match[0],$teams);
                unset($teams[$teams_key]);
                $teams_key = array_search($match[1],$teams);
                unset($teams[$teams_key]);
            }
            $tournament['tour_'.$i] = $matches;
            echo "Tour ".$i."<br/><br/>";
            var_dump(sizeof($teams));
            var_dump($nbterrains * 4);
        }
        return $tournament;
    }
}
