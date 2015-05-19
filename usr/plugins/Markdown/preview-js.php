<script type="text/javascript">
    document.getElementById('btn-md-preview').onclick = function (e) {
        var md = document.getElementById('text').value;
        var myRequest = new Request({
            url: '<?php echo $ajax_url; ?>',
            data: {'text': md},
            onSuccess: function(responseText){
                var preview = document.getElementById('div-md-preview');
                preview.innerHTML = responseText;
                preview.style.display = 'block';
                document.getElementById('btn-md-close').style.display = 'inline-block';
            }
        });
         
        myRequest.send();
        return false;
    };
    document.getElementById('btn-md-close').onclick = function (e) {
        var preview = document.getElementById('div-md-preview');
        preview.style.display = 'none';
        document.getElementById('btn-md-close').style.display = 'none';
        return false;
    };
</script>