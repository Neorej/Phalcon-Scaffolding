<footer id="footer">
    <section id="footerSection">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <h3>{{ faker.words(2, true) }}</h3>
                    <ul>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6">
                    <h3>{{ faker.words(2, true) }}</h3>
                    <ul>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6">
                    <h3>{{ faker.words(2, true) }}</h3>
                    <ul>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                        <li><a href="{{ url() }}">{{ faker.words(3, true) }}</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ url() }}">
                        <img src="images/logo.png" alt="{{ config.website.name }}" id="footerLogo"/>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="col-md-8">
            <p class="copyright">© {{ date('Y') }} <a href="{{ url() }}">{{ config.website.name }}</a></p>
        </div>
        <div class="col-md-4">
            <ul class="social">
                <li>
                    <a href="http://wwww.fb.com/themefisher" class="Facebook">
                        <i class="ion-social-facebook"></i>
                    </a>
                </li>
                <li>
                    <a href="http://wwww.twitter.com/themefisher" class="Twitter">
                        <i class="ion-social-twitter"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="Linkedin">
                        <i class="ion-social-linkedin"></i>
                    </a>
                </li>
                <li>
                    <a href="http://wwww.fb.com/themefisher" class="Google Plus">
                        <i class="ion-social-googleplus"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>