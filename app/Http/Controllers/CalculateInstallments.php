<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculateInstallments extends Controller
{
    public function get_installments(Request $request){
        $data = $request->validate([
            'instalments_count'=> 'required',
            'credit_amount'=> 'required',
            'annual_interest_rate'=> 'required',
            'maturity_date'=> 'required',
            'utilisation_date'=> 'required',
        ]);
        return $request['credit_amount']."Test from controller";

    }

    public function getData(Request $request){

    }
}
