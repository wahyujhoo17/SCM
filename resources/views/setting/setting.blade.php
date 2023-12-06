<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>Profile settings - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            margin-top: 20px;
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
        }

        .main-body {
            padding: 15px;
        }

        .nav-link {
            color: #4a5568;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }
    </style>
</head>

<body>
    <div class="container">

        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Settings</li>
            </ol>
        </nav>

        <div class="row gutters-sm">
            <div class="col-md-4 d-none d-md-block">
                <div class="card">
                    <div class="card-body">
                        <nav class="nav flex-column nav-pills nav-gap-y-1">
                            <a href="#profile" data-toggle="tab"
                                class="nav-item nav-link has-icon nav-link-faded active">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>Profile Information
                            </a>

                            <a href="#security" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield mr-2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>Security
                            </a>
                            <a href="#notification" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell mr-2">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>Notification
                            </a>
                            <a href="#billing" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-credit-card mr-2">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2">
                                    </rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>Pembayaran
                            </a>
                            <a href="#account" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-settings mr-2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path
                                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                    </path>
                                </svg>EOQ & Safety Stok
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header border-bottom mb-3 d-flex d-md-none">
                        <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                            <li class="nav-item">
                                <a href="#profile" data-toggle="tab" class="nav-link has-icon active"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg></a>
                            </li>
                            <li class="nav-item">
                                <a href="#account" data-toggle="tab" class="nav-link has-icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-settings">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path
                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                        </path>
                                    </svg></a>
                            </li>
                            <li class="nav-item">
                                <a href="#security" data-toggle="tab" class="nav-link has-icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-shield">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    </svg></a>
                            </li>
                            <li class="nav-item">
                                <a href="#notification" data-toggle="tab" class="nav-link has-icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                    </svg></a>
                            </li>
                            <li class="nav-item">
                                <a href="#billing" data-toggle="tab" class="nav-link has-icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-credit-card">
                                        <rect x="1" y="4" width="22" height="16" rx="2"
                                            ry="2"></rect>
                                        <line x1="1" y1="10" x2="23" y2="10"></line>
                                    </svg></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane active" id="profile">
                            <h6>INFORMASI PROFIL ANDA</h6>
                            <hr>
                            <form method="POST" action="/setting">
                                @csrf
                                <div class="form-group">
                                    <label for="fullName">Nama</label>
                                    <input type="text" class="form-control" id="fullName"
                                        aria-describedby="fullNameHelp" placeholder="Enter your fullname"
                                        name="nama" value="{{ $user->nama }}">
                                </div>
                                <div class="form-group">
                                    <label for="bio">Alamat</label>
                                    <textarea class="form-control autosize" name="alamat" id="bio" placeholder="Write something about you"
                                        style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 62px;">{{ $user->alamat }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail4">Email</label>
                                    <input type="email" class="form-control" name="email" id="inputEmail4"
                                        value="{{ $user->email }}" />
                                </div>

                                <div class="form-group">
                                    <label for="phoneNumber">Telepon</label>
                                    <input type="tel" class="form-control" id="phoneNumber" name="no_tlp"
                                        value="{{ $user->no_tlp }}" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                <button type="reset" class="btn btn-light">Reset Changes</button>
                            </form>

                        </div>
                        {{-- EOQ --}}
                        <div class="tab-pane" id="account">
                            <h6>EOQ</h6>
                            <hr>
                            <form method="POST" action="/setting/EOQ">
                                @csrf
                                <div class="form-group">
                                    <label for="dateRange">Select Date Range:</label>
                                    <select id="dateRange" onchange="handleDateRangeChange()" class="form-control">
                                        <option value="">Custom</option>
                                        <option value="3months">3 bulan terakhir</option>
                                        <option value="6months">6 bulan terakhir</option>
                                        <option value="lastYear">Tahun lalu</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="startDate">Start Date:</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate"
                                        value="{{ $eoq->tanggal_awal }}">
                                </div>

                                <div class="form-group">
                                    <label for="endDate">End Date:</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate"
                                        value="{{ $eoq->tanggal_akhir }}">
                                </div>

                                <button type="reset" class="btn btn-light">Reset Changes</button>
                                <button class="btn btn-primary" type="sublit">Ubah</button>
                            </form><br>

                            <hr>
                            <hr>

                            <br>
                            <h6>Safety Stok</h6>
                            <hr>
                            <form method="POST" action="/setting/SS">
                                @csrf
                                <div class="form-group">
                                    <label for="leadTime">Lead Time:</label>
                                    <select class="form-control" id="leadTime" name="leadTime">
                                        <option value="1">1 Hari</option>
                                        <option value="2">2 Hari</option>
                                        <option value="3">3 Hari</option>
                                        <option value="4">4 Hari</option>
                                        <option value="5">5 Hari</option>
                                        <option value="6">6 Hari</option>
                                        <option value="7">7 Hari</option>
                                        <option value="8">8 Hari</option>
                                        <option value="9">9 Hari</option>
                                        <option value="10">10 Hari</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="confidenceLevel">Tingkat Kepercayaan (Z-Score):</label>
                                    <select class="form-control" id="confidenceLevel" name="confidenceLevel">
                                        <option value="1.64">90%</option>
                                        <option value="1.96">95%</option>
                                        <option value="2.57">99%</option>
                                        <!-- Tambahkan opsi tingkat kepercayaan sesuai kebutuhan -->
                                    </select>
                                </div>

                                <button type="reset" class="btn btn-light">Reset Changes</button>
                                <button class="btn btn-primary" type="sublit" onclick="">Ubah</button>
                            </form><br><br>
                        </div>

                        <div class="tab-pane" id="security">
                            <h6>SECURITY SETTINGS</h6>
                            <hr>
                            <form id="passwordForm" action="/setting/ubahPassword" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="d-block">Ubah Password</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Enter your old password" name="passwordLama">
                                    <input type="text" class="form-control mt-1" id="password1"
                                        placeholder="New password" name="passwordBaru">
                                    <input type="text" class="form-control mt-1" id="password2"
                                        placeholder="Confirm new password">
                                </div>
                                <hr>

                                <button onclick="checkPasswordMatch()" class="btn btn-info" type="button">Ubah
                                    Password</button>
                            </form>

                        </div>
                        <div class="tab-pane" id="notification">
                            <h6>NOTIFICATION SETTINGS</h6>
                            <hr>
                            <form>
                                <div class="form-group">
                                    <label class="d-block mb-0">Security Alerts</label>
                                    <div class="small text-muted mb-3">Receive security alert notifications via email
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1"
                                            checked>
                                        <label class="custom-control-label" for="customCheck1">Email each time a
                                            vulnerability is found</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck2"
                                            checked>
                                        <label class="custom-control-label" for="customCheck2">Email a digest summary
                                            of vulnerability</label>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="d-block">SMS Notifications</label>
                                    <ul class="list-group list-group-sm">
                                        <li class="list-group-item has-icon">
                                            Comments
                                            <div class="custom-control custom-control-nolabel custom-switch ml-auto">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customSwitch1" checked>
                                                <label class="custom-control-label" for="customSwitch1"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item has-icon">
                                            Updates From People
                                            <div class="custom-control custom-control-nolabel custom-switch ml-auto">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customSwitch2">
                                                <label class="custom-control-label" for="customSwitch2"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item has-icon">
                                            Reminders
                                            <div class="custom-control custom-control-nolabel custom-switch ml-auto">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customSwitch3" checked>
                                                <label class="custom-control-label" for="customSwitch3"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item has-icon">
                                            Events
                                            <div class="custom-control custom-control-nolabel custom-switch ml-auto">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customSwitch4" checked>
                                                <label class="custom-control-label" for="customSwitch4"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item has-icon">
                                            Pages You Follow
                                            <div class="custom-control custom-control-nolabel custom-switch ml-auto">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customSwitch5">
                                                <label class="custom-control-label" for="customSwitch5"></label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="billing">
                            <h6>SETTINGS PEMBAYARAN</h6>
                            <hr>
                            <div class="form-group">
                                <label class="d-block mb-0">Jenis Pembayaran</label>
                                <button class="btn btn-info" data-toggle="modal" data-target="#myModal"
                                    type="button">Tambah Jenis Pembayaran</button>
                            </div>
                            <div class="form-group mb-0">
                                <label class="d-block">Pembayaran Yang Sudah Ditambahakan</label>
                                <div class="border border-gray-500 bg-gray-200 p-3 text-center font-size-sm">
                                    <table id="eoqTable" class="table table-striped jambo_table bulk_action"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>Nama</td>
                                                <td>Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($jp as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>
                                                        <!-- Button for Edit (Ubah) -->
                                                        <button
                                                            onclick="editModal('{{ $item->id }}','{{ $item->nama }}')"
                                                            class="btn btn-primary btn-sm" data-toggle="modal"
                                                            data-target="#myModalU">Ubah</button>

                                                        <!-- Button for Delete (Hapus) -->
                                                        <form
                                                            action="{{ route('jenisPembayaran.destroy', $item->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this item?')">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- MODAL Tambah --}}
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambahkan Jenis Pembayaran
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form inside the modal -->
                                            <form id="formPembayaran" method="POST" action="/jenisPembayaran">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="jenisPembayaran">Jenis Pembayaran:</label>
                                                    <input type="text" class="form-control" name="nama"
                                                        id="jenisPembayaran">
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{-- MODAL UBAHH --}}

                            <div class="modal fade" id="myModalU" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ubah Jenis Pembayaran
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form inside the modal -->
                                            <form id="formPembayaran2" method="POST" action="">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="jenisPembayaran">Jenis Pembayaran:</label>
                                                    <input type="text" class="form-control" name="nama"
                                                        id="jenisPembayaranUbah">
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (Session::has('alert'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success',
                    text: '{{ Session::get('alert') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: '{{ Session::get('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>

    <script>
        $('#leadTime').val('{{ $eoq->Ltime }}');
        $('#confidenceLevel').val('{{ $eoq->Zscore }}');

        function checkPasswordMatch() {
            var password1 = $('#password1').val();
            var password2 = $('#password2').val();

            if (password1 !== password2) {
                // Passwords don't match, show alert
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Passwords do not match! Please enter matching passwords.',
                });
            } else {
                // Passwords match, submit the form
                $('#passwordForm').submit();
            }
        }
    </script>

    <script>
        function handleDateRangeChange() {
            var dateRangeSelect = document.getElementById('dateRange');
            var startDateInput = document.getElementById('startDate');
            var endDateInput = document.getElementById('endDate');

            var today = new Date();

            // Determine the selected date range
            var selectedOption = dateRangeSelect.options[dateRangeSelect.selectedIndex].value;

            // Calculate start and end dates based on the selected option
            switch (selectedOption) {
                case '3months':
                    var threeMonthsAgo = new Date(today);
                    threeMonthsAgo.setMonth(today.getMonth() - 3);
                    startDateInput.value = threeMonthsAgo.toISOString().slice(0, 10);
                    endDateInput.value = today.toISOString().slice(0, 10);
                    break;
                case '6months':
                    var sixMonthsAgo = new Date(today);
                    sixMonthsAgo.setMonth(today.getMonth() - 6);
                    startDateInput.value = sixMonthsAgo.toISOString().slice(0, 10);
                    endDateInput.value = today.toISOString().slice(0, 10);
                    break;
                case 'lastYear':
                    var lastYear = new Date(today);
                    lastYear.setFullYear(today.getFullYear() - 1);
                    lastYear.setMonth(0); // Set to January
                    lastYear.setDate(1); // Set to th

                    var endYear = new Date(today);
                    endYear.setFullYear(today.getFullYear() - 1);
                    endYear.setMonth(11); // Set to January
                    endYear.setDate(31); // Set to th

                    startDateInput.value = lastYear.toISOString().slice(0, 10);
                    endDateInput.value = endYear.toISOString().slice(0, 10);
                    break;
                default:

            }
        }

        function editModal(id, val) {
            $('#jenisPembayaranUbah').val(val);
            $('#formPembayaran2').attr('action', 'jenisPembayaran/' + id);
        }
    </script>
</body>

</html>
