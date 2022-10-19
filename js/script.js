$( document ).ready(function() {
    $('.terrain_1').siblings('.terrain').addClass('d-none');
    $('.controls .control').click(function(){
        let direction = '';
        if($(this).hasClass('control-prev')){
            direction = 'prev';
        }else{
            direction = 'next';
        }
        $('.terrain').addClass('d-none');
        let terrain = $(this).parents('.terrain');
        $.each(terrain.attr('class').split(' '),function(index,value){
            if(value.indexOf('terrain_') >= 0){
                let index = value.split('_')[1];
                if(direction == 'prev'){
                    if(terrain.prev('.terrain').length == 0){
                        index = $('.terrain').length;
                    }else{
                        index--;
                    } 
                }else{
                    if(terrain.next('.terrain').length == 0){
                        index = 1;
                    }else{
                        index++;
                    }
                }
                $('.terrain_' + index ).removeClass('d-none');
            }
        });
    });
    $('#del-player-confirm').click(function(){
        let player = $('#del-player-id').val();
        let hrefnextturn = $('#next-turn').attr('href');
        let newhref = hrefnextturn + '&del_players=' + player;
        $('#next-turn').attr('href',newhref);
    });
});