@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/manage.css') }}" />
@endsection


@section('content')
    <div class="manage-body">
        {{-- Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <h1>Aktivitas Diikuti</h1>

            @if (auth()->user() && auth()->user()->sukarelawan->verificationStatus->name == 'Sudah Diverifikasi')
                <a href="/activities">
                    <div class="btn-fill">
                        Lihat Aktivitas
                    </div>
                </a>
            @endif
        </div>

        @php
            $shownActivityCount = 0;
        @endphp

        {{-- Filters --}}
        {{-- <div class="row fs">
        </div> --}}

        {{-- Table --}}
        <div class="manage-table">

            @if (!empty($activityDetails))
                @foreach ($activityDetails as $ad)
                    @php
                        $sActivityStatus = $ad->sukarelawanActivityStatus->name;
                        $activityStatus = $ad->activity->activityStatus->name;
                        
                        $status = '';
                        $statusClass = '';
                        $activityClass = '';
                        
                        switch ($activityStatus) {
                            case 'Pendaftaran Sedang Dibuka':
                                $activityClass = '';
                                break;
                            case 'Pendaftaran Sudah Ditutup':
                                $activityClass = 'danger';
                        
                                break;
                            case 'Aktivitas Sedang Berlangsung':
                                $activityClass = 'redeem';
                        
                                break;
                            case 'Pendaftaran Sudah Selesai':
                                $activityClass = 'success';
                                break;
                            default:
                                break;
                        }
                        
                        switch ($sActivityStatus) {
                            case 'Terdaftar':
                                $currentDateTime = date('Y-m-d H:i:s');
                                if ($currentDateTime <= $ad->activity->cleanUpDate . $ad->activity->endTime) {
                                    $status = 'Menunggu Clock In';
                                } else {
                                    $status = 'Gagal Berpartisipasi';
                                    $statusClass = 'danger';
                                }
                                break;
                            case 'ClockedIn':
                                $status = 'Menunggu Pencairan XP';
                                $statusClass = 'success';
                        
                            case 'Claimed':
                                $status = 'XP Sudah Dicairkan';
                                $statusClass = 'redeem';
                                break;
                            default:
                                break;
                        }
                    @endphp

                    @if (!is_null($sActivityStatus) && $sActivityStatus != 'Null')
                        @php
                            $shownActivityCount++;
                        @endphp
                        <div class="card-row">
                            <div class="left-container">
                                <div class="left">
                                    <a href="/activities/{{ $ad->activity->slug }}">
                                        <div class="activity-image">
                                            <img src="{{ asset(
                                                $ad->activity->bannerImageUrl
                                                    ? 'storage/images/' . $ad->activity->bannerImageUrl
                                                    : '/images/' . Config::get('constants.default_banner_image'),
                                            ) }}"
                                                alt="">
                                        </div>
                                    </a>


                                    <div class="col fs">
                                        <a href="/activities/{{ $ad->activity->slug }}">
                                            <h3>{{ $ad->activity->name }}</h3>
                                        </a>
                                        <div class="row fs">
                                            <div class="col fs">
                                                <div class="row sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M3 11.7693C3 8.28843 3 6.54752 4.08184 5.46661C5.16276 4.38477 6.90367 4.38477 10.3846 4.38477H14.0769C17.5578 4.38477 19.2987 4.38477 20.3796 5.46661C21.4614 6.54752 21.4614 8.28843 21.4614 11.7693V13.6155C21.4614 17.0964 21.4614 18.8373 20.3796 19.9182C19.2987 21.0001 17.5578 21.0001 14.0769 21.0001H10.3846C6.90367 21.0001 5.16276 21.0001 4.08184 19.9182C3 18.8373 3 17.0964 3 13.6155V11.7693Z"
                                                            stroke="#838181" stroke-width="1.5" />
                                                        <path
                                                            d="M7.61574 4.38461V3M16.8464 4.38461V3M3.46191 8.99996H21.0003"
                                                            stroke="#838181" stroke-width="1.5" stroke-linecap="round" />
                                                        <path
                                                            d="M17.7692 16.3849C17.7692 16.6297 17.672 16.8645 17.4989 17.0376C17.3258 17.2107 17.091 17.308 16.8462 17.308C16.6014 17.308 16.3666 17.2107 16.1935 17.0376C16.0203 16.8645 15.9231 16.6297 15.9231 16.3849C15.9231 16.1401 16.0203 15.9053 16.1935 15.7322C16.3666 15.5591 16.6014 15.4618 16.8462 15.4618C17.091 15.4618 17.3258 15.5591 17.4989 15.7322C17.672 15.9053 17.7692 16.1401 17.7692 16.3849ZM17.7692 12.6926C17.7692 12.9374 17.672 13.1722 17.4989 13.3453C17.3258 13.5184 17.091 13.6157 16.8462 13.6157C16.6014 13.6157 16.3666 13.5184 16.1935 13.3453C16.0203 13.1722 15.9231 12.9374 15.9231 12.6926C15.9231 12.4478 16.0203 12.213 16.1935 12.0399C16.3666 11.8668 16.6014 11.7695 16.8462 11.7695C17.091 11.7695 17.3258 11.8668 17.4989 12.0399C17.672 12.213 17.7692 12.4478 17.7692 12.6926ZM13.1539 16.3849C13.1539 16.6297 13.0566 16.8645 12.8835 17.0376C12.7104 17.2107 12.4756 17.308 12.2308 17.308C11.986 17.308 11.7512 17.2107 11.5781 17.0376C11.405 16.8645 11.3077 16.6297 11.3077 16.3849C11.3077 16.1401 11.405 15.9053 11.5781 15.7322C11.7512 15.5591 11.986 15.4618 12.2308 15.4618C12.4756 15.4618 12.7104 15.5591 12.8835 15.7322C13.0566 15.9053 13.1539 16.1401 13.1539 16.3849ZM13.1539 12.6926C13.1539 12.9374 13.0566 13.1722 12.8835 13.3453C12.7104 13.5184 12.4756 13.6157 12.2308 13.6157C11.986 13.6157 11.7512 13.5184 11.5781 13.3453C11.405 13.1722 11.3077 12.9374 11.3077 12.6926C11.3077 12.4478 11.405 12.213 11.5781 12.0399C11.7512 11.8668 11.986 11.7695 12.2308 11.7695C12.4756 11.7695 12.7104 11.8668 12.8835 12.0399C13.0566 12.213 13.1539 12.4478 13.1539 12.6926ZM8.53853 16.3849C8.53853 16.6297 8.44127 16.8645 8.26816 17.0376C8.09505 17.2107 7.86027 17.308 7.61545 17.308C7.37064 17.308 7.13585 17.2107 6.96274 17.0376C6.78963 16.8645 6.69238 16.6297 6.69238 16.3849C6.69238 16.1401 6.78963 15.9053 6.96274 15.7322C7.13585 15.5591 7.37064 15.4618 7.61545 15.4618C7.86027 15.4618 8.09505 15.5591 8.26816 15.7322C8.44127 15.9053 8.53853 16.1401 8.53853 16.3849ZM8.53853 12.6926C8.53853 12.9374 8.44127 13.1722 8.26816 13.3453C8.09505 13.5184 7.86027 13.6157 7.61545 13.6157C7.37064 13.6157 7.13585 13.5184 6.96274 13.3453C6.78963 13.1722 6.69238 12.9374 6.69238 12.6926C6.69238 12.4478 6.78963 12.213 6.96274 12.0399C7.13585 11.8668 7.37064 11.7695 7.61545 11.7695C7.86027 11.7695 8.09505 11.8668 8.26816 12.0399C8.44127 12.213 8.53853 12.4478 8.53853 12.6926Z"
                                                            fill="#838181" />
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse($ad->activity->cleanUpDate)->format('j M Y') }}
                                                </div>
                                                <div class="row sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M12.7714 6.85737C12.7714 6.65277 12.6901 6.45655 12.5454 6.31188C12.4008 6.16721 12.2045 6.08594 11.9999 6.08594C11.7953 6.08594 11.5991 6.16721 11.4545 6.31188C11.3098 6.45655 11.2285 6.65277 11.2285 6.85737V12.0002C11.2285 12.131 11.2617 12.2597 11.325 12.3741C11.3883 12.4885 11.4797 12.585 11.5906 12.6544L14.6763 14.583C14.8498 14.6915 15.0593 14.7267 15.2588 14.6808C15.3575 14.6581 15.4508 14.6161 15.5334 14.5573C15.6159 14.4986 15.6861 14.4241 15.7398 14.3382C15.7936 14.2523 15.8299 14.1566 15.8467 14.0567C15.8635 13.9567 15.8604 13.8545 15.8377 13.7557C15.815 13.6569 15.773 13.5636 15.7142 13.4811C15.6554 13.3985 15.5809 13.3284 15.495 13.2746L12.7714 11.5723V6.85737Z"
                                                            fill="#838181" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M12 3C9.61305 3 7.32387 3.94821 5.63604 5.63604C3.94821 7.32387 3 9.61305 3 12C3 14.3869 3.94821 16.6761 5.63604 18.364C7.32387 20.0518 9.61305 21 12 21C14.3869 21 16.6761 20.0518 18.364 18.364C20.0518 16.6761 21 14.3869 21 12C21 9.61305 20.0518 7.32387 18.364 5.63604C16.6761 3.94821 14.3869 3 12 3ZM4.54286 12C4.54286 11.0207 4.73574 10.051 5.1105 9.14628C5.48525 8.24153 6.03454 7.41946 6.727 6.727C7.41946 6.03454 8.24153 5.48525 9.14628 5.1105C10.051 4.73574 11.0207 4.54286 12 4.54286C12.9793 4.54286 13.949 4.73574 14.8537 5.1105C15.7585 5.48525 16.5805 6.03454 17.273 6.727C17.9655 7.41946 18.5147 8.24153 18.8895 9.14628C19.2643 10.051 19.4571 11.0207 19.4571 12C19.4571 13.9778 18.6715 15.8745 17.273 17.273C15.8745 18.6715 13.9778 19.4571 12 19.4571C10.0222 19.4571 8.12549 18.6715 6.727 17.273C5.32852 15.8745 4.54286 13.9778 4.54286 12Z"
                                                            fill="#838181" />
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse($ad->activity->startTime)->format('H:i') . ' - ' . \Carbon\Carbon::parse($ad->activity->endTime)->format('H:i') . ' WIB' }}
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col fs">
                                                <div class="row sm">
                                                    <div class="circle {{ $activityClass }}">
                                                    </div>
                                                    {{ $activityStatus }}
                                                </div>
                                                <div class="row hide">
                                                    <div class="circle">
                                                    </div>
                                                    <div class="circle redeem">
                                                    </div>
                                                    <div class="circle success">
                                                    </div>

                                                </div>

                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>

                                <div class="col full">
                                    <div class="status {{ $statusClass }}">
                                        {{ $status }}
                                    </div>
                                </div>

                            </div>

                            <div class="right">
                                @if ($sActivityStatus == 'Terdaftar')
                                    <a href="/activities/{{ $ad->activity->slug }}">
                                        <div class="action-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M17.28 8.72C17.4205 8.86063 17.4993 9.05125 17.4993 9.25C17.4993 9.44875 17.4205 9.63937 17.28 9.78L15.28 11.78C15.1394 11.9205 14.9488 11.9993 14.75 11.9993C14.5512 11.9993 14.3606 11.9205 14.22 11.78L13.22 10.78C13.1463 10.7113 13.0872 10.6285 13.0462 10.5365C13.0052 10.4445 12.9832 10.3452 12.9814 10.2445C12.9796 10.1438 12.9982 10.0438 13.0359 9.9504C13.0736 9.85701 13.1297 9.77218 13.201 9.70096C13.2722 9.62974 13.357 9.5736 13.4504 9.53588C13.5438 9.49816 13.6438 9.47963 13.7445 9.48141C13.8452 9.48318 13.9445 9.50523 14.0365 9.54622C14.1285 9.58721 14.2113 9.64631 14.28 9.72L14.75 10.19L16.22 8.72C16.3606 8.57955 16.5512 8.50066 16.75 8.50066C16.9488 8.50066 17.1394 8.57955 17.28 8.72ZM17.28 15.28C17.3537 15.2113 17.4128 15.1285 17.4538 15.0365C17.4948 14.9445 17.5168 14.8452 17.5186 14.7445C17.5204 14.6438 17.5018 14.5438 17.4641 14.4504C17.4264 14.357 17.3703 14.2722 17.299 14.201C17.2278 14.1297 17.143 14.0736 17.0496 14.0359C16.9562 13.9982 16.8562 13.9796 16.7555 13.9814C16.6548 13.9832 16.5555 14.0052 16.4635 14.0462C16.3715 14.0872 16.2887 14.1463 16.22 14.22L14.75 15.69L14.28 15.22C14.2113 15.1463 14.1285 15.0872 14.0365 15.0462C13.9445 15.0052 13.8452 14.9832 13.7445 14.9814C13.6438 14.9796 13.5438 14.9982 13.4504 15.0359C13.357 15.0736 13.2722 15.1297 13.201 15.201C13.1297 15.2722 13.0736 15.357 13.0359 15.4504C12.9982 15.5438 12.9796 15.6438 12.9814 15.7445C12.9832 15.8452 13.0052 15.9445 13.0462 16.0365C13.0872 16.1285 13.1463 16.2113 13.22 16.28L14.22 17.28C14.3606 17.4205 14.5512 17.4993 14.75 17.4993C14.9488 17.4993 15.1394 17.4205 15.28 17.28L17.28 15.28ZM7 10.25C7 10.0511 7.07902 9.86032 7.21967 9.71967C7.36032 9.57902 7.55109 9.5 7.75 9.5H11.25C11.4489 9.5 11.6397 9.57902 11.7803 9.71967C11.921 9.86032 12 10.0511 12 10.25C12 10.4489 11.921 10.6397 11.7803 10.7803C11.6397 10.921 11.4489 11 11.25 11H7.75C7.55109 11 7.36032 10.921 7.21967 10.7803C7.07902 10.6397 7 10.4489 7 10.25ZM7.75 15C7.55109 15 7.36032 15.079 7.21967 15.2197C7.07902 15.3603 7 15.5511 7 15.75C7 15.9489 7.07902 16.1397 7.21967 16.2803C7.36032 16.421 7.55109 16.5 7.75 16.5H11.25C11.4489 16.5 11.6397 16.421 11.7803 16.2803C11.921 16.1397 12 15.9489 12 15.75C12 15.5511 11.921 15.3603 11.7803 15.2197C11.6397 15.079 11.4489 15 11.25 15H7.75ZM15.986 4C15.9245 3.44999 15.6625 2.94194 15.25 2.57297C14.8375 2.20401 14.3034 2.00002 13.75 2H10.25C9.69656 2.00002 9.16255 2.20401 8.75004 2.57297C8.33754 2.94194 8.07549 3.44999 8.014 4H6.25C5.65326 4 5.08097 4.23705 4.65901 4.65901C4.23705 5.08097 4 5.65326 4 6.25V19.75C4 20.3467 4.23705 20.919 4.65901 21.341C5.08097 21.7629 5.65326 22 6.25 22H17.75C18.0455 22 18.3381 21.9418 18.611 21.8287C18.884 21.7157 19.1321 21.5499 19.341 21.341C19.5499 21.1321 19.7157 20.884 19.8287 20.611C19.9418 20.3381 20 20.0455 20 19.75V6.25C20 5.95453 19.9418 5.66194 19.8287 5.38896C19.7157 5.11598 19.5499 4.86794 19.341 4.65901C19.1321 4.45008 18.884 4.28434 18.611 4.17127C18.3381 4.0582 18.0455 4 17.75 4H15.986ZM10.25 6.5H13.75C14.53 6.5 15.217 6.103 15.621 5.5H17.75C17.9489 5.5 18.1397 5.57902 18.2803 5.71967C18.421 5.86032 18.5 6.05109 18.5 6.25V19.75C18.5 19.9489 18.421 20.1397 18.2803 20.2803C18.1397 20.421 17.9489 20.5 17.75 20.5H6.25C6.05109 20.5 5.86032 20.421 5.71967 20.2803C5.57902 20.1397 5.5 19.9489 5.5 19.75V6.25C5.5 6.05109 5.57902 5.86032 5.71967 5.71967C5.86032 5.57902 6.05109 5.5 6.25 5.5H8.379C8.783 6.103 9.47 6.5 10.25 6.5ZM10.25 3.5H13.75C13.9489 3.5 14.1397 3.57902 14.2803 3.71967C14.421 3.86032 14.5 4.05109 14.5 4.25C14.5 4.44891 14.421 4.63968 14.2803 4.78033C14.1397 4.92098 13.9489 5 13.75 5H10.25C10.0511 5 9.86032 4.92098 9.71967 4.78033C9.57902 4.63968 9.5 4.44891 9.5 4.25C9.5 4.05109 9.57902 3.86032 9.71967 3.71967C9.86032 3.57902 10.0511 3.5 10.25 3.5Z"
                                                    fill="#5822CA" />
                                            </svg>
                                            Absen
                                        </div>
                                    </a>


                                    <form method="POST"
                                        action="{{ route('activities.unjoin', ['activity' => $ad->activity->slug]) }}">
                                        @csrf
                                        <button type="submit" class="action-btn danger"
                                            onclick="return confirm('Apakah Anda yakin untuk membatalkan pendaftaran pada aktivitas ini?');">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path d="M4 20L20.0045 4M4 4L20.0045 20" stroke="#E21919" stroke-width="2"
                                                    stroke-linecap="round" />
                                            </svg>
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif


            @if ($shownActivityCount == 0)
                <div class="centered">
                    <img src="{{ asset('images/Register/register-illustration.png') }}" alt="">
                    <div class="col">
                        <h1 class="disabled">Belum ada aktivitas yang diikuti</h1>
                        <h4 class="disabled">*Anda harus terverifikasi untuk mengikuti aktivitas</h4>
                        @if (auth()->user() && auth()->user()->sukarelawan->verificationStatus->name == 'Sudah Diverifikasi')
                            <h3>
                                <div class="row-sm">
                                    <a href="/activities" class="selected">Lihat Aktivitas</a>
                                </div>
                            </h3>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
