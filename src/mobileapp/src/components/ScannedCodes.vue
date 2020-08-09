<template>
    <div>
        these are scanned codes
    </div>
</template>
<script>
import Vue from 'vue';
import axios from 'axios';

export default Vue.extend({
    name: "ScannedCodes",
    data: function() {
        return {
            changingHash: false
        }
    },
    mounted: function() {
        // This is triggered when the mobile tool changes the url on callback, adding the # symbol
        window.addEventListener("hashchange", this.onbarcode, false);
        console.log("Mounting scanned");
        this.init();
    },
    methods: {
        init: function() {
            console.log("Init saved codes");
        },
        processBarcode: function(bc) {
            const data = JSON.stringify({'code': bc});
            console.log("Data", data);
            axios.post(
                '/barcode/save', 
                data,
                {
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }
            ).then(
                response => {
                    console.log(response.data);
                    this.makeToast('Success', 'success');
                }
            ).catch(
                e => {
                    console.error(e);
                    this.makeToast('Error', 'danger');
                }
            );
            return true;
        },
        getScan: function() {
            var href = window.location.href;
            var ptr = href.lastIndexOf("#");
            if(ptr>0){
                href = href.substr(0,ptr);
            }

            window.addEventListener("storage", this.onbarcode, false);
            setTimeout('window.removeEventListener("storage", onbarcode, false)', 15000);
            localStorage.removeItem("barcode");
            
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
        },
        onbarcode: function(event) {
            switch(event.type){
                case "hashchange":{
                    if(this.changingHash == true){
                        return;
                    }
                    var hash = window.location.hash;
                    if(hash.substr(0,3) == "#zx"){
                        hash = window.location.hash.substr(3);
                        this.changingHash = true;
                        window.location.hash = event.oldURL.split("#")[1] || ""
                        this.changingHash = false;
                        // So something with the barcode
                        this.processBarcode(hash);
                    }
                    break;
                }
                case "storage":{
                    alert("storage");
                    window.focus();
                    if(event.key == "barcode"){
                        window.removeEventListener("storage", this.onbarcode, false);
                        //--- Find this functions in /job/serial.js
                        //alert(event.newValue);
                        this.processBarcode(event.newValue);
                    }
                    break;
                }
                default:{
                    console.log(event)
                    break;
                }
            }
        },
        makeToast(message, variant) {
            console.log('Generating ' + variant + 'toast');
            this.$bvToast.toast(message, {
                title: 'Barcode',
                variant: variant,
                solid: true,
                autoHideDelay: 3000
            })
        },
    }
});
</script>

<style scoped>

</style>