/*
@author: 
  Joost Elfering / http://yopefonic.wordpress.com/
@license: GNU General Public License V3 http://www.gnu.org/licenses/gpl.html
@project page: http://www.d-its.net/projects/jquery/titlecontrol/
@version: 0.2
@changelog
  0.2
    - refactoring of the code
    - image position is now determined by the script and does not need to be defined by css
  0.1
    - init structure for options build
    - init default options filled
    - create general functionality of converting title into appended element
    - added positioning of the hover element
    - added image inclusion option with another option to give the URL
    - Enhanced source with detailed comments
    - added adjusted horizontal offset for title that fall out of bounds
    - Enhanced horizontal adjustment to reposition image if it is configured
*/
(function($) {
    $.fn.titleControl = function(options) {
        // default option values
        var defaults = {
            childTag: '<span>',                                                 // tag type used for the hover element
            childClass: 'titleHover',                                           // class used for the hover element
            yDistance: 10,                                                      // horizontal offset away from the center
            xDistance: 0,                                                       // vertical offset away from direct below the origine
            imageInclude: true,                                                 // include an image in the hover (can be used for speach bubbles)
            imageUrl: '/images/transparent.gif'                                 // image URL used for the image appended in the hover (nicest solution would be CSS)
        }

        // join options and defaults
        if (options) {
            var options = $.extend(defaults, options);
        } else {
            var options = defaults;
        }

        return this.each(function() {
            title = $(this).attr('title');                                      // extract title from object

            // generate the new object to be appended
            titleTag = $(options.childTag);                                     // create tag from options
            titleTag.addClass(options.childClass);                              // add class to tag from options
            titleTag.html(title);                                               // fill tag with title
            if (options.imageInclude) {
                titleTag.append($('<img src="'+options.imageUrl+'">'));         // append an image from the option if this is set in the options
            }

            // generate subtag and remove title for interferance reasons
            $(this).append(titleTag);                                           // append the new tag to the origional object
            $(this).attr('title', '');                                          // remove title

            // obtain metrics for the source object, the window and the newly created title
            sourceMetrics = getObjectMectrics(this);
            windowMetrics = getObjectMectrics(window);
            titleMetrics = getObjectMectrics($(this).find('.'+options.childClass), $(this).find('.'+options.childClass));
            if (options.imageInclude) {                                         // obtain metrics for the image if it is included
                imageMetrics = getObjectMectrics($(this).find('.'+options.childClass+' img'), $(this).find('.'+options.childClass));
            }

            // calculate title basic centered x offset
            xOffset = (sourceMetrics.width/2) - (titleMetrics.width/2);

            // check if the box falls outside of the window to the right and adjust
            if ((sourceMetrics.left + titleMetrics.width) > windowMetrics.width) {
                xOffset = (windowMetrics.width-sourceMetrics.left)-titleMetrics.width;
            }

            // check if the box falls outside of the window to the left and adjust
            if (sourceMetrics.left + xOffset < 0) {
                xOffset = (-1*sourceMetrics.left);
            }

            // add optional distance to the x offset
            xOffset += options.xDistance;

            // calculate y offset and add optional y distance
            yOffset = sourceMetrics.height + options.yDistance;

            // position the title hover
            $(this).find('.'+options.childClass).css('top', yOffset+'px');
            $(this).find('.'+options.childClass).css('left', xOffset+'px');

            // calculate image offset if the image is included
            if (options.imageInclude) {
                xOffsetImage = (-1*xOffset) + ((sourceMetrics.width/2) - (imageMetrics.width/2)); // calculate x offset for image
                yOffsetImage = -1*imageMetrics.height;                          // calculate y offset for image
            }

            // position the title image
            if (options.imageInclude) {
                $(this).find('.' + options.childClass + ' img').css('left', xOffsetImage+'px');
                $(this).find('.' + options.childClass + ' img').css('top', yOffsetImage+'px');
            }

            // method to get the dimensions and the offset of an object
            function getObjectMectrics (object, hackObject) {
                if (hackObject) { $(hackObject).show(); }                       // this hack shows the object because offset needs to be visible to calculate

                if ($(object).offset() != null) {                               // calculate the offset if available
                    oLeft = $(object).offset().left;
                    oTop = $(object).offset().top;
                } else {
                    oLeft = 0;
                    oTop = 0;
                }

                if (isNaN($(object).outerWidth())) {                            // check if the outerWidth method is available if not take the normal width. IE needs this
                    oWidth = $(object).width();
                    oHeight = $(object).height();
                } else {
                    oWidth = $(object).outerWidth();
                    oHeight = $(object).outerHeight();
                }

                result = {                                                      // set the result hash to be returned for easy access
                    width: oWidth,
                    height: oHeight,
                    top: oTop,
                    left: oLeft
                };

                if (hackObject) { $(hackObject).css('display', ''); }           // reset the display to keep it hidden and usable with css
                
                return result;
            }
        });
    }
})(jQuery);