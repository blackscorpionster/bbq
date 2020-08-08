<template>
    <div id="app" class="h-100 d-flex flex-column" style="overflow-y: hidden">
        
        <div v-if="!token">
            You cannot access this page
        </div>

        <TopMenu
        v-if="token"
        @current-page="setCurrentPage($event)"
        >
        </TopMenu>
        
        <b-container v-if="token" fluid="lg" class="h-100">
            <b-row id="contentArea" class="h-100" style="overflow-y: hidden;">
                <b-col class="h-100 justify-content-center flex-grow-1" style="overflow-y: scroll;">
                    <ContentArea
                    :current-page="currentPage"
                    >
                    </ContentArea>
                </b-col>
            </b-row>
        </b-container>

    </div>
</template>

<script>
    import Vue from 'vue';
    import TopMenu from './TopMenu';
    import ContentArea from './ContentArea';
    import axios from 'axios';
    import {mutations} from '../store';

    export default Vue.extend({
        name: "MobileMain",
        data: function() {
            return {
                currentPage: 'favourites',
                token: null
            }
        },
        mounted: function() {
            axios.get('/init')
            .then(response => {
                console.log(response);
                this.token = response.data.token;
                mutations.setToken(this.token);
                mutations.serUser(response.data.user)
            })
            .catch(error => {
                console.error(error);
            });
        },
        components: {
            TopMenu,
            ContentArea,
        },
        methods: {
            setCurrentPage: function(value) {
                console.log("Main received page change value", value);
                if ('shutDown' === value) {
                    axios.post("/logout", JSON.stringify({token: this.token}),
                                {
                                    headers: {
                                        'Content-Type': 'application/json',
                                    }
                                }
                    )
                    .then(response => {
                        console.log("Success", response);
                        window.location.href = '/'
                    })
                    .catch(error => {
                        alert("Cannot terminate session, contact support");
                        console.error(error);
                    });
                } else {
                    this.currentPage = value;
                }
                
            }
        }
    }); 
</script>

<style scoped>
#app {
    top: 0px;
    position: absolute;
    height: 100%;
    width: 100%;
}

#contentArea {
    border-style: solid;
    border-left-width: 0em;
    border-right-width: 0em;
    border-bottom-width: 0em;
    border-top-width: .1em;
    border-top-color: #FFFFFF;
}
</style>