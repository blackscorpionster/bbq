//---- Z-XING

//Obtained from: http://stackoverflow.com/questions/26356626/using-zxing-barcode-scanner-within-a-web-page
// For Iphone Support, go to https://groups.google.com/forum/#!topic/zxing/nBJnxmDBHXE
if(window.location.hash.substr(1,2) == "zx"){
    //var bc = window.location.hash.substr(3);
    localStorage["barcode"] = decodeURI(window.location.hash.substr(3))
    window.close();
    self.close();
    window.location.href = "about:blank";//In case self.close isn't allowed
}

var changingHash = false;
function onbarcode(event){
    switch(event.type){
        case "hashchange":{
            //alert("hashchange");
            if(changingHash == true){
                return;
            }
            var hash = window.location.hash;
            if(hash.substr(0,3) == "#zx"){
                hash = window.location.hash.substr(3);
                changingHash = true;
                window.location.hash = event.oldURL.split("#")[1] || ""
                changingHash = false;
                //--- Find this functions in /job/serial.js
                //alert(hash);
                //alert(placeId);
                processBarcode(hash);
            }

            break;
        }
        case "storage":{
            //alert("storage");
            window.focus();
            if(event.key == "barcode"){
                window.removeEventListener("storage", onbarcode, false);
                //--- Find this functions in /job/serial.js
                //alert(event.newValue);
                processBarcode(event.newValue);
            }
            break;
        }
        default:{
            console.log(event)
            break;
        }
    }
}
window.addEventListener("hashchange", onbarcode, false);

function getScan(){
    var href = window.location.href;
    var ptr = href.lastIndexOf("#");
    if(ptr>0){
        href = href.substr(0,ptr);
    }
    console.log(href);
    window.addEventListener("storage", onbarcode, false);
    setTimeout('window.removeEventListener("storage", onbarcode, false)', 15000);
    localStorage.removeItem("barcode");
    //window.open  (href + "#zx" + new Date().toString());
    if(navigator.userAgent.match(/Firefox/i)){
        //Used for Firefox. If Chrome uses this, it raises the "hashchanged" event only.
        window.location.href = ("zxing://scan/?ret=" + encodeURIComponent(href + "#zx{CODE}"));
    } else if(navigator.userAgent.match(/Safari/i) && !navigator.userAgent.match(/Chrome/i)){
        //Used for Safari, this uses Qrafter instead of Zxing
        window.location.href = ("qrafter://scan/?browser=external&ret=" + encodeURIComponent(href + "#zx{CODE}"));
    } else{
        //Used for Chrome. If Firefox uses this, it leaves the scan window open.
        window.open("zxing://scan/?ret=" + encodeURIComponent(href + "#zx{CODE}"));
    }
}

function processBarcode(bc){
    //saveBarCode(bc, "Scanned");
    /*if(res)
        document.getElementById("divBarCodes").innerHTML += addEntry(res);
    */
    console.log('Bar codes', bc);
    return true;
}

export {processBarcode, getScan};

// // ------ SAVE SERIAL
// var serials = {};
// var placeId = "";

// window.onerror = function (message, url, lineNo){
//     alert('Error: ' + message + '\n' + 'Line Number: ' + lineNo);
//       return true;
// };

// function remove(code){        
//     serials[code] = "N";
//     BuildSerialDisplay();
// }


// function add(code){        
//     serials[code] = "Y";
//     BuildSerialDisplay();
// }

// //---------------------------------- IMPORTANT FUNCTIONS -----------------------------------
// function SubmitSerials(){
//     $.ajax({
//         url: "/job/serial?jobid="+$("#jobid").val(),
//         data: {"serials":serials} ,
//         method: 'POST',
//         success: function(){
//             alert("Data has been saved");
//         }
//     });
// }

// function addEntry(id, code){
//     return '<div id="barCode'+id+'" class="row stodList">'+
//                 '<div class="col-xs-10 col-md-11 col-lg-11">'+
//                     code+
//                 '</div>'+
//                 '<div class="col-xs-2 col-md-1 col-lg-1 nav-button-align">'+
//                     '<span class="fa fa-trash fa-2x sideIcon" aria-hidden="true" id="deleteBarCode" data-id="'+id+'"></span>'+
//                 '</div>'+
//             '</div>';
// }

// //This function handles the result that comes from zxing.js
// function processBarcode(bc){
//     saveBarCode(bc, "Scanned");
//     /*if(res)
//         document.getElementById("divBarCodes").innerHTML += addEntry(res);
//     */
//     return true;
// }

// function saveBarCode(bc,serialstatus){
//     console.log("SAVING..."+bc+" TO "+serialstatus);
//     stoddartLoading();
    
//     //Material id ----------------------------
//     var workid, submatid;
//     workid = $("#divBarCodes").data("workid");
//     submatid = $("#divBarCodes").data("submatid"); 
//     //----------------------------------------
    
