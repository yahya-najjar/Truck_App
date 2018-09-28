@if($flash = session('success'))
    <div class="alert alert-success">
        <h3 class="text-success"><i class="fa fa-check-circle"></i> {{ $flash }}</h3>
    </div>
@elseif($flash = session('error'))
    <div class="alert alert-danger">
        <h3 class="text-danger"><i class="fa fa-close-circle"></i> {{ $flash }}</h3>
    </div>
@elseif(count($errors))
    <div class="alert alert-danger">
        <h3 class="text-danger"><i class="fa fa-close-circle"></i>Please Fix These Errors:</h3>
        <ol>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
@elseif($flash = session('warning'))

    <div class="alert alert-warning">
        <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> {{ $flash }}</h3>
    </div>

@elseif($flash = session('info'))
    <div class="alert alert-info">
        <h3 class="text-info"><i class="fa fa-exclamation-circle"></i> {{ $flash }}</h3>

    </div>
@endif