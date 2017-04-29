$(function() {
    if ($('#work-timer').length > 0) {
        $('#work-timer').timer({
            seconds: window.dailyTime,
            format: '%H:%M:%S'
        });
        if (window.isWorking === false) {
            $('#work-timer').timer('pause');
        }
    }

    $(document).on('click', '.start-timer', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            dataType: 'json',
            context: this
        })
        .done(function(response) {
            if (response.ok === true) {
                //Change button to "Stop"
                $(this).parent('li').replaceWith(response.view);
                //Start timer with work progress
                $('#work-timer').timer('resume');
            }
            console.log("success");
        });
    });

    $(document).on('click', '.stop-timer', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            dataType: 'json',
            context: this
        })
        .done(function(response) {
            if (response.ok === true) {
                //Change button to "Start"
                $(this).parent('li').replaceWith(response.view);
                //Stop timer with work progress
                $('#work-timer').timer('pause');
            }
            console.log("success");
        });
    });
});

// (function(){
//     var Timer = {
//         init: function() {
//             this.timer = $('.work-timer');
//             this.submitButton = this.form.find('button[type=submit]');
//             this.submitButtonValue = this.submitButton.html();

//             this.bindEvents();
//         },

//         bindEvents: function() {
//             this.form.on('submit', $.proxy(this.sendRequest, this));
//         },

//         sendRequest:function(event) {
//             event.preventDefault();

//             this.submitButton.prop('disabled', true).html('Validating data...');

//             $.ajax({
//                 url: this.form.attr('action'),
//                 type: 'POST',
//                 // dataType: 'json',
//                 data: new FormData($('.main-form')[0]),
//                 context: this,
//                 async: false,
//                 cache: false,
//                 contentType: false,
//                 processData: false
//             })
//             .done(function() {
//                 this.form[0].submit();
//             })
//             .fail(function(response) {
//                 response = JSON.parse(response);
//                 this.submitButton.prop('disabled', false).html(this.submitButtonValue);
//                 this.form.find('.help-block').html('');
//                 $.each(response.responseJSON, function(field, value) {
//                     this.form.find('.field-' + field + ' .help-block').html(value);
//                 }.bind(this));
//             });
//         }
//     }

//     Timer.init();
// })();