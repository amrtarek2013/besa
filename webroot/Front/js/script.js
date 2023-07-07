$(document).ready(function() {

    "use strict";

    var columnFourth =  $( ".column-fourth" ).clone(true);
    var columnThird =  $( ".column-third" ).clone(true);
    var columnFrist =  $( ".column-frist" ).clone(true);
    var columnSecond =  $( ".column-second" ).clone(true);

    // Create a media condition that targets viewports at least 768px wide
    const mediaQuery = window.matchMedia('(max-width: 767px)')
    // Check if the media query is true
    if (mediaQuery.matches){

    document.getElementById("tabel-statics").innerHTML = "";

        columnThird.appendTo( ".tabel-statics" );
        columnFourth.appendTo( ".tabel-statics" );
        columnFrist.appendTo( ".tabel-statics" );
        columnSecond.appendTo( ".tabel-statics" );

    };

});