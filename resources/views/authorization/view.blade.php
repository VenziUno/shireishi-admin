<div>
    <form method="POST" id="formAuthorization" class="w-100">
        @csrf
        <x-action-bar>
            <x-action-bar-filter>
                <h1 class="h3 mb-4 mb-0 text-gray-800">{{ __('lang.' . Helper::changeRouteName()['name']) }}</h1>
                @if($errors->any())
                    <div class="alert alert-danger">{{$errors->first()}}</div>
                @endif
                <div class="row">
                    <div class="col-md-3">
                        <select name="admin_group" id="admin_group" onchange="getData()" class="form-control">
                            @foreach ($admin_group as $i)
                                <option value="{{ $i->id }}" @if ($loop->last) selected @endif>{{ $i->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-success" onclick="updateAuthorization()">Update</button>
                    </div>
                    <div class="col-md-1">
                        <div id="loading" style="display: none">
                            <img src="{{ asset('image/ajax-loader.gif') }}"
                                style="margin-top: 12px;margin-left: 15px;">
                        </div>
                    </div>
                    <div class="col-md-2 ml-auto mt-1">
                        <input type="checkbox" name="select-all" id="select-all" /> Tandai Semua
                    </div>
                </div>
            </x-action-bar-filter>

            <x-action-bar-action-button>
            </x-action-bar-action-button>
        </x-action-bar>
        <div id="data">

        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        getData();
    });

    function getData() {
        let role = $('#admin_group').find(':selected').val();

        $.ajax({
            url: `/authorization/data/${role}`,
            method: 'GET',
            success: function(data) {
                $('#data').html(data)
            },
            error: function(error) {
                toastr['error']('Something Error');
            }
        })
    }

    $(document).ajaxStart(function() {
        $('#loading').show();
    }).ajaxStop(function() {
        $('#loading').hide();
    });

    function updateAuthorization() {
        let formData = $('#formAuthorization').serialize();

        $.ajax({
            url: `/authorization`,
            method: 'POST',
            data: formData,
            success: function(data) {
                toastr['success']('Berhasil diupdate');
                getData();
            },
            error: function(error) {
                toastr['error']('Something Error');
            }
        })
    }

    $('#select-all').click(function(event) {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });
</script>
