jQuery(document).ready(function(){
	jQuery( '.espresso_widget_tabs' ).find( '.nav a' ).click( function ( e ) {
		if ( jQuery( this ).parent( 'li' ).hasClass( 'active' ) ) { return false; }
		var thisTabber = jQuery( this ).parents( '.espresso_widget_tabs' );
		var targetTab = jQuery( this ).attr( 'href' );
		jQuery( this ).parent( 'li' ).addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
		thisTabber.find( '.tab-pane' + targetTab ).addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
		return false;
	});
});