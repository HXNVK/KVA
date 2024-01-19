<div class="modal fade" id="kundeGruppe">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Info zu Wahl der Gruppe des Kunden</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <table class="table table-sm">
            @foreach($kundeGruppen as $kundeGruppe)
            <tr>
              <td>{{ $kundeGruppe->name }}</td>
              <td>{{ $kundeGruppe->definition }}</td>
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