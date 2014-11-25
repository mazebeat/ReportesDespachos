@extends('layouts.login')

@section('title')
@endsection

@section('file-style')
@endsection

@section('content')
<form class="form-signin" action="#">
    <div class="form-signin-heading text-center">
        {{ HTML::image('images/login-logo.png', 'Intelidata', array()) }}
    </div>
    <div class="login-wrap">
        <input type="text" class="form-control" placeholder="Usuario" autofocus>
        <input type="password" class="form-control" placeholder="Contraseña">
    
        <a href="{{URL::to('admin')}}"  class="btn btn-lg btn-login btn-block"><i class="fa fa-check"></i></a>
        {{--<button type="submit"></button>--}}

        <div class="registration">
            <label class="text-center">
                <a data-toggle="modal" href="#myModal"> Olvidaste tu contraseña?</a>
            </label>
        </div>
    </div>

    <div class="">
    	<a class="" href="http://www.customertrigger.com/" target="_blank"><img src="http://www.intelidata.cl/wp-content/themes/intelidata/images/ct.png"></a>
        <a class="pull-right" href="http://www.intersoft-sa.com/" target="_blank"><img src="http://www.intelidata.cl/wp-content/themes/intelidata/images/is2.png"></a>
    </div>
</form>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Forgot Password ?</h4>
            </div>
            <div class="modal-body">
                <p>Enter your e-mail address below to reset your password.</p>
                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <button class="btn btn-primary" type="button">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
@endsection

@section('file-script')
@endsection
