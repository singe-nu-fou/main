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
            case 'new':
                if($('#new').is(':visible')){
                    $('#new').slideUp();
                }
                else{
                    $('#new').slideUp();
                    $('#edit').slideUp();
                    $('#new').slideToggle();
                }
                break;
            case 'edit':
                var checked = getChecked();
                if(checked.length > 1){
                    alert('You can only edit one user at a time!');
                    return;
                }
                else if(checked.length === 0){
                    alert('In order to edit a user, please select one.');
                    return;
                }
                if($('#edit').is(':visible')){
                    $('#edit').slideUp();
                }
                else{
                    $('#new').slideUp();
                    $('#edit').slideUp();
                    $('#edit').slideToggle();
                }
                break;
            case 'delete':
                var checked = getChecked();
                if(checked.length === 0){
                    alert('In order to delete an item, please select one.');
                    return;
                }
                confirm("Are you sure you want to delete the selected items?");
                break;
        }
    });
});

function getChecked(){
    var checked = new Array();

    $.each($('tr').find('.checkbox:checked'),function(){
        checked.push( $(this).val() );
    });

    return checked;
}