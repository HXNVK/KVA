<div class="modal fade" id="typenbezeichnung">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Info zu Typenbezeichnung</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-12">
                    <table class="table table-striped" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>Designklasse</th>
                            <th>Neu</th>
                            <th><=></th>
                            <th>Typenbez. Alt</th>
                        </tr>
                    @foreach($propellerModellBlattTypen as $propellerModellBlattTyp)
                    <tr>
                        <td>{{ $propellerModellBlattTyp->propellerKlasseDesign->name }}</td>
                        <td>{{ $propellerModellBlattTyp->text }}</td>
                        <td>=></td>
                        <td>{{ $propellerModellBlattTyp->name_alt }}</td>
                    </tr>
                    @endforeach   
                    </table> 
            </div>
        </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">schließen</button>
        </div>
        
      </div>
    </div>
</div>