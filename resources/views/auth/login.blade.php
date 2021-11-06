@extends('welcome')

@section('content_form')
    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
            <div class="app-logo">
                <img class="img-fluid" src="{{asset('images/logo_inicial.png')}}" alt="">
            </div>
            <br>
            <h4 class="mb-0">
                <span class="d-block">Bienvenido,</span>
                <span>Por favor ingrese su usuario y contraseña.</span></h4>
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
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group"><label for="exampleEmail" class="">Usuario o
                                    Email</label>
                                <input name="email" id="exampleEmail" value="{{ old('email') }}"
                                       placeholder="Ingrese su email..."
                                       type="email"
                                       class="form-control" required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group"><label for="examplePassword"
                                                                             class="">Contraseña</label>
                                <input name="password" id="examplePassword" placeholder="Ingrese su contraseña..."
                                       type="password"
                                       class="form-control" required>

                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-check"><input name="remember" id="remember"
                                                                     {{ old('remember') ? 'checked' : '' }} type="checkbox"
                                                                     class="form-check-input"><label for="exampleCheck"
                                                                                                     class="form-check-label">Recórdarme</label>
                    </div>
                    <div class="divider row"></div>
                    <div class="d-flex align-items-center">
                        <div class="ml-auto"><a href="{{ route('password.request') }}" class="btn-lg btn btn-link">Recuperar
                                Contraseña</a>
                            <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
