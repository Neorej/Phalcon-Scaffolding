<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <form action="{{ url('users/resendEmailConfirmationPost') }}" role="form" method="post" id="contactForm">
        <h2>Resend email confirmation</h2>

        <div class="form-group">
            {{ form.render('email', ['class': 'form-control input-lg']) }}
        </div>

        {{ form.render('csrf', ['value': security.getToken()]) }}

        <div class="form-group">
            {{ form.render('submit', ['class': 'btn btn-success btn-block btn-lg']) }}
        </div>

        <hr>

        <p class="text-center">
            <a href="{{ url('users/signin') }}">Already confirmed your email address? Sign in</a>
        </p>
    </form>
</div>