<template>
    <div>
        <Collections v-if="currentPage=='collections'"></Collections>
        <Favourites v-if="currentPage=='favourites'"></Favourites>
        <Account v-if="currentPage=='account'"></Account>
    </div>
</template>

<script>
import Vue from 'vue';
import Collections from './Collections';
import Favourites from './Favourites';
import Account from './Account';

export default Vue.extend({
    name: "ContenArea",
    components: {
        Collections,
        Favourites,
        Account
    },
    props: {
        currentPage: {
            type: String,
            default: 'favourites'
        }
    },
    mounted: function() {
        console.log("Content area started, page = ", this.currentPage);
    }
})
</script>

<style scoped>

</style>