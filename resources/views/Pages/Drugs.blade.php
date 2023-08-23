@extends('layout.Base')
@section('title')
    Obat
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
                            <th>Satuan</th>
                            <th>Keterangan</th>
                            <th>Tgl Dibuat</th>
                            <th>Tgl Update</th>
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
                    <label for="">Nama Obat</label>
                    <input type="text" name="name" id="name" class="form-control mt-2" placeholder="Input disini">
                    <span class="text-danger" id="alert-name"></span>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" id="id">
                    <label for="">Satuan</label>
                    <input type="text" name="unit" id="unit" class="form-control mt-2" placeholder="Input disini">
                    <span class="text-danger" id="alert-unit"></span>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" id="id">
                    <label for="">keterangan</label>
                    <input type="text" name="desc" id="desc" class="form-control mt-2" placeholder="Input disini">
                    <span class="text-danger" id="alert-desc"></span>
                </div>
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
            $('#unit').val('');
            $('#desc').val('');
            $('#alert-name').html('');
            $('#alert-unit').html('');
            $('#alert-desc').html('');
            $('#modal-data').modal('show')   
        }

        function clearInput() {
            $('#alert-name').html('');
            $('#alert-unit').html('');
            $('#alert-desc').html('');
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
                        title: 'Waiting',
                        text: "Processing Data!",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    $.ajax({
                        url: `${baseUrl}/api/v1/drug/${dataId}`,
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
            let dataId = $(this).data('id')
            $.get(`${baseUrl}/api/v1/drug/${dataId}`, (res) => {
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
                id   : $('#id'   ).val(),
                name : $('#name' ).val(),
                unit : $('#unit' ).val(),
                desc : $('#desc' ).val()
            }

            $.ajax({
                url        : `${baseUrl}/api/v1/drug`,
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
            $('#table-data').DataTable().destroy()
            $.get(`${baseUrl}/api/v1/drug`, (res) => {
                let data = res.data

                $('#tbody').html('')
                $.each(data, (i,d) => {
                    $('#tbody').append(`
                        <tr>
                            <td>${i + 1}</td>
                            <td class="text-capitalize">${d.name}</td>
                            <td class="text-capitalize">${d.unit}</td>
                            <td class="text-capitalize">${d.desc}</td>
                            <td>${moment(d.created_at).locale('id').format('DD, MMMM YYYY')}</td>
                            <td>${moment(d.updated_at).locale('id').format('DD, MMMM YYYY')}</td>
                            <td>
                            <button id="btn-edit" data-id="${d.id}" class="btn rounded btn-sm btn-outline-primary mr-1">Edit</button>
                            <button id="btn-del" data-id="${d.id}" class="btn rounded btn-sm btn-outline-danger">Hapus</button>
                            </td>
                        </tr>
                    `)
                })

                $('#tabel-data').DataTable({
                    "language": {
                        "sProcessing": "Sedang memproses...",
                        "sLengthMenu": "Tampilkan _MENU_ entri",
                        "sZeroRecords": "Tidak ditemukan data yang sesuai",
                        "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                        "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                        "sInfoFiltered": "(disaring dari _MAX_ total entri)",
                        "sInfoPostFix": "",
                        "sSearch": "Cari:",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "Pertama",
                            "sPrevious": "Sebelumnya",
                            "sNext": "Selanjutnya",
                            "sLast": "Terakhir"
                        }
                    }
                });
            })
            .fail((err) => {
                console.log(err);
                // iziToast.error({
                //     title   : 'Error'                    ,
                //     message : 'Server sedang maintenance',
                //     position: 'topRight'
                // });
            })
        }

        $(document).ready(function() 
        {
            getAllData()
        })
    </script>
@endsection