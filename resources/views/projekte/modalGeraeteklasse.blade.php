<div class="modal fade" id="geraeteklassen">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Geräteklasse Info</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <table class="table table-sm">
            @foreach($projektGeraeteklassen as $geraeteklasse)
            <tr>
              <td>{{ $geraeteklasse->name }}</td>
              <td>{{ $geraeteklasse->beschreibung }}</td>
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