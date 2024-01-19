<div class="modal fade" id="kundeRating">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Info zu Wahl der Gruppe des Ratings</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <table class="table table-sm">
            @foreach($kundeRatingObjects as $kundeRating)
            <tr>
              <td>{{ $kundeRating->name }}</td>
              <td>{{ $kundeRating->definition }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">schließen</button>
        </div>
        
      </div>
    </div>
</div>