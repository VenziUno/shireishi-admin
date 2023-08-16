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
                        placeholder="Cari Nama Kategori">
                </div>
            </form>
        </x-action-bar-filter>

        <x-action-bar-action-button>
            <div class="row" style="margin-top:2.5rem;">
                <div class="col-md-3">
                    <x-button-add href="{{ route('game-news-category_add') }}" />
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
        let status = $('#status').find(':selected').val();

        $.ajax({
            url: `game-news-category/data?page=` + page,
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
        let status = $('#status').find(':selected').val();

        $.ajax({
            url: `game-news-category/data`,
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

    function deleteData(id) {
        swal({
                title: "Are you sure you want to Delete this?",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: `/game-news-category/delete/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: CSRF_TOKEN
                        },
                        success: function(res, data) {
                            if(res.status = true){
                                swal("Sukses", "Delete Success!", "success");
                                let formData = $('#formFilter').serialize();
                                let status = $('#status').find(':selected').val();
                                $.ajax({
                                    url: `game-news-category/data`,
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
                    swal("Cancel Delete");
                }
            });
    }

</script>
