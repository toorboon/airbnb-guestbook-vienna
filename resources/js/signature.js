import SignaturePad from "signature_pad";

$(document).ready(function(){
// init
    // makes HTML5 canvas applicable for signature drawing
    var canvas = document.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas);
    var counter = 0;

    findDeleteButtons();

// set event-handlers
    $(document).on('click', '#clear_signature', function(){
        signaturePad.clear();
    });

    $(document).on('click', '#save_signature', function(){
        if (signaturePad.isEmpty()){
            alert('Sorry, you cannot save an empty signature!');
        } else {
            document.getElementById('signature').value = signaturePad.toDataURL();
        }
    });

    // Adds new fellow lines if requested by user
    $(document).on('click', '#add_row', function(){
       drawFellowRow();
       counter++;
    });

    // Necessary for canvass redrawing on Create Guest View
    $(window).bind("resize",function(){
        if($(window).width() < 430){
            document.getElementById('canvass').width = 300;
        } else {
            document.getElementById('canvass').width = 400;
        }
    });

// declare functions
    function drawFellowRow(){

        let base = document.querySelector('#base');
        base.insertAdjacentHTML('afterbegin',
        `<div class="d-flex flex-sm-row flex-column fellow bg-light my-2">
                <div class="form-group col-md-4">
                    <label for="first_name`+counter+`">First Name</label>
                    <input id="first_name`+counter+`" type="text" class="form-control" name="fellows[`+counter+`][first_name]">
                </div>

                <div class="form-group col-md-4">
                    <label for="last_name`+counter+`">Last Name</label>
                    <input id="last_name`+counter+`" type="text" class="form-control" name="fellows[`+counter+`][last_name]">
                </div>

                <div class="form-group col-md-4 d-flex justify-content-between">
                    <div class="d-flex flex-column w-75">
                        <label for="birth_date`+counter+`">Birth Date</label>
                        <div class="js-datepicker datepickerSet d-flex">
                            <input id="birth_date`+counter+`" type="text" name="fellows[`+counter+`][birth_date]" placeholder="Select date.." data-input>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-4 ml-4 w-25">
                        <button id="delete`+counter+`" type="button" class=" btn btn-sm btn-outline-danger">&#10539;</button>
                    </div>
                </div>
            </div>`);

        // Initialise Datepicker for just added birthday field
        document.initDatepicker(document.querySelector('#birth_date'+counter).parentElement);
        setDeleteEvent();
    }

    // Deletes the not needed fellows rows if inserted by user
    function setDeleteEvent(){
        $(document).on('click', '#delete'+counter, function(){
            this.parentElement.parentElement.parentElement.remove();
        });
    }

    function findDeleteButtons(){
        let deleteButtonList = document.querySelectorAll('.artificial_delete');

        for (const button of deleteButtonList){
            let buttonId = button.id.substring(6);
            $(document).on('click', '#'+button.id, function(){
                this.parentElement.parentElement.parentElement.remove();
            })
        }

    }

});
