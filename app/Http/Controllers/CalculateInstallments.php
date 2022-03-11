<?php

namespace App\Http\Controllers;

use DateTime;
use http\Exception\UnexpectedValueException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CalculateInstallments extends Controller
{

    public function get_installments(Request $request){
        $data = $this->get_valid($request);
        if($data){
            $instalments_count = $request->input('instalments_count');
            $credit_amount = $request->input('credit_amount');
            $annual_interest_rate = $request->input('annual_interest_rate');
            $maturity_day = $request->input('maturity_day');
            $utilisation_date = $request->date('utilisation_date');

            $rows = $this->get_table_rows($instalments_count, $credit_amount,  $annual_interest_rate, $maturity_day, $utilisation_date);
            return view('table', compact('rows'));

        }

    }

    private function get_valid(Request $request)
    {
        $rules = [
            'instalments_count' => 'required|numeric',
            'credit_amount' => 'required|numeric',
            'annual_interest_rate' => 'required|numeric',
            'maturity_day' => 'required',

        ];
        $messages = [
            'instalments_count.required' => 'Number of installments cannot be blank',
            'credit_amount.numeric' => 'credit_amount must be a number',
            'credit_amount .required' => 'Credit amount cannot be blank',
            'annual_interest_rate.numeric' => 'Credit amount must be a number',
            'utilisation_date.required' => 'Please select date'
        ];
        $data = $request->validate($rules, $messages);

        /**
         * TODO
         *
         * @return ???
         */

        return $data;
    }
    private function get_installment_amount($instalments_count, $credit_amount,  $annual_interest_rate){
        $index = $annual_interest_rate/12/100;
        $b_index = 1-(1/pow((1+$index),$instalments_count));
        $ins_amount = $index*$credit_amount/$b_index;
        return $ins_amount;

    }


    private function get_table_rows($instalments_count, $credit_amount,  $annual_interest_rate, $maturity_day, $utilisation_date){
        $rows = array();
        $first_maturity_day = $this->get_first_maturity_date($maturity_day, $utilisation_date);
        $installment = $this->get_installment_amount($instalments_count, $credit_amount,  $annual_interest_rate);
        $rows[] = array(
            'number'=>0,
            'installment'=> round($installment,2),
            'head_amount'=>'',
            'interest_amount'=>'',
            'credit_amount_left'=>round($credit_amount,2),
            'maturity_date'=>$first_maturity_day);

        $maturity_date = $this->get_next_maturity_date($first_maturity_day);
        $interest_per_month = $annual_interest_rate/12;
        $interest_amount = ($credit_amount*$interest_per_month)/100;
        $head_amount = $installment - $interest_amount;
        $head_credit_amount = $credit_amount - $head_amount;

        for($i=1; $i<= $instalments_count; $i++){
            $rows[] =array(
                'number'=>$i,
                'installment'=>round( $installment, 2),
                'head_amount'=>round($head_amount, 2),
                'interest_amount'=>round($interest_amount, 2),
                'credit_amount_left'=>round($head_credit_amount, 2),
                'maturity_date'=>$maturity_date);

            $maturity_date = $this->get_next_maturity_date($maturity_date);
            $interest_amount = ($head_credit_amount*$interest_per_month)/100;
            $head_amount = $installment - $interest_amount;
            $head_credit_amount = $head_credit_amount -$head_amount;
        }
        return $rows;
    }

//    private function get_row($number,  $installment, $annual_interest_rate, $maturity_date, $head_credit_amount, $credit_amount_left){
//        $interest_per_month = $annual_interest_rate/12;
//        $interest_amount = ($head_credit_amount*$interest_per_month)/100;
//        $head_amount = $installment - $interest_amount;
//        $row = array( 'number'=>$number, 'installment'=> $installment, 'head_amount'=>$head_amount,'interest_amount'=>$interest_amount,
//        'credit_amount_left'=>$credit_amount_left, 'maturity_date'=>$maturity_date);
//        return $row;
//
//    }

    private function get_next_maturity_date($current_maturity_date): string
    {
        return date('Y-m-d', strtotime(' +1 month', strtotime($current_maturity_date)));
    }

    private function get_first_maturity_date($maturity_day, $utilisation_date){
        $utilisation_day = date('d',strtotime($utilisation_date));
        $day = 10;
        if($maturity_day!="EOM"){
            $day = $maturity_day;
        }
        $month =  date('m',strtotime($utilisation_date));
        $year = date('Y',strtotime($utilisation_date));
        $maturity_date = new DateTime();

        $maturity_date->setDate($year, $month, $day);

        if( $utilisation_day > $maturity_day ){
            $maturity_date->setDate($year, $month+1, $day);
        }
        if($maturity_day=="EOM"){
           return $maturity_date->format('Y-m-t');
        }else{
            return $maturity_date->format('Y-m-d');
        }
    }


}
