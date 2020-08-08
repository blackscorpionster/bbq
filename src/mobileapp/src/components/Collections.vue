<template>
    <div style="text-align:left;">
        <b-row>
            <b-col style="text-align: right"><b-icon icon="folder-plus" font-scale="2" style="margin:15px;"></b-icon></b-col>
        </b-row>
        <b-row v-for="index in 10" :key="index">
            <b-col><b-icon icon="folder" font-scale="4" style="margin:15px;"></b-icon></b-col>
            <b-col align-self="center">new {{index}}</b-col>
            <b-col align-self="center"><b-icon icon="heart" font-scale="2"></b-icon></b-col>
        </b-row>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    name: 'Collections',
})
</script>

<style scoped>
    .row:nth-child(even) {
        background-color: #a5a4a2;
    }
</style>