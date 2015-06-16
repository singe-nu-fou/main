if(!window.jQuery){
    alert('This plugin requires jQuery to run.');
}

(function($){
    $.fn.selectable = function(){
        var float = null;
        var input = null;
        var position = [];
        var reverse = false;
        var start = null;
        var stop = null;

        $('table.selectable tbody tr').click(function(event){
            input = $(this).find('input[type=checkbox]');
            switch(event.shiftKey){
                case true:
                    document.getSelection().removeAllRanges();
                    if(position[1] !== null){
                        float = position[1];
                        position[1] = $(this).prevAll('tr').length;
                    }
                    else{
                        position[1] = $(this).prevAll('tr').length;
                    }
                    if((position[0] > position[1]) || (position[0] === position[1] && float < position[0])){
                        reverse = true;
                    }
                    start = position[0];
                    if(float !== null && float <= position[1] && reverse === true || float !== null && float >= position[1] && reverse === false){
                         stop = float;
                    }
                    else{
                        stop = position[1];
                    }
                    switch(reverse){
                        case true:
                            for(var i = start+1; i >= stop; i--){
                                select_rows(i,input,start,stop,reverse,position);
                            }
                            break;
                        case false:
                            for(var i = start+1; i <= stop+1; i++){
                                select_rows(i,input,start,stop,reverse,position);
                            }
                            break;  
                    }                            
                    break;
                case false:
                    position[0] = $(this).prevAll('tr').length;
                    if(position.length > 1){
                        position.splice(1,1);
                    }
                    if(input.is(':checked')){
                        remove_active(input);
                    }
                    else{
                        add_active(input);
                    }
                    break;
            }
            reverse = false;
        }).mouseenter(function(){
            $(this).addClass('hover');
        }).mouseleave(function(){
            $(this).removeClass('hover');
        });
    };
})(jQuery);

function select_rows(i,input,start,stop,reverse,position){
    input = $('table.selectable tr').eq(i).find('input[type=checkbox]');
    if(stop !== position[1] && position[1] < i && reverse === false){
        remove_active(input);
    }
    else if(stop !== position[1] && position[1] > i-2 && reverse === true){
        remove_active(input);
    }
    else{
        add_active(input);
    }
}

function add_active(input){
    input.prop('checked',true).parents('tr').addClass('active');
}

function remove_active(input){
    input.prop('checked',false).parents('tr').removeClass('active');
}