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

    // Return all functions that are public available. E.g. VinylShop.hello()
    return {

        toast: toast,
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
