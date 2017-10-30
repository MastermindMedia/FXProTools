$(document).ready(function () {
    var ajax_url = fx.ajax_url;
    var $overlay = $('.fx-renewal .overlay');
    var $response = $('.fx-renewal .ajax-response');

    $('.fx-renewal form').on('submit', function (e) {
        e.preventDefault();
        $overlay.show();

        var data = {
            'action': 'fx_renew_password',
            'fx_action': 'renew_password',
            'new_password': $('#pwd').val()
        };

        $.post(ajax_url, data, function () {
            $overlay.hide();
        }).done(function (response) {
            if (response.success) {
                var count = 3;
                var message = '<h2>Password successfully updated!</h2><p>You will be redirected to your dashboard in <strong>%s</strong> seconds.</p>';
                $response.html(message.replace(/%s/g, count)).show();
                var countdown = setInterval(function () {
                    if (count == 1) {
                        message = message.replace(/seconds/g, 'second');
                    }
                    $response.html(message.replace(/%s/g, count));
                    if (count == 0) {
                        clearInterval(countdown);
                        window.open('/dashboard', "_self");

                    }
                    count--;
                }, 1000);

            } else {
                $response.html('<h2>Password update failed. Refresh this page and please try again.</h2>').show();
            }
        });

        return false;
    })
});
