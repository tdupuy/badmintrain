<?php
class Match
{
    public $all_matches = [];
    private $players = [];

    // Constructor
    public function __construct(){
    }

    public function get_matches($nbterrains,$teams){
        for($i = 0; $i < $nbterrains; $i++){
            for($j =0 ; $j < 2; $j++){
                if(isset($matches)){
                    foreach($matches as $match){
                        $my_team = array_shift(array_values($teams));
                        $matches['team_'.$j] = $my_team;
                        $teams = $this->delete_players_others_matches($teams,$my_team);
                    }
                }else{
                    $my_team = array_shift(array_values($teams));
                    $matches['team_'.$j] = $my_team;
                    $teams = $this->delete_players_others_matches($teams,$my_team);
                }
            }
            $matches['terrain_'.$i][0] = $matches['team_0'];
            $matches['terrain_'.$i][1] = $matches['team_1'];
            unset($matches['team_0']);
            unset($matches['team_1']);
        }
        return $matches;
    }

    private function delete_players_others_matches($teams,$myteam){
        $players = explode('-',$myteam);
        foreach($teams as $key => $team){
            $players_in_teams = explode('-',$team);
            if($players[0] == $players_in_teams[0] || $players[1] == $players_in_teams[0] || $players[0] == $players_in_teams[1] || $players[1] == $players_in_teams[1]){
                unset($teams[$key]);
            }
        }
        return $teams;
    }
      
}
