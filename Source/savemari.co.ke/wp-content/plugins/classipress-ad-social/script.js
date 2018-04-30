/**
 * Author: Roi Dayan
 * Author URI: http://roidayan.com
 */
jQuery(document).ready(function(){
	jQuery( 'body' ).delegate( 'span.tel[data-replace]', 'touchstart click', function(event){
		tel = jQuery( this ).attr( 'data-replace' );
		if ( tel == '' ) {
			return;
		}
		link = '<a href="tel:' + tel + '">' + tel + '</a>';
		jQuery(this).html(link).attr('data-replace', '');
		event.preventDefault();
	} );
});
