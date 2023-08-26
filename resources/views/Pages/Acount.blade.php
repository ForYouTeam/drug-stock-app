@extends('layout.Base')
@section('title')
    Akun
@endsection
@section('logout')
    <a href="{{route('logout')}}"><i class="bi bi-door-closed"></i><b>&nbsp;Logout</b></a>
@endsection
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data @yield('title')</h3>
                <p class="text-subtitle text-muted">Silahkan liat data pada tabel dibawah ini</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">@yield('logout')</li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Tabel @yield('title') <button class="btn btn-primary float-end" onclick="tambahData()">Tambah Data</button>
            </div>
            <div class="card-body">
                <table class="table table-hover" id="tabel-data">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>username</th>
                            <th>Role</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
        </div>
    </section>
      
      <!-- Modal -->
      <div class="modal fade" id="modal-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div>
                <div class="form-group">
                    <input type="hidden" name="id" id="id">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" class="form-control mt-2" placeholder="Input disini">
                    <span class="text-danger" id="alert-name"></span>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" id="id">
                    <label for="">Username</label>
                    <input type="text" name="username" id="username" class="form-control mt-2" placeholder="Input disini">
                    <span class="text-danger" id="alert-name"></span>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" id="id">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" class="form-control mt-2" placeholder="Masukan Password">
                    <span class="text-danger" id="alert-name"></span>
                </div>
                {{-- <div class="form-group">
                    <input type="hidden" name="id" id="id">
                    <label for="">Role</label>
                    <select name="scope" class="form-select" id="scope">
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="super-admin">Super admin</option>
                        <option value="admin">Admin</option>
                    </select>
                    <span class="text-danger" id="alert-name"></span>
                </div> --}}
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="postData()">Save changes</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
@section('script')
    <script>
        const baseUrl = `{{ config('app.url') }}`

        function tambahData(){
            $('#name').val('');
            $('#alert-name').html('');
            $('#modal-data').modal('show')   
        }

        function clearInput() {
            $('#alert-name').html('');
        }

        $(document).on('click', '#btn-del', function() {
            let dataId = $(this).data('id')
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data tidak dapat dipulihkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title            : 'Waiting'         ,
                        text             : "Processing Data!",
                        allowOutsideClick: false             ,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    $.ajax({
                        url: `${baseUrl}/api/v1/user/${dataId}`,
                        type: 'delete',
                        success: function(result) {
                            let data = result.data;
                            setTimeout(() => {
                                Swal.close()
                                getAllData()
                                iziToast.success({
                                    title   : 'Sukses'                ,
                                    message : 'Data berhasil dihapus!',
                                    position: 'bottomRight'
                                });
                            }, 500);
                        },
                        error: function(result) {
                            let data = result.responseJSON
                            Swal.fire({
                                icon     : 'error' ,
                                title    : 'Error' ,
                                text     : data.response.message,
                                position : 'topRight'
                            });
                        }
                    });
                }
            })
        })

        $(document).on('click', '#btn-edit', function() {
            clearInput()
            $('#password').val('')
            $('#password').attr('placeholder', 'Masukan password baru')
            let dataId = $(this).data('id')
            $.get(`${baseUrl}/api/v1/user/${dataId}`, (res) => {
                let data = res.data
                $.each(data, (i,d) => {
                    if (i != "created_at" && i != "updated_at") {
                        $(`#${i}`).val(d)
                    }
                })
                $('#modal-data').modal('show')
            }).fail((err) => {
                iziToast.error({
                    title   : 'Error'                    ,
                    message : 'Server sedang maintenance',
                    position: 'topRight'
                });
            })
        })

        function postData() {
            const data = {
                id       : $('#id'       ).val(),
                name     : $('#name'     ).val(),
                username : $('#username' ).val(),
                password : $('#password' ).val(),
                // scope    : $('#scope'    ).val(),
            }

            $.ajax({
                url        : `${baseUrl}/api/v1/user`,
                method     : "POST"                   ,
                data       : data                     ,
                success: function(res) {
                    $('#modal-data').modal('hide')
                    iziToast.success({
                        title   : 'Sukses'                 ,
                        message : 'Data berhasil diproses!',
                        position: 'bottomRight'
                    });

                    getAllData()
                },
                error: function(err) {
                    if (err.status = 422) {
                        console.log(err);
                        let data = err.responseJSON
                        let errorRes = data.errors;
                        if (errorRes.length >= 1) {
                            $.each(errorRes.data, (i, d) => {
                                $(`#alert-${i}`).html(d)
                            })
                        }
                    } else {
                        iziToast.error({
                            title   : 'Error'                    ,
                            message : 'Server sedang maintenance',
                            position: 'topRight'
                        });
                    }
                },
                dataType   : "json"
            });
        }

        function getAllData() {
            $('#tabel-data').DataTable().destroy()
            $.get(`${baseUrl}/api/v1/user`, (res) => {
                let data = res.data

                $.each(data, (i, d) => {
                if (d.scope !== 'super-admin') {
                    $('#tbody').append(`
                        <tr>
                            <td>${i + 1}</td>
                            <td class="text-capitalize">${d.name}</td>
                            <td class="text-capitalize">${d.username}</td>
                            <td class="text-capitalize">${d.scope}</td>
                            <td>${moment(d.created_at).locale('id').format('DD, MMMM YYYY')}</td>
                            <td>${moment(d.updated_at).locale('id').format('DD, MMMM YYYY')}</td>
                            <td>
                                <button id="btn-edit" data-id="${d.id}" class="btn rounded btn-sm btn-outline-primary mr-1">Edit</button>
                                <button id="btn-del" data-id="${d.id}" class="btn rounded btn-sm btn-outline-danger">Hapus</button>
                            </td>
                        </tr>
                    `);
                }
            });

                $('#tabel-data').DataTable();
            })
            .fail((err) => {
                iziToast.error({
                    title   : 'Error'                    ,
                    message : 'Server sedang maintenance',
                    position: 'topRight'
                });
            })
        }

        $(document).ready(function() 
        {
            getAllData()
        })
    </script>
@endsection