<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <form action="{{ url('users/signinPost') }}" role="form" method="post" id="contactForm">
        <h2>Sign in</h2>
        <div class="form-group">
            {{ form.render('email', ['class': 'form-control input-lg']) }}
        </div>

        <div class="form-group">
            {{ form.render('password', ['class': 'form-control input-lg']) }}
        </div>

        {{ form.render('csrf', ['value': security.getToken()]) }}

        <div class="form-group">5
            {{ form.render('submit', ['class': 'btn btn-success btn-block btn-lg']) }}
        </div>

        <hr>

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6">
                <p class="text-center">
                    <a href="{{ url('users/resetPassword') }}">Forgot password?</a>
                </p>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <p class="text-center">
                    <a href="{{ url('users/signup') }}">Create an account</a>
                </p>
            </div>
        </div>
    </form>
</div>