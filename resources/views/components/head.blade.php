  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="utf-8" accept-charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Si-PMM |
          @include('components.title_doc')
      </title>
      <link rel="shortcut icon" href="{{ asset('template/img/logo.png') }}">
      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}" />
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet"
          href="{{ asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
      <!-- iCheck -->
      <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
      <!-- JQVMap -->
      <link rel="stylesheet" href="{{ asset('template/plugins/jqvmap/jqvmap.min.css') }}" />
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="{{ asset('template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" />
      <!-- Daterange picker -->
      {{-- <link rel="stylesheet" href="{{ asset('template/plugins/daterangepicker/daterangepicker.css') }}" /> --}}
      <!-- summernote -->
      <link rel="stylesheet" href="{{ asset('template/plugins/summernote/summernote-bs4.min.css') }}" />
      <!-- Select2 -->
      <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/select2.min.css') }}">

      <!-- Theme style -->
      <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
      <link rel="stylesheet" href="{{ asset('template/dist/css/img.css') }}">
      @stack('new-css')
  </head>
