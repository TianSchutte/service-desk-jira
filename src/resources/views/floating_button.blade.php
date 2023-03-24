<style>
    .floating-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
    }

    .popup {
        display: none;
        background: #f6f6f6;
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 90%;
        max-width: 420px;
        height: 90%;
        max-height: 420px;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.25);
        border-radius: 5px;
    }

    .popup iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .button {
        display: inline-block;
        padding: 8px 16px;
        background-color: #0052cc;
        color: #fff;
        font-size: 14px;
        font-weight: 400;
        text-align: center;
        text-decoration: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .button:hover {
        background-color: #003380;
        color: #fff;
        text-decoration: none;
    }
</style>

<div class="floating-button">
    <a href="#" class="button">Help</a>
    <div class="popup">
        <iframe src="{{route('tickets.menu')}}"></iframe>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('.floating-button .button').on('click', function (e) {
        e.preventDefault();
        $('.floating-button .popup').toggle();
    });
</script>