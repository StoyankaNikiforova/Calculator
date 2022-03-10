$(document).ready(function (){
    $("#submit").click(function(event){
        event.preventDefault();
        let instalments_count = $("input[name=instalments_count]").val();        //
        let credit_amount = $("input[name=credit_amount]").val();
        let annual_interest_rate = $("input[name=annual_interest_rate]").val();
        let maturity_date = $("select[name=maturity_date]").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        let utilisation_date = $("input[name=utilisation_date]").val();
        console.log(instalments_count+"  "+ credit_amount+" "+annual_interest_rate+" "+maturity_date+" "+utilisation_date);
        $.ajax({
            url: "/get_instalments",
            type:"GET",
            data:{
                instalments_count:instalments_count,
                credit_amount:credit_amount,
                annual_interest_rate:annual_interest_rate,
                maturity_date:maturity_date,
                utilisation_date:utilisation_date,
                _token: _token
            },
            success:function(response){
                console.log("test");
                if(response) {
                    $('.success').text(response.success);
                    //$("#ajaxform")[0].reset();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});

