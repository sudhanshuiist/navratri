var flag = 0;
var attempts = 0;
var initial_images = [["images/mi10.gif","product-image-mi10"],["images/laptop.gif","product-image-laptop"],["images/tv.gif","product-image-tv"],["images/watch.gif","product-image-band"],["images/trimmer.gif","product-image-trimmer"],["images/purifier.gif","product-image-purifier"],["images/powerbank.gif","product-image-powerbank"],["images/note9.gif","product-image-redmi8"]];
var results = ["images/sandesh1.gif","images/sandesh2.gif","images/noluck.gif","images/noluck2.gif","images/sandesh1b.gif","images/durga.gif","images/sandesh2c.gif","images/sandesh2b.gif"];
var game_flag = localStorage.getItem("flag");
var result = localStorage.getItem("result");
shuffle(results);
shuffle(initial_images);
//var status = setInterval(checkStatus,2000);

var recorded_video_to_play = 0;


function main_clicked(){
    window.location.href="game.html";
}

function init_load(){
    shuffle(results);
shuffle(initial_images);
    if(!game_flag){
        download_brochure();
    }
        for(var i =1; i<=8;i++){
            document.getElementById("prod"+i).src=initial_images[i-1][0];
            document.getElementById("prod"+i).className=initial_images[i-1][1];
        }
}

function result_text(){
   var game_flag = localStorage.getItem("flag");
    var result = localStorage.getItem("result");
    if(game_flag == "2"){
        if(result == "lost"){
            document.getElementById("landing-text-header").innerText="Sorry! You have lost this time! Better luck next time!"
            document.getElementById("winning-text").innerText="";
            document.getElementById("container").hidden = true;
        } else if(result == "won"){
            document.getElementById("videoElement").autoplay = true;
        }
    } else if(game_flag == null || game_flag=="1"){
        document.getElementById("landing-text-header").innerText="You haven't played the game yet!"
            var winning_text= document.getElementById("winning-text")
            winning_text.innerText="Click here to play it";
            winning_text.addEventListener("click",function(){
                window.location.href="game.html";
                shuffle(results);
                shuffle(initial_images);
            })
            document.getElementById("container").hidden = true;
    }
    document.getElementById("share").hidden = true;
    document.getElementById("canvas").hidden = true;
}


function onProductClick(index, id){
    recorded_video_to_play = index;
    
    window.location.href="challenge.html?index="+recorded_video_to_play
    console.log("recorded video to play is set to: "+recorded_video_to_play)
}

function load_video(){
    var recordedVideoElement = document.getElementById("recordedVideo");
    var recorded_video_to_play = window.location.href.split('=').pop()
console.log("recorded video is setto : "+recorded_video_to_play )
    switch(recorded_video_to_play){
        case "0": recordedVideoElement.src="videos/solo_girl.mp4"
            break;
        case "1": recordedVideoElement.src="videos/solo_boy.mp4"
            break;
        case "2": recordedVideoElement.src="videos/group.mp4"
            break;
        case "3": recordedVideoElement.src="videos/couple.mp4"
            break;

    }
}



function checkStatus(){
        if(flag ==1){
            alert("Congratulations! You win exciting goodies!!\n Click OK to redeem it!")
            flag = 3;
            window.location.href="win.html";
            localStorage.setItem("result","won");
            localStorage.setItem("flag","2")
        }
 else if(flag == 2 && attempts== 2){
            alert("Oops! You have used your 2 chances but you can continue finding Durga Maa")
            localStorage.setItem("result","lost");
            localStorage.setItem("flag","2");
            flag = 4;
    }    
    else if(flag==2){
        localStorage.setItem("result","lost");
        localStorage.setItem("flag","2");
    } 
}


function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
      let j = Math.floor(Math.random() * (i + 1)); // random index from 0 to i
  
      // swap elements array[i] and array[j]
      // we use "destructuring assignment" syntax to achieve that
      // same can be written as:
      // let t = array[i]; array[i] = array[j]; array[j] = t
      [array[i], array[j]] = [array[j], array[i]];
    }
  }
