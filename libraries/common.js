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
            case 'new_user':
                if($('#newUser').is(':visible')){
                    $('#newUser').slideUp();
                }
                else{
                    $('#newUser').slideUp();
                    $('#editUser').slideUp();
                    $('#newUser').slideToggle();
                }
                break;
            case 'edit_user':
                var checked = getChecked();
                if(checked.length > 1){
                    alert('You can only edit one user at a time!');
                    return;
                }
                else if(checked.length === 0){
                    alert('In order to edit a user, please select one.');
                    return;
                }
                else{
                    $('#USER_NAME').text(checked[0]);
                    $('#editUser form').attr('action','libraries/update.php?action=editUser&users='+checked[0]);
                    if($('#editUser').is(':visible')){
                        $('#editUser').slideUp();
                    }
                    else{
                        $('#newUser').slideUp();
                        $('#editUser').slideUp();
                        $('#editUser').slideToggle();
                    }
                }
                break;
            case 'delete_users':
                var checked = getChecked();
                if(checked.length === 0){
                    alert('In order to delete a user, please select one.');
                    return;
                }
                if(confirm("Are you sure you want to delete the selected users?")){
                    window.location.href = "libraries/update.php?action=deleteUsers&users="+JSON.stringify(checked);
                }
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