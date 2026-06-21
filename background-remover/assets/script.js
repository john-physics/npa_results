const input = document.getElementById("images");

const preview = document.getElementById("preview");


input.addEventListener(
"change",
function(){


    preview.innerHTML="";


    let files=[...this.files];


    if(files.length > 5){

        alert("Maximum 5 images allowed");

        this.value="";

        return;

    }



    files.forEach(file=>{


        let reader=new FileReader();


        reader.onload=function(e){


            let img=document.createElement("img");

            img.src=e.target.result;


            preview.appendChild(img);


        }


        reader.readAsDataURL(file);


    });


});

const spinner = document.getElementById("spinner");
const uploadform = document.getElementById("upload-form");

uploadform.addEventListener("submit",()=>{
  
  spinner.style.display = "flex";
  
  setTimeout(() => {
   spinner.style.display = "none";
  
  }, 60000);
    
});