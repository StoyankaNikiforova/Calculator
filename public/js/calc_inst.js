$(document).ready(function (){
    $("#submit").click(function(event){
        event.preventDefault();
        let instalments_count = $("input[name=instalments_count]").val();        //
        let credit_amount = $("input[name=credit_amount]").val();
        let annual_interest_rate = $("input[name=annual_interest_rate]").val();
        let maturity_day = $("select[name=maturity_day]").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        let utilisation_date = $("input[name=utilisation_date]").val();
        console.log(instalments_count+"  "+ credit_amount+" "+annual_interest_rate+" "+maturity_day+" "+utilisation_date);
        $.ajax({
            url: "/get_instalments",
            type:"GET",
            data:{
                instalments_count:instalments_count,
                credit_amount:credit_amount,
                annual_interest_rate:annual_interest_rate,
                maturity_day:maturity_day,
                utilisation_date:utilisation_date,
                _token: _token
            },
            success:function(response){
                $('#result').html(response);
                if(response) {
                    $('.success').text(response.success);
                }
            },
            error: function(response) {
                $('#result').empty();
                if (response.status ==422){
                    console.log(response.responseJSON["errors"]["instalments_count"][0]);
                }else {
                }
            }
        });
    });
});

