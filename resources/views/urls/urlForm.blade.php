@if (session('success'))
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
@endif
@if (session('warning'))
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="alert alert-danger" role="alert">
                {{ session('warning') }}
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
@endif
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="form-group">
            <input type="text" class="form-control" name="url" id="url" value="{{ $url->url ?? old('url') }}"  placeholder="Digite a url desejada">
            
            @if ($errors->has('url')) 
                <span style="display: inline; color:red">  
                    {{ $errors->first('url') }} 
                </span>
            @endif
        </div>
    </div>
</div>