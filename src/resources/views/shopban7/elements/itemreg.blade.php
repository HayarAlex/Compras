<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-check-square-o"></i>
        <h3 class="box-title">Detalle de Fechas</h3>
    </div>
    <div class="box-body no-pad-top">
        <form id="form-ad" autocomplete="off">
            <div>

                <ul class="timeline">
                    <li class="time-label">
                        <span class="bg-blue">
                            {{ $list->fechainicio }}
                        </span>
                    </li>
                    <li>
                        <i class="fa fa-file-text-o bg-blue"></i>

                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="#">Inicio Pedido</a></h3>
                        </div>
                    </li>
                    <li class="time-label">
                        <span class="bg-green">
                            {{ $list->fechaenvp }}
                        </span>
                    </li>
                    <li>
                        <i class="fa fa-truck bg-green"></i>

                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="#">Asignacion y Envio Cotizacion Proveedor</a></h3>
                        </div>
                    </li>
                    <li class="time-label">
                        <span class="bg-green">
                            {{ $list->fecharegrev }}
                        </span>
                    </li>
                    <li>
                        <i class="fa fa-paper-plane-o bg-green"></i>

                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="#">Asignacion del area Revision</a></h3>
                        </div>
                    </li>
                    @if($list->arearevin == '1')
                        <li class="time-label">
                            <span class="bg-green">
                                {{ $list->ffini }}
                            </span>
                        </li>
                        <li>
                            <i class="fa fa-paper-plane-o bg-green"></i>

                            <div class="timeline-item">
                                <h3 class="timeline-header"><a href="#">Revision Inv. Desarrollo</a></h3>
                            </div>
                        </li>
                    @endif
                    @if($list->arearevlo == '1')
                        <li class="time-label">
                            <span class="bg-green">
                                {{ $list->ffinl }}
                            </span>
                        </li>
                        <li>
                            <i class="fa fa-paper-plane-o bg-green"></i>

                            <div class="timeline-item">
                                <h3 class="timeline-header"><a href="#">Revision Logistica</a></h3>
                            </div>
                        </li>
                    @endif
                    @if($list->arearevsa == '1')
                        <li class="time-label">
                            <span class="bg-green">
                                {{ $list->ffins }}
                            </span>
                        </li>
                        <li>
                            <i class="fa fa-paper-plane-o bg-green"></i>

                            <div class="timeline-item">
                                <h3 class="timeline-header"><a href="#">Revision Reg. Sanitario</a></h3>
                            </div>
                        </li>
                    @endif
                    @if($list->arearevsh == '1')
                        <li class="time-label">
                            <span class="bg-green">
                                {{ $list->ffinc }}
                            </span>
                        </li>
                        <li>
                            <i class="fa fa-paper-plane-o bg-green"></i>

                            <div class="timeline-item">
                                <h3 class="timeline-header"><a href="#">Revision Calidad</a></h3>
                            </div>
                        </li>
                    @endif
                        

                    <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                </ul>

            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        //-- load data
    });
</script>

