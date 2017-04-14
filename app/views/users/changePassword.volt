<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <form action="{{ url('users/changePasswordPost') }}" role="form" method="post" id="contactForm">
        <h2>Change your password</h2>

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
    </form>
</div>