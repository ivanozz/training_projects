$(function(){
    /************************************
     * Connect and login to deepstreamHub
     ************************************/
    //establish a connection. You can find your endpoint url in the
    //deepstreamhub dashboard
    var ds = deepstream('wss://035.deepstreamhub.com?apiKey=acbc2bce-b02f-4cca-a322-06598ebc3bef');

    //display the connection state at the top
    ds.on( 'connectionStateChanged', function( connectionState ){
        $( '#connection-state' ).text( connectionState );
    });

    //authenticate your connection. We haven't activated auth,
    //so this method can be called without arguments
    ds.login();

    /************************************
     * Realtime datastore
     ************************************/
    // Create or retrieve a record with the name test/johndoe
    var myRecord = ds.record.getRecord( 'test/johndoe' );

    // We want to synchronize a path within the record, e.g. `firstname`
    // with an input so that every change to the input will be saved to the
    // record and every change from the record will be written to the input
    function bindInputToPath( record, input, path ) {

        // Write changes from the record to the input element
        record.subscribe( path, function( value ){
            input.val( value );
        });

        //Write changes to the input element to the record
        input.on( 'keyup', function(){
            record.set( path, input.val() );
        });
    }

    //bind the input for firstname
    bindInputToPath( myRecord, $( '#firstname' ), 'firstname' );

    //bind the input for lastname
    bindInputToPath( myRecord, $( '#lastname' ), 'lastname' );

    /************************************
     * Publish Subscribe
     ************************************/
    // Whenever the user clicks the button
    $( '#send-event' ).click(function(){
        // Publish an event called `test-event` and send
        ds.event.emit( 'test-event', $( '#event-data' ).val() );
    });

    // Subscribe to `test-event`
    ds.event.subscribe( 'test-event', function( eventData ){
        // Whenever we receive a message for this event,
        // append a list item to our list
        var html = '<li>Received test-event with <em>' + eventData + '</em></li>';
        $( '#events-received' ).append( html );
    });

    /************************************
     * Request Response
     ************************************/
    $('#make-rpc').click(function(){
        // read the value from the input field
        // and convert it into a number
        var data = {
            value: parseFloat( $('#request-value' ).val() )
        };

        // Make a request for `multiply-number` with our data object
        // and wait for the response
        ds.rpc.make( 'multiply-number', data, function( err, resp ){

            //display the response (or an error)
            $( '#display-response' ).text( resp || err.toString() );
        });
    });

    // Register as a provider for multiply-number
    ds.rpc.provide( 'multiply-number', function( data, response ){
        // respond to the request by multiplying the incoming number
        // with the one from the response input
        response.send( data.value * parseFloat( $('#response-value' ).val() ) );
    });
});