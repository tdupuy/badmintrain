<?php
class Match
{
    public $all_matches = [];
    private $players = [];

    // Constructor
    public function __construct(){
    }

    public function generate_all_matches($players){
        $n = 4;

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
      
}
