<!DOCTYPE html>
<html lang="en">
<head>
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
</head>
<body>
<div id="app"></div>

<script>
    const authUser = @json(Auth::user());
</script>

</body>
</html>
