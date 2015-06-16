$(document).ready(function(){
    $('.selectable').selectable();
    $('tr img').mouseenter(function(event){
        event.stopPropagation();

        $('.zoomContainer').remove();

        switch($(this).prop('class')){
            case 'imgA':
                $(this).elevateZoom({zoomWindowOffetx:206,zoomWindowPosition:2,zoomWindowWidth:300,zoomWindowHeight:300});
                break;

            case 'imgB':
                $(this).elevateZoom({zoomWindowOffetx:103,zoomWindowPosition:2,zoomWindowWidth:300,zoomWindowHeight:300});
                break;

            case 'imgC':
                $(this).elevateZoom({zoomWindowPosition:2,zoomWindowWidth:300,zoomWindowHeight:300});
                break;
        }
    });
    $('.openListing').click(function(event){
        event.stopPropagation();
        event.preventDefault();
    });
    $('.advanced_control').click(function(event){
        event.preventDefault();
        $(this).blur();
        switch($(this).attr('href')){
            case 'select_all':
                $.each($('tr').find(':checkbox'),function(){
                    $(this).prop("checked",true);
                    $(this).closest('tr').addClass('active');
                });
                break;
            case 'deselect_all':
                $.each($('tr').find(':checkbox'),function(){
                    $(this).prop("checked",false);
                    $(this).closest('tr').removeClass('active');
                });
                break;
        }
    });
});