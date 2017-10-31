(function($, document, window){

    $youtube        = 'youtube.com';
    $vimeo          = 'vimeo.com';
    $auto_start     = $('*[data-ptoautostart*="yes"]');
    $show_controls  = $('*[data-ptoshowcontrols*="yes"]');

    // TODO: conflict with embedly video scroll, has diff src or its firing up first before this.
    if( $('.fx-video-container iframe').is(':visible') ){
        if( $auto_start.length > 0 ){
            $auto_start.each(function(){
                $iframe = $(this).find('iframe');
                $src = $iframe.attr('src');

                if($src.indexOf($youtube) !== -1){
                    $new_src = $src.replace( $src, $src + '&autoplay=1' ); // &controls=1
                    $iframe.attr( 'src', $new_src );
                    console.log($new_src);
                }else if($src.indexOf($vimeo) !== -1){ //
                    $new_src = $src.replace( $src, $src + '?autoplay=1' );
                    $iframe.attr( 'src', $new_src );
                    console.log($new_src);
                }else{
                    return;
                }
            });
        }

        if( $show_controls.length > 0 ){
            $show_controls.each(function(){
                $iframe = $(this).find('iframe');
                $src = $iframe.attr('src');

                if($src.indexOf($youtube) !== -1){
                    $new_src = $src.replace( $src, $src + '&controls=1' );
                    $iframe.attr( 'src', $new_src );
                    console.log($new_src);
                }else{
                    return;
                }
            });
        }
    }
    

})(jQuery, document, window);