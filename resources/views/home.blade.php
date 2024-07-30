@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Gaji</th>
                                <th>Absensi</th>
                                <th>Hutang</th>
                                <th>Koprasi</th>
                                <th>Tunjangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                
                            @endforeach
                            <tr>
                                <td>{{ $d->nik }}</td>
                                <td>{{ $d->nama }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
