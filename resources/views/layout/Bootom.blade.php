<footer>
  <div class="footer clearfix mb-0 text-muted">
      <div class="float-start">
          <p>2021 &copy; Mazer</p>
      </div>
      <div class="float-end">
          <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                  href="http://ahmadsaugi.com">A. Saugi</a></p>
      </div>
  </div>
</footer>
</div>
</div>
{{-- <script src="{{asset('assets/vendors/jquery/jquery.min.js')}}"></script> --}}
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
<script src="{{asset('assets/vendors/simple-datatables/simple-datatables.js')}}"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('assets/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}""></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></scri> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js" integrity="sha256-2Dbg51yxfa7qZ8CSKqsNxHtph8UHdgbzxXF9ANtyJHo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2()
    })
</script>