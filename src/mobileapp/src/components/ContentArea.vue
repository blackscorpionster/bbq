<template>
    <div>
        <ScannedCodes v-if="currentPage=='scannedCodes'"></ScannedCodes>
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
import ScannedCodes from './ScannedCodes';

export default Vue.extend({
    name: "ContenArea",
    components: {
        Collections,
        Favourites,
        Account,
        ScannedCodes
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