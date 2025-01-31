humhub.module("flex_theme.admin", function(module, require, $)
{
    module.initOnPjaxLoad = true;
    
    var refreshBtn;
    var form;
    
    var emptyColors = function( e ) {
        colorsForm = $('#colors-form');
            if (colorsForm) {
            console.log('form found');
            inputs = colorsForm.find(':input');
            //var count = 0;
            inputs.each(function(){
                if ($(this).is(':hidden')) {
                    return;
                }
                if ($(this).val() !== '') {
                    //count++;
                    $(this).val('');
                    var sourceInput = $('#' + $(this).attr('id') + '-source');
                    sourceInput.spectrum("set", '');
                }
            });
            //module.log.success(count + " colors emptied");
        }
    };
    
    module.export({
        emptyColors: emptyColors,
    });
});