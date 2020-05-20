$(document).ready(function(){

// call functions after load
	setClock();
    tackleClasses($(window));
    // Initialize datepickers on create/edit and guest.index view
    const datepicker = document.initDatepicker('.js-datepicker');
    const datetimepicker = document.initDatepicker('.js-datetimepicker',getConfigDateTime());

// set event-handlers
    // event-handler for making the row clickable in the dashboard table
    $(document).on('click', 'div[data-href]', function(){
        window.location = $(this).data('href');
    });

    // add confirm, before deleting sessions like a hero
    $(document).on('click', 'button[value="delete"]', function(){
        return confirm('Are you sure, you want to delete that item?');
    });

    // this checks if in the /dashboard a select for choosing the role was changed
    $(document).on('change', 'select[class="role_id_select"], select[class="accommodation_id_select"]', function(){
       this.parentNode.submit();
    });

    // this checks if in the /dashboard an input was changed or not
    $(document).on('keypress', '.input_change', function(e){
        let key = e.charCode || e.keyCode || 0;
        const initialValue = this.getAttribute('value');
        console.log(initialValue);
        if (key === 13) {
            if (!gotChanged(this)) {
                alert('You did not change anything!');
                return false;
            }
        }
    });

    // this sends the capacity form if you click outside of the input field
    $(document).on('change', '.input_change_capacity', function(){
        if (gotChanged(this)) {
            this.parentNode.submit();
        }
    });

    // activates the popovers in guests index view
    $(function () { $('[data-toggle="popover"]').popover() });

    $('.popover-dismiss').popover({ trigger: 'focus' });

    // Necessary for table redrawing on Dashboard view
    $(window).bind("resize",function(){
        // console.log($(window).width());
        tackleClasses(this);
    });

    // Clears the Search field on Dashboard
    $(document).on('click', '#clear_search', function(){
        clearElementValue('search');
    });

    // Resets the Search field on Dashboard
    $(document).on('click', '#reset_search', function(){
        window.location = '/admin/dashboard';
    });

    // Resets the Search field on Guests Overview
    $(document).on('click', '#reset_guests_search', function(){
        window.location = '/guests';
    });



// declare functions
	// Clear searches
    function clearElementValue(element){
        document.getElementById(element).value = '';
    }

    // checks if something was changed inside an input field
    function gotChanged(element){
        const initialValue = element.getAttribute('value');
        if (element.value === initialValue) {
            return false
        } else {
            return true
        }
    }

    // needed for the clock in the right upper corner
    function setClock(){
        setInterval(function() {
            var date = new Date();
            $('#date-element').html(
                (date.getDate()) + "." + (date.getMonth()+1) + "." + date.getFullYear() + " | " +  date.getHours() + ":" + (( date.getMinutes() < 10 ? "0" : "" ) + date.getMinutes()) + ":" + (( date.getSeconds() < 10 ? "0" : "" ) + date.getSeconds())
            );
        }, 500)
    }

    // removes table related bootstrap classes if screen gets to small
    function tackleClasses(window){
        if($(window).width() <760){
            $('.table_card').removeClass('table-sm', 'table-striped')
        }
        else{
            $('.table_card').addClass('table-sm', 'table-striped')
        }
    }

});
