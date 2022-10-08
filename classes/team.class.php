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
        // Randomize matches
        shuffle($this->all_matches);
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
    private function get_first_team_with_player($player,$teams){
        $player = explode('joueur_',$player)[1];
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
    public function get_team_to_play($teams){
        $max = array_search(max($this->matches_by_players),$this->matches_by_players);
        $joueurs = array_keys($this->matches_by_players,$this->matches_by_players[$max]);
        foreach($joueurs as $joueur1){
            foreach($joueurs as $joueur2){
                if($joueur1 != $joueur2){
                    $team_to_play = explode('joueur_',$joueur1)[1].'-'.explode('joueur_',$joueur2)[1];
                    if(Match::is_match_played($teams,$team_to_play) == false){
                        return $team_to_play;
                    }
                }
            }
        }
        if($teams && !empty($teams)){
            return array_shift(array_values($teams));
        }
        return false;
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