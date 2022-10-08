<?php
class Match
{

    public function __construct(){
    }

    /**
     * Génère les matches en fonction du nombre de terrains et les équipes
     * 
     * @param int $nbterrains
     * @param Array $teams
     * 
     * @return Array retourne un Array sous forme : $matches['terrain']['team_0'] = '1-2'
     *                                                                 ['team_1] = '3-4'
     */
    public function get_matches($nbterrains,$teams){
        $my_team = new Team;
        $my_team->set_matches_by_players($this->get_matches_by_player($teams));

        for($i = 1; $i <= $nbterrains; $i++){
            for($j =0 ; $j < 2; $j++){
                if(!empty($teams)){
                    $team_to_play = $my_team->get_team_to_play($teams);
                    $matches['team_'.$j] = $team_to_play;
                    $teams = $this->delete_players_others_matches($teams,$team_to_play);
                    $my_team->decrease_max_to_play($team_to_play);
                }
            }
            $matches['terrain_'.$i][0] = $matches['team_0'];
            $matches['terrain_'.$i][1] = $matches['team_1'];
            unset($matches['team_0']);
            unset($matches['team_1']);
        }

        foreach($matches as $key => $match){
            if(is_null($match[0]) || is_null($match[1])){
                unset($matches[$key]);
            }
        }

        $matches['substitutes'] = $this->get_substitutes_players($teams);
        return $matches;
    }

    
    /**
     * Supprime les autres matchs disponible pour les joueurs sélectionnés
     * 
     * @param mixed $teams toutes les équipes disponibles
     * @param mixed $myteam les joueurs sélectionnés
     * 
     * @return Array les équipes sans celles qui sont composés des joueurs sélectionnés
     */
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


    /**
     * Récupère le nombre de matchs par joueur
     * 
     * @param mixed $teams toutes les équipes
     * 
     * @return Array le nombre de match par joueur
     */
    public static function get_matches_by_player($teams){
        foreach($teams as $key => $team){
            $player = explode('-',$team);
            $matches_by_players['joueur_'.$player[0]] = $matches_by_players['joueur_'.$player[0]]+1 ?? 1;
            $matches_by_players['joueur_'.$player[1]] = $matches_by_players['joueur_'.$player[1]]+1 ?? 1;
        }
        return $matches_by_players;
    }

    public static function get_substitutes_players($matches,$players){
        foreach($matches as $match){
            foreach($match as $team){
                $players_ig = explode('-',$team);
                $players_ig_arr[] = intval($players_ig[0]);
                $players_ig_arr[] = intval($players_ig[1]);
            }
        }
        foreach($players as $player){
            if(array_search($player,$players_ig_arr) === false){
                $substitutes[] = $player;
            }
        }
        return $substitutes;
    }

    public static function is_match_played($teams,$match){
        foreach($teams as $team){
    }
      
}
