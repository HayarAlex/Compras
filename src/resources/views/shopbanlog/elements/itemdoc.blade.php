<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="panel-title">Archivo TIPO</h3>
    </div>
    <div class="box-body">
    	@if($docs == '')
        <embed src="" width="100%" height="700" type="application/pdf">
        @else
        <embed src="/storage/{{ $docs[0]->docurls }}" width="100%" height="300" type="application/pdf">
        @endif
    </div>
</div>

<script>
    $(document).ready(function () {


    });
</script>