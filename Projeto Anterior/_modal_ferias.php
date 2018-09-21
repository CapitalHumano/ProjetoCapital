<?php

function retornamodal($nomebotao, $nommodal, $ccmodal){
    
$modal = '<div class="modal fade" id="'.$nommodal.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b>Envio de E-mail / Solicitação</b></h4>
            </div>
            <div class="modal-body">
              <div class="row"> 
                <div class="col-md-3">    
                  <div class="form-group">
                    Sugestão de Início
                    <input class="form-control" type="text" name="dat'.$nommodal.'" id="dat'.$nommodal.'"/>
                  </div> 
                </div>
                <div class="col-md-9">    
                  <div class="form-group">
                    E-mail do superior imediato
                    <input class="form-control" type="text" name="ema'.$nommodal.'"/>
                  </div> 
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <div class="panel-title" style="font-size: 14px;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#'.$ccmodal.'" class="collapsed">E-mail Cópia (+)</a>
                      </div>
                    </div>
                    <div id="'.$ccmodal.'" class="panel-collapse collapse">
                      <div class="panel-body">
                        <input class="form-control" type="text" name="cc'.$nommodal.'"/>   
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="'. $nomebotao. '" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </div>
</div>';

return $modal;
}