@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection


@php
    // dd(Session::get('step1Data'));
@endphp

@section('content')
    <div class="create-activity">
        <div class="top">
            <h1>Buat Aktivitas - Langkah 3</h1>
            <div class="form-steps">
                <a href="/activities/create/1">
                    <div class="circle">
                        1
                    </div>
                </a>
                <div class="line filled"></div>
                <a href="/activities/create/2">
                    <div class="circle">
                        2
                    </div>
                </a>
                <div class="line filled"></div>
                <div class="circle filled">
                    3
                </div>
            </div>
        </div>

        <form action="{{ route('activity.publicStore', ['step' => 3]) }}" method="post">
            @csrf
            <div class="form-recap">
                <div class="form-card-container">
                    <div class="form-card">

                        <div class="form-header">
                            Pratinjau Data Aktivitas
                        </div>
                        <div class="form-subheadline">
                            Judul Lengkap
                        </div>
                        <div class="form-content">
                            {{ Session::get('step1Data.name') }}
                        </div>
                        <div class="form-subheadline">
                            Deskripsi Aktivitas
                        </div>
                        <div class="form-content">
                            {{ Session::get('step1Data.description') }}
                        </div>

                        <div class="form-subheadline">
                            Batas Registrasi
                        </div>
                        <div class="form-content">
                            @php
                                $date = Session::get('step1Data.registrationDeadlineDate');
                                $formattedDate = date('d/m/Y', strtotime($date));
                            @endphp
                            {{ $formattedDate }}
                        </div>
                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Pelaksanaan Aktivitas
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-subheadline">
                                    Tanggal Pelaksanaan
                                </div>
                                <div class="form-content">
                                    @php
                                        $date = Session::get('step1Data.cleanUpDate');
                                        $formattedDate = date('d/m/Y', strtotime($date));
                                    @endphp
                                    {{ $formattedDate }}
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-subheadline">
                                    Waktu
                                </div>
                                <div class="form-content">
                                    {{ Session::get('step1Data.startTime') }} - {{ Session::get('step1Data.endTime') }} WIB
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Lokasi Aktivitas
                        </div>
                        <div class="form-subheadline">
                            Titik Kumpul
                        </div>
                        <div class="form-content">
                            <a target="_blank" href=" {{ Session::get('step1Data.gatheringPointUrl') }}">
                                {{ Session::get('step1Data.gatheringPointUrl') }}
                            </a>
                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Banner Aktivitas
                        </div>
                        <div class="form-subheadline">
                            Banner
                        </div>
                        <div class="form-content">
                            <div class="step3-image-preview">
                                <div class="image-preview" id="imagePreview"
                                    @if (Session::has('step1Data.picture')) @else hidden @endif>
                                    @if (Session::has('step1Data.picture'))
                                        <img id="previewImage"
                                            src="{{ asset('storage/' . Session::get('step1Data.picture')) ?? '' }}"
                                            alt="Image Preview" />
                                    @else
                                        <img id="previewImage" src="" alt="Image Preview" />
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Data Sukarelawan
                        </div>
                        <div class="form-subheadline">
                            Nama Pekerjaan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.sukarelawanJobName') }}
                        </div>
                        <div class="form-subheadline">
                            Tugas Sukarelawan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.sukarelawanJobDetail') }}
                        </div>
                        <div class="form-subheadline">
                            Kriteria Sukarelawan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.sukarelawanCriteria') }}
                        </div>
                        <div class="form-subheadline">
                            Jumlah Sukarelawan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.minimumNumOfSukarelawan') }}
                        </div>
                        <div class="form-subheadline">
                            Perlengkapan Suakrelawan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.sukarelawanEquipment') }}
                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Alat Komunikasi
                        </div>
                        <div class="form-subheadline">
                            Group Chat
                        </div>
                        <div class="form-content">
                            <a target="_blank" href="{{ Session::get('step2Data.groupChatUrl') }}">
                                {{ Session::get('step2Data.groupChatUrl') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>


            <button type="submit" class="btn-fill" id="submitButton">
                Submit
            </button>


        </form>

        <div class="goBack">
            <a href="/activities/create/2">
                <button>Sebelumnya</button>
            </a>
        </div>
    </div>
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
