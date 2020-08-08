<template>
    <b-navbar toggleable="lg" type="dark" variant="dark">

        <b-navbar-brand>{{user.firstName}}</b-navbar-brand>
        
        <b-navbar-toggle target="nav-collapse" style="z-index: 90;"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="ml-auto">
                <div>
                    <b-icon 
                    @:click="getScan('aaa')"
                    icon="upc-scan" font-scale="2" 
                    style="margin:15px;">
                    </b-icon>
                    <b-icon 
                    icon="person-circle" 
                    @click="selectMenuOption('account')"
                    font-scale="2" 
                    style="margin:15px;">
                    </b-icon>
                    <b-icon 
                    icon="folder"
                    @click="selectMenuOption('collections')"
                    font-scale="2" 
                    style="margin:15px;">
                    </b-icon>
                    <b-icon 
                    icon="heart"
                    @click="selectMenuOption('favourites')" 
                    font-scale="2" 
                    style="margin:15px;">
                    </b-icon>
                    <b-icon 
                    icon="power"
                    @click="selectMenuOption('shutDown')" 
                    font-scale="2" 
                    style="margin:15px;">
                    </b-icon>
                </div>
            </b-navbar-nav>
        </b-collapse>

    </b-navbar>
</template>

<script>
import Vue from 'vue';
import axios from 'axios';
import {store} from '../store';

//import * as scanner from '../assets/js/barCodeReader.js';
export default Vue.extend({
    name: "TopMenu",
    data: function() {
        return {
            changingHash: false,
            currentPage: 'favourites'
        }
    },
    computed: {
        token() {
            return store.token
        },
        user() {
            return store.user
        }
    },
    mounted: function () {
        // This is triggered when the mobile tool changes the url on callback, adding the # symbol
        window.addEventListener("hashchange", this.onbarcode, false);

        if(window.location.hash.substr(1,2) == "zx"){
            alert('Location ZX');
            //var bc = window.location.hash.substr(3);
            localStorage["barcode"] = decodeURI(window.location.hash.substr(3))
            window.close();
            self.close();
            window.location.href = "about:blank";//In case self.close isn't allowed
        }
    }, methods: {
        selectMenuOption: function(option) {
            console.log("Opening >>> ", option);
            this.currentPage = option;
            this.$emit('current-page', option);
        },
        processBarcode: function(bc) {
            const data = JSON.stringify({'code': bc});
            console.log("Data", data);
            axios.post(
                'http://10.1.1.52:8000/barcode/save', 
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
})
</script>

<style scoped>
</style>