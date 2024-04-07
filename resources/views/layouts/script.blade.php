  <!-- start of js core -->

  <!-- jQuery -->
  <script src="{{ asset('theme/plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('theme/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
      $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- home url-->
  <script>
      var url = "{{ url('') }}";
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- datatable -->
  <script src="{{ asset('theme/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/select2/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('theme/dist/js/adminlte.js') }}"></script>
  <!-- toastr & sweetalert -->
  <script src="{{ asset('theme/plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

  <!-- end of js core -->
  <script>
      $(document).ready(function() {
          $("#form-logout").submit(function(e) {
              e.preventDefault();

              var form = $(this);
              var formData = new FormData(form[0]);

              if (confirm("Are you sure to logout?")) {
                  $.ajax({
                      url: url + "/logout",
                      type: "POST",
                      data: formData,
                      processData: false,
                      contentType: false,
                      success: function(responses) {
                          toastr.success("success!");
                          setTimeout(() => {
                              window.location = responses.data;
                          }, 2500);
                      },
                      error: function(response) {},
                  });
              }
          });
      });
  </script>