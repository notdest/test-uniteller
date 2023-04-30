import 'bootstrap/dist/css/bootstrap.min.css';
import $ from "jquery";

$(document).ready(function() {
    setInterval(function() {
        $.get( "?short=1", function( data ) {
            $( "#table" ).html( data );
        });
    }, 5000);
});
