<?php
class Team
{
    // Constructor
    public function __construct(){
    }
      
    
    public function generate_teams($players){
        $n = sizeof($players);

        for($i = 1; $i<=$n; $i++){
            for($x = 1; $x<=$n; $x++){
                if($i != $x && !isset($array[$x][$i])){
                    $array[$i][$x] = '';
                }
            }
        }
        for($i = 1; $i<=$n; $i++){
            for($x = 1; $x<=$n; $x++){
                if(isset($array[$i][$x])){
                    $this->all_matches[] = $i.'-'.$x;
                }
            }
        }
        return $this->all_matches;
    }

    public function get_first_team_with_player($player,$teams){
        $player = explode('_',$player)[1];
        foreach($teams as $team){
            $players = explode('-',$team); 
            if($player == $players[0] || $player == $players[1]){
                return $team;
            }
        }
        return false;
    }
}