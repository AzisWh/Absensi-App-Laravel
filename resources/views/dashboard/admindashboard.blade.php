@extends('layout.admin.master')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col text-center">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            Overview
          </div>
          <h2 class="page-title">
            Dashboard
          </h2>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
   <div class="container-xl">
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <span class="bg-success text-white avatar">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="50"  height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-fingerprint"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3" /><path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6" /><path d="M12 11v2a14 14 0 0 0 2.5 8" /><path d="M8 15a18 18 0 0 0 1.8 6" /><path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95" /></svg>
                    </span>
                  </div>
                  <div class="col">
                    <div class="font-weight-medium">
                      {{$rekapabsen->jmlhadir}}
                    </div>
                    <div class="text-secondary">
                      Mahasiswa Hadir
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
       
        <div class="col-md-6 col-xl-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <span class="bg-info text-white avatar">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-files"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 3v4a1 1 0 0 0 1 1h4" /><path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" /><path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" /></svg>
                    </span>
                  </div>
                  <div class="col">
                    <div class="font-weight-medium">
                        {{$dataizin->jmlizin != null ? $dataizin->jmlizin : 0}}
                    </div>
                    <div class="text-secondary">
                      Izin Mahasiswa
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <span class="bg-warning text-white avatar">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-nurse"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6c2.941 0 5.685 .847 8 2.31l-2 9.69h-12l-2 -9.691a14.93 14.93 0 0 1 8 -2.309z" /><path d="M10 12h4" /><path d="M12 10v4" /></svg>
                    </span>
                  </div>
                  <div class="col">
                    <div class="font-weight-medium">
                        {{$dataizin->jmlsakit != null ? $dataizin->jmlsakit : 0}}
                    </div>
                    <div class="text-secondary">
                      Sakit Mahasiswa
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <span class="bg-danger text-white avatar">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-nurse"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6c2.941 0 5.685 .847 8 2.31l-2 9.69h-12l-2 -9.691a14.93 14.93 0 0 1 8 -2.309z" /><path d="M10 12h4" /><path d="M12 10v4" /></svg>
                    </span>
                  </div>
                  <div class="col">
                    <div class="font-weight-medium">
                        {{$rekapabsen->jmlterlambat}}
                    </div>
                    <div class="text-secondary">
                      Terlambat
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
   </div>
  </div>
@endsection