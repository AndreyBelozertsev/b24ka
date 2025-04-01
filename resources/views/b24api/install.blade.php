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
<script>
    BX24.init(function(){
        BX24.installFinish();
    });
</script>
</body>
</html>
