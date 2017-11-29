(function($, document, window){
    $(document).ready(function(){
        $youtube        = 'youtube.com';
        $vimeo          = 'vimeo.com';
        $auto_start     = $('*[data-ptoautostart*="yes"]');
        $show_controls  = $('*[data-ptoshowcontrols*="yes"]');
        $default_yt     = $('*[data-ptodefaultyt]');

        if( $('.fx-video-container iframe').is(':visible') ){
            // auto start option for youtube and vimeo
            if( $auto_start.length > 0 ){
                $auto_start.each(function(){
                    $iframe = $(this).find('iframe');
                    $src = $iframe.attr('src');

                    if($src.indexOf($youtube) !== -1){
                        $new_src = $src.replace( $src, $src + '&showinfo=0&autoplay=1&' );
                        $iframe.attr( 'src', $new_src );
                        // console.log($new_src);
                    }else if($src.indexOf($vimeo) !== -1){ //
                        $new_src = $src.replace( $src, $src + '?autoplay=1' );
                        $iframe.attr( 'src', $new_src );
                        // console.log($new_src);
                    }else{
                        return;
                    }
                    
                });
            }

            // show control option only for vimeo.
            if( $show_controls.length > 0 ){
                $show_controls.each(function(){
                    $iframe = $(this).find('iframe');
                    $src = $iframe.attr('src');

                    if($src.indexOf($youtube) !== -1){
                        $new_src = $src.replace( $src, $src + '&showinfo=0&controls=1' );
                        $iframe.attr( 'src', $new_src );
                        // console.log($new_src);
                    }else{
                        return;
                    }
                });
            }

            if( $default_yt.length > 0 ){
                $default_yt.each(function(){
                    $iframe = $(this).find('iframe');
                    $src = $iframe.attr('src');

                    if($src.indexOf($youtube) !== -1){
                        $new_src = $src.replace( $src, $src + '&showinfo=0' );
                        $iframe.attr( 'src', $new_src );
                        // console.log($new_src);
                    }else{
                        return;
                    }
                    
                });
            }
        }
    });
})(jQuery, document, window);