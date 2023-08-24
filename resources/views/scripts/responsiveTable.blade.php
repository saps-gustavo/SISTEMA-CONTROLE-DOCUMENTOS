{{-- ESTE PLUGIN JQUERY DEPENDE DA BIBLIOTECA BASIC TABLE QUE É ADICIONADA ABAIXO --}}
@include('scripts.basicTable')
<script>
	(function( $ ) {
 
    $.fn.responsiveTable = function(options) {

    	var obj = this;

    	var settings = $.extend({
            // These are the defaults.
            hideColumnsClass: 'hide',
            changeOrientation: 600,
            targets: 
            [{
            	hideColumnsMin: 601,
            	hideColumnsMax: 992,
            	hideColumnsClassSelector: 'table-responsive-hide',
            	selectors: ['th', 'td'],
            	action: 'hide'
            }], 
            
            
        }, options );

    	var init = function (obj, settings) {
	    	return obj.each(function() 
	    	{
		    	//call basic table
		    	$(this).basictable({breakpoint: settings.changeOrientation, contentWrap: true});

		    	var currentWidth = $(window).width();
				//loop targets
				if(typeof settings.targets != 'undefined' && settings.targets instanceof Array  && settings.targets.length > 0)
				{
					for(i=0;i<settings.targets.length;i++)
					{
						if(currentWidth < settings.targets[i].hideColumnsMax && currentWidth > settings.targets[i].hideColumnsMin)
						{
							if(typeof settings.targets[i].selectors != 'undefined' && settings.targets[i].selectors instanceof Array  && settings.targets[i].selectors.length > 0)
							{
								for(x=0;x<settings.targets[i].selectors.length;x++)
								{
									if(settings.targets[i].action == 'hide')
									{
										$(this).find(settings.targets[i].selectors[x]+'.'+settings.targets[i].hideColumnsClassSelector).addClass(settings.hideColumnsClass);
										$(this).find(settings.targets[i].selectors[x]+'.'+settings.targets[i].hideColumnsClassSelector).addClass(settings.hideColumnsClass);
									}
								}
							}							
						}
						else
						{
							if(currentWidth > settings.targets[i].hideColumnsMax  || currentWidth < settings.targets[i].hideColumnsMin)
							{
								if(typeof settings.targets[i].selectors != 'undefined' && settings.targets[i].selectors instanceof Array  && settings.targets[i].selectors.length > 0)
								{
									for(x=0;x<settings.targets[i].selectors.length;x++)
									{
										if(settings.targets[i].action == 'hide')
										{
											$(this).find(settings.targets[i].selectors[x]+'.'+settings.targets[i].hideColumnsClassSelector).removeClass(settings.hideColumnsClass);
											$(this).find(settings.targets[i].selectors[x]+'.'+settings.targets[i].hideColumnsClassSelector).removeClass(settings.hideColumnsClass);
										}
									}									
								}								
							}						
						}
					}
				}
		    });
       }

       return init(obj, settings); 
    }; 
}( jQuery ));


    	
</script>