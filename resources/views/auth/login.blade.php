<!doctype html>
<html
  lang="es"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-dark"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template"
  data-style="dark">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Flex Blog</title>
    <meta name="description" content="" />

    <!-- Favicon
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />-->
    <!-- <link rel="stylesheet" href="/">Favicon de la pagina -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/tabler-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/flag-icons.css')}}">

    <!-- Core CSS -->

    <link rel="stylesheet" href="{{asset('assets/vendor/css/style.css')}}">

    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css">

    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default-dark.css')}}" class="template-customizer-theme-css">

    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/node-waves/node-waves.css')}}">

    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}">
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/form-validation/form-validation.css')}}">

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">

    <!-- Helpers -->
    <script rel="stylesheet" href="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script rel="stylesheet" href="{{asset('assets/vendor/js/template-customizer.js')}}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script rel="stylesheet" href="{{asset('assets/js/config.js')}}"></script>

        <!-- Helpers -->
        <script src="../../assets/vendor/js/helpers.js"></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        <script src="../../assets/vendor/js/template-customizer.js"></script>

        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="../../assets/js/config.js"></script>

  </head>

  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6">
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-6">
                <a href="index.html" class="app-brand-link">
                  <span class="app-brand-text demo text-heading fw-bold">Flex Blog</span>
                </a>
              </div>
              <h4 class="mb-1 text-center">Bienvenido a Flex Blog!👋</h4>
              <p class="mb-6 text-center">Por favor, Inicia Sesión</p>

              <form id="formAuthentication" class="mb-4" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                  <label for="email" class="form-label">Correo electrónico</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Ingresa tu correo electrónico"
                    value="{{ old('email') }}"
                    required autofocus />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">Contraseña</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      required />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                  </div>
                  <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="my-8">
                  <div class="d-flex justify-content-between">
                    <div class="form-check mb-0 ms-2">
                      <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                      <label class="form-check-label" for="remember_me"> Recordar me </label>
                    </div>
                    @if (Route::has('password.request'))
                      <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                      </a>
                    @endif
                  </div>
                </div>

                <div class="mb-6">
                  <button class="btn btn-primary d-grid w-100" type="submit">Iniciar Sesión</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Core JS -->
    <script src="{{asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{asset('assets/js/main.js') }}"></script>
    <script src="{{asset('assets/js/pages-auth.js') }}"></script>
  </body>
</html>
