<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Latest compiled JavaScript -->
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- joyKaomoji -->
  <script defer src="scripts/joyKaomoji.js"></script>
</head>

<body>
  <div class="p-5 bg-primary text-white text-center">
    <h1>Bonettimrc</h1>
    <p id="joyKaomoji"></p>
  </div>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="mynavbar">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://github.com/bonettimrc/azureWebsite">Github</a>
          </li>
        </ul>
        <form action="javascript:search()" method="get" class="d-flex">
          <input type="text" name="search" id="search" placeholder="Search..." class="form-control me-2">
          <button class="btn btn-primary" name="submit" type="submit">Submit</button>
        </form>
      </div>
    </div>
  </nav>
  <div class="container mt-5">
    <div class="ratio ratio-16x9">
      <iframe src="index.html"></iframe>
    </div>
    <button class="btn btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
            <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
        </svg>
    </button>
  </div>
  <script>
    function search() {
      fetch(`search.php?q=${encodeURIComponent(document.getElementsByName('search').item(0).value)}`)
        .then(res => res.json())
        .then(paths => {
          if (paths.length > 1) {
            // TODO:lister with paths
          } else {
            // iframe with path
            document.querySelector('iframe').src = paths[0]
          }
        })
    }
  </script>
</body>

</html>