<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/manifest.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/vendor.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.semanticui.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript" src="{{ asset('vendor/semantic/semantic.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript">
    function savePayment(id) {
      console.log(id);
      $.ajax({
        url: "{{ url('admin/deposits/move') }}",
        type: 'post',
        data: {
          id: id,
          _token: "{{csrf_token()}}"
        },
        success: function(data) {
          console.log(data);
          location.reload();
        },
        error: function(request, error) {
          console.log("Request: " + JSON.stringify(request));
        }
      });
    }
  </script>
@stack('scripts')