<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title> تسجيل دخول</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />

    <link href="{{ asset('dist-assets/css/themes/lite-purple.css') }}" rel="stylesheet" />
</head>

<body dir="rtl">
    <div class="auth-layout-wrap"
        style="background-image: url({{ asset('dist-assets/images/Main_container_bk.svg') }})">


        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4">
                                <img src="{{ asset('dist-assets/images/logo.jpeg') }}" alt="" />

                            </div>
                            <h1 class="mb-3 text-18 font-weight-600">تسجيل الدخول</h1>
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <!-- <label for="email">البريد الالكتروني</label> -->
                                    <input class="form-control form-control-rounded" placeholder="البريد الالكتروني"
                                        id="email" name="email" type="email" />
                                </div>
                                <div class="form-group mt-4">
                                    <!-- <label for="password">كلمة المرور</label> -->
                                    <input class="form-control form-control-rounded" placeholder="كلمة المرور"
                                        id="password" name="password" type="password" />
                                </div>
                                <button class="btn  w-100 mt-2 btn-grad"
                                    style="background-color:rgb(50, 76, 146); color:white">
                                    دخـول
                                </button>
                            </form>

                        </div>
                    </div>
                    {{-- <div
          class="col-md-6 text-center"
          style="
            background-size: cover;
            background-image: url({{asset('dist-assets/images/photo-long-3.jpg')}});

                "
                >
                <div class="pe-3 auth-right">
                    <a class="btn btn-rounded btn-outline-primary btn-outline-email w-100 btn-icon-text" href="signup.html"><i class="i-Mail-with-At-Sign"></i> Sign up with Email</a><a class="btn btn-rounded btn-outline-google w-100 btn-icon-text"><i class="i-Google-Plus"></i> Sign up with Google</a><a class="btn btn-rounded w-100 btn-icon-text btn-outline-facebook"><i class="i-Facebook-2"></i> Sign up with Facebook</a>
                </div>
            </div> --}}
                </div>
            </div>
        </div>
    </div>
</body>
