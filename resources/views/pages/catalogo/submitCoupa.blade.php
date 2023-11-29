<form id="data_form" method="POST" action="{{ $url }}">
    <input type="hidden" name="data-encoded" value="{{ $datosToSendString }}">
</form>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('data_form').submit()
    })
</script>
