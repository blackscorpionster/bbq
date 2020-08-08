<template>
    <div style="text-align:left;">
        <b-row>
            <b-col>First name:</b-col>
            <b-col>{{firstName}}</b-col>
        </b-row>
        <b-row>
            <b-col>Last name:</b-col>
            <b-col>{{lastName}}</b-col>
        </b-row>
        <b-row>
            <b-col>Email:</b-col>
            <b-col>{{email}}</b-col>
        </b-row>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
import {store} from '../store';

export default Vue.extend({
    name: 'Account',
    data: function() {
        return {
            firstName: store.user.firstName,
            lastName: store.user.lastName,
            email: store.user.email
        }
    }
})
</script>

<style scoped>

</style>