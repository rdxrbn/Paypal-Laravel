<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel-Paypal</title>
    </head>
    <body>
    <form action="{{route('createPayment')}}">
        <input type="text" name="price">
        <button type="submit">Pay Now</button>
    </form>


    </body>
</html>
