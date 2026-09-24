<div class="org-card">

<a href="{{ route('dosen.show',$d->id) }}">

<img
src="{{ $d->foto
? asset('uploads/'.$d->foto)
: 'https://ui-avatars.com/api/?name='.urlencode($d->nama) }}"
class="org-photo">

</a>

<h6>{{ $d->nama }}</h6>

<span>

{{ Str::limit($d->jabatan,45) }}

</span>

</div>