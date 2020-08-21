<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
    /* Modify the background color */ 

          

        .navbar-custom { 

            background-color: lightgreen; 

        } 

        /* Modify brand and text color */ 

          

        .navbar-custom .navbar-brand, 

        .navbar-custom .navbar-text { 

            color: green; 

        } 
    </style>
  </head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-warning fixed-top">
  <a class="navbar-brand" href="#">Moshiur</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/">Home</a>
      </li>
    </ul>
  </div>
</nav>
<br>
<br>
     <div class="container bg-white p-3">
	 <div class="row justify-content-center">
  <div class="col-sm-6">
    <div class="card bg-white rounded shadow-lg mb-5">
      <div class="card-body">
	  
          <?php
          echo form_open(base_url('pay'), 'id="payment-form"');
          ?>
          <?= csrf_field() ?>
          <h2 class="text-info" align="center">Payment</h2>
          <?= view('_message_block') ?>
          <div class="form-group">
    <label for="firstName">Firstname</label>
    <input type="text" class="form-control <?php if (session('errors.firstName')) : ?>is-invalid<?php endif ?>" id="exampleInputAmount1" aria-describedby="FirstnameHelp" placeholder="Enter Firstname" name="firstName" value="<?= old('firstName') ?>" required>
  </div>
  
  <div class="form-group">
    <label for="lastName">Lastname</label>
    <input type="text" class="form-control <?php if (session('errors.lastName')) : ?>is-invalid<?php endif ?>" id="exampleInputAmount1" aria-describedby="lastNameHelp" placeholder="Enter Lastname" value="<?= old('lastName') ?>" name="lastName" required>
  </div>
  
  <div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" class="form-control <?php if (session('errors.shippingPhone')) : ?>is-invalid<?php endif ?>" id="exampleInputAmount1" aria-describedby="phoneHelp" placeholder="Enter Phone" name="shippingPhone" value="<?= old('shippingPhone') ?>" required>
  </div>
  
  <div class="form-group">
    <label for="address">Address</label>
    <input type="text" class="form-control <?php if (session('errors.shippingAddress1')) : ?>is-invalid<?php endif ?>" id="exampleInputAmount1" aria-describedby="addressHelp" placeholder="Enter Address" name="shippingAddress1" value="<?= old('shippingAddress1') ?>" required>
  </div>
  
  <div class="form-group">
    <label for="City">City</label>
    <input type="text" class="form-control <?php if (session('errors.shippingCity')) : ?>is-invalid<?php endif ?>" id="exampleInputAmount1" aria-describedby="CityHelp" placeholder="Enter City" name="shippingCity" value="<?= old('shippingCity') ?>" required>
  </div>
  
  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" id="exampleInputAmount1" aria-describedby="emailHelp" placeholder="Enter Email" name="email" value="<?= old('email') ?>" required>
  </div>
  
          <div class="form-group">
    <label for="amount">Amount</label>
    <input type="text" class="form-control <?php if (session('errors.amount')) : ?>is-invalid<?php endif ?>" id="exampleInputAmount1" aria-describedby="emailHelp" placeholder="Enter Amount" name="amount" value="<?= old('amount') ?>" required>
  </div>
        <label for="card-element">
        Credit or debit card
        </label>
        <div id="card-element">
        <!-- A Stripe Element will be inserted here. -->
        </div>
 
        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
  <button type="submit" class="btn btn-primary">Pay</button>
  <?php echo form_close(); ?>
<script>
// Create a Stripe client.
var stripe = Stripe('<?= $config->publishableKey ?>');
 
// Create an instance of Elements.
var elements = stripe.elements();
 
// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};
 
// Create an instance of the card Element.
var card = elements.create('card', {style: style});
 
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
 
// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});
 
// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();
 
    stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
        }
    });
});
 
// Submit the form with the token ID.
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
 
    // Submit the form
    form.submit();
}
</script>
 
</div>
    </div>
  </div>
  </div>
       </div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>