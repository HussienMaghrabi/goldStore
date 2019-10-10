@php
$title = __('dashboard.Confirmation');
$body['en'] = 'Are you sure you want to delete <strong></strong>?';
$body['ar'] = 'هذا المنتج عليه عرض بالفعل هل انت متاكد من التعديل ؟!';
@endphp
<div class="modal modal-danger fade" id="check-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="float: {{ App::getLocale() == 'ar' ? 'left' : 'right' }}">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>{!! $body[App::getLocale()] !!}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left " data-dismiss="modal">{{__('dashboard.Close')}}</button>
        <button type="button" class="btn btn-outline check update">{{__('dashboard.OK')}}</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  $('.update').on('click', function (e) {
    console.log("hhhhhh");
    e.preventDefault();
      $.ajax({
          url: '{{route('admin.offers.up',App::getLocale())}}',
          dataType: 'html',
          data: $('.create').serialize(),
          success: function(data) {
            window.location.href = "{{route('admin.offers.index', App::getLocale())}}";


          }
      });
  })

</script>

