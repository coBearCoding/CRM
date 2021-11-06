@extends('welcome')

@section('content_form')
    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
            <div class="app-logo">
                <img class="img-fluid" src="{{asset('images/logo-clinic.png')}}" alt="">
            </div>
            <h4 class="mb-0">
                <span class="d-block">Cambio de Contraseña,</span>
                <span>Porfavor ingresa tu usuario y tu nueva contraseña.</span></h4>
            <div class="divider row"></div>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group"><label for="exampleEmail" class="">Usuario o
                                    Email</label>
                                <input name="email" id="exampleEmail" value="{{ old('email') }}"
                                       placeholder="Ingrese su email..."
                                       type="email" class="form-control">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group"><label for="examplePassword"
                                                                             class="">Contraseña</label>
                                <input name="password" id="examplePassword" placeholder="Ingrese su contraseña..."
                                       type="password"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="position-relative form-group"><label for="password-confirm" class="">Confirmar
                                    Contraseña</label>
                                <input name="password_confirmation" id="password-confirm"
                                       placeholder="Ingrese su confirmacion..." type="password" required
                                       autocomplete="new-password"
                                       class="form-control @error('password_confirmation') is-invalid @enderror">

                            </div>
                        </div>
                    </div>
                    <div class="divider row"></div>
                    <div class="d-flex align-items-center">
                        <div class="ml-auto"><a href="{{ route('login') }}" class="btn-lg btn btn-link">Regresar
                                Login</a>
                            <button class="btn btn-primary btn-lg">Registrar Contraseña</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


