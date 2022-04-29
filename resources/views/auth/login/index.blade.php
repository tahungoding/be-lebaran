<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login / Sumedang LRT</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon-16x16.png')}}">
  <link rel="manifest" href="{{ asset('logo/site.webmanifest')}}">
  @if(count($web))
  @foreach ($web as $webs)
      @php 
          $primary_color = $webs->primary_color 
      @endphp
  @endforeach
  @else
    @php 
        $primary_color = "#6777ef";
    @endphp
  @endif
  <style>
    a {
        color: {{$primary_color}};
    }
    .section .section-title::before {
        background-color: {{$primary_color}};
    }

    .card .card-header h4 {
        color: {{$primary_color}};
    }
    body {
      background-color: {{$primary_color}};
    }

    .section {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center
    }
  </style>
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            {{-- <div class="login-brand p-1" style="background-color: #ffffff !important;border-radius: 15px;">
              @foreach($web as $webs)
              <a href="{{ url('/') }}"><img src="{{ Storage::url($webs->logo) }}" alt="logo" width="100"></a>
              @endforeach
            </div> --}}

            <div class="card" style="border-top: 2px solid {{ $primary_color }}; border-radius: 15px;">
              <div class="card-header">
                @foreach($web as $webs)
                <h4 class="text-center">Login - {{ $webs->name }}</h4>
                @endforeach
              </div>

              <div class="card-body">
                <form method="POST" action="{{ route('login.store') }}">
                  @csrf
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="username" class="form-control" name="username" tabindex="1" required
                      autofocus>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <div class="input-group" id="showOrHide">
                      <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"><i class="fa fa-eye-slash"
                            aria-hidden="true"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-block text-white" tabindex="4" style="background-color: {{ $primary_color }};">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            {{-- <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="auth-register.html">Create One</a>
            </div> --}}
           
            <div class="simple-footer">
              Hak Cipta &copy; <span style="text-transform:uppercase">TAHUNGODING</span> 2022
            </div>
           
          </div>
        </div>
      </div>
    </section>
  </div>
  @include('sweetalert::alert')
  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <script>
    $(document).ready(function() {
      $("#showOrHide button").on('click', function(event) {
          event.preventDefault();
          if($("#showOrHide input").attr("type") == "text") {
            $('#showOrHide input').attr('type', 'password');
            $('#showOrHide i').addClass( "fa-eye-slash" );
            $('#showOrHide i').removeClass( "fa-eye" );
          } else if($('#showOrHide input').attr("type") == "password"){
            $('#showOrHide input').attr('type', 'text');
            $('#showOrHide i').removeClass( "fa-eye-slash" );
            $('#showOrHide i').addClass( "fa-eye" );
        }
      });
  });
  </script>
  <!-- Page Specific JS File -->
</body>

</html>