{{$account['user_name']}} <br><br>

Đã yêu cầu đặt lại mật khẩu。<br>
Vui lòng truy cập URL sau và đặt lại mật khẩu của bạn.<br>
<br>
<br>
{{ url(route('reset-password')) }}?reset_password_token={{$account['reset_password_token']}}
