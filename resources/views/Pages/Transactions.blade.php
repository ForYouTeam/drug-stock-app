@extends('layout.Base')
@section('title')
    Transaksi
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
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
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
                            <th style="width: 5%">No</th>
                            <th>Name</th>
                            <th>Total In</th>
                            <th>Total Out</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
        </div>
    </section>
      
      <!-- Modal -->
      <div class="modal fade" id="modal-data" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row mx-2 mt-3">
                <div class="col-lg-12">
                    <h4>Detail Transaksi Obat Masuk / Keluar</h4>
                </div>
                <div class="col-lg-12 pt-3">
                    <div class="form-group">
                        <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                        <select id="jenis_transaksi" class="form-select">
                            <option value="" selected disabled>-- Pilih Jenis Transaksi --</option>
                            <option value="in">Masuk</option>
                            <option value="out">Keluar</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="receiver_id" class="form-label">Pengirim/Penerima</label>
                        <span class="small text-muted">Field ini menunjukan penerima obat jika transaksi keluar atau pengirim obat jika jenis transaksi masuk</span>
                        <select id="receiver_id" class="form-select">
                            <option value="" selected disabled>-- Pilih Pengirim/Penerima --</option>
                            @foreach ($data['receiver'] as $item)
                                <option value="{{$item['id']}}">{{$item['nama']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5>Formulir</h5>
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-primary" id="tambah-detail" disabled>Tambah Detail</button>
                            <button type="button" class="btn btn-outline-danger" id="reset-detail">Reset</button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="drug_id" class="form-label">Nama Obat</label>
                                <select name="drug_id" id="drug_id">
                                </select>
                                <span id="drug-same" class="text-danger mt-2 small"></span>
                            </div>
                            <div class="form-group mt-3">
                                <label for="request_amount" class="form-label">Jumlah Permintaan</label>
                                <input type="number" name="request_amount" id="request_amount" value="0" class="form-control" placeholder="--Input disini--">
                            </div>
                            <div class="form-group mt-3">
                                <label for="receive_amount" class="form-label">Jumlah Diterima / Diberikan</label>
                                <input type="number" name="receive_amount" id="receive_amount" value="0" class="form-control" placeholder="--Input disini--">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <h5>Detail</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 40%">Nama Obat</th>
                                        <th>Jumlah Permintaan</th>
                                        <th>Jumlah Diterima/Diberikan</th>
                                        <th style="width: 10%">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody id="tb-details">
                                    {{-- <tr>
                                        <td>1.</td>
                                        <td>Paracetamol</td>
                                        <td>25</td>
                                        <td>15</td>
                                        <td>
                                            <button class="btn btn-outline-danger">Hapus</button>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetDetailAll()">Close</button>
              <button type="button" class="btn btn-primary" onclick="postData()">Save changes</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#drug_id').select2({
                dropdownParent: $("#modal-data"),
                theme: 'bootstrap-5', // Menggunakan tema Bootstrap 4
                placeholder: 'Pilih obat',
                minimumInputLength: 3, // Set minimum jumlah karakter sebelum pencarian dimulai
                ajax: {
                    url: `{{config('app.url')}}/api/v1/drugsearch`, // Ganti dengan URL pencarian pada server
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    },
                }
            });
        })

        let detailPayloads = []

        const drugInput          = document.getElementById('drug_id'         )
        const requestAmountInput = document.getElementById('request_amount'  )
        const receiveAmountInput = document.getElementById('receive_amount'  )
        const jenisTransaksi     = document.getElementById('jenis_transaksi' )
        const receiverId         = document.getElementById('receiver_id'     )

        function checkIfDrugReady() {
            const find = detailPayloads.find(item => item.drug_id === drugInput.value);
            if (find) {
                $('#drug-same').html('Obat telah ditambahkan')
            } else {
                $('#drug-same').html('')
            }
            return find
        }

        const checkAndLog = () => {

            if (!checkIfDrugReady() && drugInput.value != 0 && requestAmountInput.value != 0 && receiveAmountInput.value && jenisTransaksi.value && receiverId.value) {
                $('#tambah-detail').prop('disabled', false);
            } else {
                $('#tambah-detail').prop('disabled', true);
            }
        }

        drugInput.addEventListener('change', checkAndLog);
        requestAmountInput.addEventListener('input', checkAndLog);
        receiveAmountInput.addEventListener('input', checkAndLog);

        function appendDetailsToTable(data) {
            $('#tb-details').html('')
            $.each(data, (i, d) => {
                $('#tb-details').append(`
                    <tr>
                        <td>${i+1}.</td>
                        <td>${d.drug_name}</td>
                        <td>${d.request_amount}</td>
                        <td>${d.receive_amount}</td>
                        <td>
                            <button data-id="drug-${d.drug_id}" class="btn btn-outline-danger delete-details">Hapus</button>
                        </td>
                    </tr>
                `)
            })
        }

        function addToDetails() {
            const selectedOption = drugInput.options[drugInput.selectedIndex];
            detailPayloads.push({
                'drug_id'        : drugInput .value ,
                'drug_name'      : $('#drug_id').select2('data')[0].text.toUpperCase(),
                'request_amount' : requestAmountInput .value ,
                'receive_amount' : receiveAmountInput .value ,
            })
            
            appendDetailsToTable(detailPayloads)
        }

        function resetDetail() {
            $('#drug_id').val(null).trigger('change')
            requestAmountInput.value = 0
            receiveAmountInput.value = 0
            $('#drug-same').html('')
            $('#tambah-detail').prop('disabled', true);
        }

        function resetDetailAll()
        {
            $('#drug_id').val(null).trigger('change')
            requestAmountInput.value = 0
            receiveAmountInput.value = 0
            $('#drug-same').html('')
            $('#tambah-detail').prop('disabled', true);

            jenisTransaksi.value = ''
            receiverId.value = ''

            $('#tb-details').html('')
            detailPayloads.length = 0
        }

        $(document).on('click', '#tambah-detail', function() {
            addToDetails()
            resetDetail()
        })

        $(document).on('click', '#reset-detail', function() {
            resetDetail()
        })

        $(document).on('click', '.delete-details', function() {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Hapus data dari daftar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let dataId = $(this).data('id').split('-')[1]
                    const foundIndex = detailPayloads.findIndex(item => item.drug_id == dataId);

                    detailPayloads.splice(foundIndex, 1);
                    appendDetailsToTable(detailPayloads)
                    checkIfDrugReady()
                    checkAndLog()
                }
            })
        })



    </script>
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
                        title: 'Waiting',
                        text: "Processing Data!",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    $.ajax({
                        url: `${baseUrl}/api/v1/transaction/${dataId}`,
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
            $.get(`${baseUrl}/api/v1/transaction/${dataId}`, (res) => {
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
                jenis_transaksi: $('#jenis_transaksi').val(),
                receiver_id: $('#receiver_id').val(),
                detail: detailPayloads
            }

            console.log(data);

            $.ajax({
                url        : `${baseUrl}/api/v1/transaction`,
                method     : "POST"                   ,
                data       : data                     ,
                success: function(res) {
                    $('#modal-data').modal('hide')
                    iziToast.success({
                        title   : 'Sukses'                 ,
                        message : 'Data berhasil diproses!',
                        position: 'bottomRight'
                    });

                    console.log(res);
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
            $.get(`${baseUrl}/api/v1/transaction`, (res) => {
                let data = res.data

                $('#tbody').html('')
                $.each(data, (i,d) => {
                    $('#tbody').append(`
                        <tr>
                            <td>${i + 1}</td>
                            <td class="text-capitalize">${d.receiver.nama}</td>
                            <td class="text-capitalize">${d.total_in}</td>
                            <td class="text-capitalize">${d.total_out}</td>
                            <td>${moment(d.created_at).locale('id').format('DD, MMMM YYYY')}</td>
                            <td>${moment(d.updated_at).locale('id').format('DD, MMMM YYYY')}</td>
                            <td>
                                <button id="btn-del" data-id="${d.id}" class="btn rounded btn-sm btn-outline-danger">Hapus</button>
                            </td>
                        </tr>
                    `)
                })

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