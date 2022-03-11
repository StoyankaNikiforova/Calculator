<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-6">Repayment schedule</h1>

        <table class="table" id="projects-table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Installment</th>
                <th scope="col">Head amount</th>
                <th scope="col">Interest amount</th>
                <th scope="col">Credit amount left</th>
                <th scope="col">Maturity date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rows as $row)
                <tr>
                    <th scope="row">{{ $row['number']}}</th>
                    <td>{{ $row['installment']}}</td>
                    <td>{{ $row['head_amount']}}</td>
                    <td>{{ $row['interest_amount']}}</td>
                    <td>{{ $row['credit_amount_left']}}</td>
                    <td>{{ $row['maturity_date']}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>
</body>
</html>
