/* globals global */
jQuery(function($){
    var searchRequest;
    var autoData = [];
    var resultData = [];

    var thisEl = "";


    $('.search-autocomplete').on('click', function( evt ){
        thisEl = this.id;
        resultData = [];
    });


	$('.search-autocomplete').autoComplete({
		minChars: 2,
		source: function(term, suggest){

			try { searchRequest.abort(); } catch(e){}
			searchRequest = $.post(global.ajax, { search: term, action: 'search_site' }, function(result) {

                result.data.forEach (function( item ){
                    resultData.push( item.label );
                });

                autoData = result.data;
                suggest(resultData);
			});
        },
        onSelect: function (event, ui){

            // console.log(  thisEl  );

            document.getElementById( thisEl + "_hidden" ).value = autoData[ resultData.indexOf( ui ) ].value;
        }
	});
});
