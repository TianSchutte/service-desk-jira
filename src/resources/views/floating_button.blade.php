<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    .floating-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
    }

    .popup {
        display: none;
        background: #F4F5F7;
        position: absolute;
        bottom: 50px;
        right: 0;
        width: 400px;
        height: 300px;
    }

    .popup iframe {
        width: 100%;
        height: 100%;
    }
</style>
<div class="floating-button">
    <a href="#" class="button">Click Me!</a>
    <div class="popup">
        <iframe src="{{route('tickets.menu')}}">Your browser isn't compatible</iframe>
    </div>
</div>


<script>
    $('.floating-button .button').on('click', function (e) {
        e.preventDefault();
        $('.floating-button .popup').toggle();
    });
</script>