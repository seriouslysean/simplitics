jQuery(function($){

    $(document).on('click', '.simplitics .share > a.button.button-donate', function(e){
        e.preventDefault();
        _form = $('#'+$(this).parents('.share').data('form'));
        if (_form.length)
            _form.submit();
    });
    
});