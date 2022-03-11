<!DOCTYPE html>
<html>
<head>
    <title>Credit calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src={{URL::asset('js/calc_inst.js')}}></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<div class="row">

    <div class="mt-5 col-md-8 offset-md-2">
        <h1 class="card-header text-center mt-6">
           Calculate credit installments
        </h1>
        @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                    @if($errors->has("instalments_count"))
                        {{$errors->first("instalments_count")}}
                    @endif
{{--                    @foreach ($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form name="calculate-credit-installments" id="calculate-credit-installments" method="get" >
                @csrf

                <div class="form-group">
                    <label for="instalments_count">Number of installments (between 3-24)</label>
                    <input type="number" id="instalments_count" name="instalments_count" class="form-control @error('title') is-invalid @enderror" min="3" max="24" required>
                </div>
                @error('instalments_count')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="credit_amount">Credit amount (between 500-5000)</label>
                    <input type="number" id="credit_amount" name="credit_amount" class="form-control" min="500" max="5000" required>
                </div>
                <div class="form-group">
                    <label for="annual_interest_rate">Annual interest rate %</label>
                    <input type="number" id="annual_interest_rate" name="annual_interest_rate" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="maturity_day ">Maturity date </label>
                    <select id="maturity_day" name="maturity_day" class="form-control" required>>
                        <option id="10">10</option>
                        <option id="20">20</option>
                        <option id="EOM">EOM</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="utilisation_date ">Utilisation date</label>
                    <input type="date" id="utilisation_date" name="utilisation_date" class="form-control" required>
                </div>

                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div id="result">

        </div>
    </div>
</div>
</body>
</html>
