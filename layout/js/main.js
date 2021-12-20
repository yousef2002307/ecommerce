document.querySelector(".live1").oninput = function(){
    document.querySelector(".live-pre h5").innerHTML = this.value;
}
document.querySelector(".live2").oninput = function(){
    document.querySelector(".live-pre p").innerHTML = this.value;
}
document.querySelector(".live3").oninput = function(){
    document.querySelector(".live-pre h4").innerHTML = `${this.value}$`;
}