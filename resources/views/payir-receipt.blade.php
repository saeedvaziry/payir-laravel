<!-- payir-receipt.blade.php -->
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Payment Receipt</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1>{{ $message }}</h1>
        <br>
        @if(isset($transaction) && $transaction->status)
          <p>
            <b>Transaction ID: </b> {{ $transaction->transaction_id }}
          </p>
          <p>
            <b>Amount: </b> {{ $transaction->amount }} IRR
          </p>
          <p>
            <b>Card Number: </b> {{ $transaction->card_number }}
          </p>
        @endif
      </div>
    </div>
  </div>
</body>

</html>