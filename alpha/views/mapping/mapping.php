<script>
    $(document).ready(function(){
        $('.mapping-control').change(function(){
            window.location.href = hrefScrub($(this).attr('name'),$(this).val(),window.location.href);
        });
        $('#addCharacteristic').click(function(){
            $.ajax({
                url:'processes/warp.php?nav=mapping&action=selectCharacteristic',
                success:function(data){
                    $('#dataRow').append(data);
                    $('.removeCharacteristic').unbind('click').click(function(){
                        $(this).parents('.col-lg-6').remove();
                    });
                }
            });
        });
        $('.removeCharacteristic').click(function(){
            $(this).parents('.col-lg-6').remove();
        });
    });
    
    function hrefScrub(index,value,href){
        var get;
        switch(index){
            case 'mapping[CATEGORY_ID]':
                get = '&category=';
                break;
            case 'mapping[CLASSIFICATION_ID]':
                get = '&classification=';
                break;
        }
        if(href.indexOf(get) === -1){
            return href+get+value;
        }
        href = href.substring(0, href.lastIndexOf(get));
        return href+get+value;
    }
</script>
<?php
    echo $TABLE->getTable();