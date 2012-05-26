var AjaxForm = function(form, target, instant, replace) {

    var _form = form;
    var _target = target;
    var _replace = replace;
    
    var _runningRequest = false;
    var _request;
    
    var search = function() {
        
        //Abort opened requests to speed it up
        if(_runningRequest){
            _request.abort();
        }
                
        _runningRequest=true;
        _request = $.ajax({
            url: _form.attr('action'),
            type: 'POST',
            data: _form.serialize(),
            success: function(data) {
                if (_replace)
                {
                    console.log(data);
                    console.log(_target);

                    $(_target).replaceWith(data);
                }
                else
                {
                    $(_target).html(data);
                }

                 _runningRequest=false;
            }
        })
    }

    if (instant)
    {   
        $(_form).find('select').change(function(e) {
            e.preventDefault();
            search();
        });
        
        $(_form).find('input').keyup(function(e) {
            search();
        });
    }
    else 
    {
        $(_form).submit(function(e) {
            e.preventDefault();
            search();
        });
    }

};