<?php
class Match
{
    public $all_matches = [];
    private $players = [];

    // Constructor
    public function __construct(){
    }

    public function get_matches($nbterrains,$teams){
        $my_team = new Team;
        for($i = 0; $i < $nbterrains; $i++){
            for($j =0 ; $j < 2; $j++){
                if(!empty($teams)){
                    if(isset($matches)){
                        $team_to_play = $my_team->get_first_team_with_player($this->get_player_max_matches_to_play($teams),$teams);
                        if(!$team_to_play){
                            die('Erreur lors de la génération');
                        }
                        $matches['team_'.$j] = $team_to_play;
                        $teams = $this->delete_players_others_matches($teams,$team_to_play);
                    }else{
                        $team_to_play = $my_team->get_first_team_with_player($this->get_player_max_matches_to_play($teams),$teams);
                        if(!$team_to_play){
                            die('Erreur lors de la génération');
                        }
                        $matches['team_'.$j] = $team_to_play;
                        $teams = $this->delete_players_others_matches($teams,$team_to_play);
                    }
                }else{
                    $matches['team_'.$j] = null;
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

    private function get_player_max_matches_to_play($teams){
        $matches_by_players = $this->get_matches_by_player($teams);
        return array_search(max(array_values($matches_by_players)),$matches_by_players);
    }

    private function get_matches_by_player($teams){
        foreach($teams as $key => $team){
            $player = explode('-',$team);
            $matches_by_players['joueur_'.$player[0]] = $matches_by_players['joueur_'.$player[0]]+1 ?? 1;
            $matches_by_players['joueur_'.$player[1]] = $matches_by_players['joueur_'.$player[1]]+1 ?? 1;
        }
        return $matches_by_players;
    }
      
}
