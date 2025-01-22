@extends('Frontend/layout.app')

@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Member Login</h1>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="social">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    function checkform() {
      if (document.mainform.username.value=='') {
        alert("Please type your username!");
        document.mainform.username.focus();
        return false;
      }
      if (document.mainform.password.value=='') {
        alert("Please type your password!");
        document.mainform.password.focus();
        return false;
      }
      return true;
    }
</script>


<div class="form_wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-12 col-sm-12 col-xs-12">
                @include('Frontend/layout/massage_bootstrap')
                <div class="form-container loginpage">
                    <center><img src="./assets/images/login-icon.png"></center>
                    <form action="{{ route('login_auth') }}" method="post" name="mainform" onsubmit="return checkform()">
                        @csrf
                        <table width="100%" border="0" cellpadding="4" cellspacing="4">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="user">
                                            <input type=text name=username value='' class=inpts size=30
                                                autofocus="autofocus" placeholder="Username">
                                        </span>
                                        @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="password">
                                            <input type=password name=password value='' class="inpts" size=30
                                                placeholder="Password"></span>
                                        @error('password')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center"><input type="submit" value="Login" class="sbmt"></td>
                                </tr>
                                <tr>
                                    <td height="45" align="center" valign="bottom">
                                        <div class="existing_user"><a href="{{ route('forgetpassword')}}">Forgot your  password?</a></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
