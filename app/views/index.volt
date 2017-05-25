<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <base href="{{ url() }}" />

        <title>Phalcon PHP Framework</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <link rel="stylesheet" href="css/main.css?t={{ time() }}">

        <link rel="stylesheet" href="css/responsive.css">
    </head>
    <body>
        {{ partial('partials/header') }}

        <div class="container">
            {{ content() }}
        </div>

        {{ partial('partials/footer') }}

        {% if flashSession.has() %}
            {{ flashSession.output() }}
        {% endif %}

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
