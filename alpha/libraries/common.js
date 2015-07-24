$(document).ready(function(){
    /*
     * basic, bare minimum version of selectable to add the funcionality of
    */
    $('tr').click(function(){
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).find('input[type=checkbox]').attr('checked',false);
        }
        else{
            $(this).addClass('active');
            $(this).find('input[type=checkbox]').attr('checked',true);
        }
    });
    $('.CONTROL_PANEL').click(function(event){
        switch($(this).attr('ID')){
            case 'view':
                event.preventDefault();
                var checked = getChecked();
                if(checked.length < 1){
                    alert('Please select one row in order to view.');
                }
                else{
                    window.location.href = $(this).attr('href')+'&id='+JSON.stringify(checked);
                }
                break;
            case 'edit':
                event.preventDefault();
                var checked = getChecked();
                if(checked.length < 1){
                    alert('Please select one row in order to edit.');
                }
                else{
                    window.location.href = $(this).attr('href')+'&id='+JSON.stringify(checked);
                }
                break;
            case 'delete':
                event.preventDefault();
                var checked = getChecked();
                if(checked.length < 1){
                    alert('Please select one row in order to edit.');
                }
                else{
                    window.location.href = 'processes/update.php?page='+nav+'&action=delete&id='+JSON.stringify(checked);
                }
                break;
            case 'select_all':
                $.each($('tr').find('.checkbox:checkbox'),function(){
                    $(this).prop("checked",true);
                    $(this).closest('tr').addClass('active');
                });
                break;
            case 'deselect_all':
                $.each($('tr').find('.checkbox:checkbox'),function(){
                    $(this).prop("checked",false);
                    $(this).closest('tr').removeClass('active');
                });
                break;
        }
    });
});
function getChecked(){
    var checked = new Array();

    $.each($('tr').find('.checkbox:checked'),function(){
        checked.push($(this).val());
    });

    return checked;
}