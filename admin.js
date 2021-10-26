$( document ).ready(function() {
    document.getElementById('f1_upload_process').style.visibility = 'hidden';

    $("#uploadForm").submit(()=>{
        startUpload();
    });
});


function startUpload(){
    document.getElementById('f1_upload_process').style.visibility = 'visible';
    return true;
}


function stopUpload(success){
    var result = '';
    if (success == 1){
       document.getElementById('result').innerHTML =
         '<span class="msg">Die Datei konnte erfolgreich hochgeladen werden.<\/span><br/><br/>';
    }
    else {
       document.getElementById('result').innerHTML = 
         '<span class="emsg">Beim Upload der Datei trat ein efhler auf.<\/span><br/><br/>';
    }
    document.getElementById('f1_upload_process').style.visibility = 'hidden';
    return true;   
}




