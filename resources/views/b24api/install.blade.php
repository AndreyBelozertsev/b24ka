<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Установка</title>
</head>
<body>
<pre>
    Application installation has been started, auth-tokens from Bitrix24:
    @dump(request())
</pre>
<script src="//api.bitrix24.com/api/v1/"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        BX24.init(function () {
            console.log('bx24.js initialized', BX24.isAdmin());
        });
    });
</script>
</body>
</html>
