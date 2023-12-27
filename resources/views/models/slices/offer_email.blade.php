<!--scrolling content Modal -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">OFERTA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{Route( 'automation.offer-send', ['client'=>$client, 'cart'=>$cart ] )}}">
                    @csrf
                    <div class="modal-body">
                        <textarea class="form-control" id="basicTextarea" rows="3" placeholder="Textarea" name=" mensaje">Estimado {{$client->name}}, acontinuación le mostramos nuestra oferta, un gusto atenderle.
                        </textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Cerrar</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Enviar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--scrolling content Modal -->

