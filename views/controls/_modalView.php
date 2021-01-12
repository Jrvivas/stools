<!-- Modal -->

<!--agregar en botones que abren el modal:  data-toggle="modal" data-target="#<idModal>" -->
<div class="modal fade" id="<?=$id?>" tabindex="-1" role="dialog" aria-labelledby="<?=$id?>Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?=$id?>Label"><?=$title?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="body-<?=$id?>" class="modal-body">
      <div class="text-center"> 
         <img src="assets/imgs/espera.gif" alt="*" style="width:64px;padding:0px">
      </div>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button id="modalBotAceptar" type="button" data-dismiss="modal" class="btn btn-success">Aceptar</button>
      </div>
    </div>
  </div>
</div>