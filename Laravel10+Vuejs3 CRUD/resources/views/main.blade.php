<!DOCTYPE html>
<html>
<head>
   @vite('public/js/hyper-config.js')
   @vite('public/css/app-modern.min.css')
   @vite('public/css/icons.min.css')
   @vite('resources/css/app.css')
</head>
<body>
  <div id="app">
     <router-view></router-view>
  </div>
  
  @vite('resources/js/app.js')
  @vite('public/js/vendor.min.js')
</body>
</html>