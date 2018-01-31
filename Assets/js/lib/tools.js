var SiteTools = {

    /**
     * Sort an array of data by a given field
     *
     * @param data - array to be sorted
     * @param field - field to sort by or 'random'
     * @param type - 'number' or 'string'
     * @param order - 'asc' or 'desc' order
     */
    sortData : function(data, field, type, order) {
        switch (field) {
            case 'random':
                this.shuffle(data);
                break;
            default:
                switch (type) {
                    case 'number':
                        data.sort(function(a,b) {
                            if (order == 'desc') {
                                return (parseInt(b[field]) - parseInt(a[field]));
                            } else {
                                return (parseInt(a[field]) - parseInt(b[field]));
                            }
                        });
                        break;
                    default:
                        data.sort(function(a,b) {
                            if (order == 'desc') {
                                return (a[field] < b[field] ? 1 : -1);
                            } else {
                                return (a[field] > b[field] ? 1 : -1);
                            }
                        });
                        break;
                }
        }
        return data;
    },

    // ------------------------------------------------------------------

    /**
     * Randomize the list
     *
     * @param array - list of hotel id numbers
     */
    shuffle : function(array) {
        var currentIndex = array.length, temporaryValue, randomIndex;
        // while items to still shuffle
        while (0 !== currentIndex) {
            // pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;
            // ...and swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }
        return array;
    },

    // ---------------------------------------------------------------------------

    /**
     * Generate a random string
     *
     * @param len - random string length
     * @return {string}
     */
    stringGen : function stringGen(len) {
        var text = '';
        var charset = "abcdefghijklmnopqrstuvwxyz0123456789";
        for( var i=0; i < len; i++ ) {
            text += charset.charAt(Math.floor(Math.random() * charset.length));
        }

        return text;
    },

    // ---------------------------------------------------------------------------

    /**
     * Get the highest z-index value
     * @return {number}
     */
    getZindex : function() {
        var highest = 1;
        $("*").each(function() {
            var current = parseInt($(this).css("z-index"), 10);
            if(current && highest < current) highest = current;
        });

        return highest;
    },

    // ---------------------------------------------------------------------------

    /**
     * Bring the clicked dialog to the foreground
     *
     * @param elem
     */
    dialogFront : function(elem) {
        var highest = 1;
        var current = 0;

        // find the highest zindex with in the dialogs
        $("div.wyred-dialog").each(function() {
            current = parseInt($(this).css("z-index"), 10);
            if (current && highest < current) {
                highest = current;
            }
        });
        if (highest === current) highest = current + 1;

        // reset the zindexes
        $('div.wyred-dialog').css('zIndex', current);
        $(elem).css('zIndex', highest);

    },

    // ---------------------------------------------------------------------------

    /**
     * Close this dialog box
     *
     * @param id - transparent overlay parent to dialog
     * @param did - dialog id
     * @param overlays - number of active overlays
     * @param oid - shaded overlay id
     */
    closeDialog : function(id, did, overlays, oid, fade, callBack) {
        // check if modal by looking for an overlay
        if ( $('#'+id).length == 0 ) {
            // fade out and remove the dialog
            $( '#'+did ).fadeOut( fade, function() {
                // remove the dialog from the DOM
                $('#'+did).remove();
            });
            return true;
        }

        // clear out if overlay
        if (overlays === 0) {
            $( '#'+oid ).fadeOut( fade, function() {
                $('#'+oid).remove();
            });
        }

        // fade out and remove the dialog
        $( '#'+id ).fadeOut( fade, function() {
            // remove the dialog from the DOM
            $('#'+did).remove();
            // remove the overlay(s)
            $('#'+id).remove();
        });

        if (callBack) {
            callBack();
        }
    },

    // ---------------------------------------------------------------------------

    /**
     * Close a dialog by it's id
     * 
     * @param id
     */
    destroyDialog : function(id) {
        var oid = id + '-overlay';      // dark overlay
        var did = id + '-dialog';       // dialog box
        // remove the dialog from the DOM
        $('#'+did).remove();
        // remove the overlay(s)
        $('#'+id).remove();
        // remove the rest of the overlays
        $('#'+oid).remove();
    },

    // ---------------------------------------------------------------------------

    /**
     * Create a dialog box using 'simple modal' plugin and add it to the DOM, then remove it on close
     *
     * @param title - text for title bar
     * @param message - message to display
     * @param error - true for an error dialog
     * @param {String} button_text - close button text
     * @param button_name - id for the button
     */
    showDialog : function(title, message, error, button_text, button_name) {
        // define css for the modal
        var css = {position:'fixed', zIndex:'1002', top:'0px', bottom:'0px', right:'0px', left:'0px', backgroundColor: '#000'};
        var modalOptions = {opacity:60, overlayClose:true, autoResize:true, autoPosition:true, closeClass:'close-class', escClose:true, overlayCss:css};

        $('#error-modal').remove(); // remove any existing modal
        if (button_text == null) button_text = 'Close'; // set close button text

        // set styles for error div
        var title_style = '';
        if (error) { title_style = "background-color:#D90000;"; }

        var html = '<div class="modalDialogMap" id="error-modal">' +
            '<div class="content"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">' +
            '<h1 class="h1-inside-placement-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 dialog-title" style="'+title_style+'">'+title+'</h1>' +
            '<div class="contact-inside-placement col-xs-12 col-sm-12 col-md-12 col-lg-12">' +
            '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>' +
            '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 err-padd">' + message + '</div></div>' +
            '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 modal-button-bottom">' +
            '<div class="col-xs-0 col-sm-4 col-md-4 col-lg-4"></div>' +
            '<a style="'+title_style+'"';
        if (button_name != null) html += 'id="'+button_name+'" ';
        html += 'class="';
        if (button_name == null) html += 'close-class ';
        html += 'button button-background col-xs-12 col-sm-4 col-md-4 col-lg-4">'+button_text+'</a></div></div></div></div>';

        $("body").append(html);
        $('#error-modal').modal(modalOptions);
    },

    // ---------------------------------------------------------------------------

    /**
     * Create a dialog box
     * @param args - array of arguments
     */
    dialog : function(args) {
        var zindex = this.getZindex(); // get the highest zIndex
        var html;

        // create random ids for dialog and buttons
        var id  = this.stringGen(6);    // transparent overlay
        var oid = id + '-overlay';      // dark overlay
        var did = id + '-dialog';       // dialog box
        var bid = id + '-btn1';         // button id - if using default
        var closeid = id + '-clbtn1';   // top close button

        // overlay variables
        var overStyle = 'display:none; background-color: rgb(0,0,0); opacity: 0.6;';
        var overlay;

        // count the current number of overlays
        var overlays = $("div.wyred-dialog-overlay").length;

        // set default options
        var defaults = {
            parent: 'html',
            modal: true,
            title: 'Dialog Box',
            error: false,
            topclose: true,
            message: 'Dialog Message',
            buttonpanel: true,
            buttontext: 'Close',
            outsideclose: true,
            topcloseHTML: '<span style="font-size:.8em;"><i class="fa fa-close" aria-hidden="true"></i></span>',
            fade:200,
            top: '10%',
            height: '60%',
            draggable: false,
            cursor: 'default',
            buttonHTML: false
        };

        // combine the defaults and arguments
        var opts = $.extend(defaults, args);
        var parent = opts.parent;

        // set button HTML
        if (opts.buttonHTML === false) opts.buttonHTML = '<a id="'+bid+'" class="close-button dialog-button no-select col-xs-12 col-sm-4">'+opts.buttontext+'</a>';

        // -----------------------------------------

        // create the overlay to make this a modal dialog
        if (opts.modal === true) {
            // set a main overlay for all dialogs
            if (overlays === 0) {
                overlay = '<div class="wyred-dialog-overlay" id="'+oid+'" style="z-index:'+zindex+'; border:none; position:fixed; top:0; bottom:0; left:0; right:0; '+overStyle+'"></div>';
                $('html').append(overlay);
                $('#'+oid).show();
            }

            // create an invisible overlay for this dialog
            overStyle = 'background-color:transparent; overflow-y: auto';
            overlay = '<div class="wyred-dialog-overlay" id="'+id+'" style="z-index:'+zindex+'; border:none; position:fixed; top:0; bottom:0; left:0; right:0; '+overStyle+'"></div>';
            $("html").append(overlay);
            $('#'+id).show();
            parent = $('#'+id);
        }

        // -----------------------------------------

        // set styles for error div
        var title_style = '';
        if (opts.error) title_style = "background-color:red !important; color:#ffffff !important;";

        // create dialog title bar
        html =  '<div id="'+did+'" class="wyred-dialog" style="height:'+opts.height+'; top:'+opts.top+'; left:'+opts.left+'; z-index:'+zindex+'; cursor:'+opts.cursor+';">';

        // add close button option
        if (opts.topclose === true) {
            html += '       <div id="'+closeid+'" class="top-close-button">'+opts.topcloseHTML+'</div>';
        }


        html += '   <h1 class="h1-inside-placement-modal no-select title col-xs-12" style="'+title_style+'">'+opts.title;


        // create dialog body html
        html += '   </h1>'+
                '   <div class="content"><div class="col-xs-12">'+opts.message+'</div></div>';

        // lower button panel
        if (opts.buttonpanel === true) {
            html += '   <div class="lower-button-panel col-xs-12"><div class="col-xs-0 col-sm-4"></div>' + opts.buttonHTML + '</div>';
        }

        // dialog html - closure
        html += '</div>';

        // add the dialog html to the DOM - parent is html or overlay if modal
        $(parent).append(html);

        // dialog click - bring to front and stop from closing
        $('#'+did).click(function(event) {
            SiteTools.dialogFront(this);
            if (!$(event.target).hasClass('dialog-no-close')) {
                event.stopImmediatePropagation();
            }
        });

        // overlay click event
        if (opts.outsideclose === true) {
            $('#'+id).click(function(event) {
                if (!$(event.target).hasClass('dialog-no-close')) {
                    SiteTools.closeDialog(id, did, overlays, oid, opts.fade, opts.close);
                }
            });
        }

        // close button click
        $('#'+bid).click(function() {
            SiteTools.closeDialog(id, did, overlays, oid, opts.fade, opts.close);
        });

        // top close button click
        $('#'+closeid).click(function() {
            SiteTools.closeDialog(id, did, overlays, oid, opts.fade, opts.close);
        });

        // show the dialog
        $( '#'+did ).fadeIn( opts.fade );

        // bring selected dialog to foreground
        if (opts.draggable === true) {
            $( '#'+did ).draggable({
                start: function( event, ui) {
                    SiteTools.dialogFront(ui.helper);
                }
            });
        }

        // return an array of the ids and options
        return id;
    }
};