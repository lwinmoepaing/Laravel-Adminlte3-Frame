@if ($flashMessage = Session::get('success'))
<div class="alert alert-success alert-block text-white">
	<button type="button" class="close text-white" data-dismiss="alert">×</button>
    <strong class="text-white">{{ $flashMessage }}</strong>
</div>
@endif


@if ($flashMessage = Session::get('error'))
<div class="alert alert-danger alert-block text-white">
	<button type="button" class="close text-white" data-dismiss="alert">×</button>
    <strong class="text-white">{{ $flashMessage }}</strong>
</div>
@endif


@if ($flashMessage = Session::get('warning'))
<div class="alert alert-warning alert-block text-white">
	<button type="button" class="close text-white" data-dismiss="alert">×</button>
	<strong class="text-white">{{ $flashMessage }}</strong>
</div>
@endif


@if ($flashMessage = Session::get('info'))
<div class="alert alert-info alert-block text-white">
	<button type="button" class="close text-white" data-dismiss="alert">×</button>
	<strong class="text-white">{{ $flashMessage }}</strong>
</div>
@endif



@if ($errors->any())
<div class="alert alert-danger">
	<button type="button" class="close text-white" data-dismiss="alert">×</button>
	Please check the form below for errors

    @foreach ($errors->all() as $error)
        {{ $error }}<br/>
    @endforeach
</div>
@endif
