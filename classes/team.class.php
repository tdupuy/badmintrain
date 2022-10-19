<?php
class Team
{
    public $matches_by_players;

    // Constructor
    public function __construct(){
    }

    public function set_matches_by_players($matches_by_players){
        $this->matches_by_players = $matches_by_players;
    }
      
    
    /**
     * Génére les pairs uniques pour tous les joueurs indiqués
     * 
     * @param mixed $players
     * 
     * @return Array les paires uniques pour les joueurs (sizeof($players))
     */
    public function generate_teams($players,$shuffle = true){
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
        // Randomize matches
        if($shuffle){
            shuffle($this->all_matches);
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
    private function get_first_team_with_player($player,$teams,$from_team = true){
        if($from_team){
            $player = explode('joueur_',$player)[1];
        }
        foreach($teams as $team){
            $players = explode('-',$team);
            if($player == $players[0] || $player == $players[1]){
                return $team;
            }
        }
        return false;
    }

    /**
     * Retourne un des joueurs pour lequel il reste le plus de match à jouer
     * 
     * @param mixed $teams toutes les équipes
     * 
     * @return int la clé du joueur dont il reste le plus de match à faire
     */
    public function get_team_to_play($teams,$substitutes = []){
        // On cherche à créer un match avec ceux qui ont pas joués
        if(!empty($substitutes)){
            $teams_to_play = $this->generate_teams_on_purpose($substitutes);
            foreach($teams_to_play as $team_to_play){ 
                if(Match::is_match_played($teams,$team_to_play) == false){
                    return $team_to_play;
                }
            }
            // On cherche la première équipe avec un remplacant 
            foreach($substitutes as $substitute){
                $team_to_play = $this->get_first_team_with_player($substitute, $teams,false);
                if($team_to_play){
                    return $team_to_play;
                }
            }
        }
        $max = array_search(max($this->matches_by_players),$this->matches_by_players);
        $joueurs = array_keys($this->matches_by_players,$this->matches_by_players[$max]);
        $joueurs_arr = [];
        // Sinon on gère avec le nombre max de match par joueur
        foreach($joueurs as $joueur){
            $joueurs_arr[] = explode('joueur_',$joueur)[1];
        }
    
        $teams_to_play = $this->generate_teams_on_purpose($joueurs_arr);
        if($teams_to_play && sizeof($teams_to_play) > 0){
            foreach($teams_to_play as $team_to_play){
                if(Match::is_match_played($teams,$team_to_play) === false){
                    return $team_to_play;
                }
            }
        }
        // Sinon on en a plus raf et on prend la première team du tableau
        if($teams){
            return array_shift(array_values($teams));
        }
        return false;
    }

    public function generate_teams_on_purpose($teams){
        $n = sizeof($teams);
        $array = $teams;
        $r_temp = $array;
        $r_result = array();
        foreach($array as $r){
            $i = 0;
            while($i < $n-1){
                array_push($r_result,$r_temp[0].'-'.$r_temp[$i+1]);
                $i++;
            }
            $n--;
            array_shift($r_temp); //Remove the first element since all the pairs are used
        }
        
        return $r_result;
    }

    /**
     * 
     */
    public function decrease_max_to_play($players){
        $players = explode('-',$players);
        $this->matches_by_players['joueur_'.$players['0']] = $this->matches_by_players['joueur_'.$players['0']] - 1;
        $this->matches_by_players['joueur_'.$players['1']] = $this->matches_by_players['joueur_'.$players['1']] - 1;
    }
}