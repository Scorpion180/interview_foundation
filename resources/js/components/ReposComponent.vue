<template>
    <div>
        <b-container class="bv-example-row bv-example-row-flex-cols">
            <b-row>
                <b-col align-self="center">
                    <b-button size="lg" variant="primary" @click="getData" :disabled=isDisabled>Starred repos</b-button>
                </b-col>
            </b-row>
        </b-container>
         <b-toast id="toast" title="ERROR" static no-auto-hide v-if="toast">
            {{output}}
        </b-toast>
        <div  v-if="data && !toast">
            <h2>{{output}}</h2>
        <b-list-group>
            <b-list-group-item class="d-flex justify-content-between align-items-center" v-for="value in data" :key="value">
                {{ value[0] }}
                <b-badge variant="light" pill>
                    <a v-bind:href="value[1]"> Link </a>
                </b-badge>
            </b-list-group-item>
        </b-list-group>
        </div>
    </div>
</template>