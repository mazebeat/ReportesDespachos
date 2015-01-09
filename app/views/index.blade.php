@extends('layouts.login')

@section('title')
@endsection

@section('file-style')
    Inicio de Sesión
@endsection

@section('content')
    <div ng-controller="homeController">
        @if(isset($message) && count($message))
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                @foreach($message as $key => $message)
                    {{ $message }}
                @endforeach
            </div>
        @endif
        {{--<form class="form-signin" name="loginForm">--}}
        {{ Form::open(array('url' => '/','role' => 'form', 'class' => 'form-signin', 'name' => 'loginForm'))}}
        <div class="form-signin-heading text-center">
            {{ HTML::image('images/login-logo.png', 'Intelidata', array()) }}
        </div>
        <div class="login-wrap">
            <input type="text" name="usuario" id="usuario" ng-model="user.usuario"
                   class="form-control ng-dirty ng-invalid" placeholder="Usuario" required>
            <small class="help-block " style="color: #000000;">{{ \Str::upper($errors->first('usuario')) }}</small>
            <input type="password" name="contraseña" id="contraseña" ng-model="user.contraseña"
                   class="form-control ng-dirty ng-invalid" placeholder="Contraseña" required>
            <small class="help-block "
                   style="color: #000000;">{{ \Str::upper($errors->first('contraseña')) }}</small>
            <button type="submit" ng-disabled="loginForm.$invalid" id="loginFormButton"
                    class="btn btn-login btn-block ladda-button" data-style="zoom-in">
                <i class="fa fa-check"></i>
            </button>
            <div class="registration">
                <label class="text-center">
                    <a data-toggle="modal" href="#forgotPasswordModal">Olvidaste tu contraseña?</a>
                </label>
            </div>
        </div>

        <div>
            <a class="" href="http://www.customertrigger.com/" target="_blank">
                <img src="http://www.intelidata.cl/wp-content/themes/intelidata/images/ct.png">
            </a>
            <a class="pull-right" href="http://www.intersoft-sa.com/" target="_blank">
                <img src="http://www.intelidata.cl/wp-content/themes/intelidata/images/is2.png">
            </a>
        </div>
        {{ Form::close() }}

        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="forgotPasswordModal" role="dialog" tabindex="-1"
             id="forgotPasswordModal"
             class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">3.0
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Olvido su contraseña?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Ingrese su dirección de correo para realizar la solicitud.</p>
                        {{ Form::email('email', Input::old('usuario'), array('class' => 'form-control placeholder-no-fix', 'placeholder' => 'Correo', 'autofocus', 'autocomplete' => 'off')) }}
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-primary" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
    </div>
@endsection

@section('file-script')
@endsection

@section('text-script')
    <script>
        var loginButton = Ladda.create(document.querySelector('#loginFormButton'));
        Ladda.bind('.ladda-button');
    </script>
@endsection
