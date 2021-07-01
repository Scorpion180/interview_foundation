<template>
    <div>
        <b-container class="bv-example-row bv-example-row-flex-cols">
            <b-row>
                <b-col align-self="center">
                    <b-button size="lg" variant="primary" @click="getData" :disabled=isDisabled>Starred repos</b-button>
                </b-col>
            </b-row>
        </b-container>
        <div  v-if="data">
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
<script>
    export default {
        mounted(){
            let currentObj = this;
                axios.post('/getToken')
                .then(function (response) {
                    currentObj.token = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
        },
        data() {
            return {
              token: null,
              data: [],
              output: "",
            };
        },
        computed: {
            isDisabled() {
                return this.token == null;
            }
        },
        methods:{
            getData: function(e){
                e.preventDefault()
                let currentObj = this;
                currentObj.output = "Getting your data";
                currentObj.data = []
                axios.post('/repos')
                .then(function (response) {
                    console.log(response.data)
                    if(response.data.includes('Error') || response.data.includes('500')){
                        currentObj.$toasted.show(response.data, {
                        duration: 2000,
                        position: "top-left",
                        });
                        currentObj.output = ""
                    }
                    else{
                    currentObj.data = response.data
                    currentObj.output = ""
                    }
                })
                .catch(function (error) {
                    currentObj.$toasted.show(error, {
                    duration: 2000,
                    position: "top-left",
                    });
                    currentObj.output = ""
                });
            },
        }
}
</script>
