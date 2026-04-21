<div class="sidebar p-3 shadow-sm rounded">
                <h4 class="mb-3">Form Pengajuan</h4>
                <hr>
                <div class="p-2 text-center">
                    <img src="{{ asset('assets/img/ico-log-in.png') }}" style="max-width: 140px;" class="img-responsive img-need-login mb-3">
                    <h6 class="text-muted">Anda perlu login untuk melakukan pengajuan layanan mandiri.</h6>
                    <div class="mt-3">
                        <a href="{{ route('login_user') }}" class="btn btn-primary btn-label rounded-pill">
                            <i class="ri-login-box-line label-icon align-middle rounded-pill fs-16 me-2">
                                 Login Layanan Mandiri
                            
                            </i>
                        </a>
                    </div>
                </div>
                {{-- <form action="{{ route('login_user') }}" method="POST">
                    @csrf

                    @if (session('failed'))
                        <div class="alert alert-danger">
                            {{ session('failed') }}
                        </div>
                    @endif

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <p><a href="/register">Belum punya akun?</a></p>
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form> --}}

</div>
