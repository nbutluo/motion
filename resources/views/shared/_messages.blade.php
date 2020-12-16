@foreach (['danger', 'warning', 'success', 'info'] as $msg)
@if(session()->has($msg))
<div class="flash-message">
    <div class="alert alert-{{ $msg }} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ session()->get($msg) }}</h4>
    </div>
</div>
@endif
@endforeach
