<footer class="main-footer">

</footer>

@if ($bodyBG = getSettingValue($themeSettingsKey, 'body_background'))
    <style>
        body {
            background-image: url({{ $bodyBG }});
        }
    </style>
@endif

{{-- begin::Custom Scripts --}}
@stack('scripts')
{{-- end::Custom Scripts --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/front/js/html2canvas.min.js') }}"></script>
<script src="{{ asset('assets/front/js/custom-combined.min.js') }}"></script>

<div class="loading-overlay d-none" id="loadingOverlay">
    <i class="fas fa-spinner fa-pulse"></i>
</div>

</body>

</html>
