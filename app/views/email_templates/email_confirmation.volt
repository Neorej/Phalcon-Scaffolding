{% extends 'email_templates/base_template.volt' %}

{% block headerText %}
   <h1>Hi {{ name }}, <h1>
{% endblock %}

{% block text %}
     We need to confirm your email address to activate your {{ config.website.name }} account.
     <br>
     Simply click the following button to confirm:
{% endblock %}


{% block belowText %}
    <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto">
        <tr>
            <td style="border-radius: 3px; background: #2f2f2f; text-align: center;" class="button-td">
                <a href="{{ url(config.application.basePath ~ 'users/confirmEmail/' ~ code) }}" style="background: #2f2f2f; border: 15px solid #2f2f2f; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff;">Activate my account</span>&nbsp;&nbsp;&nbsp;&nbsp;
                </a>
            </td>
        </tr>
    </table>
{% endblock %}