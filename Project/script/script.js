// show time and date 
var timeInterval;
  function convertTZ(date, tzString) {
    return new Date(date.toLocaleString("en-US", { timeZone: tzString }));  //returns a locale-specific string that is adjusted to the provided time zone (us-english, australia time zone)
  }
  function melbourneTime() {
    var today = convertTZ(new Date(), "Australia/Melbourne");  //Mon Jun 27 2022 17:20:54 GMT+1000 (Australian Eastern Standard Time)
    var year = ("0" + today.getFullYear()).substr(-2,2);  
    var month = ("0" + (today.getMonth()+1)).substr(-2,2); 
    var date = ("0" + today.getDate()).substr(-2,2);
    var hour = ("0" + today.getHours()).substr(-2,2);
    var minute = ("0" + today.getMinutes()).substr(-2,2);
    var second = ("0" + today.getSeconds()).substr(-2,2);  //002 second take 0"02"
    document.getElementById("time").innerHTML = `${hour}:${minute}:${second} ${date}-${month}-${year}`;
  }

  function startTIME() {
    timeInterval = setInterval(melbourneTime, 1);  //display time every 1 milliseconds
  }

// const dropArea = document.querySelector(".drag-area"),
// dragText = dropArea.querySelector("header");

// let file;

// //If user drags the file over the drop area
// dropArea.addEventListener("dragover", (event)=> {
// 	event.preventDefault();
// 	dropArea.classList.add("active");
// 	dragText.textContent = "Release to Upload File";
// });

// //If user leave dragged File from DropArea
// dropArea.addEventListener("dragleave", ()=>{
//   dropArea.classList.remove("active");
//   dragText.textContent = "Drag & Drop to Upload File";
// });

// //If user drop File on DropArea
// dropArea.addEventListener("drop", (event)=>{
//   event.preventDefault(); //preventing from default behaviour
//   //getting user select file and [0] this means if user select multiple files then we'll select only the first one
//   file = event.dataTransfer.files[0];
//   showFile(); //calling function
// });

// function showFile(){
//   let fileType = file.type; //getting selected file type
//   let validExtensions = ["image/jpeg", "image/jpg", "image/png"]; //adding some valid image extensions in array
//   if(validExtensions.includes(fileType)){ //if user selected file is an image file
//     let fileReader = new FileReader(); //creating new FileReader object
//     fileReader.onload = ()=>{
//       let fileURL = fileReader.result; //passing user file source in fileURL variable
//         // UNCOMMENT THIS BELOW LINE. I GOT AN ERROR WHILE UPLOADING THIS POST SO I COMMENTED IT
//       // let imgTag = `<img src="${fileURL}" alt="image">`; //creating an img tag and passing user selected file source inside src attribute
//       dropArea.innerHTML = imgTag; //adding that created img tag inside dropArea container
//     }
//     fileReader.readAsDataURL(file);
//   }else{
//     alert("This is not a Document File!");
//     dropArea.classList.remove("active");
//     dragText.textContent = "Drag & Drop to Upload File";
//   }
// }


  