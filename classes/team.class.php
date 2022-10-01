<?php
class Team
{
    // Constructor
    public function __construct(){
    }
      
    
    /**
     * Génére les pairs uniques pour tous les joueurs indiqués
     * 
     * @param mixed $players
     * 
     * @return Array les paires uniques pour les joueurs (sizeof($players))
     */
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


    /**
     * Retourne la première équipe du tableau pour le joueur indiqué
     * 
     * @param mixed $player
     * @param mixed $teams
     * 
     * @return String équipe
     */
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