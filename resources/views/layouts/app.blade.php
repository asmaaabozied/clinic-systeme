<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
if (typeof toastr === 'undefined') {
    window.toastr = {
        success: function(msg) { alert(msg); },
        error: function(msg) { alert(msg); }
    };
}
</script> 