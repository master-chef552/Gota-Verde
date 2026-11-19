@if(session('exito'))<div class="gv-alert" role="status">{{ session('exito') }}</div>@endif
@if($errors->any())<div class="gv-alert error" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
