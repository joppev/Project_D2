let Project2d = (function () {


    /**
     * Show a Noty toast.
     * @param {object} obj
     * @param {string} [obj.type='success'] - background color ('success' | 'error '| 'info' | 'warning')
     * @param {string} [obj.text='...'] - text message
     */
    function toast(obj) {
        let toastObj = obj || {};   // if no object specified, create a new empty object
        new Noty({
            layout: 'topRight',
            timeout: 3000,
            modal: false,
            type: toastObj.type || 'success',   // if no type specified, use 'success'
            text: toastObj.text || '...',       // if no text specified, use '...'
        }).show();
    }
    function qlik(){
        /*
 * Basic responsive mashup template
 * @owner Enter you name here (xxx)
 */
        /*
         *    Fill in host and port for Qlik engine
         */


        connect();

        async function connect() {
            const urlQlikServer = "https://r0743641.eu.qlikcloud.com/";
            const urlLoggedIn = "api/v1/audits";//Use GET request to see if you are authenticated
            const urlLogin = "login";
            const webIntegrationId = 'Fyml_Ta_M3TY9YBzn0n2TCNaeykh5SK5';

            //Check to see if logged in
            return await fetch(`${urlQlikServer}${urlLoggedIn}`, {
                credentials: 'include',
                headers: {
                    'Qlik-Web-Integration-ID':webIntegrationId
                }
            })
                .then(async function(response)
                {
                    //check if user is authenticated; if not, redirect to login page
                    if(response.status===401){
                        const url = new URL(`${urlQlikServer}login`);
                        url.searchParams.append('returnto', 'http://localhost:3000/');
                        url.searchParams.append('qlik-web-integration-id', webIntegrationId);
                        window.location.href = url;
                    }
                })
                .catch(function(error)
                {
                    console.error(error);
                });
        }

        var config1 = {
            host: "r0743641.eu.qlikcloud.com", //the address of your Qlik Engine Instance
            prefix: "/", //or the virtual proxy to be used. for example "/anonymous/"
            port: 443, //or the port to be used if different from the default port
            isSecure: true, //should be true if connecting over HTTPS
            webIntegrationId: 'Fyml_Ta_M3TY9YBzn0n2TCNaeykh5SK5' //only needed in SaaS editions and QSEoK
        };

        require.config( {
            baseUrl: (config1.isSecure ? "https://" : "http://" ) + config1.host + (config1.port ? ":" + config1.port : "") + config1.prefix + "resources",
            webIntegrationId: config1.webIntegrationId
        } );

        require( ["js/qlik"], function ( qlik ) {
            qlik.on( "error", function ( error ) {
                $( '#popupText' ).append( error.message + "<br>" );
                $( '#popup' ).fadeIn( 1000 );
            } );
            $( "#closePopup" ).click( function () {
                $( '#popup' ).hide();
            } );


            //opend corona app
            var app = qlik.openApp("8a89b99d-1827-43ca-9b85-adb4ce8cd5d5", config1);

            //tekst rijsadvies op basis van aantal nieuwe besmettingen
            app.getObject('QV01', 'qdrKKC');

            $("#clearAll").click(function() {
                app.clearAll(true);


            });

            //geeft een lijst weer met alle qlik themas die je hebt
            //qlik.getThemeList().then(function(list){ var str = ""; list.forEach(function(value) { str += value.name + '(' + value.id + ")\n"; }); alert(str); });
            //applyd het genoemde thema en past het toe op de webpagina
            qlik.theme.apply('project4.0').then(function(result){
                //alert('theme applied with result: ' + result);
            });
            //laat zien welk thema er op de html pagina gebruikt word
            /*   app.theme.getApplied().then(function(qtheme){
               alert('Current theme background color: ' + qtheme.id);

               });*/
        } );

    }
    // Return all functions that are public available. E.g. VinylShop.hello()
    return {

        toast: toast,
        qlik:qlik,
    };

})();


/*
 * Basic responsive mashup template
 * @owner Enter you name here (xxx)
 */
/*
 *    Fill in host and port for Qlik engine
 */

/*
 * Basic responsive mashup template
 * @owner Enter you name here (xxx)
 */
/*
 *    Fill in host and port for Qlik engine
 */




export default Project2d;
