
/**
 * Javascript for the create event page
 */

//Create form tags
$('#taglist').select2({
    placeholder: 'Choose all the tags that apply. This will help people find and choose your competitions.',
});

//Create event form - show the late entries fee box if the late entries checkbox is ticked
$(document).ready(function() {
   $('#lateEntries').change(function() {
       if(this.checked)
           $('#lateEntriesCost').fadeIn('fast');

       else
           $('#lateEntriesCost').fadeOut('fast');
   });
});
//make sure the late entries fee is hidden on page load.
$(document).ready(function() {
    $('#lateEntriesCost').hide();
});

//Create event form - show the registration fee box if required
$(document).ready(function() {
    $('#registration').change(function() {
        if(this.checked)
            $('#registrationCost').fadeIn('fast');
        else
            $('#registrationCost').fadeOut('fast');
    });
});
$(document).ready(function() {
    $('#registrationCost').hide();
});


//Datepicker (start and end are linked)
$(function() {
    $('#startDate').datetimepicker({
        format: 'YYYY-M-D',
    });
    $('#endDate').datetimepicker({
        format: 'YYYY-M-D',
        useCurrent: false //Important! See issue datepicker github #1075
    });
    $("#startDate").on("dp.change", function (e) {
        $('#endDate').data("DateTimePicker").minDate(e.date);
    });
    $("#endDate").on("dp.change", function (e) {
        $('#startDate').data("DateTimePicker").maxDate(e.date);
    });
});
//date picker (closing date)
$(function() {
    $('#closingDate').datetimepicker({
        format: 'YYYY-M-D'
    });
});

$(function() {
    $('#questionDate').datetimepicker({
        format: 'YYYY-M-D'
    });
});

/**
 * Event administration page
 */

//Making sure we can pass data to the 'add detail' modal on the admin dashboard
$(function() {
    $('#detailModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);// Button that triggered the modal
        var compID = button.data('comp'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        $('.comp input').val(compID);
    });
});

//Date time picker on the add detail modal. Icons is required for them to be seen
//with this site's css.
$(function() {
    $('#dateTime').datetimepicker({
        format: 'YYYY-M-D HH:mm:ss',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });
});

//Extra information required - admin page - show the text box label
$(document).ready(function() {
    $('#infoRequired').change(function() {
        if(this.checked)
            $('#infoLabelText').fadeIn('fast');

        else
            $('#infoLabelText').fadeOut('fast');
    });
});
//make sure the late entries fee is hidden on page load.
$(document).ready(function() {
    $('#infoLabelText').hide();
});

//Specific questions - show the text box if a drop down box is selected as an answer type
$(document).ready(function() {
    $('#answerType').change(function() {
        if($('#answerType').val() == 'list')
            $('#listItemsDiv').fadeIn('fast');
        else
            $('#listItemsDiv').fadeOut('fast');
    });
});
//make sure listitemsdiv is hidden on modal load
$(document).ready(function() {
    $('#listItemsDiv').hide();
});

//entry confirm page - only allow clicking of enter&pay box when t&cs have been checked
$(document).ready(function() {
    $('#terms').change(function() {
        if(this.checked)
            $('#enterpay').removeAttr("disabled");
        else
            $('#enterpay').attr("disabled", true);
    });
});

//Show user information (when organiser clicks user name on entry list) //modal
$(function() {
    $('#viewEntryCompetitorInfoModal').on('show.bs.modal', function(event) {
        var link = $(event.relatedTarget) //link that triggered the modal
        var username = button.data('username') 
        var modal = $(this)
        modal.find('.modal-title').text(username)
    });
});

/** summernote **/
$(document).ready(function() {
    $('#description').summernote({
        height: 200,
        placeholder: 'Type and format your description here',
        toolbar: [
            ['style', ['bold','italic','underline','clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['link',['table']]
        ]
    });
});

/** Social buttons **/
$(document).ready(function() {

    var popupSize = {
        width: 780,
        height: 550
    };

    $(document).on('click', '.social-buttons > a', function(e){

        var
            verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
            horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

        var popup = window.open($(this).prop('href'), 'social',
            'width='+popupSize.width+',height='+popupSize.height+
            ',left='+verticalPos+',top='+horisontalPos+
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

        if (popup) {
            popup.focus();
            e.preventDefault();
        }

    });
});


