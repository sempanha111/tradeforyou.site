@extends('Frontend/layout.app')
@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Contact Us</h1>
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
    <div class="inside_wrap">
        <div class="container">
@include('Frontend/layout/massage_bootstrap')
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info"> Please read our <a href="/faq" target="_blank">Frequently Asked
                            Questions (FAQ)</a> page before creating a ticket. Probably your question has already been
                        answered there!</div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                    <div class="emailblock">
                        <h2>Phone number:</h2>
                        <p>Very Soon</p>
                    </div>


                    <div class="address">
                        <h2>Company Location:</h2>
                        <p>Portlethen, Aberdeen, Scotland, AB12 4UN</p>
                    </div>

                    <div class="emailblock">
                        <h2>E-mail:</h2>
                        <p><a href="mailto:support@trade30minutes.cloud">support@trade30minutes.cloud</a></p>
                    </div>


                </div>




                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                    <div class="form-container-support" style="width:100%;">






                        <h2>Send Us a Message</h2>
                        <div class="form-content">

                            <script language="javascript">
                                function checkform() {
    if (document.mainform.name.value == '') {
      alert("Please type your full name!");
      document.mainform.name.focus();
      return false;
    }
    if (document.mainform.email.value == '') {
      alert("Please enter your e-mail address!");
      document.mainform.email.focus();
      return false;
    }
    if (document.mainform.message.value == '') {
      alert("Please type your message!");
      document.mainform.message.focus();
      return false;
    }
    return true;
  }

                            </script>
                            <form action="{{ route('contact_send')}}" method="post" name="mainform" onsubmit="return checkform()">
                                @csrf
                                <table width="100%" border="0" cellpadding="5" cellspacing="5">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <tr>
                                                            <td width="44%">
                                                                <label> Your Name:</label>
                                                                <input type="text" name="name" value="" size="30"
                                                                    class="inpts">
                                                                @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </td>

                                                            <td width="2%">&nbsp;</td>
                                                            <td width="44%">
                                                                <label>Your Email:</label>
                                                                <input type="text" name="email" value="" size="30"
                                                                    class="inpts">
                                                                    @error('email')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Your Message:</label>
                                                <textarea name="message" class="inpts" cols="45" rows="4"></textarea>
                                                @error('message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>





                                        <tr>
                                            <td height="60" colspan="4" valign="bottom"><input type="submit"
                                                    value="Send" class="sbmt"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection
