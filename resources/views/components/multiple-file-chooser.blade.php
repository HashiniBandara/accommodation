<link rel="stylesheet" href="{{asset('assets/components/multiple_file_chooser/style.css')}}">
<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label {{$required ? 'required': ''}}">{{$label}}</label>
    <div class="col-sm-9">
        <div id="{{$fieldName}}-display-area">
            @foreach($filePaths as $filePath)
                <div class="file-display-box">
                    <input type="hidden" name="{{$fieldName}}[]" value="{{ $filePath }}">
                    <img src="{!!$filePath!!}">
                    <span onclick="removeFileDisplayBox(this)">x</span>
                </div>
            @endforeach
        </div>
        <div class="dropzone dropzone-default dropzone-primary @if($errors) is-invalid border-danger @endif" id="{{$fieldName}}-dropzone">
            <div class="dropzone-msg dz-message needsclick">
                <h3 class="dropzone-msg-title mb-3">{{$placeholderTitle}}</h3>
                @if($acceptHint)<p>Allowed File Types: {{$acceptHint}}</p>@endif
                <p>Maximum file size allowed: {{$maxFileSize}}</p>
                @if($placeholderText)<p>{{$placeholderText}}</p>@endif
            </div>
        </div>
        @if($errors)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors }}</strong>
            </span>
        @endif
    </div>
</div>
<script src="{{asset('assets/components/multiple_file_chooser/script.js')}}"></script>
<script>
    $(document).ready(function (){
        init_multi_dropzone('{{$fieldName}}', '{{$maxFileSize}}', '{{$uploadPath}}', {{$maximumFileCount ?:'null'}}, '{{$accept}}');
    });
</script>
