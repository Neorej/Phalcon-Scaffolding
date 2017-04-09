<form action="{{ url('index/formPost') }}" method="post" id="contactForm">

    <div class="form-group">
        {{ form.label('name') }}
        {{ form.render('name', ['class': 'form-control']) }}
    </div>

    <div class="form-group">
        {{ form.label('emailaddress') }}
        {{ form.render('emailaddress', ['class': 'form-control']) }}
    </div>

    <div class="form-group">
        {{ form.label('phone') }}
        {{ form.render('phone', ['class': 'form-control']) }}
    </div>

    <div class="form-group">
        {{ form.label('message') }}
        {{ form.render('message', ['class': 'form-control', 'rows': '8']) }}
    </div>

    {{ form.render('csrf') }}
    {{ form.render('submit', ['class': 'btn btn-success btn-lg']) }}

</form>