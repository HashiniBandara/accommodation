<link rel="stylesheet" href="{{asset('assets/components/single_file_chooser/style.css')}}">
<div class="form-group @if($uitype=="horizontal") row @endif">
    <label for="" class="@if($uitype=="horizontal") col-sm-3 @endif col-form-label {{$required ? 'required': ''}}">{{$label}}</label>
    <div @if($uitype=="horizontal") class="col-sm-9" @endif>
        <div class="display-area"
            @if($type=='image')
            data-type="img"
            @endif
            @if($type=='video')
            data-type="vid"
            @endif
            id="{{ $fieldName }}-display-area">
            @if($filePath)
                <div class="file-display-single
                @if(isSmallImage($filePath)) small @endif
                @if($type=='image') img @endif
                @if($type=='video') vid @endif
            ">
                    <input type="hidden" name="{{$fieldName}}" value="{{ $filePath }}">
                    @if($type=='image')
                        <img src="{!!$filePath!!}">
                    @elseif($type=='video')
                        <video controls>
                            <source src="{{$filePath}}">
                        </video>
                    @endif
                    <span onclick="removeFileDisplaySingle(this, '{{ $fieldName }}-dropzone')">x</span>
                </div>
            @endif
        </div>
        <div @if($filePath) style="display: none"  @endif class="dropzone dropzone-default dropzone-primary @if($errors) is-invalid border-danger @endif" id="{{ $fieldName }}-dropzone">
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
<script src="{{asset('assets/components/single_file_chooser/script.js')}}"></script>
<script>
    $(document).ready(function (){
        init_single_dropzone('{{ $fieldName }}', '{{$maxFileSize}}', '{{$uploadPath}}', '{{$accept}}');
    });
</script>