//     console.log("Saving input id = "+placeId+" FORCED?? "+$("#"+placeId).attr("data-forced"));
    
//     $.ajax({
//         url:"/job/serial/save/newmaterial",
//         type:"POST",
//         data:{"serial":bc,"status":serialstatus, "workid":workid, "submatmatid":submatid, "inputid":placeId, "proddesc":$("#txtCurrentMaterialDesc").val(),"forced":$("#"+placeId).attr("data-forced")},
//         success:function(response){
//             stoddartStopLoading();
//             //alert(response);
//             response = $.parseJSON(response);
//             console.log(response.status);
//             console.log(response.jobserial);
//             //alert(response.othercontract)
//             if(response.othercontract){
//                 console.log("The serial exist on another contract, force ? "+placeId);
//                 if(!confirm("This serial number seems to be duplicated, Do you confirm this is the right serial?")){
//                     placeId = null;
//                     return false;
//                 }
//                 $("#"+placeId).attr("data-forced",1);
//                 $("#"+placeId).parent().parent().parent().find("#btAcceptCode").click();
//                 return true;
//             }
//             if(response.status === true) {
//                 $("#"+placeId).removeAttr("data-forced");
//                 if(response.recordstatus === "Deleted"){
//                     //$("#barCode"+response.jobserial).remove();
//                     $("#"+placeId).val("");
//                     $("#"+placeId).attr("id","DELETED_"+placeId);
//                     $("#"+"DELETED_"+placeId).parent().parent().parent().find("#btSelectFile").removeAttr("data-id");
//                     $("#"+"DELETED_"+placeId).parent().parent().parent().find("#deleteBarCode").removeAttr("data-id");
//                 } else if(response.recordstatus === "Certified") {
//                     null;//What do we do, change the colors?
//                     console.log("Codes apporved");
//                 } else {
//                     console.log(placeId);
//                     $("#"+placeId).val(response.serial); //places the new serial in the input element, readonly when automatically detected, editable en manually
//                     $("#"+placeId).prop("id",response.jobserial); //Vahnges the id of the element to the id of the new record in the database, so it can be easilly updated or deleted
//                     $("#"+response.jobserial).parent().parent().parent().find("#deleteBarCode").attr({ "data-id": response.jobserial });
//                     if($("#"+response.jobserial).attr("readonly")){
//                         $("#"+response.jobserial).parent().parent().parent().find("#btSelectFile").attr({ "data-id": response.jobserial });
//                     } else {
//                         $("#"+response.jobserial).attr("readonly",true);
//                         $("#"+response.jobserial).parent().parent().parent().find("#btAcceptCode").attr("id","btSelectFile").attr({ "data-id": response.jobserial }).find("span").removeClass("fa-check").addClass("fa-folder");
//                     }
                    
//                     placeId = null;
//                 }
//             }
//             else{
//                 placeId = null;
//                 alert("The bar-code already exists!");
//                 return false;
//             }
//         },
//         error:function(response){
//             placeId = null;
//             stoddartStopLoading();
//             alert("ERRROR::: "+response);
//             return false;
//         }
//     });
// }
// //---------------------------------- END OF IMPORTANT FUNCTIONS ---------------------------------

// function BuildSerialDisplay(){
    
//     var output = "";
    
//     for(key in serials){
//         if(serials[key] === "Y"){
//            output = output  + key +  "<button onclick='remove("+key+")'>Remove</button>\n";
//         }else{             
//            output = output + "<span  style='text-decoration:line-through'>" +    key +  "<button onclick='add("+key+")'>Restore</button></span>\n";   
//         }
//     }
    
//     $("#serials").html(output);
// }

// $(function() {
//     $("#output").html("testing");

//     function callback(data){
//         $("#output").html(data);
//     }
    
//     $("#emptyFile").hide();
    
//     $("body").on("click", ".getScan", function(){
//         placeId = $(this).prop("id"); //** This is a global variable that keeps the id of the element where the scanned code must be placed into
//         console.log($(this).attr("readonly"));
//         //Only open the scanner if the attr is read only
//         if($(this).attr("readonly")){
//             getScan();
//         }
//     });
    
//     $("body").on("click","#btSelectFile",function(){
//         $("#photos").removeAttr("capture");
//         $("#photos").trigger("click");
//         //Sets the id of the input that belongs to the same row into the global variable
//         placeId = $(this).parent().find(".getScan").prop("id");
//         console.log("Input id identified: "+placeId);
//     });
    
//     $("body").on("click","#btSubmit",function(){
//         //$("#btSubmitForm").trigger("click");
//         saveBarCode(null,"Certified");
//     });
    
//     $(".cancelScan").on("click",function(){
//         $(".viewport").hide();
//         $("#viewportContainer").hide();
//     });

