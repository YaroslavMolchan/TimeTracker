$(function() {
    $('#work-timer').timer({
        seconds: window.dailyTime,
        format: '%H:%M:%S'
    });
    if (window.isWorking === false) {
        $('#work-timer').timer('pause');
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