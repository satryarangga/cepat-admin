<div>
    Hi {{$customer->first_name}} {{$customer->last_name}},
    <p>We have received your request to reset you password</p>
    <p>Please click the link below to reset your password. The link will valid for 2 hours.</p>
    <p><a href="{{config('cepat.front_end_host')}}/reset-password?token={{$token}}">Reset Password</a></p>
</div>