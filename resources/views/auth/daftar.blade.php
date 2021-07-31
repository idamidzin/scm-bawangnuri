@extends('layouts.user')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="block-center mt-4 wd-xxl pt-5" style="padding-top: 40px; margin-top: 20px;">
                <div class="card card-flat">
                    <div class="card-header text-center bg-dark">
                        <a href="#"><img class="block-center rounded" style="max-width: 128px;" src="logo.png" alt="Image" /></a>
                    </div>
                    <div class="card-body">
                        @if( session('msg-daftar') )
                        <?php 
                        $msg = session('msg-daftar');
                        ?>
                        <div class="alert alert-{{ $msg['type'] }}">
                            {!! $msg['text'] !!}
                        </div>
                        @endif
                        <p class="text-center py-2">
                            <b>Pendaftaran</b><br>
                        </p>
                        <form method="POST" class="mb-3 wd-xl block-center" id="loginForm" action="{{ route('daftar.proses') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <input class="form-control border-right-0 @error('nama') is-invalid @enderror" type="text" placeholder="Nama Lengkap" autocomplete="off" name="nama" value="{{ old('nama')  }}" onkeypress='return harusHuruf(event)'/>
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-user"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('nama'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('nama') }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <input class="form-control border-right-0 @error('email') is-invalid @enderror" type="text" placeholder="Email" autocomplete="off" name="email" value="{{ old('email') }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-envelope"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('email'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('email') }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <input class="form-control border-right-0 @error('nohp') is-invalid @enderror" type="number" placeholder="Nomor Handphone" autocomplete="off" name="nohp" value="{{ old('nohp')  }}" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-phone-square"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('nohp'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('nohp') }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <select class="form-control border-right-0 @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin">
                                        <option value="">Jenis Kelamin</option>
                                        <option @if(old('jenis_kelamin') == 'L') selected @endif value="L">Laki-laki</option>
                                        <option @if(old('jenis_kelamin') == 'P') selected @endif value="P">Perempuan</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-mars-double"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('jenis_kelamin'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('jenis_kelamin') }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <input class="form-control border-right-0 @error('nama_rekening') is-invalid @enderror" type="text" placeholder="Nama Rekening" autocomplete="off" name="nama_rekening" value="{{ old('nama_rekening')  }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="far fa-credit-card"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('nama_rekening'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('nama_rekening') }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <input class="form-control border-right-0 @error('no_rekening') is-invalid @enderror" type="text" placeholder="Nomor Rekening" autocomplete="off" name="no_rekening" value="{{ old('no_rekening')  }}" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fas fa-keyboard"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('no_rekening'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('no_rekening') }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <select class="form-control border-right-0 @error('role_id') is-invalid @enderror" name="role_id">
                                        <option value="">Posisi</option>
                                        <option @if(old('role_id') == '2') selected @endif value="2">Supplier</option>
                                        <option @if(old('role_id') == '3') selected @endif value="3">Distributor</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-mars-double"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('role_id'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('role_id') }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <input class="form-control border-right-0 @error('ktp') is-invalid @enderror" type="file" id="files" name="ktp" value="{{ old('ktp')  }}" placeholder="Masukan Username" />
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="far fa-address-card"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('ktp'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('ktp') }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <textarea class="form-control border-right-0 @error('alamat') is-invalid @enderror" type="text" name="alamat" placeholder="Masukan Alamat">{{ old('alamat')  }}</textarea>
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fas fa-home"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('alamat'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('alamat') }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <input  class="form-control border-right-0 @error('username') is-invalid @enderror" type="text" name="username" value="{{ old('username')  }}" placeholder="Masukan Username" />
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fas fa-paper-plane"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('username'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('username') }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <input  class="form-control border-right-0 @error('password') is-invalid @enderror" type="password" value="{{ old('password')  }}" name="password" placeholder="Masukan Password" />
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-lock"></em></span>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                <div class="text-help filled" id="parsley-id-19">
                                    <div class="parsley-required">{{ $errors->first('password') }}</div>
                                </div>
                                @endif
                            </div>
                            <button class="btn btn-block btn-dark mt-3" type="submit">Daftar</button>
                        </form>
                    </div>
                    <div class="card-body text-center">
                        Sudah punya akun ? <a href="{{ route('login') }}">Masuk</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            @include("layouts.includes.footer-page")
        </div>
    </div>
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
    });
    function harusHuruf(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 65 || charCode > 90)&&(charCode < 97 || charCode > 122)&&charCode>32)
            return false;
        return true;
    }
</script>
@endsection
