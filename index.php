<?php 
require_once('classes/tournament.class.php');

$tournament = false;

if(isset($_POST) && !empty($_POST) || isset($_GET) && !empty($_GET)){
    session_start();
    $tournament = new Tournament($_POST['nb_joueurs'],$_POST['nb_terrains']);
    if(!isset($_GET['turn'])){
        $turn = 1;
        $tournament = $tournament->generate_turn($turn);
    }else{
        $turn = intval($_GET['turn']);
        $turn++;
        $teams = $_SESSION['teams'];
        $old_tournament = unserialize(urldecode($_GET['tournament']));
        $tournament = $tournament->generate_turn($turn,$old_tournament,$teams);
    }
    $_SESSION['teams'] = $tournament['tour_'.$turn]['teams'];
    unset($tournament['tour_'.$turn]['teams']);
}
// Append the host(domain name, ip) to the URL.   
$url = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'] . explode('?', $_SERVER['REQUEST_URI'], 2)[0];

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./css/styles.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Génération de matchs</title>
  </head>
  <body>
    <?php if(!$tournament) : ?>
    <form action="#" method="post">
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white post-form" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">

                                <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Matchs</h2>
                                <p class="text-white-50 mb-5">Générer les matchs</p>

                                <div class="form-outline form-white mb-4">
                                    <label class="form-label" for="nb_joueurs">Nombre de joueurs</label>
                                    <input id="nb_joueurs" name="nb_joueurs" type="number" class="form-control" required="required">
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <label class="form-label" for="nb_terrains">Nombre de terrains</label>
                                    <select id="nb_terrains" name="nb_terrains" class="custom-select form-control form-control-lg" required="required">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4" selected>4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                    </select>
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Générer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <?php endif; ?>
    <?php if($tournament) : ?>
        <?php if($tournament['end']) : ?>
            <h2 class="h2 text-uppercase text-center my-2"> FIN DU TOURNOI </h2>
            <div class="text-center">
                <a href="
                    <?php echo $url ?>" 
                    class="btn btn-primary"> 
                    Retour
                </a>
            </div>
        <?php else : ?>
            <a href="<?php echo $url; ?>" class="btn primary-btn back-home"><i class="fa fa-home" aria-hidden="true"></i></a>
            <?php foreach($tournament as $key => $tour) : ?>
                <h2 class="h2 text-uppercase text-center my-2"> <?php echo str_replace('_',' ',$key); ?> </h2>
                <div class="row">
                    <div class="container-fluid text-center py-5">
                        <?php foreach($tour as $key2 => $terrain) : ?>
                            <?php if(strpos($key2,'terrain_') !== false) : ?>
                                <div class="card mx-3 mb-5" style="width: 18rem;display:inline-block;height:20rem;">
                                    <div class="card-header text-uppercase">
                                        <b><?php echo str_replace('_',' ',$key2); ?></b>
                                    </div>
                                    <div class="terrain-content">
                                        <div>
                                            <div class="left corridor"></div>
                                            <?php foreach($terrain as $key=>$match) : ?>
                                                <?php 
                                                    if($match == ""):
                                                        if($key == 0) :
                                                ?>
                                                <div class="match-impossible pt-5 px-3">
                                                    <p class="h5 text-white text-center"> Pas de match sur ce terrain (libre) </p>
                                                    <p class="h6 text-white text-center"> Sûrement la faut du développeur mais il se peut aussi que ce ne soit pas possible </p>
                                                </div>
                                                <?php
                                                        endif; 
                                                    else : 
                                                ?>
                                                <?php
                                                    $players = explode('-',$match); 
                                                ?>
                                                <?php if($key == 0) : ?>
                                                    <div class="ligne-fond top d-block"></div> 
                                                <?php endif; ?>
                                                <div class="player left d-inline-block">
                                                    <span class="player_nb"><?php echo $players[0]; ?></span>
                                                </div>
                                                <div class="player right d-inline-block">
                                                    <span class="player_nb"><?php echo $players[1]; ?></span>
                                                </div>
                                                <div class="d-block terrain-separator"></div>
                                                <?php if($key == 1) : ?>
                                                    <div class="ligne-fond bottom d-block"></div>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <div class="right corridor"></div>
                                        </div>
                                    </div>
                                    <!--<ul class="list-group list-group-flush">
                                        <?php foreach($terrain as $key=>$match) : ?>
                                            <li class="list-group-item"><?php echo 'Joueur ' . str_replace('-',' & joueur ',$match); ?></li>
                                        <?php endforeach; ?>
                                    </ul>-->
                                </div>
                            <?php elseif($key2 == "substitutes") : ?>
                                <p class="h6 "><b>Coin buvette :</b> 
                                    <?php foreach($terrain as $substitute) : ?>
                                        <span class="substitute"><?php echo $substitute; ?></span>
                                    <?php endforeach ?>
                                </p>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="text-center">
                <a href="
                    <?php echo $url.'?turn='.$turn.'&tournament='.urlencode(serialize($tournament['tour_'.$turn])); ?>" 
                    class="btn btn-primary"> 
                    Tour suivant 
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>