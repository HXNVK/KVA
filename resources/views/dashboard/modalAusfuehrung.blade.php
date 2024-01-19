<div class="modal fade" id="ausfuehrung">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Übersicht Bauweisen nach Festigkeitsklasse</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
              <div class="col-xl-12">
                  <table class="table table-striped" cellpadding="0" cellspacing="0">
                      <tr>
                          <th style=min-width:150px>Klasse</th>
                          <th>Ausführung</th>
                          <th>Bauweise</th>
                          <th>Anwendung</th>
                          <th>Max. zul. Leistung [kW]</th>
                      </tr>
                  @foreach($ausfuehrungen as $ausfuehrung)
                    <tr>
                        <td>{{ $ausfuehrung->name }}</td>
                        <td>{{ $ausfuehrung->bezeichnung }}</td>
                        <td>{{ $ausfuehrung->bauweise }}</td>
                        <td>{{ $ausfuehrung->anwendung }}</td>
                        <td>{{ $ausfuehrung->max_zul_leistung }}</td>
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