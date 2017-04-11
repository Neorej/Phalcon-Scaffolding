<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <form action="{{ url('') }}" role="form" method="post" id="contactForm">
        <h2>Contact</h2>

        <div class="form-group">
            {{ form.render('name', ['class': 'form-control input-lg']) }}
        </div>

        <div class="form-group">
            {{ form.render('email', ['class': 'form-control input-lg']) }}
        </div>

        <div class="form-group">
            {{ form.render('phone', ['class': 'form-control input-lg']) }}
        </div>


        <div class="form-group">
            {{ form.render('message', ['class': 'form-control input-lg', 'rows': '8']) }}
        </div>

        {{ form.render('csrf', ['value': security.getToken()]) }}

        <div class="form-group">
            {{ form.render('submit', ['class': 'btn btn-success btn-block btn-lg']) }}
        </div>
    </form>
</div>