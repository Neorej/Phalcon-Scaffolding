{% extends 'email_templates/base_template.volt' %}

{% block headerText %}
   <h1>Hi {{ name }}, <h1>
{% endblock %}

{% block text %}
    We received a request to reset the password associated with this e-mail address. This request is valid for {{ config.users.passwordResetCodeValidForMinutes }} minutes.

    Click the button below to create a new password.
{% endblock %}


{% block belowText %}
    <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto">
        <tr>
            <td style="border-radius: 3px; background: #2f2f2f; text-align: center;" class="button-td">
                <a href="{{ url(config.application.basePath ~ 'users/changePassword/' ~ code) }}" style="background: #2f2f2f; border: 15px solid #2f2f2f; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff;">Create new password</span>&nbsp;&nbsp;&nbsp;&nbsp;
                </a>
            </td>
        </tr>
    </table>
{% endblock %}