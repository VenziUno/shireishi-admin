@include ('common.header')
<div id="wrapper">
    @include ('common.side-menu')
    <script type="text/javascript">
        var CKoptions = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
            allowedContent: true
        };
    </script>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            @include ('common.top-body')
            @if ($message = Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            {!! $content !!}
        </div>
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Jovasoftware 2021</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(e) {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            orientation: 'bottom'
        });
    });

    function showError(data) {
        console.log(data);
        $('.invalid-feedback').remove();
        $.each(data, function(idx, item) {
            $('#' + idx).addClass('is-invalid');
            $('#' + idx).parent().append('<div class="invalid-feedback">' + item + '</div>')
        })
    }
</script>
@include ('common.footer')
