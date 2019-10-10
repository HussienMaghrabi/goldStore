<div class="modal fade" id="vid_modal_{{$id}}">
 <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span></button>
       <h4 class="modal-title">{{__('dashboard.Video')}}</h4>
     </div>
     <div class="modal-body">
       <center>
         <video height="280px" controls>
          <source src="{{ $vid }}" controls="controls" preload="none">
          {{-- <source src="movie.ogg" type="video/ogg"> --}}
        Your browser does not support the video tag.
        </video>
         {{-- <img src="{{ asset($img) }}" class="img-thumbnail" style="height:400px"> --}}
       </center>
     </div>
   </div>
   <!-- /.modal-content -->
 </div>
 <!-- /.modal-dialog -->
</div>
