<div>
    <x-action-bar>
        <x-action-bar-filter>
            <h1 class="h3 mb-4 mb-0 text-gray-800">{{ __('lang.' . Helper::changeRouteName()['name']) }}</h1>
            <form id="formFilter">
                <div class="input-group mb-3 w-25">
                    <div class="input-group-prepend">
                        <x-search-icon />
                    </div>
                    <input type="text" onkeyup="searchData()" class="form-control" name="search"
                        placeholder="Cari Nama Game">
                    <div class="col-5">
                        <select onchange="searchData()" name="status" id="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Not Active</option>
                        </select>
                    </div>
                </div>
            </form>
        </x-action-bar-filter>

        <x-action-bar-action-button>
            <div class="row"  style="margin-top:2.5rem;">
                <div class="col-md-3">
                    <x-button-add href="{{ route('game_add') }}" />
                </div>
            </div>
        </x-action-bar-action-button>
    </x-action-bar>
    <div id="data">

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        searchData();
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getData(page);
        })
    });

    function getData(page) {
        let formData = $('#formFilter').serialize();

        $.ajax({
            url: `game/data/?page=` + page,
            method: 'GET',
            data: formData,
            success: function(data) {
                $('#data').html(data)
            },
            error: function(error) {
                toastr['error']('Something Error');
            }
        })
    }

    function searchData() {
        let formData = $('#formFilter').serialize();

        $.ajax({
            url: `game/data`,
            method: 'GET',
            data: formData,
            success: function(data) {
                $('#data').html(data)
            },
            error: function(error) {
                toastr['error']('Something Error');
            }
        })
    }

    function changeStatus(id, type) {
        if(type == 1){
            var message = "Apakah anda yakin untuk menonaktifkan(arsip) data ini?"
        }
        else{
            var message = "Apakah anda yakin untuk mengaktifkan data ini?"
        }
        swal({
                title: message,
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: `/game/status/${id}/${type}`,
                        method: 'PATCH',
                        data: {
                            _token: CSRF_TOKEN
                        },
                        success: function(res, data) {
                            if(res.status = true){
                                swal("Sukses", "Success", "success");
                                searchData();
                            }else{
                                toastr['error'](res.error);
                            }
                        },
                        error: function(error) {
                            toastr['error']('Something Error');
                        }
                    })
                } else {
                    swal("Batal.");
                }
            });
    }

    function deleteData(id) {
        swal({
                title: "Apakah Anda Yakin ingin menghapus data ini ?",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: `/game/delete/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: CSRF_TOKEN
                        },
                        success: function(res, data) {
                            if(res.status = true){
                                swal("Sukses", "Berhasil dihapus!", "success");
                                let formData = $('#formFilter').serialize();
                                let language = $('#language').find(':selected').val();
                                $.ajax({
                                    url: `game/data`,
                                    method: 'GET',
                                    data: formData,
                                    success: function(data) {
                                        $('#data').html(data)
                                    },
                                    error: function(error) {
                                        toastr['error']('Something Error');
                                    }
                                })
                            }else{
                                toastr['error'](res.error);
                            }
                        },
                        error: function(error) {
                            toastr['error']('Something Error');
                        }
                    })
                } else {
                    swal("Batal Dihapus");
                }
            });
    }

</script>
