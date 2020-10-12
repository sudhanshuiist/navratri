var video = document.getElementById("videoElement");
var startVideo = document.getElementById("startRecording");
var stopVideo = document.getElementById("stopRecording");
stopVideo.hidden = true;
var retakeVideo = document.getElementById("retake");
retakeVideo.hidden = true;
var share_to_facebook = document.getElementById("sharefb");
var downloadVideo = document.getElementById("downloadVideo");

var mediaRecorder;
var options = {mimeType: 'video/webm; codecs=vp9'};
var recordedChunks = [];

function controlRecording(key) {
  if (key == 0) {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      navigator.mediaDevices.getUserMedia({ video: true }).then(function (stream) {
        video.srcObject = stream;
        video.play();

        startVideo.hidden = true;
        stopVideo.hidden = false;

        mediaRecorder = new MediaRecorder(stream, options);

        mediaRecorder.start();
        mediaRecorder.ondataavailable = function(event){
          if (event.data.size > 0) {
            recordedChunks.push(event.data);
          }
        };

      }).catch(function (error) {
        console.log("Something went wrong: => "+error);
      });
    } else {
      console.log("Can Not access camera");
    }
  } else {

    video.pause();
    startVideo.hidden = true;
    stopVideo.hidden = true;
    retakeVideo.hidden = false;

    var stream = video.srcObject;
    stream.getTracks().forEach(function(track) {
      track.stop();
    });

    var blob = new Blob(recordedChunks, {'type' : 'video/webm;' });
    
    recordedChunks = [];

    var url = URL.createObjectURL(blob);
    downloadVideo.href = url;
    downloadVideo.download = "video.webm";
    downloadVideo.click();
    window.URL.revokeObjectURL(url);

  }

  setTimeout(function(){
    mediaRecorder.stop();
  }, 5000);

}

function retake() {
  video.srcObject = null;
  startVideo.hidden = false;
  stopVideo.hidden = true;
  retakeVideo.hidden = true;
}

// function shareToFacebook() {
//   var imageData = canvas.toDataURL("images/png");

//   if (window.XMLHttpRequest) {
//     xmlhttp = new XMLHttpRequest();
//   } else {
//     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//   }

//   xmlhttp.onreadystatechange = function () {
//     if (this.readyState == 4 && this.status == 200) {

//       var response = JSON.parse(this.responseText);

//       if (response.status == 200) {
//         var width = 600;
//         var height = 400;
//         var left = (screen.width - width) / 2;
//         var top = (screen.height - (height + 100)) / 2;
//         window.open(response.url, "Share to Facebook", 'width=' + width + ' , height=' + height + ' , top=' + top + ' , left=' + left);
//       } else {
//         console.log(this.responseText);
//       }

//     }
//   }
//   var form = new FormData;
//   form.append('imageData', imageData);
//   xmlhttp.open("POST", "graph.php");
//   xmlhttp.send(form);
//   return false;
// }
