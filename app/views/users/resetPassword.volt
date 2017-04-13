<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <form action="{{ url('users/resetPasswordPost') }}" role="form" method="post" id="contactForm">
        <h2>Reset password</h2>
        <p>Enter your email address and we will send you a link to reset your password.</p>

        <div class="form-group">
            {{ form.render('email', ['class': 'form-control input-lg']) }}
        </div>

        {{ form.render('csrf', ['value': security.getToken()]) }}

        <div class="form-group">
            {{ form.render('submit', ['class': 'btn btn-success btn-block btn-lg']) }}
        </div>
    </form>
</div>