<!-- payir-form.blade.php -->
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Payment Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <form method="post">
      @csrf
      @if(session('alert'))
      <p class="alert alert-{{ session('alert') }}">
        {{ session('message') }}
      </p>
      @endif
      <div class="row">
        <div class="col-lg-12">
          <h1>Payment Form</h1>
          <br>
          <div class="form-group">
            <label for="txt-amount">Amount: </label>
            <input type="text" id="txt-amount" class="form-control" name="amount">
          </div>
          <button class="btn btn-primary">Pay</button>
        </div>
      </div>
    </form>
  </div>
</body>

</html>