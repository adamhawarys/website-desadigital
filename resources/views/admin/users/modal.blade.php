<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" >
<!-- Vertically centered scrollable modal -->
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Users ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">

        <div class="row">
            <div class="col-6">
                Nama
            </div>
            <div class="col-6">
                : {{ $item->name }}
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                Email
            </div>
            <div class="col-6">
                : {{ $item->email }}
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                Role
            </div>
            <div class="col-6">
                : 
                @if ($item->role == 'Admin')
                  <span class="badge badge-danger">
                    {{ $item->role }}
                  </span>

                  @elseif($item->role == 'Petugas')
                  <span class="badge badge-info">
                    {{ $item->role }}
                  </span>

                  @elseif($item->role == 'Warga')
                  <span class="badge badge-success">
                    {{ $item->role }}
                  </span>
                @endif
            </div>
        </div>
        
        <div class="row">
            <div class="col-6">
                Status
            </div>
            <div class="col-6">
                : @if ($item->status == 'Verify')
                  <span class="badge badge-warning">
                    {{ $item->status }}
                  </span>

                  @elseif($item->status == 'Active')
                  <span class="badge badge-success">
                    {{ $item->status }}
                  </span>

                  @elseif($item->status == 'Banned')
                  <span class="badge badge-danger">
                    {{ $item->status }}
                  </span>
                @endif
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i>
            Tutup</button>

          <form action="{{route('users.destroy', $item->id)}}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm">
            <i class="fas fa-times"></i>
            Hapus</button>
            </form>
      </div>
    </div>
  </div>
</div>