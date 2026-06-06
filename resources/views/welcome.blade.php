@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">

    <h1>Welkom!</h1>

</div>


<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999;">
    <div id="welcomeToast" class="toast align-items-center text-bg-dark border-0">

        <div class="d-flex">
            <div class="toast-body">
                👋 Welkom bij Wheely Good Cars! Bekijk ons aanbod.
            </div>

            <button type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast">
            </button>
        </div>

    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const el = document.getElementById('welcomeToast');
    if (!el) return;

    const toast = new bootstrap.Toast(el, {
        autohide: true,
        delay: 4000
    });

    toast.show();

});
</script>

@endsection