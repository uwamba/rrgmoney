<!DOCTYPE html>
<html>
<head>
    <title>Laravel Livewire Example - ItSolutionStuff.com</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@livewire/livewire@2.5.1/dist/livewire.css">
<script src="https://cdn.jsdelivr.net/npm/@livewire/livewire@2.5.1/dist/livewire.js"></script>
</head>
<body>

<div class="container">

    <div class="card">
      <div class="card-header">
        Laravel Livewire Example - ItSolutionStuff.com
      </div>
      <div class="card-body">
        <livewire:transfer-report
            searchable="name, email"
            exportable
         />

      </div>
    </div>

</div>

</body>

@livewireScripts

</html>
