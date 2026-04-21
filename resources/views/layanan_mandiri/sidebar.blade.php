<div class="profile-side">

    <div class="profile-side-card">

        <div class="profile-side-header text-center">
        <img 
                    src="{{ \App\Helpers\FotoHelper::url(auth()->user()->foto) }}" 
                    alt="Foto Profil" 
                    class="rounded-circle mb-2" 
                    width="100" 
                    height="100"
                    style="object-fit:cover;">

            <div class="profile-side-name">{{ auth()->user()->name }}</div>
            <div class="profile-side-status-wrapper">
                <div class="status-box">
                    <small>Status</small>
                    <strong>{{ auth()->user()->status }}</strong>
                </div>

                <div class="status-box {{ auth()->user()->hasVerifiedEmail() ? 'verified' : 'unverified' }}">
                    <small>Verified</small>
                    <div class="status-icon">
                        @if(auth()->user()->hasVerifiedEmail())
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-times"></i>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>

        <div class="profile-side-menu">
            <a href="{{ route('layanan_mandiri.edit_profil') }}" class="profile-side-item ">
                <i class="fas fa-user"></i>
                <span>Edit Profil</span>
            </a>

            <a href="{{ route('edit_data') }}" class="profile-side-item">
                <i class="fas fa-edit"></i>
                <span>Edit Biodata</span>
            </a>

            {{-- <a href="" class="profile-side-item">
                <i class="fas fa-envelope"></i>
                <span>Change Email</span>
            </a> --}}

            <a href="{{ route('reset_password') }}" class="profile-side-item">
                <i class="fas fa-lock"></i>
                <span>Ganti Password</span>
            </a>
        </div>

    </div>

</div>
