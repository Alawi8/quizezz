<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz System</title>
    @vite(['resources/css/app.css', 'resources/js/quizezz-env/app.js'])
</head>

<body class="bg-gray-100 h-screen flex flex-col" x-data="quizManager" x-init="$nextTick(() => { testId = (new URLSearchParams(window.location.search)).get('test_id'); init(); })">
<div id="app"></div>


</body>
</html>
