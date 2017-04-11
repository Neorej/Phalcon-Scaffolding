<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <form action="{{ url('users/signupPost') }}" role="form" method="post" id="contactForm">
        <h2>Signup</h2>
        <div class="form-group">
            {{ form.render('name', ['class': 'form-control input-lg']) }}
        </div>

        <div class="form-group">
            {{ form.render('email', ['class': 'form-control input-lg']) }}
        </div>

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    {{ form.render('password', ['class': 'form-control input-lg']) }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    {{ form.render('passwordConfirmation', ['class': 'form-control input-lg']) }}
                </div>
            </div>
        </div>

        {{ form.render('csrf', ['value': security.getToken()]) }}

        <div class="form-group">
           {{ form.render('submit', ['class': 'btn btn-success btn-block btn-lg']) }}
        </div>

        <hr>

        <p class="text-center">
            <a href="{{ url('users/signin') }}">Already have an account? Sign in</a>
        </p>
    </form>
</div>