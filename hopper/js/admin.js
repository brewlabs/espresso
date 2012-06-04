var esFrame = (function() {
	var instance = {
	 answer_confirm:	function ( text ) {
			var answer = confirm( text );

			if( answer ) { return true; }
			else { return false; }
		}
	}
	return instance;
})(window);