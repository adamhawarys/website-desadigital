<div class="sidebar p-0">
  <div class="list-group">

    <a href="{{ route('organisasi') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('organisasi') ? 'active' : '' }}">
      Struktur Organisasi
    </a>

    @foreach ($organisasi as $item)
      <a href="{{ route('organisasi.detail', $item->id) }}"
         class="list-group-item list-group-item-action {{ (request()->routeIs('organisasi.detail') && request()->route('id') == $item->id) ? 'active' : '' }}">
        {{ ucwords(strtolower($item->jabatan)) }}
      </a>
    @endforeach

  </div>
</div>
