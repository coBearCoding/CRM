@extends('welcome')

@section('content_form')
    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
            <div class="app-logo">
                <img class="img-fluid" src="{{asset('images/logo_inicial.png')}}" alt="">
            </div>
            <h4 class="mb-0">
                <span class="d-block">Bienvenido,</span>
                <span>Porfavor ingrese su email registrado para resetear la contraseña.</span></h4>
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
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group"><label for="exampleEmail" class="">Email</label>
                                <input name="email" id="exampleEmail" value="{{ old('email') }}"
                                       placeholder="Ingrese su email..." type="email"
                                       class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="divider row"></div>
                    <div class="d-flex align-items-center">
                        <div class="ml-auto"><a href="{{ route('login') }}" class="btn-lg btn btn-link">Regresar
                                Login</a>
                            <button class="btn btn-primary btn-lg">Enviar Email</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
