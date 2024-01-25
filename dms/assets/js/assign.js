
async function assign(event){

  var path = event.path.value;
  var routedto = event.routedto.value;

  var data = new FormData();
  data.append('path', path);
  data.append('routedto', routedto);

  var http = new XMLHttpRequest();

  var url = 'assign.php';
  http.open('POST', url, true);
  http.onreadystatechange = function() {
      if (http.readyState == 4 && http.status == 200) {
        console.log(http.responseText);
        if (http.responseText=="success") {
        window.location.href=('http://192.168.1.6/dms2/dms/html/file.php')
        }
      }
  }
  http.send(data);
  }