//     //Starts the scanner
//     $("#btStartScanner").on("click",function(){
//         $(".viewport").css({'display':"block"});
//         $("#viewportContainer").css({'display':"block"});
//         $(".audioScann").trigger('load');

//         Quagga.init({
//             inputStream : {
//                 name : "Live",
//                 type : "LiveStream",                  
//                 facingMode: "environment",
//                 locate : true,
//                 size: 1920,
//                 singleChannel: false,
//                 target: document.querySelector('#interactive'),    // Or '#yourElement' (optional)
//                 constraints: {
//                     width: 1920,
//                     height: 1440
//                 }
//             },
//             locator: {
//                 patchSize: "medium",
//                 halfSample: false
//             },
//             decoder : {
//               readers : ["ean_reader","upc_reader","code_128_reader"]
//             },
//             locate: true,
//             debug: {
//                 drawBoundingBox: true,
//                 showFrequency: true,
//                 drawScanline: true,
//                 showPattern: true
//             }
//           }, function(err) {
//               if (err) {
//                   alert(err);
//                   return
//               }
//               Quagga.start();
//         });

//         BuildSerialDisplay();

//         Quagga.onDetected(function(result) {
//             var code = result.codeResult.code;
//             //alert(code);
//             Quagga.stop();
//             //starts playing
//             $(".audioDemo").trigger('play');
            
//             if(!serials[code]){
//               serials[code] = "Y";

//               BuildSerialDisplay();
//               $("#viewportContainer").hide();
//               $(".viewport").hide();
//             }
//         });

//     });
    
    
//     //Starts the scanner
//     $("#btOpenCamera").on("click",function(){
//         $("#photos").attr( "capture", "camera" )
//         $("#photos").trigger("click");
//     });
    
//     $("body").on("change","#photos",function(){
//         if( $(this)[0].files[0] !== undefined) {
//             var imgsrc = URL.createObjectURL($(this)[0].files[0]); //Creates a url based on the client's image path
//             stoddartLoading();
//             Quagga.decodeSingle({
//                 src: imgsrc,
//                 locate:true,
//                 decoder: {
//                     readers: ["ean_reader","upc_reader","code_128_reader"] // List of active readers
//                 },
//             }, function(result) {
//                 stoddartStopLoading();
//                 if(result !== undefined && result.codeResult && result.codeResult !== undefined) {

//                     //----------------------------------------------------------------- *** * Scroll up to find this function
//                     //Call ajax that creates the entry in the database
//                     saveBarCode(result.codeResult.code, "Scanned");

//                     $("#photos").val(""); //Cleans the input element

//                 } else {
//                     alert("Code not detected, please enter it manually");
                    
//                     $("#"+placeId).attr("readonly",false);
//                     $("#"+placeId).parent().parent().parent().find("#btSelectFile").attr("id","btAcceptCode").find("span").removeClass("fa-folder").addClass("fa-check");
                    
//                 } //End if
//             }); // End function
//         }
//     });

//     //This function saves the manually entered code
//     $("body").on("click", "#btAcceptCode",function(){
//         console.log("Saving... Manual ")

//         var newCode = $(this).parent().find(".getScan");
//         if(newCode.val() !== ""){
//             //-------------------------------------------------------- *** * Scroll up to find this function
//             //Call ajax trans to save the code into the database, 
//             placeId = newCode.attr("id");
//             saveBarCode(newCode.val(), "Manual");
//         } else {
//             alert("Please type the code in the text box");
//         }
//         $("#photos").val(""); //Cleans the input element
//     });
    
//     $("body").on("click","#deleteBarCode",function(){
//         console.log("DELEING...");
//         //console.log($(this).attr("data-id"));
//         if( $(this).attr("data-id") !== undefined ){
            
//             //----------------------------------------------------------------- *** * Scroll up to find this function
//             //Remove successful codes
//             //Call ajax trans to save the code into the database,
//             placeId = $(this).attr("data-id");            
//             saveBarCode($("#"+placeId).val(), "Deleted");
            
//             try{
//                 $(this).parent().find(".getScan").attr("readonly",true).val("");
//                 $(this).parent().find("#btAcceptCode").attr("id","btSelectFile").find("span").removeClass("fa-check").addClass("fa-folder");
//             } catch(e){
//                 null;
//             }
            
//             $("#photos").val(""); //Cleans the input element
            
//         } else { 
//             console.log("Removing text val...");
//             $(this).parent().find(".getScan").attr("readonly",true).val("");
//             $(this).parent().find("#btAcceptCode").attr("id","btSelectFile").find("span").removeClass("fa-check").addClass("fa-folder");
//             $("#photos").val(""); //Cleans the input element
//         }
//     }); 

//     $("#submit").click(SubmitSerials);
    

// });