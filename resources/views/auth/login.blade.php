@extends('layouts.user')
@section('content')
<div class="block-center mt-4 wd-xl pt-5" style="padding-top: 40px; margin-top: 20px;">
    <!-- START card-->
    <div class="card card-flat">
        <div class="card-header text-center bg-dark">
            <a href="#"><img class="block-center rounded" style="max-width: 128px;" src="logo.png" alt="Image" /></a>
        </div>
        <div class="card-body">
            @if( session('msg') )
            <?php 
            $msg = session('msg');
            ?>
            <div class="alert alert-{{ $msg['type'] }}">
                <p>{!! $msg['text'] !!}</p>
            </div>
            @endif
            <p class="text-center py-2">
                <b>Pengelolaan Bawang Goreng Nuri</b><br>
                <b>Desa Taraju, Sindangagung Kuningn</b>
            </p>
            <form method="POST" class="mb-3" id="loginForm" novalidate="novalidate" action="{{ route('login.proses') }}">
                @csrf
                <div class="form-group">
                    <div class="input-group with-focus">
                        <input minlength="4" maxlength="30" class="form-control border-right-0" type="text" placeholder="Masukan username" autocomplete="off" required="required" name="username" value="{{ old('username') }}" />
                        <div class="input-group-append">
                            <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-envelope"></em></span>
                        </div>
                    </div>
                    @if ($errors->has('username'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="input-group with-focus">
                        <input  minlength="4" maxlength="30" class="form-control border-right-0" type="password" name="password" placeholder="Masukan Password" required="required" />
                        <div class="input-group-append">
                            <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-lock"></em></span>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <button class="btn btn-block btn-dark mt-3" type="submit">Login</button>
            </form>
        </div>
        <div class="card-body text-center">
            Belum punya akun ? <a href="{{ route('daftar') }}">Daftar</a>
        </div>
    </div>
    @include("layouts.includes.footer-page")
</div>
@endsection
@section('scripts')
<script src="{{ mix('/js/pages.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    if ($(".alert-remove").length > 0) {
      let delay = $(".alert-remove").data('delay',false);
      $(".alert-remove").delay(delay !== false ? delay : 2000).slideUp(500);
  }
})
</script>
@endsection
