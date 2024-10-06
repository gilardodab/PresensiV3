<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('admin/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('admin/js/adminlte.js') }}"></script>
<script src="{{ asset('admin/js/app.js') }}"></script>
<script src="{{ asset('admin/js/demo.js') }}"></script>
{{-- <script src="{{ asset('admin/js/sweetalert.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="{{ asset('admin/plugins/chart/Chart.min.js') }}"></script>
<script src="{{ asset('admin/js/simple-lightbox.min.js') }}"></script>
<script src="{{ asset('admin/js/validasi/jquery.validate.js') }}"></script>
<script src="{{ asset('admin/js/validasi/messages_id.js') }}"></script>

<script src="{{ asset('admin/js/shifts.js') }}"></script>
<script src="{{ asset('admin/js/karyawan.js') }}"></script>
<script src="{{ asset('admin/js/cuti.js') }}"></script>
{{-- <script src="{{ asset('admin/js/settings.js') }}"></script> --}}

<script src="{{ asset('admin/js/webcame/webcodecamjs.js') }}"></script>

<script src="{{ asset('admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('admin/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>



<link rel="stylesheet" href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>



<script src="{{ asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('admin/js/script.js') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}


<script type="text/javascript">
  $(document).ready(function() {
      $(".validate").validate();
      $(".validate2").validate();
  });

  $(document).on("click", ".access-failed", function() {
      swal({
          title: "Error!",
          text: "Anda tidak memiliki hak akses! Silahkan Hubungi Superadmin",
          icon: "error",
          timer: 2000,
      });
  });
</script>