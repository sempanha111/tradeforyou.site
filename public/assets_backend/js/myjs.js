$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    Pusher.logToConsole = true;

    var pusher = new Pusher('d30362fcd1dea0ff8332', {
      cluster: 'ap1'
    });


    var channel = pusher.subscribe('alertcrypto-channel');
    channel.bind('alertcrypto-event', function(data) {
        var id = data.user_id;
        makeAlertDepositCrypto(id);
        getLastStats();
        getLastTransactions();
        $('#status_text'+id).text('Payment Successfully');
    });
    
    function makeAlertDepositCrypto(id){
        $('#alert_payment_crypto'+id).removeClass('d-none');
    }
    function getLastStats(){
        $.ajax({
            type: "GET",
            url: routes.getLastStats,
            dataType: "json",
            success: function(res) {
                $('#stats').html(res.html);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    function getLastTransactions(){
        $.ajax({
            type: "GET",
            url: routes.getLastTransactions,
            dataType: "json",
            success: function(res) {
                $("#last_transaction").html(res.html);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    function checkPaymentStatus() {
        $.ajax({
            type: "get",
            url: routes.checkstatusdeposit,
            dataType: "json",
            success: function (res) {
                console.log(res.status)
                console.log(res.transaction_id)
            }
        });
    }


    // setInterval(function() {
    //     checkPaymentStatus();
    // }, 5000);



});

